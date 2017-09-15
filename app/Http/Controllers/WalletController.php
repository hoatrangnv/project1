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

class WalletController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index() {
       return view('adminlte::wallets.genealogy');
    }
    
    /** 
     * 
     * @param Request $request
     * @return type
     */
    
    public function usd(Request $request) {
        $currentuserid = Auth::user()->id;
        $wallets = Wallet::where('userId', '=',$currentuserid)->where('walletType',1)
       ->paginate();
        return view('adminlte::wallets.usd')->with('wallets', $wallets);
    }
    
    /**
     * @author 
     * @param Request $request
     * @return type
     */
    public function btc(Request $request){
        $currentuserid = Auth::user()->id;
        $wallets = Wallet::where('userId', '=',$currentuserid)->where('walletType',2)
                            //->take(10)
            ->paginate();
        return view('adminlte::wallets.btc')->with('wallets', $wallets);
    }
    
    /**
     * 
     * @param Request $request
     * @return type
     */
    public function getBtcCoin(Request $request){
        
        $currentuserid = Auth::user()->id;
        //get coin and update to DB
        $configuration = Configuration::apiKey( 
                    config('app.coinbase_key'), 
                    config('app.coinbase_secret') );
            
        $client = Client::create($configuration);
        $idCoinBase = Auth()->user()->userCoin->accountCoinBase;
        $account = $client->getAccount($idCoinBase);
        $btc = (double) $account->getBalance()->getAmount();
        
        //update db
        UserCoin::where('userId', '=',$currentuserid)
                ->update(['btcCoinAmount' => $btc]);
        $coin = Auth()->user()->userCoin->btcCoinAmount;
        return $coin;
    }
    
    /** 
     * Send Coin with BitGO
     * @param Request $request
     * @return type
     */
    
    public function sendCoin() {
        $this->validate($request, [
            'withdrawAmount'=>'required',
            'walletAddress'=>'required',
            'withdrawOPT'=>'required|min:6'
        ]);
        $amount = $request->get('withdrawAmount')*1e8;
        $walletAddress = $request->get('walletAddress');
        /////////////////////////////////
        $bitgo = new BitGoSDK();
        $bitgo->authenticateWithAccessToken(config('app.bitgo_token'));
        ////////////////////////////////
        //active api
        $bitgo->unlock('0000000');
        //send coin
        $wallet = $bitgo->wallets()->getWallet($user->walletAddress);
        $sendCoins = $wallet->sendCoins($walletAddress, $amount, config('app.bitgo_password'), $message = null);
        ///
        if($sendCoins['status'] == "accepted"){
            $withDraw = new Withdraw;
            $withDraw->walletAddress = $walletAddress;
            $withDraw->userId = $currentuserid;
            $withDraw->amountBTC = (double)$request->get('withdrawAmount');
            $withDraw->fee = (double)$sendCoins['fee']/1e8;
            $withDraw->detail = json_encode($sendCoins);
            $withDraw->status = 1;
            $withDraw->save();
        }
    }
    
    /**
     * @author Huynq
     * @param Request $request
     * @return view
     */
    public function btcwithdraw( Request $request ) {
       
        $currentuserid = Auth::user()->id;
        $user = UserCoin::findOrFail($currentuserid);
        $withdraws = Withdraw::where('userId', '=',$currentuserid)
                        ->get();
        $session = new Session;
        //send coin if request post
        if ( $request->isMethod('post') ) {
            //validate
            $this->validate($request, [
                'withdrawAmount'=>'required',
                'walletAddress'=>'required'
                //'withdrawOPT'=>'required|min:6'
            ]);
            
            // so sánh tiền để chuyển vào tk
            if ( $request->withdrawAmount > 
                    UserCoin::findOrFail($currentuserid)->btcCoinAmount - config('app.fee_withRaw') ) {
                
                $request->session()->flash( 'errorMessage', trans('adminlte_lang::wallet.error_not_enough') );
                return view('adminlte::wallets.btcwithdraw')->with('withdraws', $withdraws); 
                
            }
            
            //Config API key
            $configuration = Configuration::apiKey( 
                    config('app.coinbase_key'), 
                    config('app.coinbase_secret') );
            
            $client = Client::create($configuration);
        
            $transaction = Transaction::send([
                'toBitcoinAddress' => $request->walletAddress,
                'amount'           => new Money($request->withdrawAmount, CurrencyCode::BTC),
                'description'      => 'Your tranfer bitcoin!'
            ]);
            //get object account
            $account = $client->getAccount($user->accountCoinBase);
            //begin send
            try {
                $resultGiven = $client->createAccountTransaction($account, $transaction);
                //Action save to DB
                $dataInsert = [
                    "walletAddress" => $request->walletAddress,
                    "userId" => $currentuserid,
                    "amountBTC" => $request->withdrawAmount,
                    "detail" => json_encode($resultGiven)
                ];
                
                $dataInsert = Withdraw::creat($dataInsert);
                
                if($dataInsert == 1) {
                    $request->session()->flash( 'successMessage', trans('adminlte_lang::wallet.success_withdraw') );
                    //update btc amount _> DB
                    $btc = (double) $account->getBalance()->getAmount();
                    
                    UserCoin::where('userId', '=',$currentuserid)
                    ->update(['btcCoinAmount' => $btc]);
                    
                    return view('adminlte::wallets.btcwithdraw')->with('withdraws', $withdraws); 
                } else {
                    //Không kết nối được DB
                    $session->set( 'errorMessage', trans('adminlte_lang::wallet.error_db') );
                    return view('adminlte::wallets.btcwithdraw')->with('withdraws', $withdraws); 
                }
            } catch (\Exception $e) {
                //lỗi không thực hiện được giao dịch trên coinbase
                $request->session()->flash('errorMessage', $e->getMessage() );
                return view('adminlte::wallets.btcwithdraw')->with('withdraws', $withdraws); 
            }
        }else{ 
            return view('adminlte::wallets.btcwithdraw')->with('withdraws', $withdraws); 
        }
        
    }
    
    /** 
     * 
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
     * 
     * @return type
     */
    
    public function clp(){
        $currentuserid = Auth::user()->id;
        $wallets = Wallet::where('userId', '=',$currentuserid)->where('walletType',3)
       ->paginate();
        return view('adminlte::wallets.clp')->with('wallets', $wallets);
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
    
    /**
     * 
     * @param type $id
     */
    public function show($id)
    {
        echo $id;
        //return redirect('members/genealogy');
    }
}
