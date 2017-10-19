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
use App\Package;
use App\User;
use App\Wallet;
use App\Withdraw;
use Auth;
use Symfony\Component\HttpFoundation\Session\Session; 
use Validator;
use Log;
use App\CLPWalletAPI;
use App\CLPWallet;
use App\ExchangeRate;
use Google2FA;

/**
 * Description of ClpWalletController
 *
 * @author huydk
 */
class ClpWalletController extends Controller {
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * @author Huynq
     * @return type
     */
    public function clpWallet(Request $request) {
        $currentuserid = Auth::user()->id;
        $query = Wallet::where('userId', '=',$currentuserid);
        if(isset($request->type) && $request->type > 0){
            $query->where('type', $request->type);
        }
        $wallets = $query->where('walletType', Wallet::CLP_WALLET)->orderBy('id', 'desc')->paginate();
        //get Packgage
        $user = Auth::user();
        $packages = Package::all();
        $lstPackSelect = array();
        foreach ($packages as $package){
            $lstPackSelect[$package->id] = $package->name;
        }
        $requestQuery = $request->query();

        $all_wallet_type = config('cryptolanding.wallet_type');

        //CLP Wallet has 6 type:15-buy pack, 14-Deposit, 10-Withdraw, 7-Buy CLP by BTC, 8-Sell CLP, 5-Buy CLP by USD, 6-Transfer From Holding Wallet
        $wallet_type = [];
        $wallet_type[0] = trans('adminlte_lang::wallet.title_selection_filter');
        foreach ($all_wallet_type as $key => $val) {
            if($key == 5) $wallet_type[$key] = trans($val);
            if($key == 6) $wallet_type[$key] = trans($val);
            if($key == 7) $wallet_type[$key] = trans($val);
            if($key == 8) $wallet_type[$key] = trans($val);
            if($key == 10) $wallet_type[$key] = trans($val);
            if($key == 12) $wallet_type[$key] = trans($val);
            if($key == 14) $wallet_type[$key] = trans($val);
            if($key == 15) $wallet_type[$key] = trans($val);
        }

        $clpWallet = CLPWallet::where('userId', $currentuserid)->selectRaw('address')->first();
        $walletAddress = isset($clpWallet->address) ? $clpWallet->address : '';

        $currentDate = date('Y-m-d');
        $preSaleEnd = date('Y-m-d', strtotime(config('app.pre_sale_end')));

        $active = 0;
        if($currentDate > $preSaleEnd) {
            $active = 1;
        }

        return view('adminlte::wallets.clp', ['packages' => $packages, 
            'user' => $user, 
            'lstPackSelect' => $lstPackSelect, 
            'wallets'=> $wallets,
            'wallet_type'=> $wallet_type,
            'walletAddress' =>  $walletAddress,
            'requestQuery'=> $requestQuery,
            'active' => $active
        ]);
        
    }

    public static function generateCLPWallet() {
        $client = new CLPWalletAPI();

        $result = $client->generateWallet();
        if($result['success'] == 1) {
            $fields = [
                'address'     => $result['address'],
                'transaction'     => $result['tx'],
            ];

            CLPWallet::create();
        }

    }

