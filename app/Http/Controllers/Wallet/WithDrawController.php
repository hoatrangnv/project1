<?php

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

class WithDrawController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
     * @author Huynq
     * Send Coin with BitGO
     * @param Request $request
     * @return type
     */
    protected function sendCoin() {
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
    public function btcWithDraw( Request $request ) {
       
        $currentuserid = Auth::user()->id;
        $user = UserCoin::findOrFail($currentuserid);
        $withdraws = Withdraw::where('userId', '=',$currentuserid)
                        ->get();
        //send coin if request post
        if ( $request->isMethod('post') ) {
            //validate
            $this->validate($request, [
                'withdrawAmount'=>'required|numeric',
                'walletAddress'=>'required'
                //'withdrawOPT'=>'required|min:6'
            ]);
            
            // nếu tổng số tiền sau khi trừ đi phí lơn hơn 
            // số tiền chuyển đi thì thực hiện giao dịch 
            
            if ( UserCoin::findOrFail($currentuserid)->btcCoinAmount - config('app.fee_withRaw') > 
                    $request->withdrawAmount ) {
                
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
                        Log::warning( "Error when insert DB !" );
                        $request->session()->flash( 'errorMessage', trans('adminlte_lang::wallet.error_db') );
                        return view('adminlte::wallets.btcwithdraw')->with('withdraws', $withdraws); 
                    }
                } catch (\Exception $e) {
                    //lỗi không thực hiện được giao dịch trên coinbase ghi vào LOG
                    Log::error( $e->getTraceAsString() );
                    $request->session()->flash('errorMessage', "Không thực hiện chuyển tiền được trên CoinBase" );
                    return view('adminlte::wallets.btcwithdraw')->with('withdraws', $withdraws); 
                }   
            }else {
                //nếu không đủ tiền thì báo lỗi
                $request->session()->flash( 'errorMessage', trans('adminlte_lang::wallet.error_not_enough') );
                return view('adminlte::wallets.btcwithdraw')->with('withdraws', $withdraws); 
            }
        }else{ 
            return view('adminlte::wallets.btcwithdraw')->with('withdraws', $withdraws); 
        }
    }
   
}
