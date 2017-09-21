<?php

namespace App\Http\Controllers\Wallet;

use App\UserCoin;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\User;
use App\Wallet;
use App\Withdraw;
use Auth;
use Symfony\Component\HttpFoundation\Session\Session; 
use Validator;
//use App\BitGo\BitGoSDK;
use Coinbase\Wallet\Enum\CurrencyCode;
use Coinbase\Wallet\Resource\Transaction;
use Coinbase\Wallet\Value\Money;
use Coinbase\Wallet\Configuration;
use Coinbase\Wallet\Client;

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
        $this->middleware('auth');
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
    public function btcWithDraw( Request $request ) {
       
        $currentuserid = Auth::user()->id;
        $user = UserCoin::findOrFail($currentuserid);
        
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
            
            if ( UserCoin::findOrFail($currentuserid)->btcCoinAmount - config('app.fee_withRaw_BTC') > 
                    $request->withdrawAmount ) {
                
                 //Config API key
                $configuration = Configuration::apiKey( 
                        config('app.coinbase_key'), 
                        config('app.coinbase_secret') );
            
                $client = Client::create($configuration);

                $transaction = Transaction::send([
                    'toBitcoinAddress' => $request->walletAddress,
                    'amount'           => new Money($request->withdrawAmount, CurrencyCode::BTC),
                    'description'      => 'Your tranfer bitcoin!'
                ]);
                //get object account
                $account = $client->getAccount($user->accountCoinBase);
                //begin send
                try {
                    $resultGiven = $client->createAccountTransaction($account, $transaction);
                    
                    if( count(json_encode($resultGiven) ) == 0) {
                        //lỗi không thực hiện được giao dịch trên coinbase ghi vào LOG

                        //insert withdraw lưu log
                        $dataInsertWithdraw = [
                            "walletAddress" => $request->walletAddress,
                            "userId" => $currentuserid,
                            "amountBTC" => $request->withdrawAmount,
                            "status" => 0
                        ];
                    
                        $dataInsertWithdraw = Withdraw::creat($dataInsert);
                        $request->session()->flash('errorMessage', "Không thực hiện chuyển tiền được trên CoinBase" );
                        return redirect()->route('wallet.btc'); 
                    }
                    
                    /**
                     * Action save to DB
                     */
                    
                    //insert withdraw
                    $dataInsertWithdraw = [
                        "walletAddress" => $request->walletAddress,
                        "userId" => $currentuserid,
                        "amountBTC" => $request->withdrawAmount,
                        "detail" => json_encode($resultGiven),
                        "status" => 1
                    ];
                    
                    $dataInsertWithdraw = Withdraw::creat($dataInsert);
                    //insert wallet
                    $dataInsertWallet = [
                        "walletType" => Wallet::BTC_WALLET,
                        "type" => Wallet::WITH_DRAW_BTC_TYPE,
                        "userId" => $currentuserid,
                        "note" => "Withdraw BTC",
                        "amount" => $request->withdrawAmount,
                        "inOut" => "out"
                    ];
                    $dataInsertWallet = Wallet::creat($dataInsertWallet);
                            
                    if( $dataInsertWithdraw == 1 && $dataInsertWallet == 1 ) {
                        $request->session()->flash( 'successMessage', trans('adminlte_lang::wallet.success_withdraw') );
                        //update btc amount _> DB
                        $btc = (double) $account->getBalance()->getAmount();

                        UserCoin::where('userId', '=',$currentuserid)
                        ->update(['btcCoinAmount' => $btc]);
                        return redirect()->route('wallet.btc');
                    } else {
                        //Không kết nối được DB
                        Log::warning( "Error when insert DB in WithdrawBTC!" );
                        $request->session()->flash( 'errorMessage', trans('adminlte_lang::wallet.error_db') );
                        return redirect()->route('wallet.btc');
                    }
                } catch (\Exception $e) {
                    //lỗi không thực hiện được giao dịch trên coinbase ghi vào LOG
                    Log::error( $e->getTraceAsString() );
                    $request->session()->flash('errorMessage', "Không thực hiện chuyển tiền được trên CoinBase" );
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
    
    /** 
     * @author Huy NQ
     * @param Request $request
     * @return type
     */
    public function clpWithDraw( Request $request ) {
        $currentuserid = Auth::user()->id;
        
        if($request->isMethod("post")) {
            $this->validate($request, [
                'withdrawAmount'=>'required',
                'walletAddress'=>'required',
//              'withdrawOPT'=>'required|min:6'
            ]); 
            
            if( UserCoin::findOrFail($currentuserid)->btcCoinAmount - config('app.fee_withRaw_CLP') > 
                    $request->withdrawAmount ) {
                $link = "http://99.193.6.228:3080/api/withdraw/0xF0f36cC52938A6A4377c6d3B838A9df5A2c28651/1";
            
                try {
                    $ch = curl_init( $link );
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $dataCurrencyPair = curl_exec($ch);
                    curl_close($ch);

                    $newClpCoinAmount = Auth()->user()->usercoin->clpCoinAmount - 
                            $request->withrawAmount;

                    if( isset($dataCurrencyPair) && count(json_decode($dataCurrencyPair)) > 0) {
                        $reSult = json_decode($dataCurrencyPair);
                        if( $reSult["success"] == 1 ) {
                            
                            /** 
                             * update clp wallet
                             */
                            $update =  UserCoin::where("userId",$currentuserid)->update(["clpCoinAmount" => $newClpCoinAmount]);
                            
                            /**
                             * Action save to DB
                             */

                            //insert withdraw
                            $dataInsertWithdraw = [
                                "walletAddress" => $request->walletAddress,
                                "userId" => $currentuserid,
                                "amountBTC" => $request->withdrawAmount,
                                "detail" => $dataCurrencyPair,
                                "status" => 1
                            ];

                            $dataInsertWithdraw = Withdraw::creat($dataInsert);
                            //insert wallet
                            $dataInsertWallet = [
                                "walletType" => Wallet::CLP_WALLET,
                                "type" => Wallet::WITH_DRAW_CLP_TYPE,
                                "userId" => $currentuserid,
                                "note" => "Withdraw CLP",
                                "amount" => $request->withdrawAmount,
                                "inOut" => "out"
                            ];
                            $dataInsertWallet = Wallet::creat($dataInsertWallet);

                            $updateClpCoin = UserCoin::where("userId",$request->withdrawAmount)->update([ "clpCoinAmount" => $newClpCoinAmount]);
                            $request->session()->flash( 'succeesMessage', trans('adminlte_lang::wallet.success') );
                        }else{
                            //save to withdraw
                            
                            //insert withdraw
                            $dataInsertWithdraw = [
                                "walletAddress" => $request->walletAddress,
                                "userId" => $currentuserid,
                                "amountBTC" => $request->withdrawAmount,
                                "detail" => $dataCurrencyPair,
                                "status" => 0
                            ];

                            $dataInsertWithdraw = Withdraw::creat($dataInsert);
                            $request->session()->flash( 'succeesError', trans('adminlte_lang::wallet.error') );
                        }
                    }
                    
                    
                    return redirect()->route('wallet.clp');
                } catch (\Exception $ex) {
                    Log::error($ex->getTraceAsString());
                }
            }else {
                $request->session()->flash( 'errorMessage', trans('adminlte_lang::wallet.error_not_enough') );
                return redirect()->route('wallet.clp');
            }
            
        }
        
    }
}