    public function sellCLP(Request $request)
    {
        if($request->ajax()) 
        {

            $userCoin = Auth::user()->userCoin;

            $clpAmountErr = '';
            if($request->clpAmount == ''){
                $clpAmountErr = trans('adminlte_lang::wallet.amount_required');
            }elseif (!is_numeric($request->clpAmount)){
                $clpAmountErr = trans('adminlte_lang::wallet.amount_number');
            }elseif ($userCoin->clpCoinAmount < $request->clpAmount){
                $clpAmountErr = trans('adminlte_lang::wallet.error_not_enough_clp');
            }

            if ( $clpAmountErr == '') {
                //Amount CLP
                $clpRate = ExchangeRate::getCLPBTCRate() * 0.95;
                $amountBTC = $request->clpAmount * $clpRate;
                $userCoin->clpCoinAmount = ($userCoin->clpCoinAmount - $request->clpAmount);
                $userCoin->btcCoinAmount = $userCoin->btcCoinAmount + $amountBTC;
                $userCoin->save();

                $fieldCLP = [
                    'walletType' => Wallet::CLP_WALLET,//usd
                    'type' => Wallet::CLP_BTC_TYPE,//bonus f1
                    'inOut' => Wallet::OUT,
                    'userId' => Auth::user()->id,
                    'amount' => $request->clpAmount,
                    'note'   => 'Rate ' . number_format($clpRate, 8) . ' BTC'
                ];
                Wallet::create($fieldCLP);

                $fieldBTC = [
                    'walletType' => Wallet::BTC_WALLET,//reinvest
                    'type' => Wallet::CLP_BTC_TYPE,//bonus f1
                    'inOut' => Wallet::IN,
                    'userId' => Auth::user()->id,
                    'amount' => $amountBTC,
                    'note'   => 'Rate ' . number_format($clpRate, 8) . ' BTC'
                ];

                Wallet::create($fieldBTC);
                $request->session()->flash( 'successMessage', trans('adminlte_lang::wallet.msg_sell_clp_success') );

                return response()->json(array('err' => false));
            } else {
                $result = [
                        'err' => true,
                        'msg' =>[
                                'clpAmountErr' => $clpAmountErr,
                            ]
                    ];

                return response()->json($result);
            }
            
        }

        return response()->json(array('err' => false, 'msg' => null));
    }

