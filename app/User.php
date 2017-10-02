<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use App\Notifications\ResetPasswords;
use Auth;
use DB;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'status', 'active', 'refererId', 'firstname', 'lastname', 'phone', 'is2fa', 'google2fa_secret', 'password', 'address', 'address2', 'city', 'state', 'postal_code', 'country', 'birthday', 'passport', 'uid'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    public function userData() {
        return $this->hasOne(UserData::class, 'userId', 'id');
    }
    public function userCoin() {
        return $this->hasOne(UserCoin::class, 'userId', 'id');
    }
    public function userTreePermission() {
        return $this->hasOne(UserTreePermission::class, 'userId', 'id');
    }
    public function fastStart() {
        //return $this->belongsTo(BonusFastStart::class);
        return $this->hasOne(BonusFastStart::class, 'userId', 'id');
    }
    public function userLoyaty() {
        return $this->hasOne(LoyaltyUser::class, 'userId', 'id');
    }
    public function userLoyatys() {
        return $this->hasMany(LoyaltyUser::class, 'refererId', 'id');
    }
    /**
     * update: giangdt 21/09
     *
     * Return rate CLP by USD ( 1 CLP = ? USD)
     */
    public static function getCLPUSDRate(){
        return 1.12;
    }

    /**
     * update: giangdt 21/09
     *
     * Return rate CLP by BTC ( 1 CLP = ? BTC)
     */
    public static function getCLPBTCRate(){
        return 0.00025;
    }
    public static function getUid(){
        $uid = mt_rand(1001, 999999);
        if(User::where('uid', $uid)->count()){
            $uid = self::getUid();
        }
        return $uid;
    }
    /**
    * Calculate fast start bonus
    */
    public static function investBonus($userId = 0, $refererId = 0, $packageId = 0, $usdCoinAmount = 0, $level = 1)
    {
        if($refererId > 0){
            $packageBonus = 0;
            $userData = UserData::find($refererId);
            if($userData && $level <= 3){
                if($level == 1){//F1
                    $packageBonus = $usdCoinAmount * config('cryptolanding.bonus_f1_pay');
                    $userData->totalBonus = $userData->totalBonus + $packageBonus;
                    $userData->save();
                }elseif($level == 2){//F2
                    if(isset($userData->package->pack_id) &&  $userData->package->pack_id >= 3){
                        $packageBonus = $usdCoinAmount * config('cryptolanding.bonus_f2_pay');
                        $userData->totalBonus = $userData->totalBonus + $packageBonus;
                        $userData->save();
                    }
                }elseif($level == 3){//F3
                    if(isset($userData->package->pack_id) &&  $userData->package->pack_id >= 5){
                        $packageBonus = $usdCoinAmount * config('cryptolanding.bonus_f3_pay');
                        $userData->totalBonus = $userData->totalBonus + $packageBonus;
                        $userData->save();
                    }
                }
                $userCoin = $userData->userCoin;
                if($userCoin && $packageBonus > 0){
                    //Get info of user
                    $user = Auth::user();

                    $usdAmount = ($packageBonus * config('cryptolanding.usd_bonus_pay'));
                    $reinvestAmount = ($packageBonus * config('cryptolanding.reinvest_bonus_pay'));
                    $userCoin->usdAmount = ($userCoin->usdAmount + $usdAmount);
                    $userCoin->reinvestAmount = ($userCoin->reinvestAmount + $reinvestAmount);
                    $userCoin->save();
                    $fieldUsd = [
                        'walletType' => Wallet::USD_WALLET,//usd
                        'type' => Wallet::FAST_START_TYPE,//bonus f1
                        'inOut' => Wallet::IN,
                        'userId' => $userData->userId,
                        'amount' => $usdAmount,
                        'note'   => $user->name . ' ' .  trans('adminlte_lang::wallet.register_package')
                    ];
                    Wallet::create($fieldUsd);
                    $fieldInvest = [
                        'walletType' => Wallet::REINVEST_WALLET,//reinvest
                        'type' => Wallet::FAST_START_TYPE,//bonus f1
                        'inOut' => Wallet::IN,
                        'userId' => $userData->userId,
                        'amount' => $reinvestAmount,
                        'note'   => $user->name . ' ' . trans('adminlte_lang::wallet.register_package')
                    ];
                    Wallet::create($fieldInvest);
                }
                if($packageBonus > 0)
                    self::investBonusFastStart($refererId, $userId, $packageId, $packageBonus, $level);
            }
            if($userData)
                self::investBonus($userId, $userData->refererId, $packageId, $usdCoinAmount, ($level + 1));
            self::bonusBinaryThisWeek($refererId);
        }
    }

    /**
    *   Insert log for Fast Start Bonus
    */
    public static function investBonusFastStart($userId = 0, $partnerId = 0, $packageId = 0, $amount = 0, $level = 1)
    {
        if($userId > 0) {
            $fields = [
                'userId'     => $userId,
                'partnerId'     => $partnerId,
                'generation'     => $level,
                'amount'     => $amount,
            ];

            BonusFastStart::create($fields);
        }
    }

    /**
    * Loop to root to re-assign lastLeft, lastRight user in tree and caculate binary sales for each node. 
    */
    public static function bonusBinary($userId = 0, $partnerId = 0, $packageId = 0, $binaryUserId = 0, $legpos, $isUpgrade = false, $continue=true)
    {
        $userRoot = UserData::find($userId);
        $user = UserData::find($binaryUserId);
        $usdCoinAmount = 0;

        if($user)
        {
            if($isUpgrade == true) 
            {
                // If $userRoot already in binary tree
				$userPackage = UserPackage::where('userId', $userId)
                                ->where('packageId', $packageId)
                                ->orderBy('packageId', 'desc')
                                ->first();

                $usdCoinAmount = isset($userPackage->amount_increase) ? $userPackage->amount_increase : 0;

                if ($legpos == 1){
                    //Total sale on left
                    $user->totalBonusLeft = $user->totalBonusLeft + $usdCoinAmount;
                }else{
                    //Total sale on right
                    $user->totalBonusRight = $user->totalBonusRight + $usdCoinAmount;
                }
            } 
            elseif($userRoot->totalMembers == 0) 
            {
                // If $userRoot don't have own tree
                $userPackage = Package::where('pack_id', $packageId)->first();
                $usdCoinAmount = isset($userPackage->price) ? $userPackage->price : 0;

                if ($legpos == 1){
                    //Total sale on left
                    $user->totalBonusLeft = $user->totalBonusLeft + $usdCoinAmount;
                    //$user->lastUserIdLeft = $userRoot ? $userRoot->lastUserIdLeft : $userId;
                    //$userRoot always have lastUserIdLeft, lastUserIdRight > 0 ( = userid or #userid )
					if($continue)
						$user->lastUserIdLeft = $userRoot->lastUserIdLeft;
                    $user->leftMembers = $user->leftMembers + 1;

                }else{
                    //Total sale on right
                    $user->totalBonusRight = $user->totalBonusRight + $usdCoinAmount;
                    //$user->lastUserIdRight = $userRoot ? $userRoot->lastUserIdRight : $userId;
                    if($continue) 
						$user->lastUserIdRight = $userRoot->lastUserIdRight;
                    $user->rightMembers = $user->rightMembers + 1;
                }

                $user->totalMembers = $user->totalMembers + 1;
                
            } 
            else 
            {
                // If $userRoot  HAVE own tree
                $userPackage = Package::where('pack_id', $packageId)->first();
                $packageAmount = isset($userPackage->price) ? $userPackage->price : 0;

                $usdCoinAmount = $userRoot->totalBonusLeft + $userRoot->totalBonusRight + $packageAmount;

                if ($legpos == 1){
                    //Total sale on left
                    $user->totalBonusLeft = $user->totalBonusLeft + $usdCoinAmount;
                    //$user->lastUserIdLeft = $userRoot ? $userRoot->lastUserIdLeft : $userId;
                    //$userRoot always have lastUserIdLeft, lastUserIdRight > 0 ( = userid or #userid )
                    $user->lastUserIdLeft = $userRoot->lastUserIdLeft;
                    $user->leftMembers = $user->leftMembers + $userRoot->totalMembers + 1;
                }else{
                    //Total sale on right
                    $user->totalBonusRight = $user->totalBonusRight + $usdCoinAmount;
                    //$user->lastUserIdRight = $userRoot ? $userRoot->lastUserIdRight : $userId;
                    $user->lastUserIdRight = $userRoot->lastUserIdRight;
                    $user->rightMembers = $user->rightMembers + $userRoot->totalMembers + 1;
                }

                $user->totalMembers = $user->totalMembers +  $userRoot->totalMembers + 1;
            }

            $user->save();

            

            //Caculate binary bonus for up level of $userRoot in binary tree
			// $binaryUserId = $user->userId
            self::bonusBinaryWeek($binaryUserId, $usdCoinAmount, $legpos);

			$nextLegpos = isset($user->leftRight) ? $user->leftRight : -1;
			
			if($nextLegpos == $userRoot->leftRight && $continue == true) $continue = true;
			else $continue = false;
			
			//convert left, right to 1,2
			$nextLegpos = ($nextLegpos == 'left') ? 1 : 2;
			
			//Caculate loyalty bonus for up level of $userRoot in binary tree
			// $user->userId = $binaryUserId
            self::bonusLoyaltyUser($user->userId, $user->refererId, $nextLegpos);
            
            if($user->binaryUserId > 0) {    
                User::bonusBinary($userId, $partnerId, $packageId, $user->binaryUserId, $nextLegpos, $isUpgrade, $continue);
            }
        }
    }

    public static function bonusBinaryWeek($binaryUserId = 0, $usdCoinAmount = 0, $legpos)
    {
        $weeked = date('W');
        $year = date('Y');
        $weekYear = $year.$weeked;

        if($weeked < 10) $weekYear = $year.'0'.$weeked;

        $week = BonusBinary::where('userId', '=', $binaryUserId)->where('weekYear', '=', $weekYear)->first();
        if($week && $week->id > 0) { //If already have record just update amount increase 
            if($legpos == 1){
                $week->leftNew = $week->leftNew + $usdCoinAmount;
            }else{
                $week->rightNew = $week->rightNew + $usdCoinAmount;
            }
            $week->save();
        } else {
            $fields = [
                'userId'     => $binaryUserId,
                'weeked'     => $weeked,
                'year'     => $year,
                'weekYear'     => $weekYear,
            ];

            $fields['leftOpen'] = 0;
            $fields['rightOpen'] = 0;

            if($legpos == 1){
                $fields['leftNew'] = $usdCoinAmount;
                $fields['rightNew'] = 0;
            }else{
                $fields['rightNew'] = $usdCoinAmount;
                $fields['leftNew'] = 0;
            }

            BonusBinary::create($fields);
        }

        //Caculate temporary binary bonus this week right after have a new user in tree
        self::bonusBinaryThisWeek($binaryUserId);
    }

    /**
    *   Caculate temporary binary bonus this week right after have a new user in tree
    */
    public static function bonusBinaryThisWeek($userId){
        $weeked = date('W');
        $year = date('Y');
        $weekYear = $year.$weeked;

        if($weeked < 10) $weekYear = $year.'0'.$weeked;

        $binary = BonusBinary::where('weekYear', '=', $weekYear)->where('userId', '=', $userId)->first();
        //foreach ($lstBinary as $binary) {
        if($binary){
            $leftOver = $binary->leftOpen + $binary->leftNew;
            $rightOver = $binary->rightOpen + $binary->rightNew;

            if ($leftOver >= $rightOver) {
                $settled = $rightOver;
            } else {
                $settled = $leftOver;
            }

            $bonus = 0;
            $userPackage = $binary->userData->package;

            if (self::checkBinaryCount($binary->userId, 1)) {
                if ($userPackage->pack_id == 1) {
                    $bonus = $settled * config('cryptolanding.binary_bonus_1_pay');
                } elseif ($userPackage->pack_id == 2) {
                    $bonus = $settled * config('cryptolanding.binary_bonus_2_pay');
                } elseif ($userPackage->pack_id == 3) {
                    $bonus = $settled * config('cryptolanding.binary_bonus_3_pay');
                } elseif ($userPackage->pack_id == 4) {
                    $bonus = $settled * config('cryptolanding.binary_bonus_4_pay');
                } elseif ($userPackage->pack_id == 5) {
                    $bonus = $settled * config('cryptolanding.binary_bonus_5_pay');
                } elseif ($userPackage->pack_id == 6) {
                    $bonus = $settled * config('cryptolanding.binary_bonus_6_pay');
                }
            }

            $binary->settled = $settled;
            $binary->bonus_tmp = $bonus;
            $binary->save();
        }

        //}
    }

    /**
    * This cronjob function will run every 00:01 Monday of week to caculate and return bonus to user's wallet 
    */
    public static function bonusBinaryWeekCron(){
        /* Get previous weekYear */
        /* =======BEGIN ===== */
        $weeked = date('W');
        $year = date('Y');
        $weekYear = $year.$weeked;

        if($weeked < 10) $weekYear = $year.'0'.$weeked;

        $firstWeek = $weeked - 1;
        $firstYear = $year;
        $firstWeekYear = $firstYear.$firstWeek;

        if($firstWeek == 0){
            $firstWeek = 52;
            $firstYear = $year - 1;
            $firstWeekYear = $firstYear.$firstWeek;
        }

        if($firstWeek < 10) $firstWeekYear = $firstYear.'0'.$firstWeek;

        /* =======END ===== */

        $lstBinary = BonusBinary::where('weekYear', '=', $firstWeekYear)->get();
        foreach ($lstBinary as $binary) {
            $leftOver = $binary->leftOpen + $binary->leftNew;
            $rightOver = $binary->rightOpen + $binary->rightNew;

            if ($leftOver >= $rightOver) {
                $leftOpen = $leftOver - $rightOver;
                $rightOpen = 0;
                $settled = $rightOver;
            } else {
                $leftOpen = 0;
                $rightOpen = $rightOver - $leftOver;
                $settled = $leftOver;
            }

            $bonus = 0;
            $userPackage = $binary->userData->package;
            if (self::checkBinaryCount($binary->userId, 1)) {
                if ($userPackage->pack_id == 1) {
                    $bonus = $settled * config('cryptolanding.binary_bonus_1_pay');
                } elseif ($userPackage->pack_id == 2) {
                    $bonus = $settled * config('cryptolanding.binary_bonus_2_pay');
                } elseif ($userPackage->pack_id == 3) {
                    $bonus = $settled * config('cryptolanding.binary_bonus_3_pay');
                } elseif ($userPackage->pack_id == 4) {
                    $bonus = $settled * config('cryptolanding.binary_bonus_4_pay');
                } elseif ($userPackage->pack_id == 5) {
                    $bonus = $settled * config('cryptolanding.binary_bonus_5_pay');
                } elseif ($userPackage->pack_id == 6) {
                    $bonus = $settled * config('cryptolanding.binary_bonus_6_pay');
                }
            }

            $binary->settled = $settled;

            //Bonus canot over maxout $35,000
            if($bonus > config('cryptolanding.bonus_maxout')) $bonus = config('cryptolanding.bonus_maxout');

            $binary->bonus = $bonus;
            $binary->save();

            if($bonus > 0){
                $fieldUsd = [
                    'walletType' => Wallet::USD_WALLET,//usd
                    'type' =>  Wallet::BINARY_TYPE,//bonus week
                    'inOut' => Wallet::IN,
                    'userId' => $binary->userId,
                    'amount' => ($bonus * config('cryptolanding.usd_bonus_pay')),
                ];

                Wallet::create($fieldUsd);

                $fieldInvest = [
                    'walletType' => Wallet::REINVEST_WALLET,//reinvest
                    'type' => Wallet::BINARY_TYPE,//bonus week
                    'inOut' => Wallet::IN,
                    'userId' => $binary->userId,
                    'amount' => ($bonus * config('cryptolanding.reinvest_bonus_pay')),
                ];

                Wallet::create($fieldInvest);
            }

            //Check already have record for this week?
            
            $weeked = date('W');
            $year = date('Y');
            $weekYear = $year.$weeked;

            if($weeked < 10) $weekYear = $year.'0'.$weeked;

            $week = BonusBinary::where('userId', '=', $binary->userId)->where('weekYear', '=', $weekYear)->first();
            // Yes => update L-Open, R-Open
            if($week && $week->id > 0) {
                $week->leftOpen = $leftOpen;
                $week->rightOpen = $rightOpen;

                $week->save();
            } else {
                // No => create new
                $field = [
                    'userId' => $binary->userId,
                    'weeked' => $weeked,
                    'year' => $year,
                    'leftNew' => 0,
                    'rightNew' => 0,
                    'leftOpen' => $leftOpen,
                    'rightOpen' => $rightOpen,
                    'weekYear' => $weekYear,
                ];

                BonusBinary::create($field);
            }
        }
    }

    /**
    *   Check condition this this user to know he can get binary bonus and how much bonus or not get anything
    */
    public static function checkBinaryCount($userId, $packageId){
        $countLeft = UserData::where('refererId', '=', $userId)->where('packageId', '>', $packageId)->where('leftRight',  'left')->count();
        $countRight = UserData::where('refererId', '=', $userId)->where('packageId', '>', $packageId)->where('leftRight',  'right')->count();
        if($countLeft >= 3 && $countRight >= 3){
            return true;
        }
        return false;
    }

    /**
    *   Calculate loyalty bonus
    */
    public static function bonusLoyaltyUser($userId, $refererId, $legpos){
        $leftRight = $legpos == 1 ? 'left' : 'right';
        $users = UserData::where('refererId', '=', $userId)
			->where('isBinary', '=', 1)
            ->groupBy(['packageId', 'leftRight'])
            ->selectRaw('packageId, leftRight, count(*) as num')
            ->get();

        $totalf1Left = $totalf1Right = 0;
        $isSilver = 0;

        foreach ($users as $user) {
            if($user->packageId > 0){
                $package = Package::find($user->packageId);
                if($package){
                    if($user->leftRight == 'left'){
                        $totalf1Left += $package->price * $user->num;
                    }else{
                        $totalf1Right += $package->price * $user->num;
                    }
                }
            }
        }

        if($totalf1Left >= config('cryptolanding.loyalty_upgrate_silver') && $totalf1Right >= config('cryptolanding.loyalty_upgrate_silver')){
            $isSilver = 1;
        }

        $loyaltyBonus = config('cryptolanding.loyalty_bonus');
        $isGold = self::getBonusLoyaltyUser($userId, 'gold');
        $isPear = self::getBonusLoyaltyUser($userId, 'pear');
        $isEmerald = self::getBonusLoyaltyUser($userId, 'emerald');
        $isDiamond = self::getBonusLoyaltyUser($userId, 'diamond');

        $fields = [
            'userId'     => $userId,
            'leftRight'     => $leftRight,
            'isSilver'     => $isSilver,
            'isGold'     => $isGold,
            'isPear'     => $isPear,
            'isEmerald'     => $isEmerald,
            'isDiamond'     => $isDiamond,
            'refererId'     => $refererId,
        ];

        if(LoyaltyUser::where('userId', '=', $userId)->count())
        {
            $loyaltyUser = LoyaltyUser::where('userId', '=', $userId)->first();
            $loyaltyUser->f1Left = $totalf1Left;
            $loyaltyUser->f1Right = $totalf1Right;

            if($loyaltyUser->isSilver==0) {
                $loyaltyUser->isSilver = $isSilver;
                if(isset($loyaltyBonus) && isset($loyaltyBonus['silver']) && $loyaltyUser->isSilver == 1)
                    self::bonusLoyaltyCal($userId, $loyaltyBonus['silver'], 'silver');
            }

            if($loyaltyUser->isGold==0) {
                $loyaltyUser->isGold = $isGold;
                if(isset($loyaltyBonus) && isset($loyaltyBonus['gold']) && $loyaltyUser->isGold == 1)
                    self::bonusLoyaltyCal($userId, $loyaltyBonus['gold'], 'gold');
            }

            if($loyaltyUser->isPear==0) {
                $loyaltyUser->isPear = $isPear;
                if(isset($loyaltyBonus) && isset($loyaltyBonus['pear']) && $loyaltyUser->isPear == 1)
                    self::bonusLoyaltyCal($userId, $loyaltyBonus['pear'], 'pear');
            }

            if($loyaltyUser->isEmerald==0) {
                $loyaltyUser->isEmerald = $isEmerald;
                if(isset($loyaltyBonus) && isset($loyaltyBonus['emerald']) && $loyaltyUser->isEmerald == 1)
                    self::bonusLoyaltyCal($userId, $loyaltyBonus['emerald'], 'emerald');
            }

            if($loyaltyUser->isDiamond==0) {
                $loyaltyUser->isDiamond = $isDiamond;
                if(isset($loyaltyBonus) && isset($loyaltyBonus['diamond'])  && $loyaltyUser->isEmerald == 1)
                    self::bonusLoyaltyCal($userId, $loyaltyBonus['diamond'], 'diamond');
            }

            $loyaltyUser->save();
        }
        else
        {
            $fields['f1Left'] = $totalf1Left;
            $fields['f1Right'] = $totalf1Right;

            LoyaltyUser::create($fields);
        }
    }

    /**
    * Return amount loyalty bonus to usd wallet, reinvest wallet
    */
    public static function bonusLoyaltyCal($userId, $amount, $type){
        $fieldUsd = [
            'walletType' => Wallet::USD_WALLET,//usd
            'type' => Wallet::LTOYALTY_TYPE,//bonus f1
            'inOut' => Wallet::IN,
            'userId' => $userId,
            'amount' => $amount * config("cryptolanding.usd_bonus_pay"),
            'note' => $type,
        ];

        Wallet::create($fieldUsd);

        $fieldInvest = [
            'walletType' => Wallet::REINVEST_WALLET,//reinvest
            'type' => Wallet::LTOYALTY_TYPE,//bonus f1
            'inOut' => Wallet::IN,
            'userId' => $userId,
            'amount' => $amount * config("cryptolanding.reinvest_bonus_pay"),
            'note' => $type,
        ];
        
        Wallet::create($fieldInvest);
    }

    /**
    *  Check and Get loyalty type
    */
    public static function getBonusLoyaltyUser($userId, $type)
    {
        if($type == 'gold') 
        {
            $countLeft = LoyaltyUser::where('refererId', '=', $userId)
                            ->where('isSilver', 1)
                            ->where('leftRight', '=', 'left')
                            ->count();

            $countRight = LoyaltyUser::where('refererId', '=', $userId)
                            ->where('isSilver', 1)
                            ->where('leftRight', '=', 'right')
                            ->count();

            if($countLeft >= 1 && $countRight >= 1){
                return 1;
            }
        }
        elseif($type == 'pear')
        {
            $countLeft = LoyaltyUser::where('refererId', '=', $userId)
                            ->where('isGold', 1)
                            ->where('leftRight', '=', 'left')
                            ->count();

            $countRight = LoyaltyUser::where('refererId', '=', $userId)
                            ->where('isGold', 1)
                            ->where('leftRight', '=', 'right')
                            ->count();

            if($countLeft >= 1 && $countRight >= 1){
                return 1;
            }
        }
        elseif($type == 'emerald')
        {
            $countLeft = LoyaltyUser::where('refererId', '=', $userId)
                            ->where('isPear', 1)
                            ->where('leftRight', '=', 'left')
                            ->count();

            $countRight = LoyaltyUser::where('refererId', '=', $userId)
                            ->where('isPear', 1)
                            ->where('leftRight', '=', 'right')
                            ->count();

            if($countLeft >= 2 && $countRight >= 2){
                return 1;
            }
        }
        elseif($type == 'diamond')
        {
            $countLeft = LoyaltyUser::where('refererId', '=', $userId)
                            ->where('isEmerald', 1)
                            ->where('leftRight', '=', 'left')
                            ->count();

            $countRight = LoyaltyUser::where('refererId', '=', $userId)
                            ->where('isEmerald', 1)
                            ->where('leftRight', '=', 'right')
                            ->count();

            if($countLeft >= 3 && $countRight >= 3){
                return 1;
            }
        }

        return 0;
    }

    /**
    * This cronjob function will every days to caculate and return interest to user's wallet 
    */
    public static function bonusDayCron(){
        try {
            $lstUser = User::where('active', '=', 1)->get();
            foreach($lstUser as $user){
                $userData = $user->userData;
                //Get all pack in user_packages
                $package = UserPackage::where('userId', $user->id)
                            ->where('withdraw', '<', 1)
                            ->groupBy(['userId'])
                            ->selectRaw('sum(amount_increase) as totalValue')
                            ->get()
                            ->first();
                if($package) 
                {
                    $bonus = isset($userData->package->bonus) ? $userData->package->bonus : 0;

                    $usdAmount = $package->totalValue * $bonus;

                    $userCoin = $user->userCoin;
                    $userCoin->usdAmount = ($userCoin->usdAmount + $usdAmount);
                    $userCoin->save();

                    $fieldUsd = [
                        'walletType' => Wallet::USD_WALLET,//usd
                        'type' => Wallet::INTEREST_TYPE,//bonus day
                        'inOut' => Wallet::IN,
                        'userId' => $user->id,
                        'amount' => $usdAmount
                    ];

                    Wallet::create($fieldUsd);
                }
            }

        } catch(\Exception $e) {
            \Log::error('Running bonusDayCron has error: ' . date('Y-m-d') .$e->getMessage());
            //throw new \Exception("Running bonusDayCron has error");
        }
    }    

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswords($token));
    }

    public static function updateUserGenealogy($refererId, $userId = 0){
        if($userId == 0)$userId = $refererId;
        $user = UserTreePermission::find($refererId);
        if($user){
            $user->genealogy = $user->genealogy .','.$userId;
            $user->genealogy_total = $user->genealogy_total + 1;
            $user->save();
        }else{
            UserTreePermission::create(['userId'=>$refererId, 'genealogy' => $userId, 'genealogy_total' => 1]);
            $user = UserTreePermission::find($userId);
        }
        if($user->userData->refererId > 0)
            self::updateUserGenealogy($user->userData->refererId, $userId);
    }

    public static function updateUserBinary($binaryUserId, $userId = 0){
        if($userId == 0)$userId = $binaryUserId;
        $user = UserTreePermission::find($binaryUserId);
        if($user){
            $user->binary = $user->binary .','.$userId;
            $user->binary_total = $user->binary_total + 1;
            $user->save();
        }else{
            UserTreePermission::create(['userId'=>$binaryUserId, 'binary' => $userId, 'binary_total' => 1]);
            $user = UserTreePermission::find($userId);
        }
        if($user->userData && $user->userData->binaryUserId > 0)
            self::updateUserBinary($user->userData->binaryUserId, $userId);
    }

}

