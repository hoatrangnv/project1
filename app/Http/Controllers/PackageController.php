<?php

namespace App\Http\Controllers;

use App\UserCoin;
use App\UserData;
use App\UserPackage;
use Illuminate\Http\Request;

use App\User;
use App\Package;
use Auth;
use Session;
use App\Authorizable;
use Validator;
use DateTime;
use App\ExchangeRate;
use App\Wallet;
use App\CronProfitLogs;
use App\CronBinaryLogs;

class PackageController extends Controller
{
    use Authorizable;

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $packages = Package::all();
        return view('adminlte::package.index')->with('packages', $packages);
    }
    public function create()
    {
        return view('adminlte::package.create');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
                'name'=>'required|unique:packages',
                'price'=>'required|integer|unique:packages',
                'pack_id'=>'required|integer|unique:packages',
            ]
        );
        $package = Package::create($request->only('pack_id', 'name', 'price', 'token'));

        return redirect()->route('packages.index')
            ->with('flash_message',
                'Packages '. $package->name.' added!');
    }

    /**
    * Buy package action( upgrade package)
    */
    public function invest(Request $request)
    {
        $currentuserid = Auth::user()->id;
        $user = Auth::user();
        $currentDate = date("Y-m-d");
        $preSaleEnd = date('Y-m-d', strtotime(config('app.pre_sale_end')));
        if($user && $request->isMethod('post') && ($currentDate > $preSaleEnd)) 
        {
            Validator::extend('packageCheck', function ($attribute, $value) {
                $user = Auth::user();
                if($user->userData->packageId < $value)
                {
                    $package = Package::find($value);
                    if($package){
                        $packageOldId = $user->userData->packageId;
                        $usdCoinAmount = $package->price;

                        if($packageOldId > 0){
                            $usdCoinAmount = $usdCoinAmount - $user->userData->package->price;
                        }

                        $clpCoinAmount = $usdCoinAmount / ExchangeRate::getCLPUSDRate();
                        if($user->userCoin->clpCoinAmount >= $clpCoinAmount){
                            return true;
                        }
                    }
                }
                return false;
            });

            $this->validate($request, [
                'packageId' => 'required|not_in:0|packageCheck',
                'terms'    => 'required',
            ],['packageId.package_check' => 'You selected wrong package']);

            $amount_increase = $packageOldId = 0;
            $userData = $user->userData;
            $packageOldId = $userData->packageId;
            $packageOldPrice = isset($userData->package->price) ? $userData->package->price : 0;

            $userData->packageDate = date('Y-m-d H:i:s');
            $userData->packageId = $request->packageId;
            $userData->status = 1;
            $userData->save();

            $package = Package::find($request->packageId);
            if ($package) {
                $amount_increase = $package->price;
            }

            //Insert to cron logs for binary, profit
            if($packageOldId == 0) {
                if(CronProfitLogs::where('userId', $currentuserid)->count() < 1) 
                    CronProfitLogs::create(['userId' => $currentuserid]);
                if(CronBinaryLogs::where('userId', $currentuserid)->count() < 1) 
                    CronBinaryLogs::create(['userId' => $currentuserid]);
            }

            if($packageOldId > 0){
                $amount_increase = $package->price - $packageOldPrice;
            }

            //Get weekYear
            $weeked = date('W');
            $year = date('Y');
            $weekYear = $year.$weeked;

            if($weeked < 10) $weekYear = $year.'0'.$weeked;

            UserPackage::create([
                'userId' => $currentuserid,
                'packageId' => $userData->packageId,
                'amount_increase' => $amount_increase,
                'buy_date' => date('Y-m-d H:i:s'),
                'release_date' => date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") ."+ 6 months")),
                'weekYear' => $weekYear,
            ]);

            $amountCLPDecrease = $amount_increase / ExchangeRate::getCLPUSDRate();
            $userCoin = $userData->userCoin;
            $userCoin->clpCoinAmount = $userCoin->clpCoinAmount - $amountCLPDecrease;
            $userCoin->save();

            //get package name
            $package = Package::where('pack_id', $userData->packageId)->get()->first();

            $fieldUsd = [
                'walletType' => Wallet::CLP_WALLET,//usd
                'type' => Wallet::BUY_PACK_TYPE,//bonus f1
                'inOut' => Wallet::OUT,
                'userId' => Auth::user()->id,
                'amount' => $amountCLPDecrease,
                'note'   => $package->name
            ];
            Wallet::create($fieldUsd);

            // Calculate fast start bonus
            User::investBonus($user->id, $user->refererId, $request['packageId'], $amount_increase);

            // Case: User already in tree and then upgrade package => re-caculate loyalty
            if($userData->binaryUserId && $userData->packageId > 0)
                User::bonusLoyaltyUser($userData->userId, $userData->refererId, $userData->leftRight);

            // Case: User already in tree and then upgrade package => re-caculate binary bonus
            if($userData->binaryUserId > 0 && in_array($userData->leftRight, ['left', 'right'])) {
                $leftRight = $userData->leftRight == 'left' ? 1 : 2;
                User::bonusBinary($userData->userId, 
                                $userData->refererId, 
                                $userData->packageId, 
                                $userData->binaryUserId, 
                                $leftRight,
                                true,
								false
                            );
            }

            return redirect()->route('wallet.clp')
                            ->with('flash_message','Buy package successfully.');
        }
    }

    public function show($id)
    {
        return redirect('packages');
    }

    public function edit($id)
    {
        $package = Package::find($id);
        return view('adminlte::package.edit', compact('package'));
    }

    public function update(Request $request, $id)
    {
        $package = Package::find($id);
        if($package) {
            $this->validate($request, [
                    'name' => 'required|unique:packages,name,' . $id,
                    'price' => 'required|integer|unique:packages,price,' . $id,
                    'pack_id' => 'required|integer|unique:packages,pack_id,' . $id,
                ]
            );

            $input = $request->only(['pack_id', 'name', 'price', 'token']);
            $package->fill($input)->save();

            return redirect()->route('packages.index')
                ->with('flash_message',
                    'Package ' . $package->name . ' updated!');
        }else{
            return redirect()->route('Packages.index')
                ->with('error',
                    'Package not update!');
        }
    }
    public function destroy($id)
    {
        $package = Package::find($id);
        if($package){
            $package->delete();
            return redirect()->route('Packages.index')
                ->with('flash_message',
                    'Package deleted!');
        }else{
            return redirect()->route('Packages.index')
                ->with('error',
                    'Package not delete!');
        }

    }
    
    /**
     * @author Huy NQ
     * @param Request $request
     * @return type
     */
    public function withDraw(Request $request) {
        if($request->ajax()){
            $tempHistoryPackage = UserPackage::where("userId",Auth::user()->id)
                    ->orderBy('id', 'DESC')->first();
            if(!isset($tempHistoryPackage)){
                $message = trans("adminlte_lang::home.not_buy_package");
                return $this->responseError($errorCode = true,$message);
            }
            //check userID and check withdraw
            if( $tempHistoryPackage->withdraw == 1 ){
                $message = trans("adminlte_lang::home.package_withdrawn");
                return $this->responseError($errorCode = true,$message);
            }
           
            $datetime1 = new DateTime(date("Y-m-d H:i:s"));
            //get release date của package cuối cùng <-> max id
            $datetime2 = new DateTime($tempHistoryPackage->release_date);
            $interval = $datetime1->diff($datetime2);
            //compare
            if( $interval->format('%R%a') > 0 ){
                $message = trans("adminlte_lang::home.not_enought_time");
                return $this->responseError($errorCode = true,$message);
            }else{
                $listHistoryPackage = UserPackage::where("id","<=",$tempHistoryPackage->id)
                        ->where("userId",Auth::user()->id)
                        ->where("withdraw",0)
                        ->get();
                $sum = 0;
                foreach ($listHistoryPackage as $key => $value) {
                    $sum +=$value->amount_increase;
                    UserPackage::where("id",$value->id)
                        ->update(["withdraw"=> 1 ]);
                }
                $money = Auth()->user()->userCoin->usdAmount + $sum;
                $update = UserCoin::where("userId",Auth::user()->id)
                        ->update(["usdAmount" => $money]);

                $fieldUsd = [
                    'walletType' => Wallet::USD_WALLET,//usd
                    'type' => Wallet::WITHDRAW_PACK_TYPE,
                    'inOut' => Wallet::IN,
                    'userId' => Auth::user()->id,
                    'amount' => $sum,
                    'note'   => ''
                ];
                Wallet::create($fieldUsd);

                //Update packageId = 0 after withdraw
                //If over 12 months from release_date then withdraw don't update packageId = 
                $twelveMonth = strtotime($tempHistoryPackage->release_date . "+ 6 months");
                $datetime2 = new DateTime(date('Y-m-d H:i:s', $twelveMonth));

                $interval = $datetime1->diff($datetime2);

                if( $interval->format('%R%a') > 0 ) UserData::where('userId', Auth::user()->id)->update(["packageId" => 0]);

                if($update){
                    return $this->responseSuccess( $data = $money );
                }
            }
        }
    }
}
