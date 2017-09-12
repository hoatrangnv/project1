<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use App\Notifications\ResetPassword;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'status', 'refererId', 'firstname', 'lastname', 'phone', 'is2fa', 'google2fa_secret', 'password'
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
        return $this->hasOne(userData::class, 'userId', 'id');
    }
    public function userCoin() {
        return $this->hasOne(UserCoin::class, 'userId', 'id');
    }
    public static function investBonus($userId = 0, $refererId = 0, $packageId = 0, $level = 1){// Hoa hong truc tiep F1 -> F3
        if($refererId > 0){
            $packageBonus = 0;
            $package = Package::findOrFail($packageId);
            if($package){
                if($level == 1)
                    $packageBonus = $package->token * 0.1;
                elseif($level == 2)
                    $packageBonus = $package->token * 0.02;
                elseif($level == 3)
                    $packageBonus = $package->token * 0.01;

                $user = User::findOrFail($refererId);
                $user->totalBonus = $user->totalBonus + $packageBonus;
                $user->save();
                if($level < 3){
                    self::investBonusFastStart($user->refererId, $userId, $packageId, $packageBonus);
                    self::investBonus($userId, $user->refererId, $packageId, ($level + 1));
                }
            }
        }
    }
    public static function investBonusFastStart($userId = 0, $partnerId = 0, $packageId = 0, $amount = 0){// Hoa hong truc tiep F1 -> F3 log
        $fields = [
            'userId'     => $userId,
            'partnerId'     => $partnerId,
            'generation'     => $packageId,
            'amount'     => $amount,
        ];
        BonusFastStart::create($fields);
    }
    public static function bonusBinary($userId = 0, $partnerId = 0, $packageId = 0, $binaryUserId = 0, $legpos){
        $user = User::findOrFail($binaryUserId);
        $package = Package::findOrFail($packageId);
        if ($legpos == 1){
            $user->totalBonusLeft = $user->totalBonusLeft + $package->token;
            $user->lastUserIdLeft = $userId;
            $user->leftMembers = $user->leftMembers + 1;
        }else{
            $user->totalBonusRight = $user->totalBonusRight + $package->token;
            $user->lastUserIdRight = $userId;
            $user->rightMembers = $user->rightMembers + 1;
        }
        $user->totalMembers = $user->totalMembers + 1;
        $user->save();
        self::bonusBinaryWeek($binaryUserId, $package->token, $legpos);
        self::bonusLoyaltyUser($userId, $partnerId, $legpos);
        if($partnerId != $binaryUserId) {
            User::bonusBinary($userId, $partnerId, $packageId, $user->binaryUserId, $legpos);
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
                $totalf1Left += $package->token * $user->num;
            }else{
                $totalf1Right += $package->token * $user->num;
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
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }
}

