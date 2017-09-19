<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Wallet;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\User;
use App\Wallet;
use App\UserCoin;

use Auth;
use Symfony\Component\HttpFoundation\Session\Session; 
use Validator;
use Log;

class UsdWalletController extends Controller
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
    
    /** 
     * @author Huy NQ
     * @param Request $request
     * @return type
     */
    
    public function usdWallet( Request $request ) {
        //tranfer if request post
        if($request->isMethod('post')) {
            $this->validate($request, [
                'usd'=>'required|numeric',
                'clp'=>'required|numeric'
            ]);
            //Tranfer
            $this->tranferUSDCLP($request->usd, $request->clp, $request);
        }
        
        //get tỷ giá usd btc
        $dataCurrencyPair = $this->getRateUSDBTC();
        
        //get dữ liệu bảng hiển thị trên site
        $currentuserid = Auth::user()->id;
        $wallets = Wallet::where('userId', '=',$currentuserid)->where('walletType',self::USD)
       ->paginate();
        
        //Add thêm tỷ giá vào $wallets
        if(isset($dataCurrencyPair) && 
                count( json_decode($dataCurrencyPair) ) > 0 ) {
            
            $wallets->currencyPair = json_decode($dataCurrencyPair);
            
        } else {
            Log::info("Không get được tỷ giá");
        }
        
        return view('adminlte::wallets.usd')->with('wallets', $wallets);
    }
    
    /**
     * @author Huy NQ
     * @param type $usd
     * @param type $clp
     * @param type $request
     */
    private function tranferUSDCLP($usd, $clp, $request){
        //Kq sau khi tính 
        $valueAfterTranfer = [];
        $user = UserCoin::findOrFail( Auth::user()->id );

        try {
            //action trừ tiền USD và Cộng CLP của user Trong bảng UserCoin
            $valueAfterTranfer['usd_amount'] = $user->usdAmount - (double)$usd;
            $valueAfterTranfer['clp_amount'] =  $user->clpCoinAmount +  (double)$clp;
            //Hạn mức tối thiêu khi chuyển USD
            if( $usd < Wallet::MIN_TRANFER_USD_CLP ){
                 $request->session()->flash( 'errorMessage', "Số tiền chuyển nhỏ hơn hạn mức tối thiểu");
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
     * @internal Get tỷ giá Giữa USD / BTC 
     * @author Huy NQ
     * @return type json
     */
    private function getRateUSDBTC() {
        try {
            $ch = curl_init(config('app.link_ty_gia').self::BTCUSD);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $dataCurrencyPair = curl_exec($ch);
            curl_close($ch);
            return $dataCurrencyPair;
        } catch (\Exception $ex) {
            Log::error($ex->getTraceAsString());
        }
    }
    
    /** 
     * @internal Chuyển đổi giữa USD và CLP
     * @author Huy NQ
     * @param Request $request
     */
    public function switchUSDCLP(Request $request) {
        //if have get rq
        if( $request->method( 'get' ) ) {
            if( is_numeric( $request->value ) ){
                
                if($request->value == 0){
                    $data = 0;
                    $this->responseSuccess( $data );
                }
                
                if($request->type ===  self::USDCLP){
                    $data = $request->value * ( USER::getCLPUSDRate() );
                    return $this->responseSuccess( $data );
                } else {
                    $data = $request->value * ( 1/USER::getCLPUSDRate() );
                    return $this->responseSuccess( $data );
                }  
            }
        }
    }

}

