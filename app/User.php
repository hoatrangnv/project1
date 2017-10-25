<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use App\Notifications\ResetPasswords;
use Auth;
use DB;

class user extends authenticatable
{
    use notifiable, hasroles;

    protected $guard_name = 'web';

    /**
     * the attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'status', 'active', 'refererid', 'firstname', 'lastname', 'phone', 'is2fa', 'google2fa_secret', 'password', 'address', 'address2', 'city', 'state', 'postal_code', 'name_country','country', 'birthday', 'passport', 'uid','approve','photo_verification','password'
    ];

    /**
     * the attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts()
    {
        return $this->hasmany(post::class);
    }
    public function userdata() {
        return $this->hasone(userdata::class, 'userid', 'id');
    }
    public function usercoin() {
        return $this->hasone(usercoin::class, 'userid', 'id');
    }
    public function usertreepermission() {
        return $this->hasone(usertreepermission::class, 'userid', 'id');
    }
    public function faststart() {
        //return $this->belongsto(bonusfaststart::class);
        return $this->hasone(bonusfaststart::class, 'userid', 'id');
    }
    public function userloyaty() {
        return $this->hasone(loyaltyuser::class, 'userid', 'id');
    }
    public function userloyatys() {
        return $this->hasmany(loyaltyuser::class, 'refererid', 'id');
    }

    public static function getuid(){
        $uid = mt_rand(1001, 999999);
        if(user::where('uid', $uid)->count()){
            $uid = self::getuid();
        }
        return $uid;
    }
    /**
    * calculate fast start bonus
    */
    public static function investbonus($userid = 0, $refererid = 0, $packageid = 0, $usdcoinamount = 0, $level = 1)
    {
        if($refererid > 0){
            $packagebonus = 0;
            $userdata = userdata::find($refererid);
            if($userdata && $level <= 3 && $userdata->packageid > 0&& self::checkmonthsbonus($refererid)){
                if($level == 1){//f1
                    $packagebonus = $usdcoinamount * config('cryptolanding.bonus_f1_pay');
                    $userdata->totalbonus = $userdata->totalbonus + $packagebonus;
                    $userdata->save();
                }elseif($level == 2){//f2
                    if(isset($userdata->package->pack_id) &&  $userdata->package->pack_id >= 3){
                        $packagebonus = $usdcoinamount * config('cryptolanding.bonus_f2_pay');
                        $userdata->totalbonus = $userdata->totalbonus + $packagebonus;
                        $userdata->save();
                    }
                }elseif($level == 3){//f3
                    if(isset($userdata->package->pack_id) &&  $userdata->package->pack_id >= 5){
                        $packagebonus = $usdcoinamount * config('cryptolanding.bonus_f3_pay');
                        $userdata->totalbonus = $userdata->totalbonus + $packagebonus;
                        $userdata->save();
                    }
                }
                $usercoin = $userdata->usercoin;
                if($usercoin && $packagebonus > 0){
                    //get info of user
                    $user = auth::user();

                    $usdamount = ($packagebonus * config('cryptolanding.usd_bonus_pay'));
                    $reinvestamount = ($packagebonus * config('cryptolanding.reinvest_bonus_pay') / exchangerate::getclpusdrate());
                    $usercoin->usdamount = ($usercoin->usdamount + $usdamount);
                    $usercoin->reinvestamount = ($usercoin->reinvestamount + $reinvestamount);
                    $usercoin->save();
                    $fieldusd = [
                        'wallettype' => wallet::usd_wallet,//usd
                        'type' => wallet::fast_start_type,//bonus f1
                        'inout' => wallet::in,
                        'userid' => $userdata->userid,
                        'amount' => $usdamount,
                        'note'   => $user->name . ' bought package'
                    ];
                    wallet::create($fieldusd);
                    $fieldinvest = [
                        'wallettype' => wallet::reinvest_wallet,//reinvest
                        'type' => wallet::fast_start_type,//bonus f1
                        'inout' => wallet::in,
                        'userid' => $userdata->userid,
                        'amount' => $reinvestamount,
                        'note'   => $user->name . ' bought package'
                    ];
                    wallet::create($fieldinvest);
                }
                if($packagebonus > 0)
                    self::investbonusfaststart($refererid, $userid, $packageid, $packagebonus, $level);
            }
            if($userdata)
                self::investbonus($userid, $userdata->refererid, $packageid, $usdcoinamount, ($level + 1));
            self::bonusbinarythisweek($refererid);
        }
    }

