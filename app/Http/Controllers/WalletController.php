<?php

namespace App\Http\Controllers;

use App\UserCoin;
use Illuminate\Http\Request;

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
use App\Package;
use Log;
use App\Http\Controllers\Wallet\UsdWalletController as USDWallet;


class WalletController extends Controller
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
    
    public function index() {
       return view('adminlte::wallets.genealogy');
    }
    
    /** 
     * @author 
     * @return type
     */
    public function clp(){
        $currentuserid = Auth::user()->id;
        $wallets = Wallet::where('userId', '=',$currentuserid)->where('walletType', Wallet::CLP_WALLET)->paginate();
        
        //get Packgage
        $user = Auth::user();
        $packages = Package::all();
        $lstPackSelect = array();
        if($packages){
            foreach ($packages as $package){
                $lstPackSelect[$package->id] = $package->name;
            }
        }
        
        return view('adminlte::wallets.clp', ['packages' => $packages, 
            'user' => $user, 
            'lstPackSelect' => $lstPackSelect, 
            'wallets'=> $wallets
        ]);
        
    }
    
    /**
     * 
     * @param Request $request
     * @return type
     */
    public function buyclp(Request $request){
        $currentuserid = Auth::user()->id;
        $tygia = 1;
        if ($request->isMethod('post')) {
            Validator::extend('usdAmount', function ($attribute, $value) {
                $userId = Auth::user()->id;
                $userCoin = UserCoin::where('userId', '=', $userId)->first();
                if ($userCoin->usdAmount < $value)
                    return false;
                return true;
            });
            $this->validate($request, [
                'amount' => 'required|usdAmount',
            ]);

            $amount = $request->get('amount');

            $userCoin = Auth::user()->userCoin;
            $userCoin->clpCoinAmount = $userCoin->clpCoinAmount + ($tygia * $amount);
            $userCoin->usdAmount = $userCoin->usdAmount - $amount;
            $userCoin->save();

            $fieldUsd = [
                'walletType' => Wallet::USD_WALLET,//usd
                'type' => Wallet::USD_CLP_TYPE,//buy
                'inOut' => Wallet::OUT,
                'userId' => $currentuserid,
                'amount' => $amount,
            ];
            Wallet::create($fieldUsd);
            $fieldClp = [
                'walletType' => Wallet::CLP_WALLET,//clp
                'type' => Wallet::USD_CLP_TYPE,//buy
                'inOut' => Wallet::IN,
                'userId' => $currentuserid,
                'amount' => $amount,
            ];
            Wallet::create($fieldClp);
            return redirect('wallets/buyclp')
                ->with('flash_message',
                    'Buy clpCoin successfully.');
        }
        return view('adminlte::wallets.buyclp')->with(compact('user', 'tygia'));
    }

    public function transferFromHolding(Request $request)
    {
        if($request->ajax()) {
            try {
                if($userCoin->availableAmount == 0) 
                    return response()->json(array('msg' => 'Your released amount is zero'));

                $currentuserid = Auth::user()->id;

                $userCoin = Auth::user()->userCoin;
                $userCoin->clpCoinAmount = $userCoin->clpCoinAmount + $userCoin->availableAmount;
                $userCoin->availableAmount = 0;
                $userCoin->save();

                $fieldCLP = [
                    'walletType' => Wallet::CLP_WALLET,//btc
                    'type' => Wallet::REINVEST_CLP_TYPE,//tranfer
                    'inOut' => Wallet::IN,
                    'userId' => $currentuserid,
                    'amount' => $userCoin->availableAmount,
                ];
                Wallet::create($fieldCLP);

                $fieldHolidng = [
                    'walletType' => Wallet::REINVEST_WALLET,//clp
                    'type' => Wallet::REINVEST_CLP_TYPE,//tranfer
                    'inOut' => Wallet::OUT,
                    'userId' => $currentuserid,
                    'amount' => $userCoin->availableAmount,
                ];
                Wallet::create($fieldHolidng);

                
                return response()->json(array('msg' => trans('adminlte_lang::wallet.msg_transfer_success')));
            } catch ( \Exception $e) {
                return response()->json( array('msg' => trans('adminlte_lang::wallet.msg_transfer_fail')) );
            }
        }

        return response()->json( array('err' => true, 'msg' => 'You action is denied!') );
    }
    
    /**
     * 
     * @param Request $request
     * @return type
     */
    public function buyclpbybtc(Request $request){
        $currentuserid = Auth::user()->id;
        $user = Auth::user();
        $tygia = 1;
        if ($request->isMethod('post')) {
            Validator::extend('btcCoinAmount', function ($attribute, $value) {
                $currentuserid = Auth::user()->id;
                $userCoin = Auth::user()->userCoin;
                if ($userCoin->btcCoinAmount < $value)
                    return false;
                return true;
            });
            $this->validate($request, [
                'amount' => 'required|btcCoinAmount',
            ]);
            $amount = $request->get('amount');

            $userCoin = Auth::user()->userCoin;
            $userCoin->clpCoinAmount = $userCoin->clpCoinAmount + ($tygia*$amount);
            $userCoin->btcCoinAmount = $userCoin->btcCoinAmount - $amount;
            $userCoin->save();
            $fieldUsd = [
                'walletType' => Wallet::BTC_WALLET,//btc
                'type' => Wallet::BTC_CLP_TYPE,//tranfer
                'inOut' => Wallet::OUT,
                'userId' => $currentuserid,
                'amount' => $amount,
            ];
            Wallet::create($fieldUsd);
            $fieldClp = [
                'walletType' => Wallet::CLP_WALLET,//clp
                'type' => Wallet::BTC_CLP_TYPE,//tranfer
                'inOut' => Wallet::IN,
                'userId' => $currentuserid,
                'amount' => $amount,
            ];
            Wallet::create($fieldClp);
            return redirect('wallets/btctransfer')
                ->with('flash_message',
                    'Tranfer btcCoin successfully.');
        }
        return view('adminlte::wallets.btctransfer')->with(compact('user', 'tygia'));
    }
    
    /**
     * 
     * @param Request $request
     * @return type
     */
    public function sellclpbybtc(Request $request){
        $currentuserid = Auth::user()->id;
        $user = Auth::user();
        $tygia = 1;
        if ($request->isMethod('post')) {
            Validator::extend('clpCoinAmount', function ($attribute, $value) {
                $currentuserid = Auth::user()->id;
                $userCoin = Auth::user()->userCoin;
                if ($userCoin->clpCoinAmount < $value)
                    return false;
                return true;
            });
            $this->validate($request, [
                'amount' => 'required|clpCoinAmount',
            ]);
            $amount = $request->get('amount');

            $userCoin = Auth::user()->userCoin;
            $userCoin->btcCoinAmount = $userCoin->btcCoinAmount + ($tygia*$amount);
            $userCoin->clpCoinAmount = $userCoin->clpCoinAmount - $amount;
            $userCoin->save();
            $fieldUsd = [
                'walletType' => Wallet::BTC_WALLET,//btc
                'type' => Wallet::CLP_BTC_TYPE,//tranfer
                'inOut' => Wallet::IN,
                'userId' => $currentuserid,
                'amount' => $amount,
            ];
            Wallet::create($fieldUsd);
            $fieldClp = [
                'walletType' => Wallet::CLP_WALLET,//clp
                'type' => Wallet::CLP_BTC_TYPE,//tranfer
                'inOut' => Wallet::OUT,
                'userId' => $currentuserid,
                'amount' => $amount,
            ];
            Wallet::create($fieldClp);
            return redirect('wallets/clptransfer')
                ->with('flash_message',
                    'Tranfer CLPCoin successfully.');
        }
        return view('adminlte::wallets.clptransfer')->with(compact('user', 'tygia'));
    }
    
    /**
     * 
     * @return type
     */
    public function buysellclp(){
        $currentuserid = Auth::user()->id;
        $user = Auth::user();
        $tygia = 1;
        return view('adminlte::wallets.buysellclp')->with(compact('user', 'tygia'));
    }
    
}
