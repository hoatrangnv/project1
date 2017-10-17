<?php

namespace App\Http\Controllers\Backend;

use App\Authorizable;
use App\UserPackage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Package;

class ReportController extends Controller{

    public function index(){

        return view('adminlte::role.index', compact('roles', 'permissions'));
    }

    public function member_pack(){
        $packages = Package::all();
        return view('adminlte::backend.report.member_pack', compact('packages'));
    }

    public function member(Request $request){
        $type = $request->type ? $request->type : 1;
        if($type == 1){
            $from_date = $request->from_date ? $request->from_date : date("Y-m-d");
            $to_date = $request->to_date ? $request->to_date : date('Y-m-d');
        }elseif($type == 2){
            $from_date = $request->from_date ? $request->from_date : date("Y-m-d", strtotime(date('Y-m-d') . " - 7 days"));
            $to_date = $request->to_date ? $request->to_date : date('Y-m-d');
        }elseif($type == 3){
            $from_date = $request->from_date ? $request->from_date : date("Y-m-d", strtotime(date('Y-m-d') . " - 30 days"));
            $to_date = $request->to_date ? $request->to_date : date('Y-m-d');
        }else{
            $from_date = $request->from_date ? $request->from_date : date("Y-m-d");
            $to_date = $request->to_date ? $request->to_date : date('Y-m-d');
        }

        $data = UserPackage::selectRaw('user_packages.created_at as date, SUM(packages.price) as totalPrice')
            ->join('packages', 'packages.id', 'user_packages.packageId')
            ->whereBetween('user_packages.created_at', array(
                                $from_date,
                                $to_date
                            ))
            ->groupBy('user_packages.created_at')
            ->get()
            ->toArray();
        $chart['data'] = json_encode($data);//058DC7
        $totalMem = User::count();
        return view('adminlte::backend.report.member', compact('totalMem', 'data', 'from_date', 'to_date', 'type', 'chart'));
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