    /**
    *   insert log for fast start bonus
    */
    public static function investbonusfaststart($userid = 0, $partnerid = 0, $packageid = 0, $amount = 0, $level = 1)
    {
        if($userid > 0) {
            $fields = [
                'userid'     => $userid,
                'partnerid'     => $partnerid,
                'generation'     => $level,
                'packageid'     => $packageid,
                'amount'     => $amount,
            ];

            bonusfaststart::create($fields);
        }
    }

    /**
    * loop to root to re-assign lastleft, lastright user in tree and caculate binary sales for each node.
    */
    public static function bonusbinary($userid = 0, $partnerid = 0, $packageid = 0, $binaryuserid = 0, $legpos, $isupgrade = false, $continue=true)
    {
        $userroot = userdata::find($userid);
        $user = userdata::find($binaryuserid);
        $usdcoinamount = 0;

        if($user)
        {
            if($isupgrade == true)
            {
                // if $userroot already in binary tree
				$userpackage = userpackage::where('userid', $userid)
                                ->where('packageid', $packageid)
                                ->orderby('packageid', 'desc')
                                ->first();

                $usdcoinamount = isset($userpackage->amount_increase) ? $userpackage->amount_increase : 0;

                if ($legpos == 1){
                    //total sale on left
                    $user->totalbonusleft = $user->totalbonusleft + $usdcoinamount;
                }else{
                    //total sale on right
                    $user->totalbonusright = $user->totalbonusright + $usdcoinamount;
                }
            }
            elseif($userroot->totalmembers == 0)
            {
                // if $userroot don't have own tree
                $userpackage = package::where('pack_id', $packageid)->first();
                $usdcoinamount = isset($userpackage->price) ? $userpackage->price : 0;

                if ($legpos == 1){
                    //total sale on left
                    $user->totalbonusleft = $user->totalbonusleft + $usdcoinamount;
                    //$user->lastuseridleft = $userroot ? $userroot->lastuseridleft : $userid;
                    //$userroot always have lastuseridleft, lastuseridright > 0 ( = userid or #userid )
					if($continue)
						$user->lastuseridleft = $userroot->lastuseridleft;
                    $user->leftmembers = $user->leftmembers + 1;

                }else{
                    //total sale on right
                    $user->totalbonusright = $user->totalbonusright + $usdcoinamount;
                    //$user->lastuseridright = $userroot ? $userroot->lastuseridright : $userid;
                    if($continue)
						$user->lastuseridright = $userroot->lastuseridright;
                    $user->rightmembers = $user->rightmembers + 1;
                }

                $user->totalmembers = $user->totalmembers + 1;

            }
            else
            {
                // if $userroot  have own tree
                $userpackage = package::where('pack_id', $packageid)->first();
                $packageamount = isset($userpackage->price) ? $userpackage->price : 0;

                $usdcoinamount = $userroot->totalbonusleft + $userroot->totalbonusright + $packageamount;

                if ($legpos == 1){
                    //total sale on left
                    $user->totalbonusleft = $user->totalbonusleft + $usdcoinamount;
                    //$user->lastuseridleft = $userroot ? $userroot->lastuseridleft : $userid;
                    //$userroot always have lastuseridleft, lastuseridright > 0 ( = userid or #userid )
                    $user->lastuseridleft = $userroot->lastuseridleft;
                    $user->leftmembers = $user->leftmembers + $userroot->totalmembers + 1;
                }else{
                    //total sale on right
                    $user->totalbonusright = $user->totalbonusright + $usdcoinamount;
                    //$user->lastuseridright = $userroot ? $userroot->lastuseridright : $userid;
                    $user->lastuseridright = $userroot->lastuseridright;
                    $user->rightmembers = $user->rightmembers + $userroot->totalmembers + 1;
                }

                $user->totalmembers = $user->totalmembers +  $userroot->totalmembers + 1;
            }

            $user->save();



            //caculate binary bonus for up level of $userroot in binary tree
			// $binaryuserid = $user->userid
            self::bonusbinaryweek($binaryuserid, $usdcoinamount, $legpos);

			$nextlegpos = isset($user->leftright) ? $user->leftright : -1;

			if($nextlegpos == $userroot->leftright && $continue == true) $continue = true;
			else $continue = false;

			//convert left, right to 1,2
			$nextlegpos = ($nextlegpos == 'left') ? 1 : 2;

			//caculate loyalty bonus for up level of $userroot in binary tree
			// $user->userid = $binaryuserid
            if($user->packageid > 0) self::bonusloyaltyuser($user->userid, $user->refererid, $nextlegpos);

            if($user->binaryuserid > 0 && $user->packageid > 0) {
                user::bonusbinary($userid, $partnerid, $packageid, $user->binaryuserid, $nextlegpos, $isupgrade, $continue);
            }
        }
    }

