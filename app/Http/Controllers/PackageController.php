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
    public function invest(Request $request){
        if ($request->isMethod('post')) {
            Validator::extend('packageCheck', function ($attribute, $value) {
                $user = Auth::user();
                if($user->userData->packageId < $value){
                    $package = Package::find($value);
                    if($package){
                        $packageOldId = $user->userData->packageId;
                        $usdCoinAmount = $package->price;
                        if($packageOldId > 0){
                            $usdCoinAmount = $usdCoinAmount - $user->userData->package->price;
                        }
                        $clpCoinAmount = $usdCoinAmount / User::getCLPUSDRate();
                        if($user->userCoin->clpCoinAmount >= $clpCoinAmount){
                            return true;
                        }
                    }
                }
                return false;
            });
            $this->validate($request, [
                'packageId' => 'required|not_in:0|packageCheck',
            ],['packageId.package_check' => 'CLP Coin not money buy package']);
            $amount_increase = $packageOldId = 0;
            $userData = UserData::findOrFail($currentuserid);
            $packageOldId = $userData->packageId;

            $userData->packageDate = date('Y-m-d H:i:s');
            $userData->packageId = $request['packageId'];
            $userData->status = 1;
            $userData->save();

            $package = Package::findOrFail($request->packageId);
            if($package)$amount_increase = $package->price;
            if($packageOldId > 0){
                $amount_increase = $package->price - $userData->package->price;
            }
            UserPackage::create([
                'userId' => $currentuserid,
                'packageId' => $userData->packageId,
                'amount_increase' => $amount_increase,
                'buy_date' => date('Y-m-d H:i:s'),
                'release_date' => date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") ."+ 180 days"))
            ]);

            $userCoin = $user->userCoin;
            $userCoin->clpCoinAmount = $userCoin->clpCoinAmount - ($amount_increase / User::getCLPUSDRate());
            $userCoin->save();

            User::investBonus($user->id, $user->refererId, $request['packageId'], $amount_increase);
            return redirect()->route('wallet.clp')
                ->with('flash_message',
                    'Buy package successfully.');
        }
    }
    public function show($id)
    {
        return redirect('packages');
    }
    public function edit($id)
    {
        $package = Package::findOrFail($id);
        return view('adminlte::package.edit', compact('package'));
    }
    public function update(Request $request, $id)
    {
        $package = Package::findOrFail($id);
        $this->validate($request, [
                'name'=>'required|unique:packages,name,'.$id,
                'price'=>'required|integer|unique:packages,price,'.$id,
                'pack_id'=>'required|integer|unique:packages,pack_id,'.$id,
            ]
        );

        $input = $request->only(['pack_id', 'name', 'price', 'token']);
        $package->fill($input)->save();

        return redirect()->route('packages.index')
            ->with('flash_message',
                'Package '. $package->name.' updated!');
    }
    public function destroy($id)
    {
        $package = Package::findOrFail($id);
        $package->delete();

        return redirect()->route('Packages.index')
            ->with('flash_message',
                'Package deleted!');
    }
}
