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
use App\UserCoin;
use App\ExchangeRate;

use Auth;
use function Sodium\compare;
use Symfony\Component\HttpFoundation\Session\Session;
use Validator;
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
        //Add thêm tỷ giá vào $wallets
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
            $userCoin = Auth::user()->userCoin;

            $usdAmountErr = '';
            if($request->usdAmount == ''){
                $usdAmountErr = trans('adminlte_lang::wallet.msg_usd_amount_required');
            }elseif (!is_numeric($request->usdAmount)){
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
}

