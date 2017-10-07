<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\AuthPermissionCommand;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Notifications\UpdateBtcCoin;
use App\Notifications\AvailableAmountController as AvailableAmount;
use App\Cronjob\UpdateExchangeRate;
use App\User;

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
        /**
         * @author Huynq 
         * run every 30s update notification
         */
        $stringCronTab = "* * * * * *";
        try {
            $schedule->call(function () {
                UpdateBtcCoin::UpdateBtcCoinAmount();
            })->everyMinute();
        } catch (\Exception $ex) {
            Log::info($ex);
        }
        /** 
         * @author Huynq
         * run every dây update availAmount table usercoin
         */
        $stringCronTab = "* * * * * *";
        try {
            $schedule->call(function () {
                AvailableAmount::getAvailableAmount();
            })->daily();
        } catch (\Exception $ex) {
            Log::info($ex);
        }
        
        /*try {
            $schedule->call(function (){
                UpdateExchangeRate::updateExchangRate();
            })->everyMinute();
        } catch (\Exception $ex) {
            
        }*/
		
		try {
            $schedule->call(function () {
                User::bonusDayCron();
            })->daily();
        } catch (\Exception $ex) {
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
