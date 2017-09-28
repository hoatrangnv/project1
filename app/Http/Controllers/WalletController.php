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
        $wallets = Wallet::where('userId', '=',$currentuserid)->where('walletType', Wallet::CLP_WALLET)
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
    
    /**
     * 
     * @return type
     */
    public function reinvest(){
        if($request->isMethod('post')) {
            $this->validate($request, [
                'usd'=>'required|numeric',
                'clp'=>'required|numeric'
            ]);
            
            //Tranfer
            $this->tranferReinvestUSDCLP($usd, $clp, $request);
        }
        $currentuserid = Auth::user()->id;
        $wallets = Wallet::where('userId', '=',$currentuserid)->where('walletType', Wallet::CLP_WALLET)
        ->paginate();
        return view('adminlte::wallets.reinvest')->with('wallets', $wallets);
    }
    /**
     * @author Huy NQ
     * @param type $usd
     * @param type $clp
     * @param type $request
     */
    public function tranferReinvestUSDCLP($usd, $clp, $request){
        //Kq sau khi tính 
        $valueAfterTranfer = [];
        $user = Auth::user()->userCoin;

        try {
            //action trừ tiền USD và Cộng CLP của user Trong bảng UserCoin
            $valueAfterTranfer['usd_amount'] = $user->reinvestAmount - (double)$usd;
            $valueAfterTranfer['clp_amount'] =  $user->clpCoinAmount +  (double)$clp;
            //Hạn mức tối thiêu khi chuyển USD
            if( $usd > Auth()->user()->userCoin->availableAmount ){
                 $request->session()->flash( 'errorMessage', "Số tiền chuyển lớn hơn số tiền tối đa có thể chuyển");
            }
            //check gía trị sau khi thanh khoản USD mà nhỏ hơn 0 thì Not Accpect
            elseif( $valueAfterTranfer['usd_amount'] < 0 ) {
                $request->session()->flash( 'errorMessage', "Số tiền chuyển vượt quá mức cho phép của tài khoản" );
            } else {
                $user->usdAmount = $valueAfterTranfer['usd_amount'];
                $user->clpCoinAmount =  $valueAfterTranfer['clp_amount'];

                $result = $user->save();

                if($result) {

                    $dataInsert = [];
                    //Lưu LOG 2 report ... 1 : OUT USD và 2 : IN CLP vao bang Wallet
                    $dataInsert["usd_to_clp"] = [
                        "walletType" => Wallet::USD_WALLET,
                        "type"       => Wallet::USD_CLP_TYPE,
                        "inOut"      => Wallet::OUT,
                        "userId"     => Auth::user()->id,
                        "amount"     => $request->usd,
                        "note"       => "Tranfert to CLP wallet"
                    ];

                    $dataInsert["clp_from_usd"] = [
                        "walletType" => Wallet::USD_WALLET,
                        "type"       => Wallet::USD_CLP_TYPE,
                        "inOut"      => Wallet::IN,
                        "userId"     => Auth::user()->id,
                        "amount"     => $request->clp,
                        "note"       => "Tranfert from USD wallet"
                    ];
                    // Bulk insert
                    $result = Wallet::insert($dataInsert);

                    $request->session()->flash( 'successMessage', "Success" );
                } else {
                    $request->session()->flash( 'errorMessage', "Fail" );
                }
            }
        } catch (\Exception $ex) {
            Log::error( $ex->getTraceAsString() );
        }
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
