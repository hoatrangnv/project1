<?php

namespace App\Http\Controllers\Wallet;

use App\UserCoin;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\User;
use App\Wallet;
use App\Withdraw;
use App\WithdrawConfirm;
use App\CLPWalletAPI;
use Auth;
use Symfony\Component\HttpFoundation\Session\Session; 
use Validator;
//use App\BitGo\BitGoSDK;
use Coinbase\Wallet\Enum\CurrencyCode;
use Coinbase\Wallet\Resource\Transaction;
use Coinbase\Wallet\Value\Money;
use Coinbase\Wallet\Configuration;
use Coinbase\Wallet\Client;
use App\Notifications\WithDrawConfirm as WithDrawConfirmNoti;
use Carbon\Carbon;
use App\ExchangeRate;
use URL;
use Google2FA;

use Log;

/**
 * Description of WithDrawController
 *
 * @author huydk
 */
class WithDrawController extends Controller
{
	public function __construct()
	{
		//$this->middleware('auth');
	}
	
	/**
	 * 
	 * @param Request $request
	 * @return type
	 */
	public function getBtcCoin(Request $request){
		$currentuserid = Auth::user()->id;
		//get coin and update to DB
		$configuration = Configuration::apiKey( 
					config('app.coinbase_key'), 
					config('app.coinbase_secret') );
			
		$client = Client::create($configuration);
		$idCoinBase = Auth()->user()->userCoin->accountCoinBase;
		$account = $client->getAccount($idCoinBase);
		$btc = (double) $account->getBalance()->getAmount();
		
		//update db
		UserCoin::where('userId', '=',$currentuserid)
				->update(['btcCoinAmount' => $btc]);
		$coin = Auth()->user()->userCoin->btcCoinAmount;
		return $coin;
	}
	
	/** 
	 * @author Huynq
	 * Send Coin with BitGO
	 * @param Request $request
	 * @return type
	 */
	/*protected function sendCoin(Request $request) {
		$this->validate($request, [
			'withdrawAmount'=>'required',
			'walletAddress'=>'required',
			'withdrawOPT'=>'required|min:6'
		]);
		$amount = $request->get('withdrawAmount')*1e8;
		$walletAddress = $request->get('walletAddress');
		/////////////////////////////////
		$bitgo = new BitGoSDK();
		$bitgo->authenticateWithAccessToken(config('app.bitgo_token'));
		////////////////////////////////
		//active api
		$bitgo->unlock('0000000');
		//send coin
		$wallet = $bitgo->wallets()->getWallet($user->walletAddress);
		$sendCoins = $wallet->sendCoins($walletAddress, $amount, config('app.bitgo_password'), $message = null);
		///
		if($sendCoins['status'] == "accepted"){
			$withDraw = new Withdraw;
			$withDraw->walletAddress = $walletAddress;
			$withDraw->userId = $currentuserid;
			$withDraw->amountBTC = (double)$request->get('withdrawAmount');
			$withDraw->fee = (double)$sendCoins['fee']/1e8;
			$withDraw->detail = json_encode($sendCoins);
			$withDraw->status = 1;
			$withDraw->save();
		}
	}*/
	
