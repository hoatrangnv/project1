<?php

namespace App\Http\Controllers\Backend\User;

use App\User;
use App\UserData;
use App\UserCoin;
use App\Wallet;
use App\Role;
use App\Permission;
use App\Authorizable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Google2FA;

class WalletController extends Controller
{
    //use Authorizable;

    public function index(Request $request)
    {
        if($request->q){
            $userId = $request->q;
            $result = Wallet::latest()->where('userId', $userId)
                ->paginate()->setPath ( '' );
            $pagination = $result->appends ( array (
                'q' => $userId
            ));

            return view('adminlte::backend.wallet.index', compact('result'))->withQuery ( $userId );
        }
        else{
            $result = Wallet::where('userId', 0)->paginate();
            return view('adminlte::backend.wallet.index', compact('result'));
        }
    }

    public function root()
    {
        $result = User::where('refererId', 0)->paginate();
        return view('adminlte::backend.user.root', compact('result'));
    }

    public function photo_approve()
    {
        $result = User::where('approve', 1)->paginate();
        return view('adminlte::backend.user.approve', compact('result'));
    }
    public function approve_ok($id)
    {
        if( User::find($id)->update(['approve'=> 2]) ) {
            flash()->success('User has been approve ok');
        } else {
            flash()->success('User not approve ok');
        }

        return redirect()->back();
    }
    public function approve_cancel($id)
    {
        if( User::find($id)->update(['approve'=> 3]) ) {
            flash()->success('User has been approve cancel');
        } else {
            flash()->success('User not approve cancel');
        }

        return redirect()->back();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name', 'id');

        $permissions = Permission::all('name', 'id');
        $roles = $roles->toArray();
        array_unshift($roles, "[None]");
        
        return view('adminlte::backend.user.new', compact('roles', 'permissions'));
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
            'name' => 'bail|required|min:2',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            //'roles' => 'required|min:1'
        ]);

        // hash password
        $request->merge(
            [
                'password' => bcrypt($request->get('password')),
                'refererId' => 0,
                'active' => 1,
                'uid' => User::getUid(),
                'google2fa_secret' => Google2FA::generateSecretKey(16)
            ]);
        // Create the user
        if ( $user = User::create($request->except('roles', 'permissions')) ) {

            $this->syncPermissions($request, $user);
            UserData::create($request->except('roles', 'permissions'));
            UserCoin::create($request->except('roles', 'permissions'));
            flash('User has been created.');

        } else {
            flash()->error('Unable to create user.');
        }

        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'id');
        $permissions = Permission::all('name', 'id');
        $roles = $roles->toArray();

        array_unshift($roles, "[None]");
        return view('adminlte::backend.user.edit', compact('user', 'roles', 'permissions'));
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
        $this->validate($request, [
            'name' => 'bail|required|min:2',
            'email' => 'required|email|unique:users,email,' . $id,
            //'roles' => 'required|min:1'
        ]);

        // Get the user
        $user = User::find($id);
        if ($user){
            $user->fill($request->except('roles', 'permissions', 'password'));
            if($request->get('password')) {
                $user->password = bcrypt($request->get('password'));
            }
            $this->syncPermissions($request, $user);

            $user->save();

            flash()->success('User has been updated.');

            return redirect()->route('users.index');
        }else{
            return redirect()->route('users.index')
                ->with('error',
                    'User not update!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @internal param Request $request
     */
    public function destroy($id)
    {
        if ( Auth::user()->id == $id ) {
            flash()->warning('Deletion of currently logged in user is not allowed :(')->important();
            return redirect()->back();
        }

        if( User::find($id)->delete() ) {
            flash()->success('User has been deleted');
        } else {
            flash()->success('User not deleted');
        }

        return redirect()->back();
    }
    public function reset2fa(Request $request)
    {
        if($request->userid && $request->userid > 0){
            if( User::find($request->userid)->update([ 'is2fa' => 0, 'google2fa_secret' => Google2FA::generateSecretKey(16) ]) ) {
                flash()->success('User has been reset 2FA');
            } else {
                flash()->success('User not reset 2FA');
            }

        }else{
            flash()->success('User not reset 2FA.');
        }
        return redirect()->back();
    }
   
}
