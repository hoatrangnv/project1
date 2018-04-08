<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Wallet;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\User;
use App\Wallet;
use App\Package;
use App\UserCoin;
use App\UserCoinUsd;
use App\ExchangeRate;
use App\UserOrder;
use App\UserPackage;

use Auth;
use function Sodium\compare;
use Symfony\Component\HttpFoundation\Session\Session;
use Validator;
use Google2FA;

use Log;

/**
 * Description of UsdWalletController
 *
 * @author huydk
 */
class UsdWalletController extends Controller
{
    const USD = 1;
    const BTC = 2;
    const CLP = 3;
    const REINVEST = 4;
    
    const BTCUSD = "btcusd";
    const USDCLP = "UsdToClp";
    const CLPUSD = "ClptoUsd";
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /** 
     * @author Huy NQ
     * @param Request $request
     * @return type
     */
    public function usdWallet( Request $request ) {
        //tranfer if request post
        if($request->isMethod('post')) {
            $this->validate($request, [
                'usd'=>'required|numeric',
                'clp'=>'required|numeric'
            ]);
            //Tranfer
            $this->tranferUSDCLP($request->usd, $request->clp, $request);
            return redirect()->route("wallet.usd");
        }
        //get tỷ giá usd btc
        //get dữ liệu bảng hiển thị trên site
        $currentuserid = Auth::user()->id;
        $query = Wallet::where('userId', '=',$currentuserid);
        if(isset($request->type) && $request->type > 0){
            $query->where('type', $request->type);
        }

        $wallets = $query->where('walletType', Wallet::USD_WALLET)->orderBy('id', 'desc')->paginate();
        if(isset($request->type) && $request->type > 0){
             $pagination = $wallets->appends ( array (
                 'type' => $request->type
             ));
        }
        $wallets->currencyPair = Auth()->user()->usercoin->usdAmount ;
           
        $requestQuery = $request->query();
        $all_wallet_type = config('cryptolanding.wallet_type');

        //USD Wallet has 5 type: Profit day, farst start, binary, loyalty, buy CLP
        $wallet_type = [];
        $wallet_type[0] = trans('adminlte_lang::wallet.title_selection_filter');
        foreach ($all_wallet_type as $key => $val) {
            if($key == 1) $wallet_type[$key] = trans($val);
            if($key == 2) $wallet_type[$key] = trans($val);
            if($key == 3) $wallet_type[$key] = trans($val);
            if($key == 4) $wallet_type[$key] = trans($val);
            if($key == 5) $wallet_type[$key] = trans('adminlte_lang::wallet.usd_clp_type_on_usd');
            if($key == 16) $wallet_type[$key] = trans($val);
            if($key == 17) $wallet_type[$key] = trans($val);
        }

        return view('adminlte::wallets.usd', compact('wallets','wallet_type', 'requestQuery'));
    }
    