    public static function bonusbinaryweek($binaryuserid = 0, $usdcoinamount = 0, $legpos)
    {
        if(self::checkmonthsbonus($binaryuserid)){
            $weeked = date('w');
            $year = date('y');
            $weekyear = $year . $weeked;

            if($weeked < 10)
                $weekyear = $year . '0' . $weeked;

            $week = bonusbinary::where('userid', '=', $binaryuserid)->where('weekyear', '=', $weekyear)->first();
            if($week && $week->id > 0){ //if already have record just update amount increase
                if($legpos == 1){
                    $week->leftnew = $week->leftnew + $usdcoinamount;
                }else{
                    $week->rightnew = $week->rightnew + $usdcoinamount;
                }
                $week->save();
            }else{
                $fields = [
                    'userid' => $binaryuserid,
                    'weeked' => $weeked,
                    'year' => $year,
                    'weekyear' => $weekyear,
                ];

                $fields['leftopen'] = 0;
                $fields['rightopen'] = 0;

                if($legpos == 1){
                    $fields['leftnew'] = $usdcoinamount;
                    $fields['rightnew'] = 0;
                }else{
                    $fields['rightnew'] = $usdcoinamount;
                    $fields['leftnew'] = 0;
                }

                bonusbinary::create($fields);
            }

            //caculate temporary binary bonus this week right after have a new user in tree
            self::bonusbinarythisweek($binaryuserid);
        }
    }

    /**
    *   caculate temporary binary bonus this week right after have a new user in tree
    */
    public static function bonusbinarythisweek($userid){
        $weeked = date('w');
        $year = date('y');
        $weekyear = $year.$weeked;

        if($weeked < 10) $weekyear = $year.'0'.$weeked;

        $binary = bonusbinary::where('weekyear', '=', $weekyear)->where('userid', '=', $userid)->first();
        //foreach ($lstbinary as $binary) {
        if($binary){
            $leftover = $binary->leftopen + $binary->leftnew;
            $rightover = $binary->rightopen + $binary->rightnew;

            if ($leftover >= $rightover) {
                $settled = $rightover;
            } else {
                $settled = $leftover;
            }

            $bonus = 0;
            $userpackage = $binary->userdata->package;

            if (self::checkbinarycount($binary->userid, 1)) {
                if ($userpackage->pack_id == 1) {
                    $bonus = $settled * config('cryptolanding.binary_bonus_1_pay');
                } elseif ($userpackage->pack_id == 2) {
                    $bonus = $settled * config('cryptolanding.binary_bonus_2_pay');
                } elseif ($userpackage->pack_id == 3) {
                    $bonus = $settled * config('cryptolanding.binary_bonus_3_pay');
                } elseif ($userpackage->pack_id == 4) {
                    $bonus = $settled * config('cryptolanding.binary_bonus_4_pay');
                } elseif ($userpackage->pack_id == 5) {
                    $bonus = $settled * config('cryptolanding.binary_bonus_5_pay');
                } elseif ($userpackage->pack_id == 6) {
                    $bonus = $settled * config('cryptolanding.binary_bonus_6_pay');
                }
            }

            if($bonus > config('cryptolanding.bonus_maxout')) $bonus = config('cryptolanding.bonus_maxout');
            $binary->settled = $settled;
            $binary->bonus_tmp = $bonus;
            $binary->save();
        }

        //}
    }

