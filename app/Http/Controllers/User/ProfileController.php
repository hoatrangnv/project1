<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.3/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers\User;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\User;
use Auth;
use Session;
use Hash;
use App\Http\Controllers\Controller;

/**
 * Class ProfileController
 * @package App\Http\Controllers\Profile
 */
class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
        parent::__construct();
    }

    /**
     * Show profile user.
     *
     * @return Response
     */
    public function index()
    {
        $lstCountry = config('cryptolanding.lstCountry');
        $lstCountry = array_merge(array("0" => 'Choose a country'), $lstCountry);
        return view('adminlte::profile.index', compact('lstCountry'));
    }
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if($user){
            $user->fill($request->except('password'));
            $user->save();
            flash()->success('Profile has been updated.');
            return redirect()->route('profile.index');
        }else{
            return redirect()->route('profile.index')
                ->with('error',
                    'Profile not update!');
        }
    }
    /**
     * Change password profile user.
     *
     * @return Response
     */
    public function changePassword(Request $request){
        $a = $this->validate($request, [
            'new_password'=>'required|min:6'
        ]);
        //no error
        if($a == null){
            try {
                User::where('id',Auth::user()->id)
                    ->update( [ 'password' => bcrypt( $request->new_password ) ] );
                return Response::json([
                    "success" => true,
                    "result"  => null
                ] );
            } catch (Exception $e) {
                return Response::json([
                    "success" => false
                ]);
            }
        }
    }

    /**
     * Author:huynq
     * Switch on off two-factor authentication
     * @return boolean
     */
    public function switchTwoFactorAuthen(Request $request){
        try {
            $data = User::where('id',Auth::user()->id)
                        ->pluck('is2fa');
            ($data[0] == 1) ? $tmp = 0 : $tmp = 1; 
            $result = User::where('id',Auth::user()->id)
                    ->update( [ 'is2fa' => $tmp ] );
            if($result == 1){
                return Response::json([
                    "success" => true,
                    "result"  => null
                ]);
            }else{
                return Response::json([
                    "success" => false
                ]);   
            }
        } catch (Exception $e) {
            throw $e->gettraceasstring();
        }
    }


    /*
    *Author huynq
    *Danh hieu F1
    */
    private function appellationF1($value=''){

    }

    /*
    *Author huynq
    *Danh hieu F1
    */
    private function tichLuy($value=''){

    }
}