	/**
	 * @author Huynq
	 * @param Request $request
	 * @return view
	 */
	public function confirmWithdraw( Request $request ) {
		$isConfirm = false;
		$withdrawConfirm = [];

		if($request->d != '')
		{
			$data = json_decode(base64_decode($request->d));

			if($data && isset($data[1]) && $data[1] > 0 && isset($data[2]) && in_array($data[2], ['btc', 'clp']))
			{
				list($token, $id, $type, $amount) = $data;
				$withdrawConfirm = WithdrawConfirm::where('id', '=', $id)->where('withdrawAmount', $amount)->first();

				if($withdrawConfirm)
				{
					if($withdrawConfirm->status == 0)
					{
						$count = WithdrawConfirm::where('id','=', $id)
								->where('updated_at','>', Carbon::now()->subMinutes(30))
								->count();

						if($count == 0)
						{
							$isConfirm = true;
							$request->session()->flash('error', 'Link confirmation withdrawal expired!');
						}
						else
						{
							if ( $token == hash( "sha256", md5( md5( $id ) ) ) ) 
							{
								if ($request->isMethod('post'))
								{
									$totalWithdraw = UserCoin::getTotalWithdrawDay($withdrawConfirm->userId);
									$totalToday = $totalWithdraw + $withdrawConfirm->withdrawAmount * ExchangeRate::getCLPUSDRate();

									if($withdrawConfirm->type == 'btc')
									{
										self::sendCoinBTC($request, $id);
									}elseif($withdrawConfirm->type == 'clp')
									{
										if($totalToday <= 3000)
										{
											self::sendCoinCLP($request, $id);
										}else
										{
											self::withdrawCLP($request, $id);
										}
									}

									$isConfirm = true;
								}
							}else
							{
								$request->session()->flash('error', 'Something wrongs. We cannot confirm withdrawal!');
							}
						}
					}
					elseif($withdrawConfirm->status == 2)
					{
						$isConfirm = true;
						$request->session()->flash('error', 'The withdrawal cancelled!');
					}
					else
					{
						$isConfirm = true;
						$request->session()->flash('error', 'The withdrawal confirmed!');
					}
				}
				else
				{
					throw new \ErrorException("The withdrawal is not existent!");
				}
			}
			else
			{
				throw new \ErrorException("The confirmation link is not correct!");
			}
		}
		else
		{
			throw new \ErrorException("The confirmation link is not correct!");
		}

		return view('adminlte::wallets.confirmWithdraw', compact('isConfirm', 'withdrawConfirm'));
	}

	//Always withdraw BTC manually
	function withdrawBTC(Request $request, $id)
	{
		$withdrawConfirm = WithdrawConfirm::where('id', '=', $id)->first();

		if($request->status == 1){
			$withdrawConfirm->status = 2;
			$withdrawConfirm->save();

			$request->session()->flash('error', 'The withdrawal is cancelled!');
		} else {
			$user = UserCoin::where('userId', $withdrawConfirm->userId)->first();
			// nếu tổng số tiền sau khi trừ đi phí lơn hơn
			// số tiền chuyển đi thì thực hiện giao dịch
			if ($user->btcCoinAmount - config('app.fee_withRaw_BTC') >= $withdrawConfirm->withdrawAmount)
			{
				//Change status withdraw confirm
				$withdrawConfirm->status = 3;
				$withdrawConfirm->save();

				try{
					//Update btCoinAmount
					$btcCoinAmount = $user->btcCoinAmount - config('app.fee_withRaw_BTC') - $withdrawConfirm->withdrawAmount;

					UserCoin::where('userId', '=', $withdrawConfirm->userId)->update(['btcCoinAmount' => $btcCoinAmount]);

					//insert wallet
					$dataInsertWallet = [
						"walletType" => Wallet::BTC_WALLET,
						"type" => Wallet::WITH_DRAW_BTC_TYPE,
						"userId" => $withdrawConfirm->userId,
						"note" => "Processing",
						"amount" => $withdrawConfirm->withdrawAmount,
						"inOut" => Wallet::OUT
					];

					$dataInsert = Wallet::create($dataInsertWallet);

					//insert withdraw -- lưu lịch sử giao dịch -- trạng thái success
					$dataInsertWithdraw = [
						"walletAddress" => $withdrawConfirm->walletAddress,
						"userId" => $withdrawConfirm->userId,
						"amountBTC" => $withdrawConfirm->withdrawAmount,
						"wallet_id" => $dataInsert->id,
						"at_rate" => ExchangeRate::getBTCUSDRate(),
						"transaction_id" => '',
						"transaction_hash" => '',
						"status" => 2
					];

					$withdrawInsert = Withdraw::create($dataInsertWithdraw);

					$withdrawConfirm->withdraw_id = $withdrawInsert->id;
					$withdrawConfirm->save();

					$request->session()->flash('successMessage', 'Your withdrawnal is processing!');
				} catch (\Exception $e) {
					$request->session()->flash('error', "The withdrawal fail: " . $e->getMessage());
					//Change status withdraw confirm to 2 - cancel if have error
					$withdrawConfirm->status = 2;
					$withdrawConfirm->save();

					Log::error('user withdraw BTC has error: ' . $e->getMessage());
					Log::error('user withdraw BTC userId: ' . $withdrawConfirm->userId);
					Log::info($e->getTraceAsString());
				}
			} 
			else 
			{
				$request->session()->flash('error', 'Not enought BTC');
			}
		}
	}