    /**
    *   check condition this this user to know he can get binary bonus and how much bonus or not get anything
    */
    public static function checkbinarycount($userid, $packageid){
        $countleft = userdata::where('refererid', '=', $userid)->where('packageid', '>', $packageid)->where('leftright',  'left')->count();
        $countright = userdata::where('refererid', '=', $userid)->where('packageid', '>', $packageid)->where('leftright',  'right')->count();
        if($countleft >= 3 && $countright >= 3){
            return true;
        }
        return false;
    }

    /**
    *   calculate loyalty bonus
    */
    public static function bonusloyaltyuser($userid, $refererid, $legpos){
        $leftright = $legpos == 1 ? 'left' : 'right';
        $users = userdata::where('refererid', '=', $userid)
			->where('isbinary', '=', 1)
            ->groupby(['packageid', 'leftright'])
            ->selectraw('packageid, leftright, count(*) as num')
            ->get();

        $totalf1left = $totalf1right = 0;
        $issilver = 0;
        $isgold = 0;
        $ispear = 0;
        $isemerald = 0;
        $isdiamond = 0;

        foreach ($users as $user) {
            if($user->packageid > 0){
                $package = package::find($user->packageid);
                if($package){
                    if($user->leftright == 'left'){
                        $totalf1left += $package->price * $user->num;
                    }else{
                        $totalf1right += $package->price * $user->num;
                    }
                }
            }
        }

        //get userdata
        $userinfo = userdata::where('userid', '=', $userid)->get()->first();
        $loyaltyuser = loyaltyuser::where('userid', '=', $userid)->first();

        if($totalf1left >= config('cryptolanding.loyalty_upgrate_silver')
            && $totalf1right >= config('cryptolanding.loyalty_upgrate_silver')
            && $userinfo->packageid > 2) {
            $issilver = 1;

        }

        $loyaltybonus = config('cryptolanding.loyalty_bonus');
        if( isset($loyaltyuser->isgold) && $loyaltyuser->isgold == 0 )
            $isgold = self::getbonusloyaltyuser($userid, 'gold',$userinfo->packageid);
        if(isset($loyaltyuser->ispear) && $loyaltyuser->ispear == 0 )
            $ispear = self::getbonusloyaltyuser($userid, 'pear', $userinfo->packageid);
        if(isset($loyaltyuser->isemerald) && $loyaltyuser->isemerald == 0 )
            $isemerald = self::getbonusloyaltyuser($userid, 'emerald', $userinfo->packageid);
        if(isset($loyaltyuser->isdiamond) && $loyaltyuser->isdiamond == 0 )
            $isdiamond = self::getbonusloyaltyuser($userid, 'diamond', $userinfo->packageid);

        $loyaltyid = 0;
        if($issilver) $loyaltyid = 1;
        if($isgold) $loyaltyid = 2;
        if($ispear) $loyaltyid = 3;
        if($isemerald) $loyaltyid = 4;
        if($isdiamond) $loyaltyid = 5;

        if($loyaltyid > 0) {
            $userinfo->loyaltyid = $loyaltyid;
            $userinfo->save();
        }


        $fields = [
            'userid'     => $userid,
            'leftright'     => $leftright,
            'issilver'     => $issilver,
            'isgold'     => $isgold,
            'ispear'     => $ispear,
            'isemerald'     => $isemerald,
            'isdiamond'     => $isdiamond,
            'refererid'     => $refererid,
        ];

        if($loyaltyuser)
        {

            $userdata = $loyaltyuser->user->userdata;
            $loyaltyuser->f1left = $totalf1left;
            $loyaltyuser->f1right = $totalf1right;

            if($loyaltyuser->issilver==0) {
                $loyaltyuser->issilver = $issilver;
                if(isset($loyaltybonus) && isset($loyaltybonus['silver']) && $loyaltyuser->issilver == 1)
                    self::bonusloyaltycal($userid, $loyaltybonus['silver'], trans('adminlte_lang::mybonus.silver'));
            }

            if($loyaltyuser->isgold == 0){
                $loyaltyuser->isgold = $isgold;
                if(isset($loyaltybonus) && isset($loyaltybonus['gold']) && $loyaltyuser->isgold == 1)
                    self::bonusloyaltycal($userid, $loyaltybonus['gold'],  trans('adminlte_lang::mybonus.gold'));
            }

            if($loyaltyuser->ispear == 0){
                $loyaltyuser->ispear = $ispear;
                if(isset($loyaltybonus) && isset($loyaltybonus['pear']) && $loyaltyuser->ispear == 1)
                    self::bonusloyaltycal($userid, $loyaltybonus['pear'],  trans('adminlte_lang::mybonus.pear'));
            }

            if($loyaltyuser->isemerald == 0){
                $loyaltyuser->isemerald = $isemerald;
                if(isset($loyaltybonus) && isset($loyaltybonus['emerald']) && $loyaltyuser->isemerald == 1)
                    self::bonusloyaltycal($userid, $loyaltybonus['emerald'],  trans('adminlte_lang::mybonus.emerald'));
            }

            if($loyaltyuser->isdiamond == 0){
                $loyaltyuser->isdiamond = $isdiamond;
                if(isset($loyaltybonus) && isset($loyaltybonus['diamond']) && $loyaltyuser->isdiamond == 1)
                    self::bonusloyaltycal($userid, $loyaltybonus['diamond'],  trans('adminlte_lang::mybonus.diamond'));
            }

            $loyaltyuser->save();
        }
        else
        {
            $fields['f1left'] = $totalf1left;
            $fields['f1right'] = $totalf1right;

            loyaltyuser::create($fields);
        }
    }

