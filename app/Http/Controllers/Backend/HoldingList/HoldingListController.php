<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 1/4/2018
 * Time: 5:11 PM
 */

namespace App\Http\Controllers\Backend\HoldingList;

use App\Authorizable;
use App\UserTreePermission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Wallet;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class HoldingListController extends Controller
{
//    use Authorizable;

    public function __construct()
    {
        $this->middleware('auth');
        $this->holding_user = config('holding_user.holding_user');
        $this->list = array_map('intval', explode(',', config('holding_user.holding_user_list')));
//        $this->enable_date = config('holding_user.holding_user_enable_date');
//        $this->disable_date = config('holding_user.holding_user_disable_date');
//        $this->country = array_map('intval', explode(',', config('holding_user.holding_user_country')));
    }

    public function index(){
        return view('adminlte::backend.holdinglist.index', compact('result'));
    }

    public function getData (Request $request){
        DB::enableQueryLog();
        $requestData = $_REQUEST;

        $columns = array(
            0 => 'name',
            1 => 'sum',
            2 => 'created_at',
        );

        //get tệp người dùng
        $userlist = UserTreePermission::select('genealogy')->whereIn('userId',$this->list)->get();
        $user = array();

        foreach ($userlist as $value){
            $user = array_merge($user,array_map('intval',explode(',',$value->genealogy)));
        }
        $users = array_unique ($user);

//        $enableDate = Carbon::createFromFormat('d-m-Y',$this->enable_date)->setTime(00,00,00,00);
//        $disableDate = Carbon::createFromFormat('d-m-Y',$this->disable_date)->setTime(00,00,00,00);

        $sql = Wallet::selectRaw('userId,sum(amount) as sum')
            ->whereIn('userId',$users);

        $totalData = count($sql->groupBy('userId')->get());

        $totalFiltered = $totalData;
        /*-----------------------*/

        if( !empty($requestData['columns'][0]['search']['value']) ){  //name
            $data = $sql->whereHas('user',function ($query) use ($requestData){
                $query->where('name','like','%' .$requestData['columns'][0]['search']['value'] . '%');
            });
        }

        if( !empty($requestData['columns'][2]['search']['value']) ){ //date
            $string = str_replace(' ', '', $requestData['columns'][2]['search']['value']);
            $string = explode('-',$string);
            $startDate = Carbon::createFromFormat('d/m/Y',$string[0])->setTime(00,00,00,00);
            $toDate = Carbon::createFromFormat('d/m/Y',$string[1])->setTime(00,00,00,00);
            $sql = $sql->where('created_at','>=',$startDate)
                ->where('created_at','<',$toDate);
        }

        //Đếm số bản ghi ở đây
        $totalFiltered = $sql->groupBy('userId');
        $totalFiltered = count($totalFiltered->get());

        $data = $sql
            ->skip($requestData['start'])
            ->take($requestData['length'])
            ->orderBy($columns[$requestData['order'][0]['column']],$requestData['order'][0]['dir'])
            ->get();

        $tmp = array();

        foreach ($data as $value) {
            $nestedData=array();
            $nestedData[] = $value->user->name;
            $nestedData[] = $value->sum;
            if (!empty($requestData['columns'][2]['search']['value'])){
                $nestedData[] = $startDate->format('d-m-Y').'---'.$toDate->format('d-m-Y');
            }
            $nestedData[] = '';
            $tmp[] = $nestedData;
        }

        $json_data = array(
            "draw"            => intval( $requestData['draw'] ),
            "recordsTotal"    => intval( $totalData ),
            "recordsFiltered" => intval( $totalFiltered ),
            "data"            => $tmp
        );

        echo json_encode($json_data);
    }
}