    /** 
     * @author GiangDT
     * @edit Huynq
     * @param Request $request
     * @return type
     */
    public function reinvestWallet( Request $request ) {
        //tranfer if request post
        if($request->isMethod('post')) {
            $this->validate($request, [
                'usd'=>'required|numeric',
                'clp'=>'required|numeric'
            ]);
            $clp = $request->usd / User::getCLPUSDRate();
            //Tranfer
            $this->tranferReinvestUSDCLP($request->usd, $clp, $request);
        }
        
        //get tỷ giá usd btc
        //$dataCurrencyPair = $this->getRateUSDBTC();
        
        //get dữ liệu bảng hiển thị trên site
        $currentuserid = Auth::user()->id;
        $query = Wallet::where('userId', '=',$currentuserid);
        if(isset($request->type) && $request->type > 0){
            $query->where('type', $request->type);
        }
        $wallets = $query->where('walletType', Wallet::REINVEST_WALLET)->orderBy('id', 'desc')->paginate();
        if(isset($request->type) && $request->type > 0){
             $pagination = $wallets->appends ( array (
                 'type' => $request->type
             ));
        }
        //Add rate into $wallets
        $wallets->currencyPair = Auth()->user()->usercoin->reinvestAmount ;
            
        // $wallets->currencyBtc = round( $wallets->currencyPair / 
        //     json_decode($dataCurrencyPair)->last , 4);
        
        // $wallets->currencyClp = $wallets->currencyPair / User::getCLPUSDRate() ;
        
        // $wallets->rateClpBtc = User::getCLPBTCRate();
        // $wallets->rateClpUsd = User::getCLPUSDRate();
        $requestQuery = $request->query();

        //Holding Wallet has 4 types: Farst start, binary, loyalty, Transfer to CLP Wallet
        $all_wallet_type = config('cryptolanding.wallet_type');

        $wallet_type = [];
        $wallet_type[0] = trans('adminlte_lang::wallet.title_selection_filter');
        foreach ($all_wallet_type as $key => $val) {
            if($key == 1) $wallet_type[$key] = trans($val);
            if($key == 3) $wallet_type[$key] = trans($val);
            if($key == 4) $wallet_type[$key] = trans($val);
            if($key == 6) $wallet_type[$key] = trans('adminlte_lang::wallet.holding_clp_type');
            if($key == 17) $wallet_type[$key] = trans($val);
        }
        return view('adminlte::wallets.reinvest', compact('wallets','wallet_type', 'requestQuery'));
    }
    
    
    /**
     * @author Huy NQ
     * @param type $usd
     * @param type $clp
     * @param type $request
     */
    public function buyCLP(Request $request)
    {
        if($request->ajax()) {

            /** Remove **/
            // if($clpUSDRate < 0.95 * config('app.clp_target_price')) {
            //     return response()->json(array('err' => false));
            // }
            /** Remove **/
            
            $userCoin = Auth::user()->userCoin;
            $free_to_use = empty($userCoin->userCoinUsd) ? $userCoin->usdAmount : $userCoin->userCoinUsd->usdAmountFree;

            $usdAmountErr = '';
            if($request->usdAmount == ''){
                $usdAmountErr = trans('adminlte_lang::wallet.msg_usd_amount_required');
            }elseif (!is_numeric($request->usdAmount) || $request->usdAmount < 0){
                $usdAmountErr = trans('adminlte_lang::wallet.amount_number');
            }elseif ($free_to_use < $request->usdAmount){
                $usdAmountErr = trans('adminlte_lang::wallet.error_not_enough');
            }

            if($usdAmountErr == '')
            {
                $clpRate = ExchangeRate::getCLPUSDRate();
                if($clpRate < config('app.clp_target_price')) $clpRate = config('app.clp_target_price');
                $amountCLP = $request->usdAmount / $clpRate;

                $userCoin->usdAmount = $userCoin->usdAmount - $request->usdAmount;
                $userCoin->clpCoinAmount =  $userCoin->clpCoinAmount + $amountCLP;
                $userCoin->save();

                if( empty($userCoin->userCoinUsd) ) {
                    $record = [
                        userid          => Auth::user()->id,
                        usdAmountFree   => $userCoin->usdAmount - $request->usdAmount,
                        usdAmountHold   => 0,
                    ];
                    $userCoin->userCoinUsd::create($record);
                } else {
                    // update
                    $userCoin->userCoinUsd->usdAmountFree = $userCoin->userCoinUsd->usdAmountFree - $request->usdAmount;
                    $userCoin->userCoinUsd->save();
                }

                $usd_to_clp = [
                    "walletType" => Wallet::USD_WALLET,
                    "type"       => Wallet::USD_CLP_TYPE,
                    "inOut"      => Wallet::OUT,
                    "userId"     => Auth::user()->id,
                    "amount"     => $request->usdAmount,
                    "note"      => "Rate " . $clpRate . '$',
                ];
                $result = Wallet::create($usd_to_clp);

                $clp_from_usd = [
                    "walletType" => Wallet::CLP_WALLET,
                    "type"       => Wallet::USD_CLP_TYPE,
                    "inOut"      => Wallet::IN,
                    "userId"     => Auth::user()->id,
                    "amount"     => $amountCLP,
                    "note"      => "Rate " . $clpRate . '$',
                ];
                $result = Wallet::create($clp_from_usd);

                $request->session()->flash( 'successMessage', "Buy CLP successfully!" );
                return response()->json(array('err' => false));
                
            } else {
                $result = [
                        'err' => true,
                        'msg' =>[
                                'usdAmountErr' => $usdAmountErr,
                            ]
                    ];
                return response()->json($result);
            }

        }
        return response()->json(array('err' => false, 'msg' => null));
    }
    
    
    public function getDataWallet() {
        //get số liệu 
        $dataCurrencyPair = $this->getRateUSDBTC();
        
        $data["usd"] =  Auth()->user()->usercoin->usdAmount ;
        
        $data["btc"] = round( $data["usd"] / 
                json_decode($dataCurrencyPair)->last , 4);
        
        $data["clp"] = $data["usd"] / 
                ExchangeRate::getCLPUSDRate();
        
        $data["clpbtc"] = ExchangeRate::getCLPBTCRate();
        
        $data["clpusd"] = ExchangeRate::getCLPUSDRate();
        
        return $this->responseSuccess($data);
    }


