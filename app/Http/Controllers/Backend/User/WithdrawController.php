<?php

namespace App\Http\Controllers\Backend\User;

use App\User;
use App\UserData;
use App\UserCoin;
use App\WithdrawConfirm;
use App\Role;
use App\Permission;
use App\Authorizable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

use Coinbase\Wallet\Enum\CurrencyCode;
use Coinbase\Wallet\Resource\Transaction;
use Coinbase\Wallet\Value\Money;
use Coinbase\Wallet\Configuration;
use Coinbase\Wallet\Client;

use App\Withdraw;
use App\CLPWalletAPI;

class WithdrawController extends Controller
{
    //use Authorizable;

    public function index(Request $request)
    {
        $result = WithdrawConfirm::orderBy('id', 'desc')->paginate();

        $expiredTime = Carbon::now()->subMinutes(30);

        return view('adminlte::backend.withdraw.index', compact('result', 'expiredTime'));
    }

    public function withdrawApprove(Request $request)
    {
        if ($request->isMethod('post'))
        {
            if( $request->id ) {
                $withdrawConfirm = WithdrawConfirm::where('id', '=', $request->id)->first();

                if($withdrawConfirm->type == 'btc'){
                    self::sendBTC($request);
                }elseif($withdrawConfirm->type == 'clp'){
                    self::sendCLP($request);
                }

            } else {
                flash()->success('Request not approve ok');
            }
        }

        return redirect()->back();
    }

    public function sendCLP(Request $request)
    {
        $withdrawConfirm = WithdrawConfirm::where('id', '=', $request->id)->first();

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
                        "wallet_id" => $resultInsert->id,
                        "transaction_id" => '',
                        "transaction_hash" => $result["tx"],
                        "status" => 0
                    ];

                    Withdraw::create($dataInsertWithdraw);

                    flash()->success("Request withdraw id: $request->id  has been approved");
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

        return redirect()->back();
    }

    public function sendBTC(Request $request)
    {
        if( $request->id ) {
            $withdrawConfirm = WithdrawConfirm::where('id', '=', $request->id)->first();

            $user = UserCoin::where('userId', $withdrawConfirm->userId)->first();

            if ($user->btcCoinAmount - config('app.fee_withRaw_BTC') >= $withdrawConfirm->withdrawAmount)
            {
                //Change status withdraw confirm
                $withdrawConfirm->status = 3;
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

                    flash()->success("Request withdraw id: $request->id  has been approved");
                } catch (\Exception $e) {
                    $request->session()->flash('error', "The withdrawal fail: " . $e->getMessage());
                    //Change status withdraw confirm to 0 if have error
                    $withdrawConfirm->status = 1;
                    $withdrawConfirm->save();

                    Log::error('withdraw BTC has error: ' . $e->getMessage());
                    Log::info($e->getTraceAsString());
                }
            } 
            else 
            {
                $request->session()->flash('error', 'Not enought BTC');
            }

        } else {
            flash()->success('Request not approve ok');
        }

        return redirect()->back();
    }
}
