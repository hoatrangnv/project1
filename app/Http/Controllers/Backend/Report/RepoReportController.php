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
use Illuminate\Support\Facades\URL;


class RepoReportController
{
    //OPTION
    const DAY_NOW = 1;
    const WEEK_NOW = 2;
    const MONTH_NOW = 3;

    //TYPE
    const NEW_USER = 1;
    const TOTAL_PACKAGE = 2;
    const BTC_DEPOSIT = 3;
    const BTC_WITHDRAW = 4;
    const CLP_DEPOSIT = 5;
    const CLP_WITHDRAW = 6;
    const TOTAL_SELL_CLP = 7;

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
    private function get_data_package_for_pie_chart($date){
        $data = $this->userData->get_data_for_pie_chart($date);
        return $data;
    }

    /*
     * Get total for each mini report below into report display
     * Date Custom : from date, to date
     * Option : day , week, month
     */
    private function get_all_total_each_type($date){
        $total['totalTotalPackage'] = $this->userPackage->countTotalValue($date);
        $total['totalNewUser'] = $this->user->getNewUser($date);
        $total['totalPackageForPieChart'] = $this->get_data_package_for_pie_chart($date);
        $total['totalBtcDeposit'] = $this->wallet->getTotalBtcDeposit($date);
        $total['totalBtcWithDraw'] = $this->wallet->getTotalBtcWithDraw($date);
        $total['totalClpDeposit'] = $this->wallet->getTotalClpDeposit($date);
        $total['totalClpWithDraw'] = $this->wallet->getTotalClpWithDraw($date);
        $total['totalTotalSellClp'] = $this->wallet->getTotalSellCLPReport($date);
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

    /*
     * Xử lý điều hướng lấy dữ liệu theo option
     * */
    public function action_commission($opt, $dateCustom = array()){
        switch ($opt) {
            case self::DAY_NOW :
                $data = $this->getDataForCommission($opt,$dateCustom);
                break;
            case self::WEEK_NOW :
                $data = $this->getDataForCommission($opt,$dateCustom);
                break;
            case self::MONTH_NOW :
                $data = $this->getDataForCommission($opt,$dateCustom);
                break;
            default:
                break;
        }
        return $this->helper->json_encode_prettify($data);
    }

    public function getDataForCommission($opt,$dateCustom){
        $data = array();
        $data['data_analytic'] = $this->wallet->getDataReport($dateCustom, $opt);
        $data['action_type'] = ['Fast Start', 'Interest Type',
            'Binary Type', 'Ltoyalty Type', 'Matching Type'];
        $data['type'] = [Wallet::FAST_START_TYPE, Wallet::INTEREST_TYPE, Wallet::BINARY_TYPE,
            Wallet::LTOYALTY_TYPE, Wallet::MATCHING_TYPE];
        $type_10_6 = [Wallet::FAST_START_TYPE, Wallet::BINARY_TYPE,
            Wallet::LTOYALTY_TYPE, Wallet::MATCHING_TYPE];
        $temp = array();

        foreach ($data['data_analytic'] as $value) {
            if (in_array($value['type'], $type_10_6)) {
                $temp[$value['date']][$value['type']] = $value['totalPrice'] * 10 / 6;
            } else {
                $temp[$value['date']][$value['type']] = $value['totalPrice'];
            }
        }

        foreach ($temp as $key => $value) {
            foreach ($data['type'] as $val) {
                if (!isset($value[$val])) {
                    $temp[$key][$val] = $value[$val] = 0;
                }
            }
            //sort type wallet
            ksort($temp[$key]);
        }

        $data['data_analytic'] = $temp;
        $data['link'] = $this->renderLink($dateCustom);
        $data['opt'] = (int)$opt;
        $data['date_custom'] = $dateCustom;
        return $data;
    }

    /**
     * Get link day , week , month ...
     */
    private function renderLink($dateCustom){
        $from_date = $dateCustom['from_date'];
        $to_date = $dateCustom['to_date'];

        $data['day'] = URL('report/commission');
        $data['day'].= "?from_date=$from_date&to_date=$to_date";
        $data['day'].= "&opt=".self::DAY_NOW;

        $data['week'] = URL('report/commission');
        $data['week'].= "?from_date=$from_date&to_date=$to_date";
        $data['week'].= "&opt=".self::WEEK_NOW;

        $data['month'] = URL('report/commission');
        $data['month'].= "?from_date=$from_date&to_date=$to_date";
        $data['month'].= "&opt=".self::MONTH_NOW;
        return $data;
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
            /*----------------------------------BTC DEPOSIT------------------------------------------*/
            case ($type == self::BTC_DEPOSIT && $opt == self::DAY_NOW) :
                $data['data_analytic'] =  $this->wallet->getDataForBtcDepositReport($dateCustom, $opt);
                // add first_day_month and last-day-month
                $data['data_analytic'] = $this->addFristLastMonth($data['data_analytic'],$dateCustom);
                $data['total'] = $this->get_all_total_each_type($dateCustom, $opt);
                $data['type'] = $type;$data['opt'] = $opt;$data['date_custom']=$dateCustom;
                $data['title'] = "BTC DEPOSIT";
                $data = $this->helper->json_encode_prettify($data);
                break;
            case ($type == self::BTC_DEPOSIT && $opt == self::WEEK_NOW) :
                $data['data_analytic'] =  $this->wallet->getDataForBtcDepositReport($dateCustom, $opt);
                // add first_day_week and last_day_week
                $data['data_analytic'] = $this->addFristLastWeekDay($data['data_analytic'],$dateCustom);
                $data['total'] = $this->get_all_total_each_type($dateCustom, $opt);
                $data['type'] = $type;$data['opt'] = $opt;$data['date_custom']=$dateCustom;
                $data['title'] = "Total Package";
                $data = $this->helper->json_encode_prettify($data);
                break;
            case ($type == self::BTC_DEPOSIT && $opt == self::MONTH_NOW) :
                $data['data_analytic'] =  $this->wallet->getDataForBtcDepositReport($dateCustom, $opt);
                // add first_day_month and last-day-month
                $data['data_analytic'] = $this->addFristLastMonth($data['data_analytic'],$dateCustom);
                $data['total'] = $this->get_all_total_each_type($dateCustom, $opt);
                $data['type'] = $type;$data['opt'] = $opt;$data['date_custom']=$dateCustom;
                $data['title'] = "Total Package";
                $data = $this->helper->json_encode_prettify($data);
                break;
            /*----------------------------------BTC WITHDRAW------------------------------------------*/
            case ($type == self::BTC_WITHDRAW && $opt == self::DAY_NOW) :
                $data['data_analytic'] =  $this->wallet->getDataForBtcWithDrawReport($dateCustom, $opt);
                // add first_day_month and last-day-month
                $data['data_analytic'] = $this->addFristLastMonth($data['data_analytic'],$dateCustom);
                $data['total'] = $this->get_all_total_each_type($dateCustom, $opt);
                $data['type'] = $type;$data['opt'] = $opt;$data['date_custom']=$dateCustom;
                $data['title'] = "BTC DEPOSIT";
                $data = $this->helper->json_encode_prettify($data);
                break;
            case ($type == self::BTC_WITHDRAW && $opt == self::WEEK_NOW) :
                $data['data_analytic'] =  $this->wallet->getDataForBtcWithDrawReport($dateCustom, $opt);
                // add first_day_week and last_day_week
                $data['data_analytic'] = $this->addFristLastWeekDay($data['data_analytic'],$dateCustom);
                $data['total'] = $this->get_all_total_each_type($dateCustom, $opt);
                $data['type'] = $type;$data['opt'] = $opt;$data['date_custom']=$dateCustom;
                $data['title'] = "Total Package";
                $data = $this->helper->json_encode_prettify($data);
                break;
            case ($type == self::BTC_WITHDRAW && $opt == self::MONTH_NOW) :
                $data['data_analytic'] =  $this->wallet->getDataForBtcWithDrawReport($dateCustom, $opt);
                // add first_day_month and last-day-month
                $data['data_analytic'] = $this->addFristLastMonth($data['data_analytic'],$dateCustom);
                $data['total'] = $this->get_all_total_each_type($dateCustom, $opt);
                $data['type'] = $type;$data['opt'] = $opt;$data['date_custom']=$dateCustom;
                $data['title'] = "Total Package";
                $data = $this->helper->json_encode_prettify($data);
                break;
            /*----------------------------------CLP DEPOSIT------------------------------------------*/
            case ($type == self::CLP_DEPOSIT && $opt == self::DAY_NOW) :
                $data['data_analytic'] =  $this->wallet->getDataForClpDepositReport($dateCustom, $opt);
                // add first_day_month and last-day-month
                $data['data_analytic'] = $this->addFristLastMonth($data['data_analytic'],$dateCustom);
                $data['total'] = $this->get_all_total_each_type($dateCustom, $opt);
                $data['type'] = $type;$data['opt'] = $opt;$data['date_custom']=$dateCustom;
                $data['title'] = "BTC DEPOSIT";
                $data = $this->helper->json_encode_prettify($data);
                break;
            case ($type == self::CLP_DEPOSIT && $opt == self::WEEK_NOW) :
                $data['data_analytic'] =  $this->wallet->getDataForClpDepositReport($dateCustom, $opt);
                // add first_day_week and last_day_week
                $data['data_analytic'] = $this->addFristLastWeekDay($data['data_analytic'],$dateCustom);
                $data['total'] = $this->get_all_total_each_type($dateCustom, $opt);
                $data['type'] = $type;$data['opt'] = $opt;$data['date_custom']=$dateCustom;
                $data['title'] = "Total Package";
                $data = $this->helper->json_encode_prettify($data);
                break;
            case ($type == self::CLP_DEPOSIT && $opt == self::MONTH_NOW) :
                $data['data_analytic'] =  $this->wallet->getDataForClpDepositReport($dateCustom, $opt);
                // add first_day_month and last-day-month
                $data['data_analytic'] = $this->addFristLastMonth($data['data_analytic'],$dateCustom);
                $data['total'] = $this->get_all_total_each_type($dateCustom, $opt);
                $data['type'] = $type;$data['opt'] = $opt;$data['date_custom']=$dateCustom;
                $data['title'] = "Total Package";
                $data = $this->helper->json_encode_prettify($data);
                break;
            /*----------------------------------CLP WITHDRAW------------------------------------------*/
            case ($type == self::CLP_WITHDRAW && $opt == self::DAY_NOW) :
                $data['data_analytic'] =  $this->wallet->getDataForClpWithDrawReport($dateCustom, $opt);
                // add first_day_month and last-day-month
                $data['data_analytic'] = $this->addFristLastMonth($data['data_analytic'],$dateCustom);
                $data['total'] = $this->get_all_total_each_type($dateCustom, $opt);
                $data['type'] = $type;$data['opt'] = $opt;$data['date_custom']=$dateCustom;
                $data['title'] = "BTC DEPOSIT";
                $data = $this->helper->json_encode_prettify($data);
                break;
            case ($type == self::CLP_WITHDRAW && $opt == self::WEEK_NOW) :
                $data['data_analytic'] =  $this->wallet->getDataForClpWithDrawReport($dateCustom, $opt);
                // add first_day_week and last_day_week
                $data['data_analytic'] = $this->addFristLastWeekDay($data['data_analytic'],$dateCustom);
                $data['total'] = $this->get_all_total_each_type($dateCustom, $opt);
                $data['type'] = $type;$data['opt'] = $opt;$data['date_custom']=$dateCustom;
                $data['title'] = "Total Package";
                $data = $this->helper->json_encode_prettify($data);
                break;
            case ($type == self::CLP_WITHDRAW && $opt == self::MONTH_NOW) :
                $data['data_analytic'] =  $this->wallet->getDataForClpWithDrawReport($dateCustom, $opt);
                // add first_day_month and last-day-month
                $data['data_analytic'] = $this->addFristLastMonth($data['data_analytic'],$dateCustom);
                $data['total'] = $this->get_all_total_each_type($dateCustom, $opt);
                $data['type'] = $type;$data['opt'] = $opt;$data['date_custom']=$dateCustom;
                $data['title'] = "Total Package";
                $data = $this->helper->json_encode_prettify($data);
                break;
            /*----------------------------------TOTAL SELL CLP------------------------------------------*/
            case ($type == self::TOTAL_SELL_CLP && $opt == self::DAY_NOW) :
                $data['data_analytic'] =  $this->wallet->getDataForTotalSellCLPReport($dateCustom, $opt);
                // add first_day_month and last-day-month
                $data['data_analytic'] = $this->addFristLastMonth($data['data_analytic'],$dateCustom);
                $data['total'] = $this->get_all_total_each_type($dateCustom, $opt);
                $data['type'] = $type;$data['opt'] = $opt;$data['date_custom']=$dateCustom;
                $data['title'] = "BTC DEPOSIT";
                $data = $this->helper->json_encode_prettify($data);
                break;
            case ($type == self::TOTAL_SELL_CLP && $opt == self::WEEK_NOW) :
                $data['data_analytic'] =  $this->wallet->getDataForTotalSellCLPReport($dateCustom, $opt);
                // add first_day_week and last_day_week
                $data['data_analytic'] = $this->addFristLastWeekDay($data['data_analytic'],$dateCustom);
                $data['total'] = $this->get_all_total_each_type($dateCustom, $opt);
                $data['type'] = $type;$data['opt'] = $opt;$data['date_custom']=$dateCustom;
                $data['title'] = "Total Package";
                $data = $this->helper->json_encode_prettify($data);
                break;
            case ($type == self::TOTAL_SELL_CLP && $opt == self::MONTH_NOW) :
                $data['data_analytic'] =  $this->wallet->getDataForTotalSellCLPReport($dateCustom, $opt);
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