    public function getTransferAndBuyPackages(Request $request) {

        if ( $request->ajax() ) {

            $user = User::where('uid', $request->get('id', 0))
                        ->orWhere('name', $request->get('username', ''))
                        ->where('active', 1)
                        ->first();
            
            if(empty($user)) {
                return response()->json(['err' => trans('adminlte_lang::message.user_not_found')]);
            }

            $packages = Package::orderBy('price')->get();

            if(empty($user->userData->packageId)) {
                $myPackageId = 0;
                $myPackagePrice = 0;
            } else {
                $myPackageId = $user->userData->packageId;
                $myPackage = Package::where('id', $myPackageId)->get()->first();
                $myPackagePrice = $myPackage->price;
            }
    
            $transferOptions = [];
            foreach($packages as $package) {
                $price_diff = ($package->price > $myPackagePrice) ? 
                            '$'. number_format($package->price - $myPackagePrice - $user->userCoin->userCoinUsd->usdAmountHold, 2) : 
                            trans('adminlte_lang::message.not_available');
                $transferOptions[$package->id] = [
                    'name' => $package->name,
                    'price' => $package->price,
                    'enable' => $package->id>$myPackageId and ($package->price - $myPackagePrice)<Auth()->user()->usercoin->usdAmount,
                    'amount' => $package->price - $myPackagePrice,
                    'text' => ($myPackageId ? trans('adminlte_lang::message.upgrade_to') : trans('adminlte_lang::message.activate_user_package_to')) . ' ' . $package->name . '  (' . $price_diff . ')',
                ];
            }

            return response()->json([
                'id' => $user->uid, 
                'username' => $user->name, 
                'transferoptions' => $transferOptions]);

        }
    }