    /**
    * return amount loyalty bonus to usd wallet, reinvest wallet
    */
    public static function bonusloyaltycal($userid, $amount, $type){
        if(self::checkmonthsbonus($userid)){
            $usdamount = $amount * config('cryptolanding.usd_bonus_pay');
            $reinvestamount = $amount * config('cryptolanding.reinvest_bonus_pay') / exchangerate::getclpusdrate();

            $usercoin = usercoin::where('userid', $userid)->get()->first();
            $usercoin->usdamount = ($usercoin->usdamount + $usdamount);
            $usercoin->reinvestamount = ($usercoin->reinvestamount + $reinvestamount);
            $usercoin->save();

            $fieldusd = [
                'wallettype' => wallet::usd_wallet,
                //usd
                'type' => wallet::ltoyalty_type,
                //bonus f1
                'inout' => wallet::in,
                'userid' => $userid,
                'amount' => $usdamount,
                'note' => $type,
            ];

            wallet::create($fieldusd);

            $fieldinvest = [
                'wallettype' => wallet::reinvest_wallet,
                //reinvest
                'type' => wallet::ltoyalty_type,
                //bonus f1
                'inout' => wallet::in,
                'userid' => $userid,
                'amount' => $reinvestamount,
                'note' => $type,
            ];

            wallet::create($fieldinvest);
        }
    }

