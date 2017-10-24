<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.3/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers\Backend;

use App\Http\Requests;
use App\UserData;
use App\LoyaltyUser;
use App\BonusBinary;
use App\Package;
use App\UserCoin;
use App\UserPackage;
use Auth;
use Log;
use DB;
use DateTime;
use App\Http\Controllers\Controller;


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
        return view('adminlte::backend.home.index');
    }


    /*
    *Author huynq
    *Doanh so F1 moi tinh trong tuan hien tai and trai and phai
    */
    private function newF1InWeek($value='')
    {
        $weeked = date('W');
        $year = date('Y');
        $weekYear = $year.$weeked;
        if($weeked < 10)$weekYear = $year.'0'.$weeked;
        try {
            $data =  BonusBinary::where('userId',Auth::user()->id)->where('weekYear', $weekYear)
                ->get();
            if(count($data) > 0){
                $data['total']   = $data[0]->leftNew + $data[0]->rightNew;
                $data['leftNew'] = $data[0]->leftNew;
                $data['rightNew']= $data[0]->rightNew;
                $data['leftOpen']= $data[0]->leftOpen;
                $data['rightOpen']= $data[0]->rightOpen;
            }else{
                $data['total'] = 0;
                $data['leftNew'] = 0;
                $data['rightNew'] = 0;
                $data['leftOpen']= 0;
                $data['rightOpen']= 0;
            }
            return $data;
        } catch (Exception $e) {
            Log::error( $e->gettraceasstring() );
        }
    }

    /*
    *Author huynq
    * Tong doanh so F1 tu khi tham gia and trai and phai
    */
    private function getF1CurrentWeek($value='')
    {
        try {
            $data = UserData::where('refererId', Auth::user()->id)
                ->pluck('userId');
            if ($data) {
                $firstDayThisWeek = date("Y-m-d 00:00:00", strtotime('monday this week'));

                $amount = 0;
                foreach( $data as $userId ) {
                    // Get current week package from table user_packages
                    $pakages = UserPackage::where('userId', $userId)->where('buy_date', '>',  $firstDayThisWeek)
                    ->get();
                    
                    foreach ($pakages as $package) {
                        $amount += $package->amount_increase;
                    }
                }

                //
                return $amount;
            }else{
                //Debug
                Log::error('Cannot get user with userid = ' . Auth::user()->id);
            }
        } catch (Exception $e) {
            Log::error($e->gettraceasstring());
        }
    }

    /**
    * @Author GiangDT
    * Total F1 from beginning day
    */
    private function getF1TotalSale()
    {
        try {
            $data = UserData::where('refererId', Auth::user()->id)
                ->pluck('userId');
            if ($data) {

                $amount = 0;
                foreach( $data as $userId ) {
                    // Get current week package from table user_packages
                    $pakages = UserPackage::where('userId', $userId)->get();
                    
                    foreach ($pakages as $package) {
                        $amount += $package->amount_increase;
                    }
                }

                //
                return $amount;
            }else{
                //Debug
                Log::error('Cannot get user with userid = ' . Auth::user()->id);
            }
        } catch (Exception $e) {
            Log::error($e->gettraceasstring());
        }
    }

    /*
    *Author huynq
    *Thông tin coin 
    */
    private function getInfoCoin(){
        try {
            $data = UserCoin::where("userId",Auth::user()->id)
                    ->get();
            return $data;
        } catch (Exception $ex) {
            echo $e->gettraceasstring();
        }
    }
}