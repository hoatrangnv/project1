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
/**
 * Description of AutoAddBinary
 *
 * @author giangdt
 */
class AutoAddBinary {
    
    public static function addBinary(){
        //Set no limit execution timeout
        set_time_limit(0);
        //Get this weekYear;
        $weeked = date('W');
        $year = date('Y');
        $weekYear = $year.$weeked;

        if($weeked < 10) $weekYear = $year.'0'.$weeked;
        
        //Get all member which has isBinary > 0 orderby id
        $allMember = UserData::where('isBinary', 1)->where('packageId', '>', 0)->orderby('userId')->get();

        //Foreach each
        foreach($allMember as $member) {
            //Check each member, get all F1 not yet add to binary
            $allF1NotYetBinary = UserData::where('isBinary', 0)->where('status', 1)->where('refererId', $member->userId)->get();

            if($allF1NotYetBinary) 
            {
                //Get left or right is weak
                $thisWeek = BonusBinary::where('userId', '=', $member->userId)->where('weekYear', '=', $weekYear)->first();
                if(!$thisWeek) {
                    continue;
                }
                $leftOver = $thisWeek->leftOpen + $thisWeek->leftNew;
                $rightOver = $thisWeek->rightOpen + $thisWeek->rightNew;

                $leftWeak = 0;
                if ($leftOver >= $rightOver) {
                    $leftWeak = 0;
                } else {
                    $leftWeak = 1;
                }

                foreach($allF1NotYetBinary as $f1Member)
                {
                    if($leftWeak) {//Add to left
                        self::pushToTree($member->userId, $f1Member->userId, 1);
                    } else {//Add to right
                        self::pushToTree($member->userId, $f1Member->userId, 2);
                    }
                }
            }
        }
    }

    public static function pushToTree($userId, $f1UserId, $legPos) 
    {
        $user = User::find($userId);
        if($legPos)
        {
            //Get user that is added to tree
            $userData = UserData::find($f1UserId);
            if($userData && $userData->refererId == $userId && $userData->isBinary !== 1) {
                $userData->isBinary = 1;
                if($userData->lastUserIdLeft == 0) $userData->lastUserIdLeft = $userData->userId;
                if($userData->lastUserIdRight == 0) $userData->lastUserIdRight = $userData->userId;

                $userData->leftRight = $legPos == 1 ? 'left' : 'right';
                $lastUserIdLeft = $lastUserIdRight = $userId;

                if($user->userData 
                    && $user->userData->lastUserIdLeft 
                    && $user->userData->lastUserIdLeft > 0) {
                        $lastUserIdLeft = $user->userData->lastUserIdLeft;
                }

                if($user->userData 
                    && $user->userData->lastUserIdRight 
                    && $user->userData->lastUserIdRight > 0) {
                        $lastUserIdRight = $user->userData->lastUserIdRight;
                }

                if($legPos == 1){
                    $userData->binaryUserId = $lastUserIdLeft;
                }else{
                    $userData->binaryUserId = $lastUserIdRight;
                }

                $userData->save();

                //Calculate binary bonus
                $isUpgrade = false;
                User::bonusBinary(
                                $userData->userId, 
                                $userData->refererId, 
                                $userData->packageId, 
                                $userData->binaryUserId, 
                                $legPos,
                                $isUpgrade
                            );

                //Calculate loyalty
                User::bonusLoyaltyUser($userData->userId, $userData->refererId, $legPos);
                User::updateUserBinary($userData->userId);
            }
        }
    }
}
