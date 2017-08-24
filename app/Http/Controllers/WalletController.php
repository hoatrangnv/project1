<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Wallet;
use App\Withdraw;
use Auth;
use Session;
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
        return view('adminlte::wallets.btcwithdraw')->with('withdraws', $withdraws);
    }
    public function deposit(Request $request){
        if($request->ajax()) {
            if(isset($request['action']) && $request['action'] == 'btc') {
                $currentuserid = Auth::user()->id;
                $user = User::findOrFail($currentuserid);
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
	public function show($id)
    {
		echo $id;
        //return redirect('members/genealogy');
    }
}
