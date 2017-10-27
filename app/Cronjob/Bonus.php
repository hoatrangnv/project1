<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Cronjob;

use App\UserPackage;
use App\User;
use App\Wallet;
use App\BonusBinary;
use App\ExchangeRate;
use App\CronProfitLogs;
use App\CronBinaryLogs;
use DB;

/**
 * Description of UpdateStatusBTCTransaction
 *
 * @author giangdt
 */
class Bonus
{
	
	/**
	* This cronjob function will every days to caculate and return interest to user's wallet 
	*/
	public static function bonusDayCron(){
		set_time_limit(0);
		try {
			$lstUser = User::where('active', '=', 1)->get();
			foreach($lstUser as $user){
				//Get cron status
				$cronStatus = CronProfitLogs::where('userId', $user->id)->first();
				if(isset($cronStatus) && $cronStatus->status == 1) continue;

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

					//Update cron status from 0 => 1
					$cronStatus->status = 1;
					$cronStatus->save();
				}
			}

			//Update status from 1 => 0 after run all user
			DB::table('cron_profit_day_logs')->update(['status' => 0]);

		} catch(\Exception $e) {
			\Log::error('Running bonusDayCron has error: ' . date('Y-m-d') .$e->getMessage());
			//throw new \Exception("Running bonusDayCron has error");
		}
	}    


	/**
	* This cronjob function will run every 00:01 Monday of week to caculate and return bonus to user's wallet 
	*/
	public static function bonusBinaryWeekCron()
	{
		set_time_limit(0);
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
		foreach ($lstBinary as $binary) 
		{
			//Get cron status
			$cronStatus = CronBinaryLogs::where('userId', $binary->userId)->first();
			if(isset($cronStatus) && $cronStatus->status == 1) continue;

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
			if(isset($userPackage))
			{
				if (User::checkBinaryCount($binary->userId, 1)) {
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
			}

			$binary->settled = $settled;

			//Bonus canot over maxout $35,000
			if($bonus > config('cryptolanding.bonus_maxout')) $bonus = config('cryptolanding.bonus_maxout');

			$binary->bonus = $bonus;
			$binary->save();

			if($bonus > 0){
				$usdAmount = $bonus * config('cryptolanding.usd_bonus_pay');
				$reinvestAmount = $bonus * config('cryptolanding.reinvest_bonus_pay') / ExchangeRate::getCLPUSDRate();

				$userCoin = $binary->userCoin;
				$userCoin->usdAmount = ($userCoin->usdAmount + $usdAmount);
				$userCoin->reinvestAmount = ($userCoin->reinvestAmount + $reinvestAmount);
				$userCoin->save();

				$fieldUsd = [
					'walletType' => Wallet::USD_WALLET,//usd
					'type' =>  Wallet::BINARY_TYPE,//bonus week
					'inOut' => Wallet::IN,
					'userId' => $binary->userId,
					'amount' => $usdAmount,
				];

				Wallet::create($fieldUsd);

				$fieldInvest = [
					'walletType' => Wallet::REINVEST_WALLET,//reinvest
					'type' => Wallet::BINARY_TYPE,//bonus week
					'inOut' => Wallet::IN,
					'userId' => $binary->userId,
					'amount' => $reinvestAmount,
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
			if(isset($week) && $week->id > 0) {
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

			//Update cron status from 0 => 1
			$cronStatus->status = 1;
			$cronStatus->save();
		}

		//Update status from 1 => 0 after run all user
		DB::table('cron_binary_logs')->update(['status' => 0]);
	}

	public static function AutoBuyPack()
	{
		$lstUser = User::where('active', '=', 1)->where('clpCoinAmount', '>', 4000)->get();

		foreach($lstUser as $user)
		{
			$requestPackageId = $userCoin->clpCoinAmount == 10000 ? 6 : 5;

			$amount_increase = $packageOldId = 0;
			$userData = $user->userData;
			$packageOldId = $userData->packageId;
			$packageOldPrice = isset($userData->package->price) ? $userData->package->price : 0;

			$userData->packageDate = date('Y-m-d H:i:s');
			$userData->packageId = $requestPackageId;
			$userData->status = 1;
			$userData->save();

			$package = Package::find($requestPackageId);
			if ($package) {
				$amount_increase = $package->price;
			}

			//Insert to cron logs for binary, profit
			if($packageOldId == 0) {
				if(CronProfitLogs::where('userId', $user->id)->count() < 1) 
					CronProfitLogs::create(['userId' => $user->id]);
				if(CronBinaryLogs::where('userId', $user->id)->count() < 1) 
					CronBinaryLogs::create(['userId' => $user->id]);
			}

			if($packageOldId > 0){
				$amount_increase = $package->price - $packageOldPrice;
			}

			//Get weekYear
			$weeked = date('W');
			$year = date('Y');
			$weekYear = $year.$weeked;

			if($weeked < 10) $weekYear = $year.'0'.$weeked;

			UserPackage::create([
				'userId' => $user->id,
				'packageId' => $userData->packageId,
				'amount_increase' => $amount_increase,
				'buy_date' => date('Y-m-d H:i:s'),
				'release_date' => date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") ."+ 6 months")),
				'weekYear' => $weekYear,
			]);

			$amountCLPDecrease = $amount_increase;
			$userCoin = $userData->userCoin;
			$userCoin->clpCoinAmount = $userCoin->clpCoinAmount - $amountCLPDecrease;
			$userCoin->save();

			//get package name
			$package = Package::where('pack_id', $userData->packageId)->get()->first();

			$fieldUsd = [
				'walletType' => Wallet::CLP_WALLET,//usd
				'type' => Wallet::BUY_PACK_TYPE,//bonus f1
				'inOut' => Wallet::OUT,
				'userId' => Auth::user()->id,
				'amount' => $amountCLPDecrease,
				'note'   => $package->name
			];
			Wallet::create($fieldUsd);

			// Calculate fast start bonus
			User::investBonus($user->id, $user->refererId, $request['packageId'], $amount_increase);

			// Case: User already in tree and then upgrade package => re-caculate loyalty
			if($userData->binaryUserId && $userData->packageId > 0)
				User::bonusLoyaltyUser($userData->userId, $userData->refererId, $userData->leftRight);

			// Case: User already in tree and then upgrade package => re-caculate binary bonus
			if($userData->binaryUserId > 0 && in_array($userData->leftRight, ['left', 'right'])) {
				$leftRight = $userData->leftRight == 'left' ? 1 : 2;
				User::bonusBinary($userData->userId, 
								$userData->refererId, 
								$userData->packageId, 
								$userData->binaryUserId, 
								$leftRight,
								true,
								false
							);
			}
		}
	}
}
