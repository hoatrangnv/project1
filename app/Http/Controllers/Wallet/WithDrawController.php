<?php

namespace App\Http\Controllers\Wallet;

use App\UserCoin;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\User;
use App\Wallet;
use App\Withdraw;
use App\WithdrawConfirm;
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
use URL;

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
    protected function sendCoin() {
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
    }
    
    /**
     * @author Huynq
     * @param Request $request
     * @return view
     */
    public function confirmWithdraw( Request $request ) {
        $isConfirm = false;
        $withdrawConfirm = [];
        if($request->d != ''){
            $data = json_decode(base64_decode($request->d));
            if($data && isset($data[1]) && $data[1] > 0 && isset($data[2]) && in_array($data[2], ['btc', 'clp'])){
                list($token, $id, $type) = $data;
                $withdrawConfirm = WithdrawConfirm::where('id', '=', $id)->first();
                if($withdrawConfirm){
                    if($withdrawConfirm->status == 0){
                        $count = WithdrawConfirm::where('id','=', $id)
                            ->where('updated_at','>', Carbon::now()->subMinutes(30))
                            ->count();
                        if($count == 0){
                            $isConfirm = true;
                            $request->session()->flash('error', 'Link Confirm Withdraw expired!');
                        }else{
                            if ( $token == hash( "sha256", md5( md5( $id ) ) ) ) {
                                if ($request->isMethod('post')){
                                    if($withdrawConfirm->type == 'btc'){
                                        $isConfirm = self::sendCoinBTC($request, $id);
                                    }elseif($withdrawConfirm->type == 'clp'){
                                        $isConfirm = self::sendCoinCLP($request, $id);
                                    }
                                }
                            }else{
                                $request->session()->flash('error', 'Something wrongs. We cannot Confirm Withdraw!');
                            }
                        }
                    }elseif($withdrawConfirm->status == 2){
                        $isConfirm = true;
                        $request->session()->flash('status', 'Withdraw have Cancel!');
                    }else{
                        $isConfirm = true;
                        $request->session()->flash('status', 'Withdraw have done Confirm!');
                    }
                }else{
                    $request->session()->flash('error', 'Something wrongs. We cannot Confirm Withdraw!');
                }
            }
        }else{
            $request->session()->flash('error', 'Something wrongs. We cannot Confirm Withdraw!');
        }
        return view('adminlte::wallets.confirmWithdraw', compact('isConfirm', 'withdrawConfirm'));
    }
    function sendCoinBTC(Request $request, $id){
        $isConfirm = false;
        $withdrawConfirm = WithdrawConfirm::where('id', '=', $id)->first();
        if($request->status == 1){
            $withdrawConfirm->status = 2;
            $withdrawConfirm->save();
            $request->session()->flash('status', 'Withdraw have Cancel!');
            $isConfirm = true;
        }else {
            $user = UserCoin::where('userId', $withdrawConfirm->userId)->first();
            // nếu tổng số tiền sau khi trừ đi phí lơn hơn
            // số tiền chuyển đi thì thực hiện giao dịch
            if ($user->btcCoinAmount - config('app.fee_withRaw_BTC') > $withdrawConfirm->withdrawAmount) {
                //Config API key
                $configuration = Configuration::apiKey(config('app.coinbase_key'), config('app.coinbase_secret'));
                $client = Client::create($configuration);
                $transaction = Transaction::send([
                    'toBitcoinAddress' => $withdrawConfirm->walletAddress,
                    'amount' => new Money($withdrawConfirm->withdrawAmount, CurrencyCode::BTC),
                    'description' => 'Your tranfer bitcoin!'
                ]);
                //get object account
                $account = $client->getAccount($user->accountCoinBase);
                //begin send
                try {
                    $resultGiven = $client->createAccountTransaction($account, $transaction);
                    if (count(json_encode($resultGiven)) == 0) {
                        //lỗi không thực hiện được giao dịch trên coinbase ghi vào LOG
                        //insert withdraw -- lưu lịch ví -- trạng thái fail
                        $dataInsertWithdraw = [
                            "walletAddress" => $withdrawConfirm->walletAddress,
                            "userId" => $withdrawConfirm->userId,
                            "amountBTC" => $withdrawConfirm->withdrawAmount,
                            "status" => 0
                        ];
                        $dataInsertWithdraw = Withdraw::create($dataInsertWithdraw);
                        $request->session()->flash('error', "Không thực hiện chuyển tiền được trên CoinBase");
                        //return redirect()->route('wallet.btc');
                    }
                    //insert withdraw -- lưu lịch sử giao dịch -- trạng thái success
                    $dataInsertWithdraw = [
                        "walletAddress" => $withdrawConfirm->walletAddress,
                        "userId" => $withdrawConfirm->userId,
                        "amountBTC" => $withdrawConfirm->withdrawAmount,
                        "detail" => json_encode($resultGiven),
                        "status" => 1
                    ];
                    $dataInsertWithdraw = Withdraw::create($dataInsertWithdraw);
                    //insert wallet -- lưu lịch sử ví
                    $dataInsertWallet = [
                        "walletType" => Wallet::BTC_WALLET,
                        "type" => Wallet::WITH_DRAW_BTC_TYPE,
                        "userId" => $withdrawConfirm->userId,
                        "note" => "Withdraw BTC",
                        "amount" => $withdrawConfirm->withdrawAmount,
                        "inOut" => "out"
                    ];
                    $dataInsertWallet = Wallet::create($dataInsertWallet);
                    if ($dataInsertWithdraw && $dataInsertWallet) {
                        $request->session()->flash('error', trans('adminlte_lang::wallet.success_withdraw'));
                        //update btc amount _> DB
                        $btc = (double)$account->getBalance()->getAmount();
                        UserCoin::where('userId', '=', $withdrawConfirm->userId)->update(['btcCoinAmount' => $btc]);
                        $withdrawConfirm->status = 1;
                        $withdrawConfirm->save();
                        $isConfirm = true;

                        //return redirect()->route('wallet.btc');
                    } else {
                        //Không kết nối được DB
                        Log::warning("Error when insert DB in WithdrawBTC!");
                        $request->session()->flash('error', trans('adminlte_lang::wallet.error_db'));
                        //return redirect()->route('wallet.btc');
                    }
                } catch (\Exception $e) {
                    //lỗi không thực hiện được giao dịch trên coinbase ghi vào LOG
                    Log::error($e->getTraceAsString());
                    $request->session()->flash('error', "Không thực hiện chuyển tiền được trên CoinBase");
                    //return redirect()->route('wallet.btc');
                }
            } else {
                //nếu không đủ tiền thì báo lỗi
                $request->session()->flash('error', trans('adminlte_lang::wallet.error_not_enough'));
                //return redirect()->route('wallet.btc');
            }
        }
        return $isConfirm;
    }

    function sendCoinCLP(Request $request, $id){
        $isConfirm = false;
        $withdrawConfirm = WithdrawConfirm::where('id', '=', $id)->first();
        if($request->status == 1){
            $withdrawConfirm->status = 2;
            $withdrawConfirm->save();
            $request->session()->flash('status', 'Withdraw have Cancel!');
            $isConfirm = true;
        }else {
            $user = UserCoin::where('userId', $withdrawConfirm->userId)->first();
            if ($user->clpCoinAmount - config('app.fee_withRaw_CLP') > $withdrawConfirm->withdrawAmount) {
                $link = "http://99.193.6.228:3080/api/withdraw/0xF0f36cC52938A6A4377c6d3B838A9df5A2c28651/1";
                try {
                    $ch = curl_init($link);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $dataCurrencyPair = curl_exec($ch);
                    curl_close($ch);
                    $newClpCoinAmount = $user->clpCoinAmount - $withdrawConfirm->withrawAmount;
                    if (isset($dataCurrencyPair) && count(json_decode($dataCurrencyPair)) > 0) {
                        $reSult = json_decode($dataCurrencyPair);
                        if ($reSult["success"] == 1) {
                            $update = UserCoin::where("userId", $withdrawConfirm->userId)->update(["clpCoinAmount" => $newClpCoinAmount]);
                            //insert withdraw -- lưu lịch sử giao dịch -- trạng thái ở đây là success
                            $dataInsertWithdraw = [
                                "walletAddress" => $withdrawConfirm->walletAddress,
                                "userId" => $withdrawConfirm->userId,
                                "amountCLP" => $withdrawConfirm->withdrawAmount,
                                "detail" => $dataCurrencyPair,
                                "status" => 1
                            ];
                            $dataInsertWithdraw = Withdraw::create($dataInsertWithdraw);
                            //insert wallet -- lưu lịch sử ví
                            $dataInsertWallet = [
                                "walletType" => Wallet::CLP_WALLET,
                                "type" => Wallet::WITH_DRAW_CLP_TYPE,
                                "userId" => $withdrawConfirm->userId,
                                "note" => "Withdraw CLP",
                                "amount" => $withdrawConfirm->withdrawAmount,
                                "inOut" => "out"
                            ];
                            $resultInsert = Wallet::create($dataInsertWallet);
                            $updateClpCoin = UserCoin::where("userId", $withdrawConfirm->withdrawAmount)->update(["clpCoinAmount" => $newClpCoinAmount]);
                            $request->session()->flash('succeesMessage', trans('adminlte_lang::wallet.success'));
                            $withdrawConfirm->status = 1;
                            $withdrawConfirm->save();
                            $isConfirm = true;
                        } else {
                            //save to withdraw
                            //insert withdraw -- lưu lịch sử ví -- trạng thái ở đây là fail
                            $dataInsertWithdraw = [
                                "walletAddress" => $withdrawConfirm->walletAddress,
                                "userId" => $withdrawConfirm->userId,
                                "amountCLP" => $withdrawConfirm->withdrawAmount,
                                "detail" => $dataCurrencyPair,
                                "status" => 0
                            ];
                            $resultInsert = Withdraw::create($dataInsertWithdraw);
                            $request->session()->flash('succeesError', trans('adminlte_lang::wallet.error'));
                        }
                    }
                    //return redirect()->route('wallet.clp');
                } catch (\Exception $ex) {
                    Log::error($ex->getTraceAsString());
                }
            } else {
                $request->session()->flash('errorMessage', trans('adminlte_lang::wallet.error_not_enough'));
                //return redirect()->route('wallet.clp');
            }
        }
        return $isConfirm;
    }
    /** 
     * @author Huy NQ
     * @param Request $request
     * @return type
     */
    public function clpWithDraw( Request $request ) {
        if($request->isMethod("post")) {
            $this->validate($request, [
                'withdrawAmount'=>'required',
                'walletAddress'=>'required',
//              'withdrawOPT'=>'required|min:6'
            ]);
            if( Auth::user()->userCoin->clpCoinAmount - config('app.fee_withRaw_CLP') > $request->withdrawAmount ) {
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
                    $encrypt    = [hash("sha256", md5(md5($withdrawConfirm->id))), $withdrawConfirm->id, 'clp'];
                    $linkConfirm =  URL::to('/confirmWithdraw')."?d=".base64_encode(json_encode($encrypt));
                    $coinData = ['amount' => $request->withdrawAmount, 'address' => $request->walletAddress, 'type' => 'clp'];
                    $user->notify(new WithDrawConfirmNoti($user, $coinData, $linkConfirm));
                    $request->session()->flash( 'successMessage', trans('adminlte_lang::wallet.success_withdraw') );
                    return redirect()->route('wallet.clp');
                }
            }else {
                $request->session()->flash( 'errorMessage', trans('adminlte_lang::wallet.error_not_enough') );
                return redirect()->route('wallet.clp');
            }
        }else{
            return redirect()->route('wallet.clp');
        }
    }
    public function btcWithDraw( Request $request ) {
        $user = Auth::user()->userCoin;
        //send coin if request post
        if ( $request->isMethod('post') ) {
            //validate
            $this->validate($request, [
                'withdrawAmount'=>'required|numeric',
                'walletAddress'=>'required'
                //'withdrawOPT'=>'required|min:6'
            ]);
            // nếu tổng số tiền sau khi trừ đi phí lơn hơn
            // số tiền chuyển đi thì thực hiện giao dịch
            if ( $user->btcCoinAmount - config('app.fee_withRaw_BTC') > $request->withdrawAmount ) {
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
                    $encrypt    = [hash("sha256", md5(md5($withdrawConfirm->id))), $withdrawConfirm->id, 'btc'];
                    $linkConfirm =  URL::to('/confirmWithdraw')."?d=".base64_encode(json_encode($encrypt));
                    $coinData = ['amount' => $request->withdrawAmount, 'address' => $request->walletAddress, 'type' => 'btc'];
                    $user->notify(new WithDrawConfirmNoti($user, $coinData, $linkConfirm));
                    $request->session()->flash( 'successMessage', trans('adminlte_lang::wallet.success_withdraw') );
                    return redirect()->route('wallet.btc');
                }
            }else {
                //nếu không đủ tiền thì báo lỗi
                $request->session()->flash( 'errorMessage', trans('adminlte_lang::wallet.error_not_enough') );
                return redirect()->route('wallet.btc');
            }
        }else{
            return redirect()->route('wallet.btc');
        }
    }
}
