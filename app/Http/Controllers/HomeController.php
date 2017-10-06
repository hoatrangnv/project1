<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.3/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use App\UserData;
use App\BonusBinary;
use App\Package;
use App\UserCoin;
use App\UserPackage;
use Auth;
use Log;
use DB;
use DateTime;


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
        $data = [];
        //Tong doanh so and ben trai and ben phai
        $data['newF1InWeek']      = $this->getF1CurrentWeek();
        $data['totalF1Sale']   = $this->getF1TotalSale();
        
        //Goi Packgade id
        $userData = UserData::where('userId', Auth::user()->id)->get()->first();
        $data['package'] = isset($userData->packageId) ? $userData->packageId : 0;

        if( count( Package::where('id',$data['package'])->get() ) == 0 ){
            $data['value'] = 0;
        }else{
            $data['value'] = Package::where('id',$data['package'])->get()[0]->price;
        }

        //Doanh so F1 moi
        $newF1InWeek = $this->newF1InWeek();
        //$data['newF1InWeek'] = $newF1InWeek['total'];
        $data['leftNew']     = $newF1InWeek['leftNew'];
        $data['rightNew']    = $newF1InWeek['rightNew'];
        $data['leftTotal']    = isset($userData->totalBonusLeft) ? $userData->totalBonusLeft : 0;
        $data['rightTotal']   = isset($userData->totalBonusRight) ? $userData->totalBonusRight : 0;
        //Get số lương coin trong tài khoản
        $data['coin'] = $this->getInfoCoin();
        //Get lịch sử package
        $data['history_package'] = UserPackage::getHistoryPackage();
        // check turn on/off button withdraw
        $tempHistoryPackage = UserPackage::where("userId",Auth::user()->id)
                    ->orderBy('id', 'DESC')->first();
        if(isset($tempHistoryPackage)){
            //check status withdraw
            if( $tempHistoryPackage->withdraw == 1 ){
                $disabled = true;
            } else {
                $datetime1 = new DateTime(date("Y-m-d H:i:s"));
                //get release date của package cuối cùng <-> max id
                $datetime2 = new DateTime($tempHistoryPackage->release_date);
                $interval = $datetime1->diff($datetime2);
                //compare
                if( $interval->format('%R%a') > 0 ){
                    $disabled = true;
                }
            }
            
        }else{
            $disabled = true;
        }
        return view('adminlte::home.index')->with(compact('data','disabled'));
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