	//Approve withdraw
	function withdrawCLP(Request $request, $id)
	{
		$withdrawConfirm = WithdrawConfirm::where('id', '=', $id)->first();

		if($request->status == 1){
			$withdrawConfirm->status = 2;
			$withdrawConfirm->save();

			$request->session()->flash('error', 'The withdrawal is cancelled!');
		} else {
			$user = UserCoin::where('userId', $withdrawConfirm->userId)->first();
			// nếu tổng số tiền sau khi trừ đi phí lơn hơn
			// số tiền chuyển đi thì thực hiện giao dịch
			if ($user->clpCoinAmount - config('app.fee_withRaw_CLP') >= $withdrawConfirm->withdrawAmount)
			{
				//Change status withdraw confirm
				$withdrawConfirm->status = 3;
				$withdrawConfirm->save();

				try{
					$newClpCoinAmount = $user->clpCoinAmount - config('app.fee_withRaw_CLP') - $withdrawConfirm->withdrawAmount;
					$update = UserCoin::where("userId", $withdrawConfirm->userId)->update(["clpCoinAmount" => $newClpCoinAmount]);
							
					//insert wallet
					$dataInsertWallet = [
						"walletType" => Wallet::CLP_WALLET,
						"type" => Wallet::WITH_DRAW_CLP_TYPE,
						"userId" => $withdrawConfirm->userId,
						"note" => "Processing",
						"amount" => $withdrawConfirm->withdrawAmount,
						"inOut" => Wallet::OUT
					];

					$resultInsert = Wallet::create($dataInsertWallet);

					//insert withdraw
					$dataInsertWithdraw = [
						"walletAddress" => $withdrawConfirm->walletAddress,
						"userId" => $withdrawConfirm->userId,
						"amountCLP" => $withdrawConfirm->withdrawAmount,
						"wallet_id" => $resultInsert->id,
						"at_rate" => ExchangeRate::getCLPUSDRate(),
						"transaction_id" => '',
						"transaction_hash" => '',
						"status" => 2
					];

					$withdrawInsert = Withdraw::create($dataInsertWithdraw);

					$withdrawConfirm->withdraw_id = $withdrawInsert->id;
					$withdrawConfirm->save();

					$request->session()->flash('successMessage', 'Your withdrawnal is processing!');

				} catch (\Exception $e) {
					$request->session()->flash('error', "The withdrawal fail");
					//Change status withdraw confirm to 0 if have error
					$withdrawConfirm->status = 2;
					$withdrawConfirm->save();

					Log::error('user withdraw CLP has error: ' . $e->getMessage());
					Log::error('user withdraw CLP userId: ' . $withdrawConfirm->userId);
					Log::info($e->getTraceAsString());
				}
			} 
			else 
			{
				$request->session()->flash('error', 'Not enought BTC');
			}
		}
	}
	