    public function usdTransferValidate(Request $request) {
        if ( $request->ajax() ) {

            // validate transferee if username is provided
            if( $request->username == '' ) {
                return response()->json(['err' => trans('adminlte_lang::wallet.user_required') ]);
            } elseif( !preg_match('/^\S*$/u', $request->username) ) {
                return response()->json(['err' => trans('adminlte_lang::wallet.user_notspace') ]);
            } elseif( !User::where('name', $request->username)->where('active', 1)->count() ) {
                return response()->json(['err' => trans('adminlte_lang::wallet.username_invalid') ]);
            } elseif( $request->username == Auth()->user()->name ) {
                return response()->json(['err' => trans('adminlte_lang::wallet.cannot_send_yourself') ]);
            }

            // or validate transferee if user id is provided
            if( $request->userid == '' ) {
                return response()->json(['err' => trans('adminlte_lang::wallet.uid_required') ]);
            } elseif( !preg_match('/^\S*$/u', $request->userid) ) {
                return response()->json(['err' => trans('adminlte_lang::wallet.uid_notspace') ]);
            } elseif(!User::where('uid', $request->userid)->where('active', 1)->count()) {
                return response()->json(['err' => trans('adminlte_lang::wallet.uid_invalid') ]);
            } elseif( $request->userid == Auth()->user()->uid ) {
                return response()->json(['err' => trans('adminlte_lang::wallet.cannot_send_yourself') ]);
            }

            // or check if user transfer and transfee are up/down line related & no side line
            $transferer = Auth()->user();
            $transferUsdWallet = $transferer->usercoin->usdAmount;
            $transferee = User::where('name', $request->username)->where('uid', $request->userid)->where('active', 1)->first();
            $transferer_uplines = $transferer->upLines();

Log::debug('------------- usdTransferValidate --------------');
Log::debug( 'Transferer = ' . $transferer->id . ' ' . $transferer->name);
Log::debug( 'Transferee = ' . $transferee->id . ' ' . $transferee->name);
if( $transferer->isUpline($transferee->id) ) {
    Log::debug( 'Is ' . $transferer->name . '(' . $transferer->id . ') upline of ' . $transferee->name . '(' . $transferee->id . ') : Yes' ) ;
} else {
    Log::debug( 'Is ' . $transferer->name . '(' . $transferer->id . ') upline of ' . $transferee->name . '(' . $transferee->id . ') : No' ) ;
}
if( $transferee->isUpline($transferer->id) ) {
    Log::debug( 'Is ' . $transferer->name . '(' . $transferer->id . ') downline of ' . $transferee->name . '(' . $transferee->id . ') : Yes' ) ;
} else {
    Log::debug( 'Is ' . $transferer->name . '(' . $transferer->id . ') downline of ' . $transferee->name . '(' . $transferee->id . ') : No' ) ;
}
if( empty($transferer->userCoin->userCoinUsd) ) {
    Log::debug( 'Transferer max Free amount = ' . 'no record created yet' );
} else {
    Log::debug( 'Transferer max Free amount = ' . $transferer->userCoin->userCoinUsd->usdAmountFree );
}
if( empty($transferee->userCoin->userCoinUsd) ) {
    Log::debug( 'Transferee Hold account = ' . 'no record created yet' );
} else {
    Log::debug( 'Transferee Hold account = ' . $transferee->userCoin->userCoinUsd->usdAmountHold );
}
Log::debug( 'Transferee current package : ' . $transferee->userData->package );
Log::debug('----------------------------------------------');

            if( !$transferer->isUpline($transferee->id) && !$transferee->isUpline($transferer->id) ) {
                return response()->json(['err' => trans('adminlte_lang::wallet.not_related') ]);
            }

            // validate the transfer amount 
            // 1. cannot be less than 0
            // 2. cannot be greater than package price different - transferee's USD in hold
            if( $request->trfAmount <= 0) {
                return response()->json(['err' => trans('adminlte_lang::wallet.amount_need_positive') ]);
            }

            /*
             * CR0032 Treat all USD are the same & no ceiling limit
             *
            $free_to_use = empty($transferer->userCoin->userCoinUsd) ? $transferer->usercoin->usdAmount : $transferer->userCoin->userCoinUsd->usdAmountFree;
            $transferer_usd_wallet_balance = $transferer->usercoin->usdAmount;
            if( $request->trfAmount > $free_to_use ) {
                return response()->json(['err' => trans('adminlte_lang::wallet.insufficient_balance') ]);
            }
            $transferee = User::where('name', $request->username)->where('uid', $request->userid)->where('active', 1)->first();
            $usdAmountHold = empty($transferee->userCoin->userCoinUsd->usdAmountHold) ? 0 : $transferee->userCoin->userCoinUsd->usdAmountHold;

            $biggestPackage = Package::orderBy('price')->get()->last()->price;
            $currentPackage = empty($transferee->userData->package) ? 0 : $transferee->userData->package->price;
            $maxTransferAmount = $biggestPackage - $currentPackage - $usdAmountHold;

            if( $request->trfAmount > $maxTransferAmount) {
                return response()->json(['err' => trans('adminlte_lang::wallet.exceed_transferee_limit') ]);
            }
            */

            if( $request->trfAmount > $transferer->usercoin->usdAmount ) {
                return response()->json(['err' => trans('adminlte_lang::wallet.insufficient_balance') ]);
            }

        }
    }


