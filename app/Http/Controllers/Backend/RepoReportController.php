<?php
/**
 * Created by PhpStorm.
 * User: huydk
 * Date: 10/30/2017
 * Time: 1:41 PM
 */

namespace App\Http\Controllers\Backend;

use App\Helper\Helper;
use App\UserPackage;
use App\User;
use App\Package;
use App\UserData;
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

    public function __construct(Helper $helper,User $user,UserPackage $userPackage,UserData $userData)
    {
        $this->helper = $helper;
        $this->user = $user;
        $this->userPackage = $userPackage;
        $this->userData = $userData;
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

    /* Action get Data for report Controller
     * Type : new user, total package
     * Option : day , week , month
     * Date Custom : from date, to date
     * @return json data
     */
    public function action ($type, $opt, $dateCustom = array()){
        switch (TRUE){
            /*----NEW USER----*/
            case ($type == self::NEW_USER && $opt == self::DAY_NOW) :
                //Get data for main chart
                $data['data_analytic'] =  $this->user->getNewUserData($dateCustom);
                //Get data for mini chart
                $data['total'] = $this->get_all_total_each_type($dateCustom);
                //Add data for another element
                $data['type'] = $type;$data['opt'] = $opt;$data['date_custom']=$dateCustom;
                //Json to return
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
                $data['total'] = $this->get_all_total_each_type($dateCustom, $opt);
                $data['type'] = $type;$data['opt'] = $opt;$data['date_custom']=$dateCustom;
                $data['title'] = "Total Package";
                $data = $this->helper->json_encode_prettify($data);
                break;
            case  ($type == self::TOTAL_PACKAGE && $opt == self::MONTH_NOW) :
                $data['data_analytic'] =  $this->userPackage->getDataReport($date);
                $data['total'] = $this->get_all_total_each_type($date);
                $data['type'] = $type;$data['opt'] = $opt;$data['date_custom']=$dateCustom;
                $data['title'] = "Total Package";
                $data = $this->helper->json_encode_prettify($data);
                break;
        }

        return $data;
    }


}