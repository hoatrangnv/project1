<?php

namespace App\Http\Controllers\Backend\User;

use App\User;
use App\UserData;
use App\UserCoin;
use App\Wallet;
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
use App\ExchangeRate;

use Log;

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

    public function withdrawReject(Request $request)
    {
        if ($request->isMethod('post'))
        {
            if( $request->id ) {
                $withdrawConfirm = WithdrawConfirm::where('id', '=', $request->id)->first();

                $withdrawRecord = Withdraw::where('id', $withdrawConfirm->wallet_id)->first();
                $withdrawRecord->status = 3; //Reject
                $withdrawRecord->save();

                //User
                $user = User::where('id', $withdrawRecord->userId)->first();
                $userCoin = $user->userCoin;

                $walletId = $withdrawRecord->wallet_id;
                $wallet = Wallet::where('id', $withdrawRecord->wallet_id)->first();
                $wallet->note = "Rejected";
                $wallet->save();

                //Return money for user
                if($withdrawConfirm->type == 'btc')
                {
                    $userCoin->btcCoinAmount += config('app.fee_withRaw_BTC') + $withdrawConfirm->withdrawAmount;
                }elseif($withdrawConfirm->type == 'clp')
                {
                    $userCoin->clpCoinAmount += config('app.fee_withRaw_CLP') + $withdrawConfirm->withdrawAmount;
                }
                $userCoin->save();

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
        
        //Change status withdraw confirm
        $withdrawConfirm->status = 1; //Approve
        $withdrawConfirm->save();

        try {

            $clpApi = new CLPWalletAPI();
            //Transfer CLP to investor
            //$result = $clpApi->addInvestor($withdrawConfirm->walletAddress, $withdrawConfirm->withdrawAmount);
            $result = $clpApi->transferCLP($withdrawConfirm->walletAddress, $withdrawConfirm->withdrawAmount);

            if ($result["success"] == 1) {
                if(!isset($result["tx"])) throw new \Exception("Transaction have none value");
                
                //withdraw
                $withdrawRecord = Withdraw::where('id', $withdrawConfirm->withdraw_id)->first();
                $withdrawRecord->status = 0;
                $withdrawRecord->save();

                //wallet
                $wallet = Wallet::where('id', $withdrawRecord->wallet_id)->first();
                $wallet->note = "Pending";
                $wallet->save();

                flash()->success("Request withdraw id: $request->id  has been approved");
            } else {
                flash()->error('The withdrawal fail.');
                //Change status withdraw confirm to 3 if have error
                $withdrawConfirm->status = 3;
                $withdrawConfirm->save();
            }

        } catch (\Exception $e) {
            flash()->error('The withdrawal fail - Exception -' . $e->getMessage());
            //Change status withdraw confirm to 2 - Cancel if have error
            //Do NOTHING
            $withdrawConfirm->status = 3;
            $withdrawConfirm->save();
            /*
            //Withdraw record
            $withdrawRecord = Withdraw::where('id', $withdrawConfirm->withdraw_id)->first();
            $withdrawRecord->status = 3; //Reject
            $withdrawRecord->save();

            //User
            $user = User::where('id', $withdrawRecord->userId)->first();
            $userCoin = $user->userCoin;

            //Wallet
            $wallet = Wallet::where('id', $withdrawRecord->wallet_id)->first();
            $wallet->note = "Error";
            $wallet->save();

            //Return money for user
            $userCoin->clpCoinAmount += config('app.fee_withRaw_CLP') + $withdrawConfirm->withdrawAmount;
            $userCoin->save();*/

            Log::error('withdraw CLP has error: ' . $e->getMessage());
            Log::info('confirm id:' . $withdrawConfirm->id);
            Log::info($e->getTraceAsString());
        }
        
        return redirect()->back();
    }

    public function sendBTC(Request $request)
    {
        if( $request->id ) {
            $withdrawConfirm = WithdrawConfirm::where('id', '=', $request->id)->first();

            $user = UserCoin::where('userId', $withdrawConfirm->userId)->first();

            
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

                //Withdraw record
                $withdrawRecord = Withdraw::where('id', $withdrawConfirm->withdraw_id)->first();
                $withdrawRecord->transaction_hash = $transaction_hash;
                $withdrawRecord->transaction_id = $transaction_id;
                $withdrawRecord->status = 0;
                $withdrawRecord->save();


                $walletId = $withdrawRecord->wallet_id;
                $wallet = Wallet::where('id', $withdrawRecord->wallet_id)->first();
                $wallet->note = "Pending";
                $wallet->save();

                flash()->success("Request withdraw id: $request->id  has been approved");
            } catch (\Exception $e) {
                $request->session()->flash('error', "The withdrawal fail: " . $e->getMessage());
                //Change status withdraw confirm to 0 if have error
                //Do NOTHING
                $withdrawConfirm->status = 2;
                $withdrawConfirm->save();
                
                //Withdraw record
                $withdrawRecord = Withdraw::where('id', $withdrawConfirm->withdraw_id)->first();
                $withdrawRecord->status = 3; //Reject
                $withdrawRecord->save();

                //User
                $user = User::where('id', $withdrawRecord->userId)->first();
                $userCoin = $user->userCoin;

                $walletId = $withdrawRecord->wallet_id;
                $wallet = Wallet::where('id', $withdrawRecord->wallet_id)->first();
                $wallet->note = "Error";
                $wallet->save();

                //Return money for user
                $userCoin->btcCoinAmount += config('app.fee_withRaw_BTC') + $withdrawConfirm->withdrawAmount;
                $userCoin->save();

                Log::error('withdraw BTC has error: ' . $e->getMessage());
                Log::info('confirm id:' . $withdrawConfirm->id);
                Log::info($e->getTraceAsString());
            }

        } else {
            flash()->success('Request not approve ok');
        }

        return redirect()->back();
    }
}
