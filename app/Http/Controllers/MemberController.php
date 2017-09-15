<?php

namespace App\Http\Controllers;

use App\UserData;
use Illuminate\Http\Request;

use App\User;
use App\BonusBinary;
use Auth;
use Session;

class MemberController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index(){
       return view('adminlte::members.genealogy');
    }
	
	public function genealogy(Request $request){
		if($request->ajax()){
			if(isset($request['action'])){
				if($request['action'] == 'getUser'){
					if(isset($request['username']) && $request['username'] != ''){
                        $currentuserid = Auth::user()->id;
                        $user = User::where('name', '=', $request['username'])->where('status', 1)->first();
                        $userData = UserData::where('userId', '=', $user->id)->first();
                        if($userData->refererId == $currentuserid || $userData->binaryUserId == $currentuserid){
                            $fields = [
                                'id'     => $user->id,
                                'u'     => $user->name,
                                'totalMembers'     => $userData->totalMembers,
                                'packageId'     => $userData->packageId,
                                'loyaltyId'     => $userData->loyaltyId,
                                'leg'     => $userData->leftRight == 'left' ? 1 : $userData->leftRight == 'right' ? 2 : 0,
                                'pkg'     => 2000,
                                'ws'     => self::getWeeklySale($user->id),
                                'dmc'     => 3,
                                'l'     => 'Rookie',
                            ];
                        }else{
                            return response()->json(['err'=>1]);
                        }
					}else{
                        $currentuserid = Auth::user()->id;
                        $user = User::findOrFail($currentuserid);
                        $userData = UserData::where('userId', '=', $user->id)->first();
                        $fields = [
                            'id'     => $user->id,
                            'u'     => $user->name,
                            'totalMembers'     => $userData->totalMembers,
                            'packageId'     => $userData->packageId,
                            'loyaltyId'     => $userData->loyaltyId,
                            'leg'     => $userData->leftRight == 'left' ? 1 : $userData->leftRight == 'right' ? 2 : 0,
                            'pkg'     => 2000,
                            'ws'     => self::getWeeklySale($user->id),
                            'dmc'     => 3,
                            'l'     => 'Rookie',
                        ];
					}
                    return response()->json($fields);
				}elseif($request['action'] == 'getChildren'){
                    $currentuserid = Auth::user()->id;
                    $fields = array();
                    if(isset($request['id']) && $request['id'] > 0){
                        $users = UserData::where('binaryUserId', '=', $request['id'])->where('status', 1)->get();
                        $fields = array();
                        foreach ($users as $user) {
                            $userInfo = User::findOrFail($user->userId);
                            if($user->refererId == $currentuserid || $userData->binaryUserId == $currentuserid) {
                                $fields[] = [
                                    'id' => $userInfo->id,
                                    'u' => $userInfo->name,
                                    'totalMembers' => $user->totalMembers,
                                    'packageId' => $user->packageId,
                                    'loyaltyId' => $user->loyaltyId,
                                    'leg' => $user->leftRight == 'left' ? 1 : $user->leftRight == 'right' ? 2 : 0,
                                    'pkg' => 2000,
                                    'ws' => self::getWeeklySale($userInfo->id),
                                    'dmc' => 3,
                                    'l' => 'Rookie',
                                ];
                            }
                        }
                    }
                    return response()->json($fields);
				}else{
                    return response()->json(['err'=>1]);
                }
			}else{
                return response()->json(['err'=>1]);
            }
		}
        return view('adminlte::members.genealogy');
    }
	
	public function binary(Request $request){
        $currentuserid = Auth::user()->id;
		if($request->ajax()){
			if(isset($request['id']) && $request['id'] > 0){
                $user = User::findOrFail($request['id']);
                if($user->userData->refererId == $currentuserid || $user->userData->binaryUserId == $currentuserid) {
                    $fields = [
                        'lvl' => 0,
                        'id' => $user->id,
                        'name' => $user->name,
                        'parentID' => $user->userData->binaryUserId,
                        'level' => 0,
                        'weeklySale' => self::getWeeklySale($user->id),
                        'pkg' => 2000,
                        'left' => self::getWeeklySale($user->id, 'left'),
                        'right' => self::getWeeklySale($user->id, 'right'),
                        'lMembers' => $user->userData->leftMembers,
                        'rMembers' => $user->userData->rightMembers,
                    ];
                    $children = self::getBinaryChildren($user->id);
                    if ($children) {
                        $fields['children'] = $children;
                    }
                    return response()->json($fields);
                }else{
                    return response()->json(['err'=>1]);
                }
			}else{
                $user = User::findOrFail($currentuserid);
                $fields = [
                    'lvl'     => 0,
                    'id'     => $user->id,
                    'name'     => $user->name,
                    'parentID'     => null,
                    'level'     => 0,
                    'weeklySale'     => self::getWeeklySale($user->id),
                    'pkg'     => 2000,
                    'left'     => self::getWeeklySale($user->id, 'left'),
                    'right'     => self::getWeeklySale($user->id, 'right'),
                    'lMembers'     => $user->userData->leftMembers,
                    'rMembers'     => $user->userData->rightMembers,
                ];
                $children = self::getBinaryChildren($user->id);
                if($children){
                    $fields['children'] = $children;
                }
                return response()->json($fields);
			}
        }
		return view('adminlte::members.binary');
    }
    function getWeeklySale($userId, $type = 'total'){
        $weekYear = date('YW');
        $week = BonusBinary::where('userId', '=', $userId)->where('weekYear', '=', $weekYear)->first();
        if($type == 'left') {
            return $week ? $week->leftNew : 0;
        }elseif($type == 'right'){
            return $week ? $week->rightNew : 0;
        }else{
            return $week ? $week->leftNew + $week->rightNew : 0;
        }
    }
    function getBinaryChildren($userId, $level = 0){
        $currentuserid = Auth::user()->id;
        $level = $level + 1;
        $fields = array();
        if($level < 4){
            $UserDatas = UserData::where('binaryUserId', '=', $userId)->where('status', 1)->get();
            foreach ($UserDatas as $user) {
                if($user->refererId == $currentuserid || $user->binaryUserId == $currentuserid) {
                    $field = [
                        'pos' => $user->leftRight == 'left' ? 1 : 2,
                        'lvl' => $level,
                        'id' => $user->user->id,
                        'name' => $user->user->name,
                        'parentID' => $user->binaryUserId,
                        'level' => 0,
                        'weeklySale' => self::getWeeklySale($user->user->id),
                        'pkg' => 2000,
                        'left' => self::getWeeklySale($user->user->id, 'left'),
                        'right' => self::getWeeklySale($user->user->id, 'right'),
                        'lMembers' => $user->leftMembers,
                        'rMembers' => $user->rightMembers,
                    ];
                    $children = self::getBinaryChildren($user->user->id, $level);
                    if ($children) {
                        $field['children'] = $children;
                    }
                    $fields[] = $field;
                }
            }
        }
        return $fields;
    }
	
	public function refferals(){
		$currentuserid = Auth::user()->id;
        //$users = User::where('referrerId='.$currentuserid);
        $users = UserData::where('refererId', '=',$currentuserid)->where('status', 1)->orderBy('userId', 'desc')
               ->paginate();
        return view('adminlte::members.refferals')->with('users', $users);
    }
	public function pushIntoTree(Request $request){
        $currentuserid = Auth::user()->id;
        if($request->ajax()){
            if(isset($request['userid']) && $request['userid'] > 0 && isset($request['legpos']) && in_array($request['legpos'], array(1,2))){
                $user = User::findOrFail($request['userid']);
                if($user && $user->refererId == $currentuserid){
                    $userParent = User::findOrFail($currentuserid);
                    $user->isBinary = 1;
                    $user->lastUserIdLeft = $user->id;
                    $user->lastUserIdRight = $user->id;
                    $user->leftRight = $request['legpos'] == 1 ? 'left' : 'right';
                    if($request['legpos'] == 1){
                        $user->binaryUserId = $userParent->lastUserIdLeft;
                    }else{
                        $user->binaryUserId = $userParent->lastUserIdRight;
                    }
                    $user->save();
                    User::bonusBinary($user->id, $user->refererId, $user->packageId, $user->binaryUserId, $request['legpos']);

                    return response()->json(['status'=>1]);
                }
            }
        }
        return response()->json(['err'=>1]);
    }
	public function show($id)
    {
		echo $id;
        //return redirect('members/genealogy');
    }
}
