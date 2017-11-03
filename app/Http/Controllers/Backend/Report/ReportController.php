<?php

namespace App\Http\Controllers\Backend\Report;

use App\Authorizable;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Backend\Report\RepoReportController;
use Illuminate\Http\Request;

class ReportController extends Controller{

    use Authorizable;

    public function __construct(RepoReportController $repo)
    {
        $this->middleware('auth');
        $this->repo = $repo;
    }

    public function getDataReport(Request $request){
        if ( $request->type && $request->type && $request->from_date && $request->to_date ) {
            $type = $request->type;
            $opt = $request->opt;
            $dateCustom['from_date'] = $request->from_date;
            $dateCustom['to_date'] = $request->to_date;
        } else {
            $type = 2;
            $opt = 1;
            $dateCustom = ['from_date' => $this->repo->getDateNow(), 'to_date' => $this->repo->getDateNow()];
        }
        
        $dada = $this->repo->action($type,$opt,$dateCustom);
        return view('adminlte::backend.report.member',['data'=>$dada]);
    }

    public function getDataCommissionReport(Request $request){
        if ( $request->type && $request->type && $request->from_date && $request->to_date ) {
            $type = $request->type;
            $opt = $request->opt;
            $dateCustom['from_date'] = $request->from_date;
            $dateCustom['to_date'] = $request->to_date;
        } else {
            $type = 2;
            $opt = 1;
            $dateCustom = ['from_date' => $this->repo->getDateNow(), 'to_date' => $this->repo->getDateNow()];
        }

        $dada = $this->repo->action_commission($type,$opt,$dateCustom);
//        return view('adminlte::backend.report.commission.index',['data'=>$dada]);
        return view('adminlte::backend.report.commission.index');
    }

}
