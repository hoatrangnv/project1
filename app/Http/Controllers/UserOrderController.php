<?php namespace App\Http\Controllers;
use App\UserCoin;
use App\UserData;
use App\UserPackage;
use Illuminate\Http\Request;

use App\User;
use App\Package;
use Auth;
use Session;
use App\Authorizable;
use Validator;
use DateTime;
use App\ExchangeRate;
use App\Wallet;
use App\CronProfitLogs;
use App\CronBinaryLogs;
use App\CronMatchingLogs;
use App\UserOrder;

class UserOrderController extends Controller
{
		public function addNew(Request $request)
		{
			$currentuserid = Auth::user()->id;
	        $user = Auth::user();
	        $currentDate = date("Y-m-d");
	        $preSaleEnd = date('Y-m-d', strtotime(config('app.pre_sale_end')));
	        if($user && $request->isMethod('post') && ($currentDate > $preSaleEnd))
	        {
	        	$package=Package::find($request->packageId);
				if($request->walletId!=Wallet::CLP_WALLET && $request->walletId!=Wallet::BTC_WALLET)
				{
					return redirect()->route('package.buy')
	                            ->with('errorMessage','Whoops. Something went wrong.');
				}
				if($package)
				{
					$currentUser=Auth::user();
					$userData=UserData::where('userId',$currentUser->id)->first();
					$userCoin=UserCoin::where('userId',$currentUser->id)->first();
					$exchangeRate=ExchangeRate::all();
					//
					$rateCLPUSD=$exchangeRate[0]->exchrate;
					$rateBTCUSD=$exchangeRate[1]->exchrate;
					$balanceCLP=$userCoin->clpCoinAmount;
					$balanceBTC=$userCoin->btcCoinAmount;
					$amount=$package->price;
					$enough=false;

					if(floatval($request->walletId)==Wallet::CLP_WALLET)//clp wallet
					{
						$amount=round($amount/$rateCLPUSD,5);
						if(floatval($amount)<=$balanceCLP)
						{
							$enough=true;
						}
						else
						{
							$enough=false;
						}
					}

					if(floatval($request->walletId)==Wallet::BTC_WALLET){
						$amount=round($amount/$rateBTCUSD,5);
						if(floatval($amount)<=$balanceBTC)
						{
							$enough=true;
						}
						else
						{
							$enough=false;
						}

					}
					$orderField=[
						'userId'=>$currentUser->id,
						'packageId'=>$package->id,
						'walletType'=>$request->walletId,
						'amountCLP'=>$request->walletId==Wallet::CLP_WALLET?$amount:null,
						'amountBTC'=>$request->walletId==Wallet::BTC_WALLET?$amount:null,
						'buy_date'=>(new \DateTime())->format('Y-m-d H:i:s'),
						'paid_date'=>null,
						'status'=>1
					];
					if($enough){//add order, process user packages
						Validator::extend('packageCheck', function ($attribute, $value) {
			                $user = Auth::user();
			                if($user->userData->packageId < $value)
			                {
			                    return true;
			                }
			                return false;
			            });

			            $this->validate($request, [
			                'packageId' => 'required|not_in:0|packageCheck',
			                //'terms'    => 'required',
			            ],['packageId.package_check' => 'You selected wrong package']);

			            $amount_increase = $packageOldId = 0;
			            $userData = $user->userData;
			            $packageOldId = $userData->packageId;
			            $packageOldPrice = isset($userData->package->price) ? $userData->package->price : 0;

			            $userData->packageDate = date('Y-m-d H:i:s');
			            $userData->packageId = $request->packageId;
			            $userData->status = 1;
			            $userData->save();

			            $package = Package::find($request->packageId);
			            if ($package) {
			                $amount_increase = $package->price;
			            }

			            //Insert to cron logs for binary, profit
			            if($packageOldId == 0) {
			                if(CronProfitLogs::where('userId', $currentuserid)->count() < 1) 
			                    CronProfitLogs::create(['userId' => $currentuserid]);
			                if(CronBinaryLogs::where('userId', $currentuserid)->count() < 1) 
			                    CronBinaryLogs::create(['userId' => $currentuserid]);
			                if(CronMatchingLogs::where('userId', $currentuserid)->count() < 1) 
			                    CronMatchingLogs::create(['userId' => $currentuserid]);
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
			                'userId' => $currentuserid,
			                'packageId' => $userData->packageId,
			                'amount_increase' => $amount_increase,
			                'buy_date' => date('Y-m-d H:i:s'),
			                'release_date' => date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") ."+ 6 months")),
			                'weekYear' => $weekYear,
			            ]);


			            $amountCLPDecrease = $amount_increase / ExchangeRate::getCLPUSDRate();
			            $amountBTCDecrease = $amount_increase / ExchangeRate::getBTCUSDRate();

			            $userCoin = $userData->userCoin;

			            if($request->walletId==Wallet::CLP_WALLET)
		            	{
		            		$userCoin->clpCoinAmount = round($userCoin->clpCoinAmount, 2) - $amountCLPDecrease;
		            	}
		            	if($request->walletId==Wallet::BTC_WALLET)
	            		{
	            			$userCoin->btcCoinAmount = round($userCoin->btcCoinAmount, 2) - $amountBTCDecrease;
	            		}
			            


			            $userCoin->save();

			            //get package name
			            $package = Package::where('pack_id', $userData->packageId)->get()->first();

			            $walletType=$request->walletId;
			            $famount=$request->walletId==Wallet::CLP_WALLET?$amountCLPDecrease:$amountBTCDecrease;

			            $fieldUsd = [
			                'walletType' => $walletType,//usd
			                'type' => Wallet::BUY_PACK_TYPE,//bonus f1
			                'inOut' => Wallet::OUT,
			                'userId' => Auth::user()->id,
			                'amount' => $famount,
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

			            //create order
			            $orderField['status']=2;
			            UserOrder::create($orderField);

			            return redirect()->route('package.buy')
			                            ->with('flash_message','Buy package successfully.');
					}
					else//add order
					{
						UserOrder::create($orderField);
						return redirect()->route('package.buy')
							->with('flash_message','Your balance is not enough to buy this package. So, an order has been created!');
					}

					
				}
				else
				{
					return redirect()->route('package.buy')
	                            ->with('errorMessage','Whoops. Something went wrong.');
				}
	        }
	        else
	        {
	        	return 'Restricted Access';
	        }
			
		}
	}
?>