    public function transferUSD(Request $request) {

        if($request->ajax()) {

            // validate transferee if username is provided
            if( $request->username == '' ){
                return response()->json(['err' => trans('adminlte_lang::wallet.user_required') ]);
            } elseif( !preg_match('/^\S*$/u', $request->username) ) {
                return response()->json(['err' => trans('adminlte_lang::wallet.user_notspace') ]);
            } elseif(!User::where('name', $request->username)->where('active', 1)->count()) {
                return response()->json(['err' => trans('adminlte_lang::wallet.username_invalid') ]);
            }

            // or validate transferee if user id is provided
            if( $request->userid == '' ){
                return response()->json(['err' => trans('adminlte_lang::wallet.uid_required') ]);
            } elseif( !preg_match('/^\S*$/u', $request->userid) ) {
                return response()->json(['err' => trans('adminlte_lang::wallet.uid_notspace') ]);
            } elseif(!User::where('uid', $request->userid)->where('active', 1)->count()) {
                return response()->json(['err' => trans('adminlte_lang::wallet.uid_invalid') ]);
            }

            // or check if user transfer and transfee are up/down line related & no side line
            $transferer = Auth()->user();
            $transferUsdWallet = $transferer->usercoin->usdAmount ;
            $transferee = User::where('name', $request->username)->where('uid', $request->userid)->where('active', 1)->first();
            $transferer_uplines = $transferer->upLines();
            if( !$transferer->isUpline($transferee->id) && !$transferee->isUpline($transferer->id)) {
                return response()->json(['err' => trans('adminlte_lang::wallet.not_related') ]);
            }

            if( !$transferer->isUpline($transferee->id) && !$transferee->isUpline($transferer->id)) {
                return response()->json(['err' => trans('adminlte_lang::wallet.not_related') ]);
            }

            // validate the transfer amount 
            // 1. cannot be less than 0
            // 2. cannot be greater than package price different - transferee's USD in hold
            if( $request->trfAmount <= 0) {
                return response()->json(['err' => trans('adminlte_lang::wallet.amount_need_positive') ]);
            }

            /*
             * CR0032
             * 
            $free_to_use = empty($transferer->userCoin->userCoinUsd) ? $transferer->usercoin->usdAmount : $transferer->userCoin->userCoinUsd->usdAmountFree;
            $transferer_usd_wallet_balance = $transferer->usercoin->usdAmount;
            if( $request->trfAmount > $free_to_use ) {
                return response()->json(['err' => trans('adminlte_lang::wallet.insufficient_balance') ]);
            }
            $transferee = User::where('name', $request->username)->where('uid', $request->userid)->where('active', 1)->first();
            $usdAmountHold = empty($transferee->userCoin->userCoinUsd->usdAmountHold) ? 0 : $transferee->userCoin->userCoinUsd->usdAmountHold;            
            $biggestPackage = Package::orderBy('price')->get()->last()->price;
            $currentPackage = empty($transferee->userData->package) ? 0 : $transferee->userData->package->price;
            $maxTransferAmount = $biggestPackage - $usdAmountHold;

            if( $request->trfAmount > $maxTransferAmount) {
                return response()->json(['err' => trans('adminlte_lang::wallet.exceed_transferee_limit') ]);
            }
            */

            if( $request->trfAmount > $transferer->usercoin->usdAmount ) {
                return response()->json(['err' => trans('adminlte_lang::wallet.insufficient_balance') ]);
            }

            // Validate the OTP
            
            // if($request->OTP == ''){
            //     return response()->json(['err' => trans('adminlte_lang::wallet.otp_required') ]);
            // }else{
            //     $key = Auth::user()->google2fa_secret;
            //     $valid = Google2FA::verifyKey($key, $request->OTP);
            //     if(!$valid){
            //         return response()->json(['err' => trans('adminlte_lang::wallet.otp_not_match') ]);
            //     }
            // }


            // Update the transaction deatil tables & the USD Wallet Balance (Step 1 of 3)
            $currentDate = date("Y-m-d");
            $preSaleEnd = date('Y-m-d', strtotime(config('app.pre_sale_end')));
            $transferAmount = $request->trfAmount;
            $usdAmountHold = empty($transferee->userCoin->userCoinUsd->usdAmountHold) ? 0 : $transferee->userCoin->userCoinUsd->usdAmountHold;

            if($request->isMethod('post') && ($currentDate > $preSaleEnd))
	        {
                // Update the transaction ledger in wallet table
                $transferOutDetail = [
                    'walletType'        => Wallet::USD_WALLET,
                    'type'              => Wallet::TRANSFER_USD_TYPE,
                    'inOut'             => Wallet::OUT,
                    'userId'            => $transferer->id,
                    'amount'            => $transferAmount,
                    'note'              => 'Transfer to ' . $request->username,
                ];
                Wallet::create($transferOutDetail);

                $transferInDetail = [
                    'walletType'        => Wallet::USD_WALLET,
                    'type'              => Wallet::TRANSFER_USD_TYPE,
                    'inOut'             => Wallet::IN,
                    'userId'            => $transferee->id,
                    'amount'            => $transferAmount,
                    'note'              => 'Transfer from ' . $transferer->name,
                ];
                Wallet::create($transferInDetail);

                // Update user balance in user_coins table
                $transferer->userCoin->usdAmount = $transferer->userCoin->usdAmount - $transferAmount;
                $transferer->userCoin->save();

                $transferee->userCoin->usdAmount = $transferee->userCoin->usdAmount + $transferAmount;
                $transferee->userCoin->save();

                // Update user USD balance breakdown(free and hold) amount
                if ( empty($transferer->userCoin->userCoinUsd) ) {
                    $record = [
                        'userId'            => $transferer->id,
                        'usdAmountHold'     => 0,
                        'usdAmountFree'     => $transferer->userCoin->usdAmount,
                    ];
                    UserCoinUsd::create($record);
                } else {
                    if ( $transferAmount <= $transferer->userCoin->userCoinUsd->usdAmountHold ) {
                        $transferer->userCoin->userCoinUsd->usdAmountHold = $transferer->userCoin->userCoinUsd->usdAmountHold - $transferAmount;
                        $transferer->userCoin->userCoinUsd->save();
                    } else {
                        $transferer->userCoin->userCoinUsd->usdAmountHold = $transferer->userCoin->userCoinUsd->usdAmountHold - $transferAmount;
                        $transferer->userCoin->userCoinUsd->usdAmountFree = $transferer->userCoin->userCoinUsd->usdAmountFree - ($transferAmount - $transferer->userCoin->userCoinUsd->usdAmountHold);
                        $transferer->userCoin->userCoinUsd->save();
                    }
                }

                if ( empty($transferee->userCoin->userCoinUsd) ) {
                    $record = [
                        'userId'            => $transferee->id,
                        'usdAmountHold'     => $transferAmount,
                        'usdAmountFree'     => $transferee->userCoin->usdAmount - $transferAmount,
                    ];
                    UserCoinUsd::create($record);
                } else {
                    $transferee->userCoin->userCoinUsd->usdAmountHold = $transferee->userCoin->userCoinUsd->usdAmountHold + $transferAmount;
                    $transferee->userCoin->userCoinUsd->save();
                }


                // $user->notify( new UserLoginNotification($user) );


            }

            return response()->json(['err' => false, 'msg' => trans('adminlte_lang::wallet:transfer_completed')]);
            

        }
        return response()->json(['err' => false, 'msg' => null]);
    }

}