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
            if($key == 7) $wallet_type[$key] = trans($val);
            if($key == 8) $wallet_type[$key] = trans($val);
            if($key == 9) $wallet_type[$key] = trans($val);
            if($key == 11) $wallet_type[$key] = trans($val);
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
        $currentuserid = Auth::user()->id;
        $userCoin = Auth::user()->userCoin;
        if ( $request->isMethod('post') ) {
            //validate
            $this->validate($request, [
                'btcAmount'=>'required|numeric',
                'clpAmount'=>'required|numeric'
            ]);
            // nếu tổng số tiền sau khi trừ đi phí lơn hơn 
            // số tiền chuyển đi thì thực hiện giao dịch
            if ( $userCoin->btcCoinAmount >= $request->btcAmount ) {
                //Amount CLP
                $amountCLP = ($request->btcAmount / ExchangeRate::getCLPBTCRate()) + $userCoin->clpCoinAmount;
                $userCoin->btcCoinAmount = $userCoin->btcCoinAmount - $request->btcAmount;
                $userCoin->clpCoinAmount = $amountCLP;
                $userCoin->save();

                $fieldBTC = [
                    'walletType' => Wallet::BTC_WALLET,//usd
                    'type' => Wallet::BTC_CLP_TYPE,//bonus f1
                    'inOut' => Wallet::OUT,
                    'userId' => Auth::user()->id,
                    'amount' => $request->btcAmount,
                    'note'   => 'Buy CLP'
                ];
                Wallet::create($fieldBTC);

                $fieldCLP = [
                    'walletType' => Wallet::CLP_WALLET,//reinvest
                    'type' => Wallet::BTC_CLP_TYPE,//bonus f1
                    'inOut' => Wallet::IN,
                    'userId' => Auth::user()->id,
                    'amount' => $amountCLP,
                    'note'   => 'Buy CLP by BTC'
                ];
                Wallet::create($fieldCLP);

                $request->session()->flash( 'successMessage', trans('adminlte_lang::wallet.msg_buy_clp_success') );
                return redirect()->route('wallet.btc');
            } else {
                //Not enough money
                $request->session()->flash( 'errorMessage', trans('adminlte_lang::wallet.error_not_enough') );
                return redirect()->route('wallet.btc');
            }
        } else { 
            return redirect()->route('wallet.btc');
        }
        
    }
    
}