    /** 
     * @author GiangDT
     * @param Request $request
     * @return type
     */
    public function clptranfer(Request $request){
        if($request->ajax()){

            $userCoin = Auth::user()->userCoin;
            $clpAmountErr = $clpUsernameErr = $clpUidErr = $clpOTPErr = $transferRuleErr = '';

            if($request->clpAmount == ''){
                $clpAmountErr = trans('adminlte_lang::wallet.amount_required');
            }elseif (!is_numeric($request->clpAmount)){
                $clpAmountErr = trans('adminlte_lang::wallet.amount_number');
            }elseif ($userCoin->clpCoinAmount < $request->clpAmount){
                $clpAmountErr = trans('adminlte_lang::wallet.error_not_enough');
            }

            if($request->clpUsername == ''){
                $clpUsernameErr = trans('adminlte_lang::wallet.username_required');
            }elseif (!preg_match('/^\S*$/u', $request->clpUsername)){
                $clpUsernameErr = trans('adminlte_lang::wallet.username_notspace');
            }elseif (!User::where('name', $request->clpUsername)->where('active', 1)->count()){
                $clpUsernameErr = trans('adminlte_lang::wallet.username_not_invalid');
            }

            if($request->clpUid == ''){
                $clpUidErr = trans('adminlte_lang::wallet.uid_required');
            }elseif (!preg_match('/^\S*$/u', $request->clpUid)){
                $clpUidErr = trans('adminlte_lang::wallet.uid_notspace');
            }elseif (!User::where('uid', $request->clpUid)->where('active', 1)->count()){
                $clpUidErr = trans('adminlte_lang::wallet.uid_not_invalid');
            }

            if($request->clpOTP == ''){
                $clpOTPErr = trans('adminlte_lang::wallet.otp_required');
            }else{
                $key = Auth::user()->google2fa_secret;
                $valid = Google2FA::verifyKey($key, $request->clpOTP);
                if(!$valid){
                    $clpOTPErr = trans('adminlte_lang::wallet.otp_not_match');
                }
            }

            /******************* Only transfer in Genealogy ***************/
            // Get all Genealogy current user
            $lstCurrentGenealogyUser = [];
            if($userTreePermission = Auth::user()->userTreePermission)
                $lstCurrentGenealogyUser = explode(',', $userTreePermission->genealogy);

            // Get all Genealogy transfer user
            $transferUser = User::where('name', '=', $request->clpUsername)->first();
            $lstTransferGenealogyUser = [];
            if($userTreePermission = $transferUser->userTreePermission)
                $lstTransferGenealogyUser = explode(',', $userTreePermission->genealogy);

            if(!in_array($transferUser->id, $lstCurrentGenealogyUser) 
                && !in_array(Auth::user()->id, $lstTransferGenealogyUser)) {
                $transferRuleErr = trans('adminlte_lang::wallet.msg_transfer_rule');
            }

            if($clpAmountErr =='' && $clpUsernameErr == '' && $clpOTPErr == '' && $clpUidErr == '' && $transferRuleErr == ''){
                $userCoin->clpCoinAmount = $userCoin->clpCoinAmount - $request->clpAmount;
                $userCoin->save();
                $userRi = User::where('name', $request->clpUsername)->where('active', 1)->first();
                $userRiCoin = $userRi->userCoin;
                if($userRiCoin){
                    $userRiCoin->clpCoinAmount = $userRiCoin->clpCoinAmount + $request->clpAmount;
                    $userRiCoin->save();

                    $field = [
                        'walletType' => Wallet::CLP_WALLET,//btc
                        'type' =>  Wallet::TRANSFER_CLP_TYPE,//transfer BTC
                        'inOut' => Wallet::OUT,
                        'userId' => $userCoin->userId,
                        'amount' => $request->clpAmount,
                        'note' => 'To ' . $request->clpUsername
                    ];

                    Wallet::create($field);

                    $field = [
                        'walletType' => Wallet::CLP_WALLET,//btc
                        'type' => Wallet::TRANSFER_CLP_TYPE,//transfer BTC
                        'inOut' => Wallet::IN,
                        'userId' => $userRiCoin->userId,
                        'amount' => $request->clpAmount,
                        'note' => 'From ' . $request->clpUsername
                    ];

                    Wallet::create($field);

                    $request->session()->flash( 'successMessage', trans('adminlte_lang::wallet.msg_transfer_success') );
                    return response()->json(array('err' => false));
                }else{
                    $result = [
                        'err' => true,
                        'msg' =>[
                                'clpAmountErr' => '',
                                'clpUsernameErr' => trans('adminlte_lang::wallet.user_required'),
                                'clpOTPErr' => '',
                                'clpUidErr' => '',
                                'transferRuleErr' => '',
                            ]
                    ];
                    return response()->json($result);
                }
            }else{
                $result = [
                    'err' => true,
                    'msg' =>[
                        'clpAmountErr' => $clpAmountErr,
                        'clpUsernameErr' => $clpUsernameErr,
                        'clpOTPErr' => $clpOTPErr,
                        'clpUidErr' => $clpUidErr,
                        'transferRuleErr' => $transferRuleErr,
                    ]
                ];
                return response()->json($result);
            }
        }
        return response()->json(array('err' => true, 'msg' => null));
    }

    /**
     * @author Huynq
     * @param Request $request
     * @return null
     */
    public function getClpWallet(Request $request)
    {
        if($request->ajax())
        {
            set_time_limit(0);
            $userId = Auth::user()->id;

            if( CLPWallet::where('userId', $userId)->count() == 0 ){
                CLPWallet::create(['userId' => $userId]);
            } elseif ( CLPWallet::where('userId', $userId)->count() > 0 ){
                return response()->json(array('err' => true, 'msg' => null));
            }
            $clpAddress = new CLPWalletAPI();
            $result = $clpAddress->generateWallet();

            if ($result['success']) {
                CLPWallet::where('userId',$userId )->update(['address' => $result['address']]);
                return response()->json(array('data'=>$result['address'],'err' => false, 'msg' => null));
            } else {
                CLPWallet::where('userId', $userId)->forcedelete();
                return response()->json(array('err' => true, 'msg' => null));
            }
        }
    }
}
