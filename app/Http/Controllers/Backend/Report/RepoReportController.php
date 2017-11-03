<?php
/**
 * Created by PhpStorm.
 * User: huydk
 * Date: 10/30/2017
 * Time: 1:41 PM
 */

namespace App\Http\Controllers\Backend\Report;

use App\Helper\Helper;
use App\UserPackage;
use App\User;
use App\Package;
use App\UserData;
use App\Wallet;
use DB;


class RepoReportController
{
    //OPTION
    const DAY_NOW = 1;
    const WEEK_NOW = 2;
    const MONTH_NOW = 3;

    //TYPE
    const NEW_USER = 1;
    const TOTAL_PACKAGE = 2;

    public function __construct(Helper $helper,User $user,UserPackage $userPackage,UserData $userData,Wallet $wallet)
    {
        $this->helper = $helper;
        $this->user = $user;
        $this->userPackage = $userPackage;
        $this->userData = $userData;
        $this->wallet = $wallet;
    }
    
    public function getDateNow(){
        return $this->helper->get_date_now();
    }
    /**
     * @param $from_date
     * @param $to_date
     * @return array
     */
    private function get_data_package_for_pie_chart($date, $opt){
        $data = $this->userData->get_data_for_pie_chart($date , $opt);
        return $data;
    }

    /*
     * Get total for each mini report below into report display
     * Date Custom : from date, to date
     * Option : day , week, month
     */
    private function get_all_total_each_type($date, $opt){
        $total['totalTotalPackage'] = $this->userPackage->countTotalValue($date, $opt);
        $total['totalNewUser'] = $this->user->getNewUser($date, $opt);
        $total['totalPackageForPieChart'] = $this->get_data_package_for_pie_chart($date, $opt);
        return $total;
    }

    private function addFristLastWeekDay($data = array(),$date){
        foreach ($data as $key => $value){
            if($key == 0){
                $data[$key]['first_day'] = $date['from_date'];
                $data[$key]['last_day']  =  $this->helper->get_end_day_of_week($value['date']);
            }elseif ($key == (count($data) -1) ){
                $data[$key]['first_day'] = $this->helper->get_frist_day_of_week($value['date']);
                $data[$key]['last_day'] = $date['to_date'];
            }else{
                $data[$key]['first_day'] = $this->helper->get_frist_day_of_week($value['date']);
                $data[$key]['last_day'] = $this->helper->get_end_day_of_week($value['date']);
            }
        }
        return $data;
    }

    private function addFristLastMonth($data = array(),$date){
        foreach ($data as $key => $value){
            if($key == 0){
                $data[$key]['first_day'] = $date['from_date'];
                $data[$key]['last_day']  =  $this->helper->get_end_day_of_month($value['date']);
            }elseif ($key == (count($data) -1) ){
                $data[$key]['first_day'] = $this->helper->get_frist_day_of_month($value['date']);
                $data[$key]['last_day'] = $date['to_date'];
            }else{
                $data[$key]['first_day'] = $this->helper->get_frist_day_of_month($value['date']);
                $data[$key]['last_day'] = $this->helper->get_end_day_of_month($value['date']);
            }
        }
        return $data;
    }

    public function action_commission($type, $opt, $dateCustom = array()){
        switch ($opt){
            case self::DAY_NOW :
                $data['data_analytic'] = $this->wallet->getDataReport($dateCustom, $opt);
//                dd($data);
        }
    }
    /* Action get Data for report Controller
     * Type : new user, total package
     * Option : day , week , month
     * Date Custom : from date, to date
     * @return json data
     */
    public function action ($type, $opt, $dateCustom = array()){
        //add 1 day for $to_date
        switch (TRUE){
            /*----NEW USER----*/
            case ($type == self::NEW_USER && $opt == self::DAY_NOW) :
                //Get data for main chart
                $data['data_analytic'] =  $this->user->getDataReport($dateCustom , $opt);
                //Get data for mini chart
                $data['total'] = $this->get_all_total_each_type($dateCustom,$opt);
                //Add data for another element
                $data['title'] = "New User";$data['type'] = $type;$data['opt'] = $opt;$data['date_custom']=$dateCustom;
                //Json to return
                $data = $this->helper->json_encode_prettify($data);
                break;
            case ($type == self::NEW_USER && $opt == self::WEEK_NOW) :
                $data['data_analytic'] =  $this->user->getDataReport($dateCustom , $opt);
                // add first_day_week and last_day_week
                $data['data_analytic'] = $this->addFristLastWeekDay($data['data_analytic'],$dateCustom);
                $data['total'] = $this->get_all_total_each_type($dateCustom,$opt);
                $data['title'] = "New User";$data['type'] = $type;$data['opt'] = $opt;$data['date_custom']=$dateCustom;
                $data = $this->helper->json_encode_prettify($data);
                break;
            case ($type == self::NEW_USER && $opt == self::MONTH_NOW) :
                $data['data_analytic'] =  $this->user->getDataReport($dateCustom , $opt);
                // add first_day_week and last_day_week
                $data['data_analytic'] = $this->addFristLastMonth($data['data_analytic'],$dateCustom);
                $data['total'] = $this->get_all_total_each_type($dateCustom,$opt);
                $data['title'] = "New User";$data['type'] = $type;$data['opt'] = $opt;$data['date_custom']=$dateCustom;
                $data = $this->helper->json_encode_prettify($data);
                break;
            /*----TOTAL_PACKAGE----*/
            case ($type == self::TOTAL_PACKAGE && $opt == self::DAY_NOW) :
                $data['data_analytic'] =  $this->userPackage->getDataReport($dateCustom, $opt);
                $data['total'] = $this->get_all_total_each_type($dateCustom, $opt);
                $data['type'] = $type; $data['opt'] = $opt; $data['date_custom']=$dateCustom;
                $data['title'] = "Total Package";
                $data = $this->helper->json_encode_prettify( $data );
                break;
            case  ($type == self::TOTAL_PACKAGE && $opt == self::WEEK_NOW) :
                $data['data_analytic'] =  $this->userPackage->getDataReport($dateCustom, $opt);
                // add first_day_week and last_day_week
                $data['data_analytic'] = $this->addFristLastWeekDay($data['data_analytic'],$dateCustom);
                $data['total'] = $this->get_all_total_each_type($dateCustom, $opt);
                $data['type'] = $type;$data['opt'] = $opt;$data['date_custom']=$dateCustom;
                $data['title'] = "Total Package";
                $data = $this->helper->json_encode_prettify($data);
                break;
            case  ($type == self::TOTAL_PACKAGE && $opt == self::MONTH_NOW) :
                $data['data_analytic'] =  $this->userPackage->getDataReport($dateCustom, $opt);
                // add first_day_month and last-day-month
                $data['data_analytic'] = $this->addFristLastMonth($data['data_analytic'],$dateCustom);
                $data['total'] = $this->get_all_total_each_type($dateCustom, $opt);
                $data['type'] = $type;$data['opt'] = $opt;$data['date_custom']=$dateCustom;
                $data['title'] = "Total Package";
                $data = $this->helper->json_encode_prettify($data);
                break;
        }

        return $data;
    }
    
}