	function sendCoinBTC(Request $request, $id)
	{
		$withdrawConfirm = WithdrawConfirm::where('id', '=', $id)->first();

		if($request->status == 1){
			$withdrawConfirm->status = 2;
			$withdrawConfirm->save();

			$request->session()->flash('error', 'The withdrawal is cancelled!');
		} else {
			$user = UserCoin::where('userId', $withdrawConfirm->userId)->first();
			// nếu tổng số tiền sau khi trừ đi phí lơn hơn
			// số tiền chuyển đi thì thực hiện giao dịch
			if ($user->btcCoinAmount - config('app.fee_withRaw_BTC') >= $withdrawConfirm->withdrawAmount)
			{
				//Change status withdraw confirm
				$withdrawConfirm->status = 1;
				$withdrawConfirm->save();

				//begin send
				try {
					//Config API key
					$configuration = Configuration::apiKey(config('app.coinbase_key'), config('app.coinbase_secret'));
					$client = Client::create($configuration);
					$transaction = Transaction::send([
						'toBitcoinAddress' => $withdrawConfirm->walletAddress,
						'amount' => new Money($withdrawConfirm->withdrawAmount, CurrencyCode::BTC),
						'description' => ''
					]);

					//get object account
					$account = $client->getAccount(config('app.coinbase_account'));
				
					//send btc
					$client->createAccountTransaction($account, $transaction);
				
					//Update btCoinAmount
					$btcCoinAmount = $user->btcCoinAmount - config('app.fee_withRaw_BTC') - $withdrawConfirm->withdrawAmount;

					UserCoin::where('userId', '=', $withdrawConfirm->userId)->update(['btcCoinAmount' => $btcCoinAmount]);

					//insert wallet
					$dataInsertWallet = [
						"walletType" => Wallet::BTC_WALLET,
						"type" => Wallet::WITH_DRAW_BTC_TYPE,
						"userId" => $withdrawConfirm->userId,
						"note" => "Pending",
						"amount" => $withdrawConfirm->withdrawAmount,
						"inOut" => Wallet::OUT
					];

					$dataInsert = Wallet::create($dataInsertWallet);

					//Get transaction request
					$transaction_hash = '';
					$transaction_id = '';
					$allTransactions = $client->getAccountTransactions($account);
					foreach($allTransactions as $transaction) {
						if($transaction->getTo()->getAddress() == $withdrawConfirm->walletAddress) {
							$transaction_hash = $transaction->getNetwork()->getHash();
							$transaction_id = $transaction->getId();
							break;
						}
					}

					//insert withdraw -- lưu lịch sử giao dịch -- trạng thái success
					$dataInsertWithdraw = [
						"walletAddress" => $withdrawConfirm->walletAddress,
						"userId" => $withdrawConfirm->userId,
						"amountBTC" => $withdrawConfirm->withdrawAmount,
						"wallet_id" => $dataInsert->id,
						"transaction_id" => $transaction_id,
						"transaction_hash" => $transaction_hash,
						"status" => 0
					];

					$dataInsertWithdraw = Withdraw::create($dataInsertWithdraw);

					$request->session()->flash('successMessage', 'You have withdrawn successfully!');
				} catch (\Exception $e) {
					$request->session()->flash('error', "The withdrawal fail: " . $e->getMessage());
					//Change status withdraw confirm to 0 if have error
					$withdrawConfirm->status = 2;
					$withdrawConfirm->save();

					Log::error('withdraw BTC has error: ' . $e->getMessage());
					Log::info($e->getTraceAsString());
				}
			} 
			else 
			{
				$request->session()->flash('error', 'Not enought BTC');
			}
		}
	}

	//Send CLP coin automatically
	function sendCoinCLP(Request $request, $id)
	{
		$withdrawConfirm = WithdrawConfirm::where('id', '=', $id)->first();

		if($request->status == 1){
			$withdrawConfirm->status = 2;
			$withdrawConfirm->save();
			$request->session()->flash('error', 'The withdrawal is cancelled!');
		}else {
			$user = UserCoin::where('userId', $withdrawConfirm->userId)->first();
			if ($user->clpCoinAmount - config('app.fee_withRaw_CLP') >= $withdrawConfirm->withdrawAmount)
			{
				//Change status withdraw confirm
				$withdrawConfirm->status = 1;
				$withdrawConfirm->save();

				try {

					$clpApi = new CLPWalletAPI();
					//Transfer CLP to investor
					//$result = $clpApi->addInvestor($withdrawConfirm->walletAddress, $withdrawConfirm->withdrawAmount);
					$result = $clpApi->transferCLP($withdrawConfirm->walletAddress, $withdrawConfirm->withdrawAmount);

					$newClpCoinAmount = $user->clpCoinAmount - config('app.fee_withRaw_CLP') - $withdrawConfirm->withdrawAmount;

					if ($result["success"] == 1) {
						if(!isset($result["tx"])) throw new \Exception("Transaction have none value");
						
						$update = UserCoin::where("userId", $withdrawConfirm->userId)->update(["clpCoinAmount" => $newClpCoinAmount]);
						
						//insert wallet
						$dataInsertWallet = [
							"walletType" => Wallet::CLP_WALLET,
							"type" => Wallet::WITH_DRAW_CLP_TYPE,
							"userId" => $withdrawConfirm->userId,
							"note" => "Pending",
							"amount" => $withdrawConfirm->withdrawAmount,
							"inOut" => Wallet::OUT
						];

						$resultInsert = Wallet::create($dataInsertWallet);

						//insert withdraw
						$dataInsertWithdraw = [
							"walletAddress" => $withdrawConfirm->walletAddress,
							"userId" => $withdrawConfirm->userId,
							"amountCLP" => $withdrawConfirm->withdrawAmount,
							"at_rate" => ExchangeRate::getCLPUSDRate(),
							"wallet_id" => $resultInsert->id,
							"transaction_id" => '',
							"transaction_hash" => $result["tx"],
							"status" => 0
						];

						Withdraw::create($dataInsertWithdraw);

						$request->session()->flash('successMessage', 'You have withdrawn successfully!');

					} else {
						$request->session()->flash('error', 'The withdrawal fail.');
						//Change status withdraw confirm to 0 if have error
						$withdrawConfirm->status = 0;
						$withdrawConfirm->save();
					}

				} catch (\Exception $e) {
					$request->session()->flash('error', 'The withdrawal fail.');
					//Change status withdraw confirm to 0 if have error
					$withdrawConfirm->status = 0;
					$withdrawConfirm->save();

					Log::error('withdraw CLP has error: ' . $e->getMessage());
				}
			
			} else {
				$request->session()->flash('error', 'Not enought CLP');
			}
		}
	}

