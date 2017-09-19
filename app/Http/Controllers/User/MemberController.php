<?php

namespace App\Http\Controllers\User;

use App\UserData;
use Illuminate\Http\Request;

use App\User;
use App\BonusBinary;
use Auth;
use Session;
use App\Http\Controllers\Controller;

class MemberController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index(){
       return view('adminlte::members.genealogy');
    }
	
	public function genealogy(Request $request)
    {
		if($request->ajax()){
			if(isset($request['action'])) {
				if($request['action'] == 'getUser') {
					if(isset($request['username']) && $request['username'] != '') {
                        $currentuserid = Auth::user()->id;
                        $user = User::where('name', '=', $request['username'])->where('active', 1)->first();
                        //$userData = UserData::where('userId', '=', $user->id)->first();
                        if($user) {
                            $fields = [
                                'id'     => $user->id,
                                'u'     => $user->name,
                                'totalMembers'     => $user->userData->totalMembers,
                                'packageId'     => $user->userData->packageId,
                                'loyaltyId'     => $user->userData->loyaltyId,
                                'leg'     => $user->userData->leftRight == 'left' ? 1 : $user->userData->leftRight == 'right' ? 2 : 0,
                                'pkg'     => 2000,
                                'ws'     => self::getWeeklySale($user->id),
                                'dmc'     => 3,
                                'l'     => 'Rookie',
                            ];
                        } else {
                            return response()->json(['err'=>1]);
                        }
					} else {
                        $currentuserid = Auth::user()->id;
                        $user = User::findOrFail($currentuserid);
                       // $userData = UserData::where('userId', '=', $user->id)->first();
                        $fields = [
                            'id'     => $user->id,
                            'u'     => $user->name,
                            'totalMembers'     => $user->userData->totalMembers,
                            'packageId'     => $user->userData->packageId,
                            'loyaltyId'     => $user->userData->loyaltyId,
                            'leg'     => $user->userData->leftRight == 'left' ? 1 : $user->userData->leftRight == 'right' ? 2 : 0,
                            'pkg'     => 2000,
                            'ws'     => self::getWeeklySale($user->id),
                            'dmc'     => 3,
                            'l'     => 'Rookie',
                        ];
					}
                    return response()->json($fields);
				} elseif ($request['action'] == 'getChildren') {
                    $currentuserid = Auth::user()->id;
                    $fields = array();
                    if(isset($request['id']) && $request['id'] > 0){
                        $userDatas = UserData::where('refererId', '=', $request['id'])->get();
                        $fields = array();
                        foreach ($userDatas as $userData) {
                            if($userData->user->active == 1) {
                                $fields[] = [
                                    'id' => $userData->userId,
                                    'u' => $userData->user->name,
                                    'totalMembers' => $userData->totalMembers,
                                    'packageId' => $userData->packageId,
                                    'loyaltyId' => $userData->loyaltyId,
                                    'leg' => $userData->leftRight == 'left' ? 1 : $userData->leftRight == 'right' ? 2 : 0,
                                    'pkg' => 2000,
                                    'ws' => self::getWeeklySale($userData->userId),
                                    'dmc' => 3,
                                    'l' => 'Rookie',
                                ];
                            }
                        }
                    }
                    return response()->json($fields);
				} else {
                    return response()->json(['err'=>1]);
                }
			} else {
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
                if($user->userData->refererId == $currentuserid || $user->userData->binaryUserId == $currentuserid || $currentuserid == $user->id) {
                    $childLeft = UserData::where('binaryUserId', $user->id)->where('leftRight', 'left')->first();
                    $childRight = UserData::where('binaryUserId', $user->id)->where('leftRight', 'right')->first();
                    $weeklySale = self::getWeeklySale($user->id);
                    $fields = [
                        'lvl' => 0,
                        'id' => $user->id,
                        'name' => $user->name,
                        'parentID' => $user->userData->binaryUserId,
                        'childLeftId' => $childLeft ? $childLeft->userId : 0,
                        'childRightId' => $childRight ? $childRight->userId : 0,
                        'level' => 0,
                        'left'     => $weeklySale['left'],
                        'right'     => $weeklySale['right'],
                        'pkg' => 2000,
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
                $childLeft = UserData::where('binaryUserId', $user->id)->where('leftRight', 'left')->first();
                $childRight = UserData::where('binaryUserId', $user->id)->where('leftRight', 'right')->first();
                $weeklySale = self::getWeeklySale($user->id);
                $fields = [
                    'lvl'     => 0,
                    'id'     => $user->id,
                    'name'     => $user->name,
                    'parentID'     => null,
                    'childLeftId' => $childLeft ? $childLeft->userId : 0,
                    'childRightId' => $childRight ? $childRight->userId : 0,
                    'level'     => 0,
                    'weeklySale'     => $weeklySale['total'],
                    'left'     => $weeklySale['left'],
                    'right'     => $weeklySale['right'],
                    'pkg'     => 2000,
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
        $weeked = date('W');
        $year = date('Y');
        $weekYear = $year.$weeked;
        if($weeked < 10)$weekYear = $year.'0'.$weeked;
        $week = BonusBinary::where('userId', '=', $userId)->where('weekYear', '=', $weekYear)->first();
        $result = ['left'=>0, 'right'=>0, 'total'=>0];
        if($week){
            $result['left'] = $week->leftNew;
            $result['right'] = $week->rightNew;
            $result['total'] = $week->leftNew + $week->rightNew;
        }
        return $result;
    }
    function getBinaryChildren($userId, $level = 0){
        $currentuserid = Auth::user()->id;
        $level = $level + 1;
        $fields = array();
        if($level < 4){
            $UserDatas = UserData::where('binaryUserId', '=', $userId)->where('status', 1)->get();
            foreach ($UserDatas as $user) {
                if($user->refererId == $currentuserid || $user->binaryUserId == $currentuserid) {
                    $childLeft = UserData::where('binaryUserId', $user->user->id)->where('leftRight', 'left')->first();
                    $childRight = UserData::where('binaryUserId', $user->user->id)->where('leftRight', 'right')->first();
                    $weeklySale = self::getWeeklySale($user->user->id);
                    $field = [
                        'pos' => $user->leftRight == 'left' ? 1 : 2,
                        'lvl' => $level,
                        'id' => $user->user->id,
                        'name' => $user->user->name,
                        'parentID' => $user->binaryUserId,
                        'childLeftId' => $childLeft ? $childLeft->userId : 0,
                        'childRightId' => $childRight ? $childRight->userId : 0,
                        'level' => 0,
                        'weeklySale'     => $weeklySale['total'],
                        'left'     => $weeklySale['left'],
                        'right'     => $weeklySale['right'],
                        'pkg'     => 2000,
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
        if($request->ajax()){
            if(isset($request->userid) && $request->userid > 0 && isset($request['legpos']) && in_array($request['legpos'], array(1,2))){
                $userData = UserData::findOrFail($request->userid);
                if($userData && $userData->refererId == Auth::user()->id && $userData->isBinary !== 1){
                    $userData->isBinary = 1;
                    $userData->lastUserIdLeft = $userData->userId;
                    $userData->lastUserIdRight = $userData->userId;
                    $userData->leftRight = $request['legpos'] == 1 ? 'left' : 'right';
                    $lastUserIdLeft = $lastUserIdRight = Auth::user()->id;
                    if(Auth::user()->userData && Auth::user()->userData->lastUserIdLeft && Auth::user()->userData->lastUserIdLeft > 0){
                        $lastUserIdLeft = Auth::user()->userData->lastUserIdLeft;
                    }
                    if(Auth::user()->userData && Auth::user()->userData->lastUserIdRight && Auth::user()->userData->lastUserIdRight > 0){
                        $lastUserIdRight = Auth::user()->userData->lastUserIdRight;
                    }
                    if($request['legpos'] == 1){
                        $userData->binaryUserId = $lastUserIdLeft;
                    }else{
                        $userData->binaryUserId = $lastUserIdRight;
                    }
                    $userData->save();
                    User::bonusBinary($userData->userId, $userData->refererId, $userData->packageId, $userData->binaryUserId, $request['legpos']);

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