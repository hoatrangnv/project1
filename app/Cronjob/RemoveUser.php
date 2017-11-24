<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Cronjob;
use App\UserData;
use App\User;
use App\BonusBinary;
use App\UserTreePermission;
use DB;
/**
 * Description of RemoveUser
 *
 * @author giangdt
 */
class RemoveUser {
    
    public static function delete(){
        //Set no limit execution timeout
        set_time_limit(0);
        //Get this weekYear;
        $sevenDaysBefore = strtotime(date('Y-m-d 00:00:01') . " - 4 days");
        $sevenDaysBefore = date('Y-m-d H:i:s', $sevenDaysBefore);
        
        //Get all member that don't buy package
        $allMember = DB::table('users')
            ->join('user_datas', 'users.id', '=', 'user_datas.userId')
            ->where('user_datas.status', '=', 0)
            ->where('users.created_at', '<', $sevenDaysBefore)
            ->select('users.id', 'user_datas.refererId')
            ->get();

        //Foreach each
        foreach($allMember as $member) {
            //Delete UserData
            DB::table('user_datas')->where('userId', '=', $member->id)->delete();

            //Delete Usercoin
            DB::table('user_coins')->where('userId', '=', $member->id)->delete();

            //Delete Usertreepermsion
            DB::table('user_tree_permissions')->where('userId', '=', $member->id)->delete();

            //Delete User
            DB::table('users')->where('id', '=', $member->id)->delete();

            //Re calculate total genealogy
            self::updateUserGenealogy($member->refererId, $member->id);
        }
    }

    public static function updateUserGenealogy($refererId, $userId = 0){
        if($userId == 0) $userId = $refererId;
        $user = UserTreePermission::find($refererId);
        if($user){
            $user->genealogy_total = $user->genealogy_total - 1;
            $user->save();
        }

        if(isset($user->userData->refererId) && $user->userData->refererId > 0)
            self::updateUserGenealogy($user->userData->refererId, $userId);
    }

}
