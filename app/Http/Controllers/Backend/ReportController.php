<?php

namespace App\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Backend\RepoReportController;
use Illuminate\Http\Request;

class ReportController extends Controller{

    use Authorizable;

    public function __construct(RepoReportController $repo)
    {
        $this->middleware('auth');
        $this->repo = $repo;
    }

    public function getDataReport(Request $request){
        $type = $request->type;
        $opt = $request->opt;
        $dateCustom['from_date'] = $request->from_date;
        $dateCustom['to_date'] = $request->to_date;
        $dada = $this->repo->action($type,$opt,$dateCustom);
        return view('adminlte::backend.report.member',['data'=>$dada]);
    }

}
