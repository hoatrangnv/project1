<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App;
use App\User;
use Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Session;
use Coinbase\Wallet\Client;
use Coinbase\Wallet\Configuration;
use Coinbase\Wallet\Resource\Account;
use Coinbase\Wallet\Resource\Address;

class UserController extends Controller
{
    public function __construct() 
    {
        $this->middleware(['auth', 'isAdmin']);
        parent::__construct();
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return view('adminlte::users.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::get();
        return view('adminlte::users.create', ['roles'=>$roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=>'required|max:120',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6|confirmed'
        ]);
        $configuration = Configuration::apiKey($apiKey, $apiSecret);
        $client = Client::create($configuration);

        $user = User::create($request->only('email', 'name', 'password'));

        $roles = $request['roles'];

        if (isset($roles)) {

            foreach ($roles as $role) {
            $role_r = Role::where('id', '=', $role)->firstOrFail();            
            $user->assignRole($role_r);
            }
        }        

        return redirect()->route('users.index')
            ->with('flash_message',
             'User successfully added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect('users');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::get();
        $configuration = Configuration::apiKey( config('app.coinbase_key'), config('app.coinbase_secret'));
        $client = Client::create($configuration);
        $account = new Account([
            'name' => 'New Account 6'
        ]);
        /*$client->createAccount($account);
        //$accountId = 'fe7791b7-7d7b-5a3a-bbbf-d324cefddd7a';
        $accountId = $account->getId();
        $account = $client->getAccount($accountId);
        $address = new Address([
            'name' => 'New Address 2'
        ]);
        $client->createAccountAddress($account, $address);
        $addresses = $client->getAccountAddresses($account);
        //$accounts = $client->getAccounts();
        print_r($addresses);*/
        //$account->getId();
        //$accountId = 'fe7791b7-7d7b-5a3a-bbbf-d324cefddd7a';
        //$account = $client->getAccount($accountId);
        //$account = $client->getPrimaryAccount();
        //$client->createAccount($account);
        $accountId = '99608fe5-c6d6-55e8-bb31-5c8c7b998642';
        //$accountId = $account->getId();
        $address = new Address([
            'name' => 'New Address19'
        ]);
        $account = $client->getAccount($accountId);
        //$client->createAccountAddress($account, $address);
        $addressId = $client->getAccountAddresses($account);
        print_r($addressId);
        $addresses = $client->getAccountAddress($account, $addressId->getFirstId());
        echo "Your address is: ".json_encode($addresses->getAddress())."<br>";
        die;

        return view('adminlte::users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $this->validate($request, [
            'name'=>'required|max:120',
            'email'=>'required|email|unique:users,email,'.$id,
            'password'=>'required|min:6|confirmed'
        ]);

        $input = $request->only(['name', 'email', 'password']);
        $roles = $request['roles'];
        $user->fill($input)->save();

        if (isset($roles)) {        
            $user->roles()->sync($roles);            
        }        
        else {
            $user->roles()->detach();
        }
        return redirect()->route('users.index')
            ->with('flash_message',
             'User successfully edited.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')
            ->with('flash_message',
             'User successfully deleted.');
    }
}
