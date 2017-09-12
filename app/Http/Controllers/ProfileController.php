<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.3/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\User;
use Auth;
use Session;

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
        $data = [];
        try {
            $data['PersonalData'] = $this->PersonalData();
            return view('adminlte::profile.index')->with('data', $data);
        } catch (Exception $e) {
            //Debug
            echo $e->gettraceasstring();
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
    *Author:huynq
    *PersonalData Controller
    */
    private function PersonalData($value='')
    {   
        $dataSend = [];
        try {
            $data = User::where('id',Auth::user()->id)
                    ->get();
            if ($data) {
                $dataSend['id'] = $data[0]->id;
                $dataSend['username'] = $data[0]->name;
                $dataSend['email'] = $data[0]->email;
                $dataSend['full_name'] = $data[0]->firstname.$data[0]->lastname;
                $dataSend['address_stress'] = null;
                $dataSend['address_stress_2'] = null;
                $dataSend['city'] = null;
                $dataSend['state'] = null;
                $dataSend['country'] = null;
                $dataSend['phone_number'] = $data[0]->phone;
                $dataSend['date_of_birth'] = null;
                $dataSend['passport_id_card'] = null;
                $dataSend['registration_date'] = $data[0]->created_at;
                $dataSend['sponsor_id'] = $data[0]->id;
                $dataSend['sponsor_username'] = $data[0]->name;
                $dataSend['sponsor_email'] = $data[0]->email;
                $dataSend['sponsor_phone_number'] = $data[0]->phone;
                $dataSend['sponsor_country'] = null;
                ($data[0]->is2fa == 1)  ? $dataSend['is2fa'] = true 
                                        : $dataSend['is2fa'] = false;
                return $dataSend; 
            }else{
                //Debug
                var_dump("Khong ton tai value");
            }      
        } catch (Exception $e) {
            echo ($e->gettraceasstring());
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