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
    public function clpWallet() {
        $currentuserid = Auth::user()->id;
        $wallets = Wallet::where('userId', '=',$currentuserid)->where('walletType',3)
       ->paginate();
        
        //get Packgage
        $currentuserid = Auth::user()->id;
        $user = Auth::user();
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
        
    }
    
}
