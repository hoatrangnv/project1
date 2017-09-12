<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Package;
use Auth;
use Session;

class PackageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $packages = Package::all();
        return view('adminlte::packages.index')->with('packages', $packages);
    }
    public function create()
    {
        return view('adminlte::packages.create');
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
            $user->packageId = $request['packageId'];
            $user->status = 1;
            $user->save();
            User::investBonus($user->id, $user->refererId, $user->packageId);
            return redirect()->route('packages.invest')
                ->with('flash_message',
                    'Buy package successfully.');
        }
        $packages = Package::all();
        $lstPackSelect = array();
        foreach ($packages as $package){
            $lstPackSelect[$package->id] = $package->name;
        }
        return view('adminlte::packages.invest', ['packages' => $packages, 'user' => $user, 'lstPackSelect' => $lstPackSelect]);
    }
    public function show($id)
    {
        return redirect('packages');
    }
    public function edit($id)
    {
        $package = Package::findOrFail($id);
        return view('adminlte::packages.edit', compact('package'));
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
