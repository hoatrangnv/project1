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
        $wallets = Wallet::where('userId', '=',$currentuserid)->where('walletType',3)
       ->paginate();
        
        //get Packgage
        $currentuserid = Auth::user()->id;
        $user = User::findOrFail($currentuserid);
        $packages = Package::all();
        $lstPackSelect = array();
        foreach ($packages as $package){
            $lstPackSelect[$package->id] = $package->name;
        }
        
        return view('adminlte::wallets.clp', ['packages' => $packages, 
            'user' => $user, 
            'lstPackSelect' => $lstPackSelect, 
            'wallets'=> $wallets
        ]);
        
//        return view('adminlte::wallets.clp')->with('wallets', $wallets);
    }
    
    /**
     * 
     * @return type
     */
    public function reinvest(){
        $currentuserid = Auth::user()->id;
        $wallets = Wallet::where('userId', '=',$currentuserid)->where('walletType',4)
        ->paginate();
        return view('adminlte::wallets.reinvest')->with('wallets', $wallets);
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

            $userCoin = UserCoin::findOrFail($currentuserid);
            $userCoin->clpCoinAmount = $userCoin->clpCoinAmount + ($tygia * $amount);
            $userCoin->usdAmount = $userCoin->usdAmount - $amount;
            $userCoin->save();

            $fieldUsd = [
                'walletType' => 1,//usd
                'type' => 1,//buy
                'inOut' => 'out',
                'userId' => $currentuserid,
                'amount' => $amount,
            ];
            Wallet::create($fieldUsd);
            $fieldClp = [
                'walletType' => 3,//clp
                'type' => 1,//buy
                'inOut' => 'in',
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
    
    /**
     * 
     * @param Request $request
     * @return type
     */
    public function buyclpbybtc(Request $request){
        $currentuserid = Auth::user()->id;
        $user = User::findOrFail($currentuserid);
        $tygia = 1;
        if ($request->isMethod('post')) {
            Validator::extend('btcCoinAmount', function ($attribute, $value) {
                $currentuserid = Auth::user()->id;
                $userCoin = UserCoin::findOrFail($currentuserid);
                if ($userCoin->btcCoinAmount < $value)
                    return false;
                return true;
            });
            $this->validate($request, [
                'amount' => 'required|btcCoinAmount',
            ]);
            $amount = $request->get('amount');

            $userCoin = UserCoin::findOrFail($currentuserid);
            $userCoin->clpCoinAmount = $userCoin->clpCoinAmount + ($tygia*$amount);
            $userCoin->btcCoinAmount = $userCoin->btcCoinAmount - $amount;
            $userCoin->save();
            $fieldUsd = [
                'walletType' => 2,//btc
                'type' => 2,//tranfer
                'inOut' => 'out',
                'userId' => $currentuserid,
                'amount' => $amount,
            ];
            Wallet::create($fieldUsd);
            $fieldClp = [
                'walletType' => 3,//clp
                'type' => 2,//tranfer
                'inOut' => 'in',
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
        $user = User::findOrFail($currentuserid);
        $tygia = 1;
        if ($request->isMethod('post')) {
            Validator::extend('clpCoinAmount', function ($attribute, $value) {
                $currentuserid = Auth::user()->id;
                $userCoin = UserCoin::findOrFail($currentuserid);
                if ($userCoin->clpCoinAmount < $value)
                    return false;
                return true;
            });
            $this->validate($request, [
                'amount' => 'required|clpCoinAmount',
            ]);
            $amount = $request->get('amount');

            $userCoin = UserCoin::findOrFail($currentuserid);
            $userCoin->btcCoinAmount = $userCoin->btcCoinAmount + ($tygia*$amount);
            $userCoin->clpCoinAmount = $userCoin->clpCoinAmount - $amount;
            $userCoin->save();
            $fieldUsd = [
                'walletType' => 2,//btc
                'type' => 2,//tranfer
                'inOut' => 'in',
                'userId' => $currentuserid,
                'amount' => $amount,
            ];
            Wallet::create($fieldUsd);
            $fieldClp = [
                'walletType' => 3,//clp
                'type' => 2,//tranfer
                'inOut' => 'out',
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
        $user = User::findOrFail($currentuserid);
        $tygia = 1;
        return view('adminlte::wallets.buysellclp')->with(compact('user', 'tygia'));
    }
    
}
