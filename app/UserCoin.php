<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class UserCoin extends Model
{
    use HasRoles;
    use Notifiable;
    public $timestamps = false;
    protected $primaryKey = 'userId';
    protected $fillable = [
        'userId', 'accountCoinBase', 'walletAddress', 'btcCoinAmount', 'clpCoinAmount', 'usdAmount', 'reinvestAmount'
    ];
    public function user() {
        return $this->hasOne(User::class, 'id', 'userId');
    }

    public static function  getTotalWithdrawTransferDay($userId)
    {
        //Only transfer CLP, Withdraw $10.000 per day
            $listWithdraw = Withdraw::where('userId', $userId)->where('created_at', '>', Carbon::today())->get();
            $amountWithdraw = 0;
            foreach($listWithdraw as $withdraw)
            {
                if($withdraw->amountCLP)
                    $amountWithdraw += $withdraw->amountCLP * $withdraw->at_rate;
                if($withdraw->amountBTC)
                    $amountWithdraw += $withdraw->amountBTC * $withdraw->at_rate;
            }

            //List transfer
            $listTransfer = Wallet::where('userId', $userId)
                                    ->where('inOut', 'out')
                                    ->where('walletType', 3)
                                    ->where('type', 12)
                                    ->where('created_at', '>', Carbon::today())
                                    ->get();
            $transferAmount = 0;
            foreach($listTransfer as $transfer)
            {
                $transferAmount += $transfer->amount * ExchangeRate::getCLPUSDRate();
            }

            return ($amountWithdraw + $transferAmount);
    }

    public static function  getTotalWithdrawDay($userId)
    {
        //Only transfer CLP, Withdraw $10.000 per day
        $listWithdraw = Withdraw::where('userId', $userId)->where('created_at', '>', Carbon::today())->get();
        $amountWithdraw = 0;
        foreach($listWithdraw as $withdraw)
        {
            if($withdraw->amountCLP)
                $amountWithdraw += $withdraw->amountCLP * $withdraw->at_rate;
            if($withdraw->amountBTC)
                $amountWithdraw += $withdraw->amountBTC * $withdraw->at_rate;
        }

        return $amountWithdraw;
    }

    public static function  countNumberWithdrawCLPDay($userId)
    {
        //Only transfer CLP, Withdraw $10.000 per day
        $numberWithdrawToday = Withdraw::where('userId', $userId)
                                    ->whereNotNull('amountCLP')
                                    ->where('created_at', '>', Carbon::today())->count();

        return $numberWithdrawToday;
    }
}
