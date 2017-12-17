<?php

namespace App\Console;

use function foo\func;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\AuthPermissionCommand;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Notifications\UpdateBtcCoin;
use App\Notifications\AvailableAmountController as AvailableAmount;
use App\Cronjob\UpdateExchangeRate;
use App\Cronjob\GetClpWallet;
use App\Cronjob\Bonus;
use App\Cronjob\AutoAddBinary;
use App\Cronjob\AutoBuyPack;
use App\Cronjob\UpdateStatusBTCWithdraw;
use App\Cronjob\UpdateStatusCLPWithdraw;
use App\Cronjob\UpdateCLPCoin;
use App\Cronjob\ClpcoinMailchimpSubscriptionV_0_1;
use Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        AuthPermissionCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //Auto add to binary at 23:30 every sunday
        $stringCronTab = "* * * * * *";
        try {
            $schedule->call(function () {
                Log::info('Auto add to binary date: ' . date('Y-m-d H:i:s'));
                AutoAddBinary::addBinary();
            })->weekly()->sundays()->at('23:30'); //->weekly()->sundays()->at('23:30');
        } catch (\Exception $ex) {
            Log::info($ex);
        }
		
        // Profit run everyday
		try {
            $schedule->call(function () {
                Log::info('Interest date: ' . date('Y-m-d'));
                Bonus::bonusDayCron();
            })->daily();
        } catch (\Exception $ex) {
            Log::info($ex);
        }

        // Matching run everyday
        try {
            $schedule->call(function () {
                Log::info('Matching date: ' . date('Y-m-d'));
                Bonus::bonusMatchingDayCron();
            })->dailyAt('00:15');
        } catch (\Exception $ex) {
            Log::info($ex);
        }

        // Binary bonus run on monday each week
        try {
            $schedule->call(function () {
                Log::info('Binary date: ' . date('Y-m-d'));
                Bonus::bonusBinaryWeekCron();
            })->weekly()->mondays()->at('00:30'); //->weekly()->mondays()->at('00:30');
        } catch (\Exception $ex) {
            Log::info($ex);
        }

        /**
         * @author Huynq 
         * run every 30s update notification
         */
        try {
            $schedule->call(function () {
                UpdateBtcCoin::UpdateBtcCoinAmount();
            })->everyMinute();
        } catch (\Exception $ex) {
            Log::info($ex);
        }
        /** 
         * @author Huynq
         * run every day update availableAmount(from holding wallet) table usercoin
         */
        try {
            $schedule->call(function () {
                AvailableAmount::getAvailableAmount();
            })->daily();
        } catch (\Exception $ex) {
            Log::info($ex);
        }
        
        // Cronjob update exchange BTC, CLP rate
        try {
            $schedule->call(function (){
                UpdateExchangeRate::updateExchangRate();
            })->everyMinute();
        } catch (\Exception $ex) {
            
        }


        // Cron job update status withdraw BTC
        try {
            $schedule->call(function () {
                UpdateStatusBTCWithdraw::updateStatusWithdraw();
            })->everyFiveMinutes();
        } catch (\Exception $ex) {
            Log::info($ex);
        }

        // Cron job update status withdraw CLP
        try {
            $schedule->call(function () {
                UpdateStatusCLPWithdraw::updateStatusWithdraw();
            })->everyFiveMinutes();
        } catch (\Exception $ex) {
            Log::info($ex);
        }

        // Cron job update get CLP
        try {
            $schedule->call(function (){
                UpdateCLPCoin::UpdateClpCoinAmount();
            })->everyMinute();
        } catch (\Exception $ex) {
            Log::info($ex);
        }

        try {
            $schedule->call(function (){
                ClpcoinMailchimpSubscriptionV_0_1::cronjobUpdate();
            })->hourly();
        } catch (\Exception $ex){
            Log::info($ex);
        }
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
