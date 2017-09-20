<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use App\Notifications\ResetPasswords;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'status', 'active', 'refererId', 'firstname', 'lastname', 'phone', 'is2fa', 'google2fa_secret', 'password', 'address', 'address2', 'city', 'state', 'postal_code', 'country', 'birthday', 'passport'
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
    public function userLoyatys() {
        return $this->hasMany(LoyaltyUser::class, 'refererId', 'id');
    }
    public static function getCLPUSDRate(){
        return 1;
    }
    public static function getCLPBTCRate(){
        return 1;
    }
    public static function investBonus($userId = 0, $refererId = 0, $packageId = 0, $usdCoinAmount = 0, $level = 1){// Hoa hong truc tiep F1 -> F3
        if($refererId > 0){
            $packageBonus = 0;
            $package = Package::findOrFail($packageId);
            if($package){
                $userData = UserData::find($refererId);
                if($userData){
                    if($level == 1){//F1
                        $packageBonus = $usdCoinAmount * config('cryptolanding.bonus_f1_pay');
                        $userData->totalBonus = $userData->totalBonus + $packageBonus;
                        $userData->save();
                    }elseif($level == 2){//F2
                        if($userData->package->pack_id >= 3){
                            $packageBonus = $usdCoinAmount * config('cryptolanding.bonus_f2_pay');
                            $userData->totalBonus = $userData->totalBonus + $packageBonus;
                            $userData->save();
                        }
                    }elseif($level == 3){//F3
                        if($userData->package->pack_id >= 5){
                            $packageBonus = $usdCoinAmount * config('cryptolanding.bonus_f3_pay');
                            $userData->totalBonus = $userData->totalBonus + $packageBonus;
                            $userData->save();
                        }
                    }
                    $userCoin = $userData->userCoin;
                    if($userCoin && $packageBonus > 0){
                        $usdAmount = ($packageBonus * config('cryptolanding.usd_bonus_pay'));
                        $reinvestAmount = ($packageBonus * config('cryptolanding.reinvest_bonus_pay'));
                        $userCoin->usdAmount = ($userCoin->usdAmount + $usdAmount);
                        $userCoin->reinvestAmount = ($userCoin->reinvestAmount + $reinvestAmount);
                        $userCoin->save();
                        $fieldUsd = [
                            'walletType' => 1,//usd
                            'type' => 4,//bonus f1
                            'inOut' => 'in',
                            'userId' => $userData->userId,
                            'amount' => $usdAmount,
                        ];
                        Wallet::create($fieldUsd);
                        $fieldInvest = [
                            'walletType' => 4,//reinvest
                            'type' => 4,//bonus f1
                            'inOut' => 'in',
                            'userId' => $userData->userId,
                            'amount' => $reinvestAmount,
                        ];
                        Wallet::create($fieldInvest);
                    }
                    if($level < 3){
                        if($packageBonus > 0)
                            self::investBonusFastStart($refererId, $userId, $packageId, $packageBonus);
                        self::investBonus($userId, $userData->refererId, $packageId, $usdCoinAmount, ($level + 1));
                    }
                }
            }
        }
    }
    public static function investBonusFastStart($userId = 0, $partnerId = 0, $packageId = 0, $amount = 0){// Hoa hong truc tiep F1 -> F3 log
        if($userId > 0){
            $fields = [
                'userId'     => $userId,
                'partnerId'     => $partnerId,
                'generation'     => $packageId,
                'amount'     => $amount,
            ];
            BonusFastStart::create($fields);
        }
    }
    public static function bonusBinary($userId = 0, $partnerId = 0, $packageId = 0, $binaryUserId = 0, $legpos){
        $user = UserData::findOrFail($binaryUserId);
        $usdCoinAmount = 0;
        if($user){
            $userPackage = UserPackage::where('userId', $userId)->where('packageId', $packageId)->first();
            if($userPackage){
                $usdCoinAmount = $userPackage->amount_increase;
            }
            if ($legpos == 1){
                $user->totalBonusLeft = $user->totalBonusLeft + $usdCoinAmount;
                $user->lastUserIdLeft = $userId;
                $user->leftMembers = $user->leftMembers + 1;
            }else{
                $user->totalBonusRight = $user->totalBonusRight + $usdCoinAmount;
                $user->lastUserIdRight = $userId;
                $user->rightMembers = $user->rightMembers + 1;
            }
            $user->totalMembers = $user->totalMembers + 1;
            $user->save();
            self::bonusBinaryWeek($binaryUserId, $usdCoinAmount, $legpos);
            self::bonusLoyaltyUser($userId, $partnerId, $legpos);
            //if($user->binaryUserId > 0 && $partnerId != $binaryUserId) {
            if($user->binaryUserId > 0 || $user->refererId > 0) {
                User::bonusBinary($userId, $partnerId, $packageId, $user->binaryUserId, $legpos);
            }
        }
    }
    public static function bonusBinaryWeek($binaryUserId = 0, $usdCoinAmount = 0, $legpos){
        $weeked = date('W');
        $year = date('Y');
        $weekYear = $year.$weeked;
        if($weeked < 10)$weekYear = $year.'0'.$weeked;
        $week = BonusBinary::where('userId', '=', $binaryUserId)->where('weekYear', '=', $weekYear)->first();
        if($week && $week->id > 0){
            if($legpos == 1){
                $week->leftNew = $week->leftNew + $usdCoinAmount;
            }else{
                $week->rightNew = $week->rightNew + $usdCoinAmount;
            }
            $week->save();
        }else{
            $firstWeek = $weeked - 1;
            $firstYear = $year;
            $firstWeekYear = $firstYear.$firstWeek;
            if($firstWeek == 0){
                $firstWeek = 52;
                $firstYear = $year - 1;
                $firstWeekYear = $firstYear.$firstWeek;
            }
            if($firstWeek < 10)$firstWeekYear = $firstYear.'0'.$firstWeek;
            $week = BonusBinary::where('userId', '=', $binaryUserId)->where('weekYear', '=', $firstWeekYear)->first();
            if($week){
                $fields = [
                    'userId'     => $binaryUserId,
                    'weeked'     => $weeked,
                    'year'     => $year,
                    'weekYear'     => $weekYear,
                ];
                if($week->leftNew > $week->rightNew){
                    $week['leftOpen'] = $week->leftNew - $week->rightNew;
                    $week['rightOpen'] = 0;
                }else{
                    $week['rightOpen'] = $week->rightNew - $week->leftNew;
                    $week['leftOpen'] = 0;
                }
                if($legpos == 1){
                    $fields['leftNew'] = $usdCoinAmount;
                    $fields['rightNew'] = 0;
                }else{
                    $fields['rightNew'] = $usdCoinAmount;
                    $fields['leftNew'] = 0;
                }
                BonusBinary::create($fields);
            }else{
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
        }
    }
    public static function bonusLoyaltyUser($userId, $refererId, $legpos){
        $loyaltyBonus = array('silver' => 5000, 'gold' => 10000, 'pear' => 20000, 'emerald' => 50000, 'diamond' => 100000);
        $leftRight = $legpos == 1 ? 'left' : 'right';
        $users = UserData::where('refererId', '=',$userId)
            ->groupBy(['packageId', 'leftRight'])
            ->selectRaw('packageId, count(*) as num')
            ->get();
        $totalf1Left = $totalf1Right = 0;
        $isSilver = 0;
        foreach ($users as $user) {
            if($user->packageId > 0){
                $package = Package::findOrFail($user->packageId);
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
        if(LoyaltyUser::where('userId', '=', $userId)->count()){
            $loyaltyUser = LoyaltyUser::where('userId', '=', $userId)->first();
            $loyaltyUser->f1Left = $totalf1Left;
            $loyaltyUser->f1Right = $totalf1Right;
            if($loyaltyUser->isSilver==0)
                $loyaltyUser->isSilver = $isSilver;
            if($loyaltyUser->isGold==0)
                $loyaltyUser->isGold = $isGold;
            if($loyaltyUser->isPear==0)
                $loyaltyUser->isPear = $isPear;
            if($loyaltyUser->isEmerald==0)
                $loyaltyUser->isEmerald = $isEmerald;
            if($loyaltyUser->isDiamond==0)
                $loyaltyUser->isDiamond = $isDiamond;
            $loyaltyUser->save();
        }else{
            $fields['f1Left'] = $totalf1Left;
            $fields['f1Right'] = $totalf1Right;

            LoyaltyUser::create($fields);
        }
    }
    public static function getBonusLoyaltyUser($userId, $type){
        if($type == 'gold') {
            $countLeft = LoyaltyUser::where('refererId', '=', $userId)->where('isSilver', 1)->where('leftRight', '=', 'left')->count();
            $countRight = LoyaltyUser::where('refererId', '=', $userId)->where('isSilver', 1)->where('leftRight', '=', 'right')->count();
            if($countLeft >= 1 && $countRight >= 1){
                return 1;
            }
        }elseif($type == 'pear'){
            $countLeft = LoyaltyUser::where('refererId', '=', $userId)->where('isGold', 1)->where('leftRight', '=', 'left')->count();
            $countRight = LoyaltyUser::where('refererId', '=', $userId)->where('isGold', 1)->where('leftRight', '=', 'right')->count();
            if($countLeft >= 1 && $countRight >= 1){
                return 1;
            }
        }elseif($type == 'emerald'){
            $countLeft = LoyaltyUser::where('refererId', '=', $userId)->where('isPear', 1)->where('leftRight', '=', 'left')->count();
            $countRight = LoyaltyUser::where('refererId', '=', $userId)->where('isPear', 1)->where('leftRight', '=', 'right')->count();
            if($countLeft >= 2 && $countRight >= 2){
                return 1;
            }
        }elseif($type == 'diamond'){
            $countLeft = LoyaltyUser::where('refererId', '=', $userId)->where('isEmerald', 1)->where('leftRight', '=', 'left')->count();
            $countRight = LoyaltyUser::where('refererId', '=', $userId)->where('isEmerald', 1)->where('leftRight', '=', 'right')->count();
            if($countLeft >= 3 && $countRight >= 3){
                return 1;
            }
        }
        return 0;
    }
    public static function pushIntoTree(){

    }
    public static function bonusDay(){
        $lstUser = User::where('active', '=', 1)->where('status', '=', 1)->get();
        foreach($lstUser as $user){
            $userData = $user->userData;
            $price = $userData->package->price;
            $bonus = $userData->package->bonus;
            $usdAmount = (($price * $bonus) * config('cryptolanding.usd_bonus_pay'));
            $reinvestAmount = (($price * $bonus) * config('cryptolanding.reinvest_bonus_pay'));
            $userCoin = $user->userCoin;
            $userCoin->usdAmount = ($userCoin->usdAmount + $usdAmount);
            $userCoin->reinvestAmount = ($userCoin->reinvestAmount + $reinvestAmount);
            $userCoin->save();
            $fieldUsd = [
                'walletType' => 1,//usd
                'type' => 3,//bonus day
                'inOut' => 'in',
                'userId' => $user->id,
                'amount' => $usdAmount,
            ];
            Wallet::create($fieldUsd);
            $fieldInvest = [
                'walletType' => 4,//reinvest
                'type' => 3,//bonus day
                'inOut' => 'in',
                'userId' => $user->id,
                'amount' => $reinvestAmount,
            ];
            Wallet::create($fieldInvest);
        }
    }
    public static function bonusBinaryWeekCron(){
        $weeked = date('W');
        $year = date('Y');
        $weekYear = $year.$weeked;
        if($weeked < 10)$weekYear = $year.'0'.$weeked;
        $firstWeek = $weeked - 1;
        $firstYear = $year;
        $firstWeekYear = $firstYear.$firstWeek;
        if($firstWeek == 0){
            $firstWeek = 52;
            $firstYear = $year - 1;
            $firstWeekYear = $firstYear.$firstWeek;
        }
        if($firstWeek < 10)$firstWeekYear = $firstYear.'0'.$firstWeek;

        $lstBinary = BonusBinary::where('weekYear', '=', $firstWeekYear)->get();
        foreach ($lstBinary as $binary) {
            $leftOver = $binary->leftOpen + $binary->leftNew;
            $rightOver = $binary->rightOpen + $binary->rightNew;
            if ($leftOver >= $rightOver) {
                $leftOpen = 0;
                $rightOpen = $leftOver - $rightOver;
                $settled = $rightOver;
            } else {
                $leftOpen = $rightOver - $leftOver;
                $rightOpen = 0;
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
            $binary->bonus = $bonus;
            $binary->save();
            if($bonus > 0){
                $fieldUsd = [
                    'walletType' => 1,//usd
                    'type' => 5,//bonus week
                    'inOut' => 'in',
                    'userId' => $binary->userId,
                    'amount' => ($bonus * config('cryptolanding.usd_bonus_pay')),
                ];
                Wallet::create($fieldUsd);
                $fieldInvest = [
                    'walletType' => 4,//reinvest
                    'type' => 5,//bonus week
                    'inOut' => 'in',
                    'userId' => $binary->userId,
                    'amount' => ($bonus * config('cryptolanding.reinvest_bonus_pay')),
                ];
                Wallet::create($fieldInvest);
            }
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
    public function checkBinaryCount($userId, $packageId){
        $countLeft = UserData::where('refererId', '=', $userId)->where('packageId', '>', $packageId)->where('leftRight', '>', 'left')->count();
        $countRight = UserData::where('refererId', '=', $userId)->where('packageId', '>', $packageId)->where('leftRight', '>', 'right')->count();
        if($countLeft >= 3 && $countRight >= 3){
            return true;
        }
        return false;
    }
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswords($token));
    }
}

