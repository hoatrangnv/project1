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
        'name', 'email', 'status', 'refererId', 'firstname', 'lastname', 'phone', 'is2fa', 'google2fa_secret', 'password', 'address', 'address2', 'city', 'state', 'postal_code', 'country', 'birthday', 'passport'
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
    public static function investBonus($userId = 0, $refererId = 0, $packageId = 0, $level = 1, $clpCoinAmount = 0){// Hoa hong truc tiep F1 -> F3
        $package = Package::findOrFail($packageId);
        if($package && $level == 1){
            $packageOld = Package::where('price', '<', $package->price)->orderBy('price', 'desc')->first();
            $priceA = 0;
            if($packageOld){
                $priceA = $packageOld->price;
            }
            $clpCoinAmount = ($package->price - $priceA) * \App\Package::Tygia;
            $userCoin = UserCoin::findOrFail($userId);
            $userCoin->clpCoinAmount = $userCoin->clpCoinAmount - $clpCoinAmount;
            $userCoin->save();
        }
        if($refererId > 0){
            $packageBonus = 0;
            if($package){
                $userData = UserData::find($refererId);
                if($userData){
                    if($level == 1){//F1
                        $packageBonus = $clpCoinAmount * 0.1;
                        $userData->totalBonus = $userData->totalBonus + $packageBonus;
                        $userData->save();
                    }elseif($level == 2){//F2
                        if($userData->package->price >= 1000){
                            $packageBonus = $clpCoinAmount * 0.02;
                            $userData->totalBonus = $userData->totalBonus + $packageBonus;
                            $userData->save();
                        }
                    }elseif($level == 3){//F3
                        if($userData->package->price >= 5000){
                            $packageBonus = $clpCoinAmount * 0.01;
                            $userData->totalBonus = $userData->totalBonus + $packageBonus;
                            $userData->save();
                        }
                    }
                    $userCoin = UserCoin::find($refererId);
                    if($userCoin && $packageBonus > 0){
                        $usdAmount = ($packageBonus * 0.6);
                        $reinvestAmount = ($packageBonus * 0.4);
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
                            self::investBonusFastStart($userData->userId, $userId, $packageId, $packageBonus);
                        self::investBonus($userId, $userData->refererId, $packageId, ($level + 1), $clpCoinAmount);
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
        $package = Package::findOrFail($packageId);
        $clpCoinAmount = 0;
        if($user){
            if($package) {
                $packageOld = Package::where('price', '<', $package->price)->orderBy('price', 'desc')->first();
                $priceA = 0;
                if ($packageOld) {
                    $priceA = $packageOld->price;
                }
                $clpCoinAmount = ($package->price - $priceA) * \App\Package::Tygia;
            }
            if ($legpos == 1){
                $user->totalBonusLeft = $user->totalBonusLeft + $clpCoinAmount;
                $user->lastUserIdLeft = $userId;
                $user->leftMembers = $user->leftMembers + 1;
            }else{
                $user->totalBonusRight = $user->totalBonusRight + $clpCoinAmount;
                $user->lastUserIdRight = $userId;
                $user->rightMembers = $user->rightMembers + 1;
            }
            $user->totalMembers = $user->totalMembers + 1;
            $user->save();
            //self::bonusBinaryWeek($binaryUserId, $clpCoinAmount, $legpos);
            //self::bonusLoyaltyUser($userId, $partnerId, $legpos);
            if($partnerId != $binaryUserId) {
                User::bonusBinary($userId, $partnerId, $packageId, $user->binaryUserId, $legpos);
            }
        }
    }
    public static function bonusBinaryWeek($binaryUserId = 0, $packageToken = 0, $legpos){
        $weeked = date('W');
        $year = date('Y');
        $weekYear = $year.$weeked;
        if($weeked < 10)$weekYear = $year.'0'.$weeked;
        $week = BonusBinary::where('userId', '=', $binaryUserId)->where('weekYear', '=', $weekYear)->first();
        if($week && $week->id > 0){
            if($legpos == 1){
                $week->leftNew = $week->leftNew + $packageToken;
            }else{
                $week->rightNew = $week->rightNew + $packageToken;
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
                    $fields['leftNew'] = $packageToken;
                    $fields['rightNew'] = 0;
                }else{
                    $fields['rightNew'] = $packageToken;
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
                    $fields['leftNew'] = $packageToken;
                    $fields['rightNew'] = 0;
                }else{
                    $fields['rightNew'] = $packageToken;
                    $fields['leftNew'] = 0;
                }
                BonusBinary::create($fields);
            }
        }
    }
    public static function bonusLoyaltyUser($userId, $refererId, $legpos){
        $loyaltyBonus = array('silver' => 5000, 'gold' => 10000, 'pear' => 20000, 'emerald' => 50000, 'diamond' => 100000);
        $leftRight = $legpos == 1 ? 'left' : 'right';
        $users = User::where('refererId', '=',$userId)
            //->where('leftRight', '=',$leftRight)
            ->groupBy('packageId, leftRight')
            ->selectRaw('packageId, count(id) as num')
            ->get();
        $totalf1Left = $totalf1Right = 0;
        $isSilver = 0;

        foreach ($users as $user) {
            $package = Package::findOrFail($user->packageId);
            if($user->leftRight == 'left'){
                $totalf1Left += $package->price * $user->num;
            }else{
                $totalf1Right += $package->price * $user->num;
            }
        }
        if($totalf1Left >= 50000 && $totalf1Right >= 50000){
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
        if(LoyaltyUser::where('userId', '=',$userId)->count()){
            $loyaltyUser = LoyaltyUser::where('userId', '=',$userId)->first();
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
            $countLeft = LoyaltyUser::where('refererId', '=',$userId)->where('isPear', 1)->where('leftRight', '=', 'left')->count();
            $countRight = LoyaltyUser::where('refererId', '=',$userId)->where('isPear', 1)->where('leftRight', '=', 'right')->count();
            if($countLeft >= 2 && $countRight >= 2){
                return 1;
            }
        }elseif($type == 'diamond'){
            $countLeft = LoyaltyUser::where('refererId', '=',$userId)->where('isEmerald', 1)->where('leftRight', '=', 'left')->count();
            $countRight = LoyaltyUser::where('refererId', '=',$userId)->where('isEmerald', 1)->where('leftRight', '=', 'right')->count();
            if($countLeft >= 3 && $countRight >= 3){
                return 1;
            }
        }
        return 0;
    }
    public static function bonusDay(){
        $lstUser = User::where('active', '=', 1)->where('status', '=', 1)->get();
        foreach($lstUser as $user){
            $userData = $user->userData;
            $price = $userData->package->price;
            $bonus = $userData->package->bonus;
            $usdAmount = (($price * $bonus)*0.6);
            $reinvestAmount = (($price * $bonus)*0.4);
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
                if ($userPackage->price == 100) {
                    $bonus = $settled * 0.05;
                } elseif ($userPackage->price == 500) {
                    $bonus = $settled * 0.06;
                } elseif ($userPackage->price == 1000) {
                    $bonus = $settled * 0.07;
                } elseif ($userPackage->price == 2000) {
                    $bonus = $settled * 0.08;
                } elseif ($userPackage->price == 5000) {
                    $bonus = $settled * 0.09;
                } elseif ($userPackage->price == 10000) {
                    $bonus = $settled * 0.1;
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
                    'amount' => ($bonus*0.6),
                ];
                Wallet::create($fieldUsd);
                $fieldInvest = [
                    'walletType' => 4,//reinvest
                    'type' => 5,//bonus week
                    'inOut' => 'in',
                    'userId' => $binary->userId,
                    'amount' => ($bonus*0.4),
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