    /**
    *  check and get loyalty type
    */
    public static function getbonusloyaltyuser($userid, $type, $packageid)
    {
        if($type == 'gold')
        {
            $countleft = loyaltyuser::where('refererid', '=', $userid)
                            ->where('issilver', 1)
                            ->where('leftright', '=', 'left')
                            ->count();

            $countright = loyaltyuser::where('refererid', '=', $userid)
                            ->where('issilver', 1)
                            ->where('leftright', '=', 'right')
                            ->count();

            if($countleft >= 1 && $countright >= 1 && $packageid > 4){
                return 1;
            }
        }
        elseif($type == 'pear')
        {
            $countleft = loyaltyuser::where('refererid', '=', $userid)
                            ->where('isgold', 1)
                            ->where('leftright', '=', 'left')
                            ->count();

            $countright = loyaltyuser::where('refererid', '=', $userid)
                            ->where('isgold', 1)
                            ->where('leftright', '=', 'right')
                            ->count();

            if($countleft >= 1 && $countright >= 1 && $packageid > 5){
                return 1;
            }
        }
        elseif($type == 'emerald')
        {
            $countleft = loyaltyuser::where('refererid', '=', $userid)
                            ->where('ispear', 1)
                            ->where('leftright', '=', 'left')
                            ->count();

            $countright = loyaltyuser::where('refererid', '=', $userid)
                            ->where('ispear', 1)
                            ->where('leftright', '=', 'right')
                            ->count();

            if($countleft >= 2 && $countright >= 2 && $packageid > 5){
                return 1;
            }
        }
        elseif($type == 'diamond')
        {
            $countleft = loyaltyuser::where('refererid', '=', $userid)
                            ->where('isemerald', 1)
                            ->where('leftright', '=', 'left')
                            ->count();

            $countright = loyaltyuser::where('refererid', '=', $userid)
                            ->where('isemerald', 1)
                            ->where('leftright', '=', 'right')
                            ->count();

            if($countleft >= 3 && $countright >= 3 && $packageid > 5){
                return 1;
            }
        }

        return 0;
    }


    private function checkmonthsbonus($userid){
        $lastpackage = userpackage::where('userid', $userid)->orderbydesc('packageid')->first();
        $isbonus = false;
        if($lastpackage){
            if($lastpackage->withdraw == 1){
                $release_date = strtotime(date("y-m-d", strtotime($lastpackage->release_date)));
                $release_date_12 = strtotime(date("y-m-d", strtotime($lastpackage->release_date) . " + 6 months"));
                $withdraw_date = strtotime(date("y-m-d", strtotime($lastpackage->updated_at)));
                if($release_date != $withdraw_date){
                    if($withdraw_date >= $release_date_12){
                        $isbonus = true;
                    }
                }
            }else{
                $isbonus = true;
            }
        }
        return $isbonus;
    }

    public function sendpasswordresetnotification($token)
    {
        $this->notify(new resetpasswords($token));
    }

    public static function updateusergenealogy($refererid, $userid = 0){
        if($userid == 0)$userid = $refererid;
        $user = usertreepermission::find($refererid);
        if($user){
            $user->genealogy = $user->genealogy .','.$userid;
            $user->genealogy_total = $user->genealogy_total + 1;
            $user->save();
        }else{
            usertreepermission::create(['userid'=>$refererid, 'genealogy' => $userid, 'genealogy_total' => 0]);
            $user = usertreepermission::find($userid);
        }
        if($user->userdata->refererid > 0)
            self::updateusergenealogy($user->userdata->refererid, $userid);
    }

    public static function updateuserbinary($binaryuserid, $userid = 0){
        if($userid == 0)$userid = $binaryuserid;
        $user = usertreepermission::find($binaryuserid);
        if($user){
            $user->binary = $user->binary .','.$userid;
            $user->binary_total = $user->binary_total + 1;
            $user->save();
        }else{
            usertreepermission::create(['userid'=>$binaryuserid, 'binary' => $userid, 'binary_total' => 1]);
            $user = usertreepermission::find($userid);
        }
        if($user->userdata && $user->userdata->binaryuserid > 0)
            self::updateuserbinary($user->userdata->binaryuserid, $userid);
    }

    public static function userHasRole( $user_id )
    {
       return DB::table('user_has_roles')->where('user_id', '=', $user_id)->get();
    }

}

