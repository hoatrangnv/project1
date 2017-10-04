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
        $wallets = $query->where('walletType', Wallet::CLP_WALLET)->paginate();
        //get Packgage
        $currentuserid = Auth::user()->id;
        $user = Auth::user();
        $packages = Package::all();
        $lstPackSelect = array();
        foreach ($packages as $package){
            $lstPackSelect[$package->id] = $package->name;
        }
        $requestQuery = $request->query();
        $wallet_type = config('cryptolanding.wallet_type');
        foreach ($wallet_type as $key => $val)
            $wallet_type[$key] = trans($val);
        return view('adminlte::wallets.clp', ['packages' => $packages, 
            'user' => $user, 
            'lstPackSelect' => $lstPackSelect, 
            'wallets'=> $wallets,
            'wallet_type'=> $wallet_type,
            'requestQuery'=> $requestQuery,
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

    public function clptranfer(Request $request){
        if($request->ajax()){
            $userCoin = Auth::user()->userCoin;
            $clpAmountErr = $clpUsernameErr = $clpUidErr = $clpOTPErr = '';
            if($request->clpAmount == ''){
                $clpAmountErr = 'The Amount field is required';
            }elseif (is_numeric($request->clpAmount)){
                $clpAmountErr = 'The Amount must be a number';
            }elseif ($userCoin->clpCoinAmount < $request->clpAmount){
                $clpAmountErr = trans('adminlte_lang::wallet.error_not_enough');
            }
            if($request->clpUsername == ''){
                $clpUsernameErr = 'The Username field is required';
            }elseif (!preg_match('/^\S*$/u', $request->clpUsername)){
                $clpUsernameErr = 'The Username not required';
            }elseif (!User::where('name', $request->clpUsername)->where('active', 1)->count()){
                $clpUsernameErr = 'The Username is not invalid';
            }
            if($request->clpUid == ''){
                $clpUidErr = 'The Uid field is required';
            }elseif (!preg_match('/^\S*$/u', $request->clpUid)){
                $clpUidErr = 'The Uid not required';
            }elseif (!User::where('uid', $request->clpUid)->where('active', 1)->count()){
                $clpUidErr = 'The Uid is not invalid';
            }
            if($request->clpOTP == ''){
                $clpOTPErr = 'The OTP field is required';
            }else{
                $key = Auth::user()->google2fa_secret;
                $valid = Google2FA::verifyKey($key, $request->clpOTP);
                if(!$valid){
                    $clpOTPErr = 'The OTP not match';
                }
            }
            if($clpAmountErr !='' && $clpUsernameErr != '' && $clpOTPErr != '' && $clpUidErr != ''){
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
                        'note' => 'Transfer from ' . $request->clpUsername
                    ];

                    Wallet::create($field);

                    $field = [
                        'walletType' => Wallet::CLP_WALLET,//btc
                        'type' => Wallet::TRANSFER_CLP_TYPE,//transfer BTC
                        'inOut' => Wallet::IN,
                        'userId' => $userRiCoin->userId,
                        'amount' => $request->clpAmount,
                        'note' => 'Transfer from ' . $request->clpUsername
                    ];

                    Wallet::create($field);

                    $request->session()->flash( 'successMessage', trans('adminlte_lang::wallet.success_tranfer_clp') );
                    return response()->json(array('err' => false));
                }else{
                    $result = [
                        'err' => true,
                        'msg' => ['clpUsernameErr'=>'User not required']
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
                    ]
                ];
                return response()->json($result);
            }
        }
        return response()->json(array('err' => true, 'msg' => null));
    }
}
