<?php

namespace App\Http\Controllers;

use App\UserCoin;
use App\UserData;
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
            'price'=>'required|unique:packages',
            'token'=>'required',
            ]
        );
        $package = Package::create($request->only('name', 'price', 'token'));
		
        return redirect()->route('packages.index')
            ->with('flash_message',
             'Packages '. $package->name.' added!');
    }
    public function invest(Request $request){
        $currentuserid = Auth::user()->id;
        $user = User::findOrFail($currentuserid);
        if ($request->isMethod('post')) {
            Validator::extend('packageCheck', function ($attribute, $value) {
                $user = Auth::user();
                if($user->userData->packageId < $value){
                    $package = Package::find($value);
                    if($package){
                        $packageOld = Package::where('price', '<', $package->price)->orderBy('price', 'desc')->first();
                        $priceA = 0;
                        if($packageOld){
                            $priceA = $packageOld->price;
                        }
                        $clpCoinAmount = ($package->price - $priceA);
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

            $userData = UserData::findOrFail($currentuserid);
            $userData->packageId = $request['packageId'];
            $userData->status = 1;
            $userData->save();

            User::investBonus($user->id, $user->refererId, $request['packageId']);
            return redirect()->route('packages.invest')
                ->with('flash_message',
                    'Buy package successfully.');
        }
        $packages = Package::all();
        $lstPackSelect = array();
        foreach ($packages as $package){
            $lstPackSelect[$package->id] = $package->name;
        }
        return view('adminlte::package.invest', ['packages' => $packages, 'user' => $user, 'lstPackSelect' => $lstPackSelect]);
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
				'token'=>'required',
            ]
        );

        $input = $request->only(['name', 'price', 'token']);
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
