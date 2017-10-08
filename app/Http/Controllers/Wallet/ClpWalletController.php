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
            if($key == 14) $wallet_type[$key] = trans($val);
            if($key == 15) $wallet_type[$key] = trans($val);
        }

        $clpWallet = CLPWallet::where('userId', $currentuserid)->selectRaw('address')->first();
        $walletAddress = isset($clpWallet->address) ? $clpWallet->address : '';

        return view('adminlte::wallets.clp', ['packages' => $packages, 
            'user' => $user, 
            'lstPackSelect' => $lstPackSelect, 
            'wallets'=> $wallets,
            'wallet_type'=> $wallet_type,
            'walletAddress' =>  $walletAddress,
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

    public function sellCLP(Request $request){
        $currentuserid = Auth::user()->id;
        $userCoin = Auth::user()->userCoin;
        if ( $request->isMethod('post') ) {
            //validate
            $this->validate($request, [
                'btcAmount'=>'required|numeric',
                'clpAmount'=>'required|numeric'
            ]);

            if ( $userCoin->clpCoinAmount >= $request->clpAmount ) {
                //Amount CLP
                $amountBTC = ($request->clpAmount * ExchangeRate::getCLPBTCRate()) + $userCoin->btcCoinAmount;
                $userCoin->clpCoinAmount = ($userCoin->clpCoinAmount - $request->clpAmount);
                $userCoin->btcCoinAmount = $amountBTC;
                $userCoin->save();

                $fieldCLP = [
                    'walletType' => Wallet::CLP_WALLET,//usd
                    'type' => Wallet::CLP_BTC_TYPE,//bonus f1
                    'inOut' => Wallet::OUT,
                    'userId' => Auth::user()->id,
                    'amount' => $request->clpAmount,
                    'note'   => 'Sell CLP'
                ];
                Wallet::create($fieldCLP);

                $fieldBTC = [
                    'walletType' => Wallet::BTC_WALLET,//reinvest
                    'type' => Wallet::CLP_BTC_TYPE,//bonus f1
                    'inOut' => Wallet::IN,
                    'userId' => Auth::user()->id,
                    'amount' => $amountBTC,
                    'note'   => 'Sell CLP'
                ];
                Wallet::create($fieldBTC);
                $request->session()->flash( 'successMessage', trans('adminlte_lang::wallet.msg_sell_clp_success') );
                return redirect()->route('wallet.clp');
            } else {
                //Not enough money
                $request->session()->flash( 'errorMessage', trans('adminlte_lang::wallet.error_not_enough') );
                return redirect()->route('wallet.clp');
            }
        } else { 
            return redirect()->route('wallet.clp');
        }
        
    }
    
}
