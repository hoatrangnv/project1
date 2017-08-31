<?php

namespace App\Http\Controllers;

use App\UserCoin;
use Illuminate\Http\Request;

use App\User;
use App\Wallet;
use App\Withdraw;
use Auth;
use Session;
use Validator;

use Coinbase\Wallet\Client;
use Coinbase\Wallet\Configuration;

class WalletController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
       return view('adminlte::wallets.genealogy');
    }
	
	public function usd(Request $request){
		$currentuserid = Auth::user()->id;
		$wallets = Wallet::where('userId', '=',$currentuserid)->where('walletType',1)
				->take(10)
			   //->limit(10)->offset(0)
				->get();
        return view('adminlte::wallets.usd')->with('wallets', $wallets);
    }
	
	public function btc(Request $request){
		$currentuserid = Auth::user()->id;
		$wallets = Wallet::where('userId', '=',$currentuserid)->where('walletType',2)
				->take(10)
			   //->limit(10)->offset(0)
				->get();
        return view('adminlte::wallets.btc')->with('wallets', $wallets);
    }

    public function btcwithdraw(Request $request){
        $currentuserid = Auth::user()->id;
        $withdraws = Withdraw::where('userId', '=',$currentuserid)
            ->take(10)
            //->limit(10)->offset(0)
            ->get();
        if ($request->isMethod('post')) {
            $key = Auth::user()->google2fa_secret;
            $this->validate($request, [
                'amount'=>'required',
                'walletAddress'=>'required',
                'code'=>'required|min:6'
            ]);
            $code = $request->get('code');
            $amount = $request->get('amount');
            $valid = Google2FA::verifyKey($key, $code);

        }
        return view('adminlte::wallets.btcwithdraw')->with('withdraws', $withdraws);
    }
    public function deposit(Request $request){
        if($request->ajax()) {
            if(isset($request['action']) && $request['action'] == 'btc') {
                $currentuserid = Auth::user()->id;
                $user = UserCoin::findOrFail($currentuserid);
                if ($user->walletAddress == '' && $user->accountCoinBase != '') {
                    $configuration = Configuration::apiKey(config('app.coinbase_key'), config('app.coinbase_secret'));
                    $client = Client::create($configuration);
                    $account = $client->getAccount($user->accountCoinBase);
                    $addressId = $client->getAccountAddresses($account);
                    $addresses = $client->getAccountAddress($account, $addressId->getFirstId());
                    $walletAddress = json_encode($addresses->getAddress());
                    if ($walletAddress != '') {
                        $user->walletAddress = $walletAddress;
                        $user->save();
                    }
                }
                return response()->json(array('walletAddress' => $user->walletAddress));
            }
        }
        die();
    }

	public function clp(){
		$currentuserid = Auth::user()->id;
		$wallets = Wallet::where('userId', '=',$currentuserid)->where('walletType',3)
				->take(10)
			   //->limit(10)->offset(0)
				->get();
        return view('adminlte::wallets.clp')->with('wallets', $wallets);
    }
	
	public function reinvest(){
		$currentuserid = Auth::user()->id;
		$wallets = Wallet::where('userId', '=',$currentuserid)->where('walletType',4)
				->take(10)
			   //->limit(10)->offset(0)
				->get();
        return view('adminlte::wallets.reinvest')->with('wallets', $wallets);
    }
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
	public function buysellclp(){
        $currentuserid = Auth::user()->id;
        $user = User::findOrFail($currentuserid);
        $tygia = 1;
        return view('adminlte::wallets.buysellclp')->with(compact('user', 'tygia'));
    }
	public function show($id)
    {
		echo $id;
        //return redirect('members/genealogy');
    }
}
