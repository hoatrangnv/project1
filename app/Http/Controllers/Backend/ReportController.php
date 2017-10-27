<?php

namespace App\Http\Controllers\Backend;

use App\Authorizable;
use App\Helper\Helper;
use App\UserPackage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Package;
use DB;



class ReportController extends Controller{

    use Authorizable;

    const DAY_NOW = 1;
    const WEEK_NOW = 2;
    const MONTH_NOW = 3;

    public function __construct(Helper $helper,User $user,UserPackage $userPackage)
    {
        $this->middleware('auth');
        $this->helper = $helper;
        $this->user = $user;
        $this->userPackage = $userPackage;
    }

    public function index(){

        return view('adminlte::role.index', compact('roles', 'permissions'));
    }

    public function member_pack(){
        $packages = Package::all();
        return view('adminlte::backend.report.member_pack', compact('packages'));
    }

    /**
     * @deprecated get data for report app ( Ngày , Tháng , Năm Hiện Tại)
     * @see
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDataReport(Request $request){
        switch ($type = $request->type) {
            case self::DAY_NOW :
                //$from_data <=> $now_date
                $from_date = $this->helper->get_date_now();
                $to_date = $this->helper->get_date_now();
                $data =  $this->userPackage->getDataReport($from_date , $to_date);
                $newUser = $this->user->getNewUser($from_date,$to_date);
                $dataPackage = $this->getDataPackage($from_date,$to_date);
                break;
            case self::WEEK_NOW :
                $from_date = $this->helper->get_frist_day_of_week();
                $to_date = $this->helper->get_end_day_of_week();
                $data = $this->userPackage->getDataReport($from_date,$to_date);
                $newUser = $this->user->getNewUser($from_date,$to_date);
                $dataPackage = $this->getDataPackage($from_date,$to_date);
                break;
            case self::MONTH_NOW :
                $from_date = $this->helper->get_frist_day_of_month();
                $to_date = $this->helper->get_last_day_of_month();
                $data = $this->userPackage->getDataReport($from_date,$to_date);
                $newUser = $this->user->getNewUser($from_date,$to_date);
                $dataPackage = $this->getDataPackage($from_date,$to_date);
                break;
            default :
                $from_date = $request->from_date ? $request->from_date : $this->helper->get_date_now() ;
                $to_date = $request->to_date ? $request->to_date : $this->helper->get_date_now() ;
                $data = $this->userPackage->getDataReport($from_date , $to_date);
                $newUser = $this->user->getNewUser($from_date,$to_date);
                $dataPackage = $this->getDataPackage($from_date,$to_date);
                break;
        }

        $data = $this->helper->json_encode_prettify($data);
        $dataPackage = $this->helper->json_encode_prettify($dataPackage);
        $totalMem = $this->user->count();
        return view('adminlte::backend.report.member',
            compact('totalMem', 'data', 'from_date', 'to_date', 'type', 'chart','newUser','dataPackage'));
    }

    /**
     * @param $from_date
     * @param $to_date
     * @return array
     */
    function getDataPackage($from_date,$to_date){
        $packages = Package::all();
        $data = [];
        foreach ($packages as $package){
            $data[] = [$package->name , $package->users->where('packageDate','>=',$from_date)->where('packageDate','<=',$to_date)->count()];
        }
        return $data;
    }

    function createDateRangeArray($strDateFrom, $strDateTo){
        $aryRange = array();
        $iDateFrom = mktime(0, 0, 0, substr($strDateFrom, 5, 2), substr($strDateFrom, 8, 2), substr($strDateFrom, 0, 4));
        $iDateTo = mktime(0, 0, 0, substr($strDateTo, 5, 2), substr($strDateTo, 8, 2), substr($strDateTo, 0, 4));
        if($iDateTo >= $iDateFrom){
            array_push($aryRange, date('d/m/Y', $iDateFrom));
            while($iDateFrom < $iDateTo){
                $iDateFrom += 86400;
                array_push($aryRange, date('d/m/Y', $iDateFrom));
            }
        }
        return $aryRange;
    }

    function createDataChart($date_arr, $from_date, $data){
        $fromTime = mktime(0, 0, 0, substr($from_date, 5, 2), substr($from_date, 8, 2), substr($from_date, 0, 4));
        $arrData = array_fill(0, count($date_arr), 0);
        $type = 'totalPrice';
        foreach($data as $cd){
            $key = ceil((strtotime($cd['date']) - $fromTime) / 86400);
            $arrData[$key] = (int) $cd[$type];
        }
        return $arrData;
    }
}