	/** 
	 * @author Huy NQ
	 * @param Request $request
	 * @return type
	 */
	public function clpWithDraw( Request $request ) {
		if($request->ajax()) 
		{
			$userCoin = Auth::user()->userCoin;

			$withdrawAmountErr = $walletAddressErr = $withdrawOTPErr = '';

			if($request->withdrawAmount == ''){
				$withdrawAmountErr = trans('adminlte_lang::wallet.amount_required');
			}elseif (!is_numeric($request->withdrawAmount)){
				$withdrawAmountErr = trans('adminlte_lang::wallet.amount_number');
			}elseif (($userCoin->clpCoinAmount - config('app.fee_withRaw_CLP')) < $request->withdrawAmount){
				$withdrawAmountErr = trans('adminlte_lang::wallet.error_not_enough_clp');
			}elseif ($request->withdrawAmount < 0.01){
				$withdrawAmountErr = 'The withdraw amount must be at least 0.01';
			}

			$userData = Auth::user()->userData;
			if($userData->packageId < 1)
			{
				$withdrawAmountErr = 'Please be noted that the minimum mining pack for any withdrawal requests is $100';
			}

			if($request->withdrawAmount * ExchangeRate::getCLPUSDRate() > 3000)
			{
				$withdrawAmountErr = 'You cannot withdraw more than $3,000 per time';
			}

			//Only transfer CLP, Withdraw $10.000 per day
            $totalMoneyOut = UserCoin::getTotalWithdrawTransferDay(Auth::user()->id);

            $currentTotal = $request->withdrawAmount * ExchangeRate::getCLPUSDRate() + $totalMoneyOut;

            if($currentTotal > 10000)
            {
                $withdrawAmountErr = 'You cannot transfer & withdraw more than $10,000 a day';
            }

			if($request->walletAddress == ''){
				$walletAddressErr = 'Ethereum Address is required';
			}elseif (!preg_match('/^\S*$/u', $request->clpUsername)){
				$walletAddressErr = 'Ethereum Address does not have spaces';
			}


			if($request->withdrawOTP == ''){
				$withdrawOTPErr = trans('adminlte_lang::wallet.otp_required');
			}else{
				$key = Auth::user()->google2fa_secret;
				$valid = Google2FA::verifyKey($key, $request->withdrawOTP);
				if(!$valid){
					$withdrawOTPErr = trans('adminlte_lang::wallet.otp_not_match');
				}
			}


			if(  $withdrawAmountErr == '' && $walletAddressErr == '' && $withdrawOTPErr == '') {
				$user = Auth::user();
				if($user){
					$field = [
						'withdrawAmount' => $request->withdrawAmount,
						'walletAddress' => $request->walletAddress,
						'userId' => Auth::user()->id,
						'status' => 0,
						'type' => 'clp',
					];
					$withdrawConfirm = WithdrawConfirm::create($field);
					$encrypt    = [hash("sha256", md5(md5($withdrawConfirm->id))), $withdrawConfirm->id, 'clp', $request->withdrawAmount];
					$linkConfirm =  URL::to('/confirmWithdraw')."?d=".base64_encode(json_encode($encrypt));
					$coinData = ['amount' => $request->withdrawAmount, 'address' => $request->walletAddress, 'type' => 'clp'];
					$user->notify(new WithDrawConfirmNoti($user, $coinData, $linkConfirm));

					$request->session()->flash( 'successMessage', 'The withdrawal confirmation have sent to your mail box!' );
					return response()->json(array('err' => false));
				}
			}else {
				$result = [
					'err' => true,
					'msg' =>[
							'withdrawAmountErr' => $withdrawAmountErr,
							'walletAddressErr' => $walletAddressErr,
							'withdrawOTPErr' => $withdrawOTPErr,
						]
				];
				
				return response()->json($result);
			}
			
		}

		return response()->json(array('err' => false, 'msg' => null));
	}

