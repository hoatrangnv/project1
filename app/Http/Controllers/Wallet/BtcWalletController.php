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

use Log;

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
    public function btcWallet(Request $request){
        $currentuserid = Auth::user()->id;
        $wallets = Wallet::where('userId', '=',$currentuserid)->where('walletType',2)
                            //->take(10)
            ->paginate();
        return view('adminlte::wallets.btc')->with('wallets', $wallets);
    }
    
    /** 
     * @author 
     * @param Request $request
     * @return type
     */
    public function deposit(Request $request){
        if($request->ajax()) {
            if(isset($request['action']) && $request['action'] == 'btc') {
                $currentuserid = Auth::user()->id;
                $user = UserCoin::findOrFail($currentuserid);
                return response()->json(array('walletAddress' => $user->walletAddress));
            }
        }
        die();
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
}
