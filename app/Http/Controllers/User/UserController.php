<?php

namespace App\Http\Controllers\User;

use App\User;
use App\UserData;
use App\UserCoin;
use App\Role;
use App\Permission;
use App\Authorizable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Google2FA;

class UserController extends Controller
{
    public function search(Request $request)
    {
        $userId = $request->get('id', 0);
        $userName = $request->get('username', '');
        if($userId > 0 || $userName != ''){
            if($userId > 0)
                $user = User::where('uid', $userId)->where('active', 1)->first();
            elseif($userName != '')
                $user = User::where('name', '=', $userName)->where('active', 1)->first();
            if($user){
                if($user->uid == 0 || $user->uid == null){
                    $user->uid = User::getUid();
                    $user->save();
                }
                return response()->json(array('id' => $user->uid, 'username'=>$user->name));
            }
        }
        return response()->json(array('err' => 'User not exit.'));
    }
}