	public function btcWithDraw( Request $request )
	{
		$user = Auth::user()->userCoin;
		//send coin if request post
		if ( $request->isMethod('post') ) {
			//validate
			$this->validate($request, [
				'withdrawAmount'=>'required|numeric|min:0.0001',
				'walletAddress'=>'required',
				'withdrawOPT'=>'required'
			]);

			$btcOTPErr = '';
			if($request->withdrawOPT == ''){
				$btcOTPErr = trans('adminlte_lang::wallet.otp_required');
			}else{
				$key = Auth::user()->google2fa_secret;
				$valid = Google2FA::verifyKey($key, $request->withdrawOPT);
				if(!$valid){
					$btcOTPErr = trans('adminlte_lang::wallet.otp_not_match');
				}
			}

			if($btcOTPErr != ''){
				$request->session()->flash( 'errorMessage', $btcOTPErr );
				return redirect()->route('wallet.btc');
			}

			//Only transfer CLP, Withdraw $10.000 per day
            $totalMoneyOut = UserCoin::getTotalWithdrawTransferDay(Auth::user()->id);

            //Cannot withdraw more than $3000 per time
            $withdrawValue = $request->withdrawAmount * ExchangeRate::getBTCUSDRate();
            if($withdrawValue > 3000)
            {
            	$request->session()->flash( 'errorMessage', 'You cannot withdraw more than $3,000 per time' );
				return redirect()->route('wallet.btc');
            }

            $currentTotal = $withdrawValue + $totalMoneyOut;
            
            if($currentTotal > 10000)
            {
                //cannot transfer & withdraw more than $10000
				$request->session()->flash( 'errorMessage', 'You cannot transfer & withdraw more than $10,000 a day' );
				return redirect()->route('wallet.btc');
            }

			if($request->walletAddress == ''){
				$walletAddressErr = 'Bitcoin Address is required';
			}elseif (!preg_match('/^\S*$/u', $request->clpUsername)){
				$walletAddressErr = 'Bitcoin Address does not have spaces';
			}

			if ( $user->btcCoinAmount - config('app.fee_withRaw_BTC') >= $request->withdrawAmount ) {
				$user = Auth::user();
				if($user){
					$field = [
						'withdrawAmount' => $request->withdrawAmount,
						'walletAddress' => $request->walletAddress,
						'userId' => Auth::user()->id,
						'status' => 0,
						'type' => 'btc',
					];

					$withdrawConfirm = WithdrawConfirm::create($field);

					$encrypt    = [hash("sha256", md5(md5($withdrawConfirm->id))), $withdrawConfirm->id, 'btc', $request->withdrawAmount];
					$linkConfirm =  URL::to('/confirmWithdraw')."?d=".base64_encode(json_encode($encrypt));
					$coinData = ['amount' => $request->withdrawAmount, 'address' => $request->walletAddress, 'type' => 'btc'];
					$user->notify(new WithDrawConfirmNoti($user, $coinData, $linkConfirm));

					$request->session()->flash( 'successMessage', 'The withdrawal confirmation email was sent to your mail box' );

					return redirect()->route('wallet.btc');
				}
			}else {
				//nếu không đủ tiền thì báo lỗi
				$request->session()->flash( 'errorMessage', trans('adminlte_lang::wallet.error_not_enough_btc') );
				return redirect()->route('wallet.btc');
			}
		}else{
			return redirect()->route('wallet.btc');
		}
	}
}
