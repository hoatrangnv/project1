<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.3/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\UserData;
use App\BonusBinary;
use App\Package;
use Auth;
use Session;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        try {
            $data = [];
            //Tong doanh so and ben trai and ben phai
            $totalF1User              = $this->totalF1();
            $data['totalF1User']      = $totalF1User->totalBonus;
            $data['totalF1UserLeft']  = $totalF1User->totalBonusLeft;
            $data['totalF1UserRight'] = $totalF1User->totalBonusRight;
            //Goi Packgade id
            $data['package'] = $totalF1User->packageId;

            if( count( Package::where('id',$data['package'])->get() ) == 0 ){
                $data['value'] = 0;
            }else{
                $data['value'] = Package::where('id',$data['package'])->get()[0]->price;
            }

            //Doanh so F1 moi
            $newF1InWeek = $this->newF1InWeek();
            $data['newF1InWeek'] = $newF1InWeek['total'];
            $data['leftNew']     = $newF1InWeek['leftNew'];
            $data['rightNew']    = $newF1InWeek['rightNew'];
            
            return view('adminlte::home.index')->with('data', $data);
        } catch (Exception $e) {
            //Debug
            echo $e->gettraceasstring();
        }
    }

    /*
    *Author huynq
    *Doanh so F1 moi tinh trong tuan hien tai and trai and phai
    */
    private function newF1InWeek($value='')
    {
        try {
            $data =  BonusBinary::where('userId',Auth::user()->id)
                    ->get();
            if(count($data) > 0){
                $data['total']   = $data[0]->leftNew + $data[0]->rightNew;
                $data['leftNew'] = $data['0']->leftNew;
                $data['rightNew']= $data['0']->rightNew;
            }else{
                $data['total'] = 0;
                $data['leftNew'] = 0;
                $data['rightNew'] = 0;
            }
            return $data;
        } catch (Exception $e) {
            echo $e->gettraceasstring();    
        }    
    }

    /*
    *Author huynq
    *Tong doanh so F1 tu khi tham gia and trai and phai
    */
    private function totalF1($value='')
    {   
        try {
            $data = UserData::where('userId',Auth::user()->id)
                    ->get();
            if ($data) {
                return $data[0]; 
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