<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

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
use Google2FA;

use Log;

/**
 * Description of BtcWalletController
 *
 * @author huydk
 */
class BtcWalletController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * @author Huy NQ
     * @param Request $request
     * @return type
     */
    public function btcWallet(Request $request){
        $currentuserid = Auth::user()->id;
        $wallets = Wallet::where('userId', '=',$currentuserid)->where('walletType', Wallet::BTC_WALLET)
                            //->take(10)
            ->paginate();
        $query = Wallet::where('userId', '=',$currentuserid);
        if(isset($request->type) && $request->type > 0){
            $query->where('type', $request->type);
        }
        $wallets = $query->where('walletType', Wallet::BTC_WALLET)->paginate();
        $requestQuery = $request->query();
        $wallet_type = config('cryptolanding.wallet_type');
        foreach ($wallet_type as $key => $val)
            $wallet_type[$key] = trans($val);

        $all_wallet_type = config('cryptolanding.wallet_type');

        //BTC Wallet has 5 type: 13-Deposit, 9-Withdraw, 7-Buy CLP, 8-Sell CLP, 11-Transfer BTC
        $wallet_type = [];
        foreach ($all_wallet_type as $key => $val) {
            if($key == 7) $wallet_type[$key] = trans($val);
            if($key == 8) $wallet_type[$key] = trans($val);
            if($key == 9) $wallet_type[$key] = trans($val);
            if($key == 11) $wallet_type[$key] = trans($val);
            if($key == 13) $wallet_type[$key] = trans($val);
        }
        
        return view('adminlte::wallets.btc',compact('wallets','wallet_type', 'requestQuery'));
    }
    
    /** 
     * @author Huynq
     * @param Request $request
     * @return type
     */
    public static function deposit(Request $request){
        if($request->ajax()) {
            if(isset($request['action']) && $request['action'] == 'btc') {
                $user = Auth::user()->userCoin;
                return response()->json(array('walletAddress' => $user->walletAddress));
            }
        }
        die();
    }
    
    /**
     * @author Huy Nq
     * @param Request $request
     * @return type
     */
    public function getBtcCoin(Request $request){
        if($request->ajax()){
            return Auth()->user()->userCoin->btcCoinAmount;
        }
    }
    
    /** 
     * @author Huynq
     * @param Request $request
     * @return type
     */
    public function btctranfer(Request $request){
        if($request->ajax()){
            $userCoin = Auth::user()->userCoin;
            $btcAmountErr = $btcUsernameErr = $btcUidErr = $btcOTPErr = '';
            if($request->btcAmount == ''){
                $btcAmountErr = trans('adminlte_lang::wallet.amount_required');
            }elseif (!is_numeric($request->btcAmount)){
                $btcAmountErr = trans('adminlte_lang::wallet.amount_number');
            }elseif ($userCoin->btcCoinAmount < $request->btcAmount){
                $btcAmountErr = trans('adminlte_lang::wallet.error_not_enough');
            }
            if($request->btcUsername == ''){
                $btcUsernameErr = trans('adminlte_lang::wallet.username_required');
            }elseif (!preg_match('/^\S*$/u', $request->btcUsername)){
                $btcUsernameErr = trans('adminlte_lang::wallet.username_notspace');
            }elseif (!User::where('name', $request->btcUsername)->where('active', 1)->count()){
                $btcUsernameErr = trans('adminlte_lang::wallet.username_not_invalid');
            }
            if($request->btcUid == ''){
                $btcUidErr = trans('adminlte_lang::wallet.uid_required');
            }elseif (!preg_match('/^\S*$/u', $request->btcUid)){
                $btcUidErr = trans('adminlte_lang::wallet.uid_notspace');
            }elseif (!User::where('uid', $request->btcUid)->where('active', 1)->count()){
                $btcUidErr = trans('adminlte_lang::wallet.uid_not_invalid');
            }
            if($request->btcOTP == ''){
                $btcOTPErr = trans('adminlte_lang::wallet.otp_required');
            }else{
                $key = Auth::user()->google2fa_secret;
                $valid = Google2FA::verifyKey($key, $request->btcOTP);
                if(!$valid){
                    $btcOTPErr = trans('adminlte_lang::wallet.otp_not_match');
                }
            }
            if($btcAmountErr =='' && $btcUsernameErr == '' && $btcOTPErr == '' && $btcUidErr == ''){
                $userCoin->btcCoinAmount = $userCoin->btcCoinAmount - $request->btcAmount;
                $userCoin->save();
                $userRi = User::where('name', $request->btcUsername)->where('active', 1)->first();
                $userRiCoin = $userRi->userCoin;
                if($userRiCoin){
                    $userRiCoin->btcCoinAmount = $userRiCoin->btcCoinAmount + $request->btcAmount;
                    $userRiCoin->save();

                    $field = [
                        'walletType' => Wallet::BTC_WALLET,//btc
                        'type' =>  Wallet::TRANSFER_BTC_TYPE,//transfer BTC
                        'inOut' => Wallet::OUT,
                        'userId' => $userCoin->userId,
                        'amount' => $request->btcAmount,
                        'note' => 'Transfer from ' . $request->btcUsername
                    ];

                    Wallet::create($field);

                    $field = [
                        'walletType' => Wallet::BTC_WALLET,//btc
                        'type' => Wallet::TRANSFER_BTC_TYPE,//transfer BTC
                        'inOut' => Wallet::IN,
                        'userId' => $userRiCoin->userId,
                        'amount' => $request->btcAmount,
                        'note' => 'Transfer from ' . $request->btcUsername
                    ];

                    Wallet::create($field);

                    $request->session()->flash( 'successMessage', trans('adminlte_lang::wallet.success_tranfer_btc') );
                    return response()->json(array('err' => false));
                }else{
                    $result = [
                        'err' => true,
                        'msg' =>[
                                'btcAmountErr' => '',
                                'btcUsernameErr' => trans('adminlte_lang::wallet.user_required'),
                                'btcOTPErr' => '',
                                'btcUidErr' => '',
                            ]
                    ];
                    return response()->json($result);
                }
            }else{
                $result = [
                    'err' => true,
                    'msg' =>[
                        'btcAmountErr' => $btcAmountErr,
                        'btcUsernameErr' => $btcUsernameErr,
                        'btcOTPErr' => $btcOTPErr,
                        'btcUidErr' => $btcUidErr,
                    ]
                ];
                return response()->json($result);
            }
        }
        return response()->json(array('err' => true, 'msg' => null));
    }
    public function tranferBtcClp(Request $request){
        $currentuserid = Auth::user()->id;
        $userCoin = Auth::user()->userCoin;
        $walletAdmin = config("app.btc_wallet_admin");
        if ( $request->isMethod('post') ) {
            //validate
            $this->validate($request, [
                'btcAmount'=>'required|numeric',
                'clpAmount'=>'required|numeric'
            ]);
            // nếu tổng số tiền sau khi trừ đi phí lơn hơn 
            // số tiền chuyển đi thì thực hiện giao dịch
            if ( $userCoin->btcCoinAmount - config('app.fee_withRaw') >
                    $request->btcAmount ) {
                //Config API key
                $configuration = Configuration::apiKey( 
                        config('app.coinbase_key'), 
                        config('app.coinbase_secret') );
            
                $client = Client::create($configuration);
                //quy đổi sang clp cho user
                $newClpUser = $request->btcAmount / User::getCLPBTCRate() + $userCoin->clpCoinAmount;
                $transaction = Transaction::send([
                    'toBitcoinAddress' => $walletAdmin,
                    'amount'           => new Money($request->btcAmount, CurrencyCode::BTC),
                    'description'      => 'Your tranfer bitcoin!'
                ]);
                //get object account
                $account = $client->getAccount($userCoin->accountCoinBase);
                //begin send
                try {
                    $resultGiven = $client->createAccountTransaction($account, $transaction);
                    //Action save to DB
                    if( count(json_encode($resultGiven)) > 0) {
                        //Lưu log
                        $dataInsert = [
                            "walletAddress" => $address,
                            "userId" => $currentuserid,
                            "amountBTC" => $request->btcAmount,
                            "detail" => json_encode($resultGiven)
                        ];
                        $dataInsert = Withdraw::create($dataInsert);
                        if($dataInsert == 1) {
                            $request->session()->flash( 'successMessage', trans('adminlte_lang::wallet.success_withdraw') );
                            //update btc amount của user sau khi chuyển
                            $btc = (double) $account->getBalance()->getAmount();
                            UserCoin::where('userId', '=',$currentuserid)
                            ->update([
                                'btcCoinAmount' => $btc,
                                'clpCoinAmount' => $newClpUser
                            ]);
                            return redirect()->route('wallet.btc');
                        } else {
                            //Không kết nối được DB
                            Log::warning( "Error when insert or update into DB !" );
                            $request->session()->flash( 'errorMessage', trans('adminlte_lang::wallet.error_db') );
                            return redirect()->route('wallet.btc');
                        }
                        
                    }else{
                        //lỗi không thực hiện được giao dịch trên coinbase ghi vào LOG
                        //Log::error( $e->getTraceAsString() );
                        $request->session()->flash('errorMessage', "Không thực hiện chuyển tiền được trên CoinBase" );
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
        } else { 
            return redirect()->route('wallet.btc');
        }
        
    }
    
    /** 
     * @author Huynq
     * @param Request $request
     * @return type
     */
    public static function switchBTCCLP(Request $request){
         //if have get rq
        if( $request->method( 'get' ) ) {
            if( is_numeric( $request->value ) ){
                
                if($request->value == 0){
                    $data = 0;
                    return BtcWalletController::responseSuccess( $data );
                }
                
                if($request->type ===  "ClpToBtc"){
                    $clpbtc = new BtcWalletController();
                    
                    $data = $request->value * ( USER::getCLPBTCRate() );
                    return $clpbtc->responseSuccess( $data );
                } else {
                    $clpbtc = new BtcWalletController();
                    
                    $data = $request->value * ( 1/USER::getCLPBTCRate() );
                    return $clpbtc->responseSuccess( $data );
                }  
            }
        }
    }
    
}
