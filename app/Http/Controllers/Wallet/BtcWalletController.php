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
use App\ExchangeRate;
use DateTime;

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
    public function showBTCWallet(Request $request){
        $currentuserid = Auth::user()->id;
        //$wallets = Wallet::where('userId', '=',$currentuserid)->where('walletType', Wallet::BTC_WALLET)->paginate();
        $query = Wallet::where('userId', '=',$currentuserid);

        //Filter option
        if(isset($request->type) && $request->type > 0){
            $query->where('type', $request->type);
        }

        $walletAddress = Auth::user()->userCoin->walletAddress;

        $wallets = $query->where('walletType', Wallet::BTC_WALLET)->orderBy('id', 'desc')->paginate();
        $requestQuery = $request->query();


        $all_wallet_type = config('cryptolanding.wallet_type');

        //BTC Wallet has 5 type: 13-Deposit, 9-Withdraw, 7-Buy CLP, 8-Sell CLP, 11-Transfer BTC
        $wallet_type = [];
        $wallet_type[0] = trans('adminlte_lang::wallet.title_selection_filter');
        foreach ($all_wallet_type as $key => $val) {
            if($key == 7) $wallet_type[$key] = trans('adminlte_lang::wallet.btc_clp_type_on_btc');
            if($key == 8) $wallet_type[$key] = trans($val);
            if($key == 9) $wallet_type[$key] = trans($val);
            //if($key == 11) $wallet_type[$key] = trans($val);
            if($key == 13) $wallet_type[$key] = trans($val);
        }

        return view('adminlte::wallets.btc',compact('wallets','wallet_type', 'requestQuery', 'walletAddress'));
    }
    
    /**
     * @author Huy Nq
     * @param Request $request
     * @return type
     */
    public function getBtcCoin(Request $request){
        if($request->ajax()){
            return number_format(Auth()->user()->userCoin->btcCoinAmount, 5);
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
                        'note' => 'Transfer to ' . $request->btcUsername
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

    public function buyCLP(Request $request){
        if($request->ajax()) 
        {
            $userCoin = Auth::user()->userCoin;

            $btcAmountErr = '';
            $clpAmountErr = '';
            if($request->btcAmount == ''){
                $btcAmountErr = trans('adminlte_lang::wallet.amount_required');
            }elseif (!is_numeric($request->btcAmount)){
                $btcAmountErr = trans('adminlte_lang::wallet.amount_number');
            }elseif ($userCoin->btcCoinAmount < $request->btcAmount){
                $btcAmountErr = trans('adminlte_lang::wallet.error_not_enough_btc');
            }

            //Amount CLP
            $clpRate = ExchangeRate::getCLPBTCRate();

            $amountCLP = $request->btcAmount / $clpRate;
            $holdingAmount = 0;

            $currentDate = date('Y-m-d');


            $privateSaleStart = date('Y-m-d', strtotime(config('app.first_private_start')));
            $privateSaleEnd = date('Y-m-d', strtotime(config('app.first_private_end')));

            $secondSaleStart = date('Y-m-d', strtotime(config('app.second_private_start')));
            $secondSaleEnd = date('Y-m-d', strtotime(config('app.second_private_end')));

            $preSaleStart = date('Y-m-d', strtotime(config('app.pre_sale_start')));
            $preSaleEnd = date('Y-m-d', strtotime(config('app.pre_sale_end')));

            if($currentDate <= $preSaleEnd) 
            {


                //Private sale 1
                if($privateSaleStart <= $currentDate && $currentDate <= $privateSaleEnd)
                {

                    if($request->clpAmount != 25000 || $amountCLP < 24950) {
                        $clpAmountErr = trans('adminlte_lang::wallet.msg_private_sale_1') . ' 25,000 CLP ' . trans('adminlte_lang::wallet.msg_sale_tail');
                    }

                    $amountCLP = 10000;
                    $holdingAmount = 15000;
                }

                //Private sale 2
                if($secondSaleStart <= $currentDate && $currentDate <= $secondSaleEnd)
                {
                    //Get total sales
                    $total = Wallet::where('walletType', Wallet::REINVEST_WALLET)
                                    ->where('type', Wallet::BTC_CLP_TYPE)
                                    ->where('amount', 6666.66)
                                    ->count();

                    if($total == 150) {
                        $clpAmountErr = 'Sorry, the quota in this private sale reached.';
                    } else if($request->clpAmount != 16666.66 || $amountCLP < 16630) {
                        $clpAmountErr = trans('adminlte_lang::wallet.msg_private_sale_2') . ' 16,666.66 CLP ' . trans('adminlte_lang::wallet.msg_sale_tail');
                    } else if($userCoin->reinvestAmount > 0) {
                        $clpAmountErr = 'You cannot buy more CLP.';
                    }

                    $amountCLP = 10000;
                    $holdingAmount = 6666.66;
                }

                //Pre sale
                if($preSaleStart <= $currentDate && $currentDate <= $preSaleEnd)
                {
                    if($request->clpAmount != 12500 || $amountCLP < 12475) {
                        $clpAmountErr = trans('adminlte_lang::wallet.msg_pre_sale') . ' 12,500 CLP ' . trans('adminlte_lang::wallet.msg_sale_tail');
                    } else if($userCoin->reinvestAmount > 0) {
                        $clpAmountErr = 'You cannot buy more CLP.';
                    }

                    $amountCLP = 10000;
                    $holdingAmount = 2500;
                }

            }
            

            // nếu tổng số tiền sau khi trừ đi phí lơn hơn 
            // số tiền chuyển đi thì thực hiện giao dịch
            if ( $btcAmountErr == '' && $clpAmountErr == '') {
                
                $userCoin->btcCoinAmount = $userCoin->btcCoinAmount - $request->btcAmount;
                $userCoin->clpCoinAmount = $userCoin->clpCoinAmount + $amountCLP;
                $userCoin->reinvestAmount = $userCoin->reinvestAmount + $holdingAmount;
                $userCoin->save();

                $fieldBTC = [
                    'walletType' => Wallet::BTC_WALLET,//usd
                    'type' => Wallet::BTC_CLP_TYPE,//bonus f1
                    'inOut' => Wallet::OUT,
                    'userId' => Auth::user()->id,
                    'amount' => $request->btcAmount,
                    'note'   => 'Rate ' . number_format($clpRate, 8) . ' BTC'
                ];
                Wallet::create($fieldBTC);

                $fieldCLP = [
                    'walletType' => Wallet::CLP_WALLET,//reinvest
                    'type' => Wallet::BTC_CLP_TYPE,//bonus f1
                    'inOut' => Wallet::IN,
                    'userId' => Auth::user()->id,
                    'amount' => $amountCLP,
                    'note'   => 'Rate ' . number_format($clpRate, 8) . ' BTC'
                ];
                Wallet::create($fieldCLP);

                if($holdingAmount > 0) {
                    $fieldCLPHolding = [
                        'created_at' => date("Y-m-d H:i:s"),
                        'updated_at' => date("Y-m-d H:i:s", strtotime('2017-11-01')),
                        'walletType' => Wallet::REINVEST_WALLET,//reinvest
                        'type' => Wallet::BTC_CLP_TYPE,//bonus f1
                        'inOut' => Wallet::IN,
                        'userId' => Auth::user()->id,
                        'amount' => $holdingAmount,
                        'note'   => 'Rate ' . number_format($clpRate, 8) . ' BTC'
                    ];
                    Wallet::create($fieldCLPHolding);
                }
                

                $request->session()->flash( 'successMessage', trans('adminlte_lang::wallet.msg_buy_clp_success') );
                
                return response()->json(array('err' => false));
            } else {
                $result = [
                        'err' => true,
                        'msg' =>[
                                'btcAmountErr' => $btcAmountErr,
                                'clpAmountErr' => $clpAmountErr,
                            ]
                    ];

                return response()->json($result);
            }
        }

        return response()->json(array('err' => false, 'msg' => null));
    }
    
}
