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

            $usdAmountErr = '';
            if($request->usdAmount == ''){
                $usdAmountErr = trans('adminlte_lang::wallet.msg_usd_amount_required');
            }elseif (!is_numeric($request->usdAmount) || $request->usdAmount < 0){
                $usdAmountErr = trans('adminlte_lang::wallet.amount_number');
            }elseif ($userCoin->usdAmount < $request->usdAmount){
                $usdAmountErr = trans('adminlte_lang::wallet.error_not_enough');
            }
     
            if($usdAmountErr == '')
            {
                $clpRate = ExchangeRate::getCLPUSDRate();
                $amountCLP = $request->usdAmount / $clpRate;

                $userCoin->usdAmount = $userCoin->usdAmount - $request->usdAmount;
                $userCoin->clpCoinAmount =  $userCoin->clpCoinAmount + $amountCLP;
                $userCoin->save();

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
                // Bulk insert
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
        $userId = $request->get('id', 0);
        $userName = $request->get('username', '');
        if($userId > 0 || $userName != ''){
            if($userId > 0)
                $user = User::where('uid', $userId)->where('active', 1)->first();
            elseif($userName != '')
                $user = User::where('name', '=', $userName)->where('active', 1)->first();

            if(empty($user)) {
                return response()->json(['err' => trans('adminlte_lang::message.user_not_found')]);
            }

            if(empty($user->userData->packageId)) {
                $myPackageId = 0;
                $myPackagePrice = 0;
            } else {
                $myPackageId = $user->userData->packageId;
                $myPackage = Package::where('id', $myPackageId)->get()->first();
                $myPackagePrice = $myPackage->price;
            }

            $packages = Package::orderBy('price')->get();

            $transferOptions = [];
            foreach($packages as $package) {
                $index = $package->id * (($package->id>$myPackageId) ? 1 : -1);
                $price_diff = ($package->price > $myPackagePrice) ? '$'. number_format($package->price - $myPackagePrice,2) : trans('adminlte_lang::message.not_available');
                $transferOptions[$package->id] =  
                    ($myPackageId ? trans('adminlte_lang::message.upgrade_to') : trans('adminlte_lang::message.activate_user_package_to')) . ' ' . $package->name . '  (' . $price_diff . ')';
            }

            foreach($packages as $package) {
                $price_diff = ($package->price > $myPackagePrice) ? '$'. number_format($package->price - $myPackagePrice,2) : trans('adminlte_lang::message.not_available');
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
        return response()->json(['err' => trans('adminlte_lang::message.user_not_found')]);
    }


    public function transferUSD(Request $request) {

        if($request->ajax()) {

            // validate transferee 
            if( $request->username == '' ){
                return response()->json(['err' => trans('adminlte_lang::wallet.user_required') ]);
            } elseif( !preg_match('/^\S*$/u', $request->username) ) {
                return response()->json(['err' => trans('adminlte_lang::wallet.user_notspace') ]);
            } elseif(!User::where('name', $request->username)->where('active', 1)->count()) {
                return response()->json(['err' => trans('adminlte_lang::wallet.username_invalid') ]);
            }

            if( $request->userId == '' ){
                return response()->json(['err' => trans('adminlte_lang::wallet.uid_required') ]);
            } elseif( !preg_match('/^\S*$/u', $request->userId) ) {
                return response()->json(['err' => trans('adminlte_lang::wallet.uid_notspace') ]);
            } elseif(!User::where('uid', $request->userId)->where('active', 1)->count()) {
                return response()->json(['err' => trans('adminlte_lang::wallet.uid_invalid') ]);
            }

            $transferer = Auth()->user();
            $transferUsdWallet = $transferer->usercoin->usdAmount ;

            $transferee = User::where('name', $request->username)->where('uid', $request->userId)->where('active', 1)->first();
            if( $transferee->userData->packageId ) {
                $transfereePackage = Package::where('id', $transferee->userData->packageId)->get()->first();
                $transfereePackagePrice = $transfereePackage->price;
                $transfereeCurrentPackage = $transfereePackage;
            } else {
                $transfereePackagePrice = 0;
            }
            
            $upgradeToPackage = Package::where('id', $request->packageId)->get()->first();
            $transferAmount = $upgradeToPackage->price - $transfereePackagePrice;

            // Validate sufficient money for transfer
            if( $transferUsdWallet<$transferAmount ) {
                return response()->json(['err' => trans('adminlte_lang::wallet.error_not_enough') ]);
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
            if($request->isMethod('post') && ($currentDate > $preSaleEnd))
	        {
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

                $transferer->userCoin->usdAmount = $transferer->userCoin->usdAmount - $transferAmount;
                $transferer->userCoin->save();

                $transferee->userCoin->usdAmount = $transferee->userCoin->usdAmount + $transferAmount;
                $transferee->userCoin->save();

    // $user->notify( new UserLoginNotification($user) );

                // Transferee converts USD to CLP (Step 2 of 3)
                $sendUsdToClp = [
                    'walletType'        => Wallet::USD_WALLET,
                    'type'              => Wallet::USD_CLP_TYPE,
                    'inOut'             => Wallet::OUT,
                    'userId'            => $transferee->id,
                    'amount'            => $transferAmount,
                    'note'              => 'Rate 1.0 USD',
                ];
                Wallet::create($sendUsdToClp);

                $sendUsdToClp = [
                    'walletType'        => Wallet::CLP_WALLET,
                    'type'              => Wallet::USD_CLP_TYPE,
                    'inOut'             => Wallet::IN,
                    'userId'            => $transferee->id,
                    'amount'            => $transferAmount,
                    'note'              => 'Rate 1.0 USD',
                ];
                Wallet::create($sendUsdToClp);

                $transferee->userCoin->usdAmount = $transferee->userCoin->usdAmount - $transferAmount;
                $transferee->userCoin->save();

                $transferee->userCoin->clpCoinAmount = $transferee->userCoin->clpCoinAmount + $transferAmount;
                $transferee->userCoin->save();

                // Transferee acquire the Package (activate or upgrade) from CLP (Step 3 of 3)
                $orderField=[
                    'userId'            => $transferee->id,
                    'packageId'         => $upgradeToPackage->id,
                    'walletType'        => Wallet::CLP_WALLET,
                    'amountCLP'         => $transferAmount,
                    'amountBTC'         => null,
                    'buy_date'          => (new \DateTime())->format('Y-m-d H:i:s'),
                    'paid_date'         => null,
                    'type'              => ($transferAmount == $upgradeToPackage->price) ? UserOrder::TYPE_UPGRADE : UserOrder::TYPE_NEW,
                    'original'          => ($transferAmount == $upgradeToPackage->price) ? 0 : $transfereeCurrentPackage->id,
                    'status'            => UserOrder::STATUS_PAID,
                ];
                UserOrder::create($orderField);

                $clpBuyPackage = [
                    'walletType'        => Wallet::CLP_WALLET,
                    'type'              => Wallet::BUY_PACK_TYPE,
                    'inOut'             => Wallet::OUT,
                    'userId'            => $transferee->id,
                    'amount'            => $transferAmount,
                    'note'              => $transferee->name . ' bought package',
                ];
                Wallet::create($clpBuyPackage);

                $transferee->userData->packageDate = date('Y-m-d H:i:s');
                $transferee->userData->packageId = $upgradeToPackage->id;
                $transferee->userData->status = 1;
                $transferee->userData->save();

                $weeked = date('W');
                $year = date('Y');
                $weekYear = $year.$weeked;

                if($weeked < 10) $weekYear = $year.'0'.$weeked;
                UserPackage::create([
                    'userId'            => $transferee->id,
                    'packageId'         => $upgradeToPackage->id,
                    'amount_increase'   => $transferAmount,
                    'buy_date'          => date('Y-m-d H:i:s'),
                    'release_date'      => date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") ."+ 6 months")),
                    'weekYear'          => $weekYear,
                ]);

                // Calculate fast start bonus
                User::investBonus($transferee->id, $transferee->refererId, $upgradeToPackage->id, $transferAmount, $transferee->name);

                // Case: User already in tree and then upgrade package => re-calculate loyalty
                if($transferee->userData->binaryUserId && $transferee->userData->packageId > 0)
                    User::bonusLoyaltyUser($transferee->userData->userId, $transferee->userData->refererId, $transferee->userData->leftRight);

                // Case: User already in tree and then upgrade package => re-caculate binary bonus
                if($transferee->userData->binaryUserId > 0 && in_array($transferee->userData->leftRight, ['left', 'right'])) {
                    $leftRight = $transferee->userData->leftRight == 'left' ? 1 : 2;
                    User::bonusBinary($transferee->userData->userId, 
                        $transferee->userData->refererId, 
                        $transferee->userData->packageId, 
                        $transferee->userData->binaryUserId, 
                        $transferee->leftRight,
                        true,
                        false
                    );
                }


            }

            return response()->json(['err' => false, 'msg' => trans('adminlte_lang::wallet:transfer_completed')]);
            

        }
        return response()->json(['err' => false, 'msg' => null]);
    }
}

