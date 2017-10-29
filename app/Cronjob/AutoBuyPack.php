<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Cronjob;

use App\UserPackage;
use App\UserData;
use App\UserCoin;
use App\User;
use App\Wallet;
use App\Package;
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
class AutoBuyPack
{
	public static function AutoBuyPack()
	{
		if(date('Y-m-d') != '2017-11-01') return;

		$lstUser = User::where('active', '=', 1)->get();

		foreach($lstUser as $user)
		{
			$userCoin = $user->userCoin;
			if($userCoin->clpCoinAmount == 0) continue;
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
				'userId' => $user->id,
				'amount' => $amountCLPDecrease,
				'note'   => $package->name
			];
			Wallet::create($fieldUsd);

			// Calculate fast start bonus
			self::investBonus($user->id, $user->refererId, $requestPackageId, $amount_increase);

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

	/**
	* Calculate fast start bonus
	*/
	public static function investBonus($userId = 0, $refererId = 0, $packageId = 0, $usdCoinAmount = 0, $level = 1)
	{
		if($refererId > 0)
		{
			$packageBonus = 0;

			$userData = UserData::find($refererId);
			$userCoin = $userData->userCoin;

			if($userData && $level <= 3 && $userCoin->reinvestAmount > 100)
			{
				if($level == 1){//F1
					$packageBonus = $usdCoinAmount * config('cryptolanding.bonus_f1_pay');
					$userData->totalBonus = $userData->totalBonus + $packageBonus;
					$userData->save();
				}elseif($level == 2){//F2
					if(isset($userData->package->pack_id) &&  $userCoin->reinvestAmount > 100){
						$packageBonus = $usdCoinAmount * config('cryptolanding.bonus_f2_pay');
						$userData->totalBonus = $userData->totalBonus + $packageBonus;
						$userData->save();
					}
				}elseif($level == 3){//F3
					if(isset($userData->package->pack_id) &&  $userCoin->reinvestAmount > 100){
						$packageBonus = $usdCoinAmount * config('cryptolanding.bonus_f3_pay');
						$userData->totalBonus = $userData->totalBonus + $packageBonus;
						$userData->save();
					}
				}
				
				if($userCoin && $packageBonus > 0){
					//Get info of user
					$user = User::find($userId);

					$usdAmount = ($packageBonus * config('cryptolanding.usd_bonus_pay'));
					$reinvestAmount = ($packageBonus * config('cryptolanding.reinvest_bonus_pay') / ExchangeRate::getCLPUSDRate());

					$userCoin->usdAmount = ($userCoin->usdAmount + $usdAmount);
					$userCoin->reinvestAmount = ($userCoin->reinvestAmount + $reinvestAmount);
					$userCoin->save();

					$fieldUsd = [
						'walletType' => Wallet::USD_WALLET,//usd
						'type' => Wallet::FAST_START_TYPE,//bonus f1
						'inOut' => Wallet::IN,
						'userId' => $userData->userId,
						'amount' => $usdAmount,
						'note'   => $user->name . ' bought package'
					];
					Wallet::create($fieldUsd);
					$fieldInvest = [
						'walletType' => Wallet::REINVEST_WALLET,//reinvest
						'type' => Wallet::FAST_START_TYPE,//bonus f1
						'inOut' => Wallet::IN,
						'userId' => $userData->userId,
						'amount' => $reinvestAmount,
						'note'   => $user->name . ' bought package'
					];
					Wallet::create($fieldInvest);
				}
				if($packageBonus > 0)
					User::investBonusFastStart($refererId, $userId, $packageId, $packageBonus, $level);
			}

			if($userData)
				self::investBonus($userId, $userData->refererId, $packageId, $usdCoinAmount, ($level + 1));
		}
	}
}
