<?php namespace App\Http\Controllers;
use App\UserCoin;
use App\UserCoinUsd;
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

use Log;

class UserOrderController extends Controller
{

		public function cancelOrder(Request $request)
		{
			if(!$request->ajax())
			{
				$currentuserid=Auth::user()->id;
				$order=UserOrder::where('userId',$currentuserid)->where('id',$request->orderId)->where('status',UserOrder::STATUS_PENDING)->first();
				$oldPackage=Auth::user()->userData->packageId;
				if($order)
				{
					$order->status=UserOrder::STATUS_CANCEL;
					$order->save();
					$msg='The Order Buy '.$order->package->name.' package has been canceled.';
					if($oldPackage>0)
						$msg='The Order Upgrade to '.$order->package->name.' package has been canceled.';
					return redirect()->route('package.buy')
			                            ->with('flash_message',$msg);
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

		public function checkOrder(Request $request)
		{
			if($request->ajax())
			{
				$currentuserid=Auth::user()->id;
				$orders=UserOrder::where('userId',$currentuserid)->where('status',UserOrder::STATUS_PENDING)->get();
				if(count($orders)>0)
				{
					return json_encode(['status'=>false,'data'=>$orders[0]->package->name]);
				}
				else
				{
					return json_encode(['status'=>true,'data'=>null]);
				}
			}
		}

		public function checkBalance(Request $request)
		{
			if($request->ajax())
			{

				$user=Auth::user();
				$package=Package::find($request->pid);
				if(!empty($package))
				{
					//check upgrade or update
					$oldPackage=$user->userData->packageId;
					$amount=$damount=$package->price;
					$check=false;
					if($oldPackage!=0)
					{
						$amount=$damount=$amount-$user->userData->package->price;
                    }

                    if($request->wallet==Wallet::USD_WALLET){
                        $check = ($amount<=$user->UserCoin->usdAmount);
                    }
					if($request->wallet==Wallet::CLP_WALLET){
						$amount=round($amount/ExchangeRate::getCLPUSDRate(),8);
						$clpCoinAmount=$user->UserCoin->clpCoinAmount;
						if($amount<=$clpCoinAmount)
							$check=true;
					}
					if($request->wallet==Wallet::BTC_WALLET){
						$amount=round($amount/ExchangeRate::getBTCUSDRate(),8);
						$btcCoinAmount=$user->UserCoin->btcCoinAmount;
						if($amount<=$btcCoinAmount)
							$check=true;
                    }
/*
Log::debug( '---------------- check Balance -----------------' );
Log::debug( 'Current user is ' . $user->id . ' ' . $user->name );
Log::debug( 'Current package is ' . $user->userData->packageId . ' ' . $user->userData->package->name . ' $' . number_format($user->userData->package->price,2) );
Log::debug( 'wants to buy '. $package->id . ' ' . $package->name . ' $' . number_format($package->price,2) );
Log::debug( 'using wallet ' . $request->wallet );
Log::debug( 'Wallet '. $request->wallet . ' has balance ' . number_format($user->UserCoin->usdAmount,2));
Log::debug( 'checkBalance result : ' . $check);
*/
					return json_encode([
                        'status'=>$check,
                        'packName'=>$package->name,
                        'packPriceUSD'=>$amount,
                        'packPriceBTC'=>round($damount/ExchangeRate::getBTCUSDRate(),8),
                        'packPriceCLP'=>floatval(round($damount/ExchangeRate::getCLPUSDRate(),8))
                    ]);
				}
				else
				{
					return json_encode(['status'=>'error']);
				}
				
			}
			else
			{
				return 'Restricted Access';
			}
		}

		public function addNew(Request $request)
		{
			$currentuserid = Auth::user()->id;
	        $user = Auth::user();

	        $currentDate = date("Y-m-d");
	        $preSaleEnd = date('Y-m-d', strtotime(config('app.pre_sale_end')));
	        if($user && $request->isMethod('post') && ($currentDate > $preSaleEnd))
	        {
	        	$package=Package::find($request->packageId);
				if($request->walletId!=Wallet::USD_WALLET && $request->walletId!=Wallet::CLP_WALLET && $request->walletId!=Wallet::BTC_WALLET)
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
                    
                    $balanceUSD=$userCoin->usdAmount;
					$balanceCLP=$userCoin->clpCoinAmount;
                    $balanceBTC=$userCoin->btcCoinAmount;
                    $amount=$package->price;
                    $amount=$package->price-$user->userData->package->price;
					$enough=false;
					$pOldPrice = isset($user->userData->package->price) ?$user->userData->package->price : 0;
/*
Log::debug( '-------------------- add New -------------------' );
Log::debug( 'Current user is ' . $currentUser->id . ' ' . $currentUser->name);
Log::debug( 'Current package is ' . $currentUser->userData->packageId . ' ' . $currentUser->userData->package->name . ' $' . number_format($currentUser->userData->package->price,2) );
Log::debug( 'wants to buy '. $package->id . ' ' . $package->name . ' $' . number_format($package->price,2) );
Log::debug( 'using wallet ' . $request->walletId );
if($request->walletId == Wallet::USD_WALLET ) {
    Log::debug( 'Wallet '. $request->wallet . 'has balance ' . number_format($balanceUSD,2));
} elseif($request->walletId == Wallet::CLP_WALLET ) {
    Log::debug( 'Wallet '. $request->wallet . 'has balance ' . number_format($balanceCLP,2));
} else {
    Log::debug( 'Wallet '. $request->wallet . 'has balance ' . number_format($balanceBTC,2));
}
*/
                    if(floatval($request->walletId)==Wallet::USD_WALLET)//usd holding wallet
                    {
                        $enough = ($amount<=$balanceUSD);
                    }
                    if(floatval($request->walletId)==Wallet::CLP_WALLET)//clp wallet
					{
						$amount=round(($amount-$pOldPrice)/$rateCLPUSD,8);
						$enough=floatval($amount)<=$balanceCLP;
					}

					if(floatval($request->walletId)==Wallet::BTC_WALLET){
						$amount=round(($amount-$pOldPrice)/$rateBTCUSD,8);
						$enough=floatval($amount)<=$balanceBTC;
                    }
					///////////////////////////////////////////////////
					$orderField=[
						'userId'=>$currentUser->id,
						'packageId'=>$package->id,
                        'walletType'=>$request->walletId,
                        'amountUSD'=>$request->walletId==Wallet::USD_WALLET?$amount:null,
						'amountCLP'=>$request->walletId==Wallet::CLP_WALLET?$amount:null,
						'amountBTC'=>$request->walletId==Wallet::BTC_WALLET?$amount:null,
						'buy_date'=>(new \DateTime())->format('Y-m-d H:i:s'),
						'paid_date'=>null,
						'type'=>(isset($user->userData->packageId) && $user->userData->packageId!=0)?UserOrder::TYPE_UPGRADE:UserOrder::TYPE_NEW,
						'original'=>$user->userData->packageId,
						'status'=>1
                    ];
/*
if($enough) {
    Log::debug( 'System indicate sufficient amount');
    Log::debug( 'and we are going to post ' . json_encode($orderField));
} else {
    Log::debug( 'System indicate insufficient amount');
}
*/
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
			            //++++++++++++++++++++++++++++++++++++++++++++++
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


                        $amountUSDDecrease = $amount_increase;
			            $amountCLPDecrease = round($amount_increase / ExchangeRate::getCLPUSDRate(),8);
			            $amountBTCDecrease = round($amount_increase / ExchangeRate::getBTCUSDRate(),8);

			            $userCoin = $userData->userCoin;

                        if($request->walletId==Wallet::USD_WALLET)
		            	{
                            $userCoin->usdAmount = $userCoin->usdAmount- $amountUSDDecrease;
                            $userCoin->save();
                            if( $amountUSDDecrease < $userCoin->userCoinUsd->usdAmountHold ) {
                                $userCoin->userCoinUsd->usdAmountHold = $userCoin->userCoinUsd->usdAmountHold - $amountUSDDecrease;
                            } else {
                                $remainder = $amountUSDDecrease - $userCoin->userCoinUsd->usdAmountHold;
                                $userCoin->userCoinUsd->usdAmountHold = 0;                                
                                $userCoin->userCoinUsd->usdAmountFree = $userCoin->userCoinUsd->usdAmountFree - $remainder;
                            }
                            $userCoin->userCoinUsd->save();
                        }
                        if($request->walletId==Wallet::CLP_WALLET)
		            	{
                            $userCoin->clpCoinAmount = round($userCoin->clpCoinAmount, 8) - $amountCLPDecrease;
                            $userCoin->save();
		            	}
		            	if($request->walletId==Wallet::BTC_WALLET)
	            		{
                            $userCoin->btcCoinAmount = round($userCoin->btcCoinAmount, 8) - $amountBTCDecrease;
                            $userCoin->save();
                        }
			            

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


			            $msg='Thank for your purchase. The '.$package->name.' package has been bought successfully.';
			            if(isset($userData->packageId) && $userData->packageId!=0 && isset($userData->package->name))//upgrade
			            	$msg='Thank for your upgrade. Your '.$userData->package->name.' package has been upgraded to '.$package->name.' package successfully.';

			            return redirect()->route('package.buy')
			                            ->with('flash_message',$msg);
					}
					else//add order
					{
						UserOrder::create($orderField);
						return redirect()->route('package.buy')
							->with('flash_message','Your order has been placed. You have '.config('cryptolanding.timeToExpired').' hour(s) to pay your order!');
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
		public function payOrder(Request $request)
		{
			$currentuserid = Auth::user()->id;
	        $user = Auth::user();
	        $currentDate = date("Y-m-d");
	        $preSaleEnd = date('Y-m-d', strtotime(config('app.pre_sale_end')));
	        if($user && $request->isMethod('post') && ($currentDate > $preSaleEnd)){
	        	$order=UserOrder::find($request->orderId);

	        	if(!empty($order) && $order->status==UserOrder::STATUS_PENDING)
        		{
        			$buyDate=strtotime($order->buy_date)+config('cryptolanding.timeToExpired')*3600;
	                $time=time();
	                if($buyDate>=time())
	                {
	                	//buy action
	                	if($order->walletType!=Wallet::CLP_WALLET && $order->walletType!=Wallet::BTC_WALLET)//check wallet type
						{
							return redirect()->route('package.buy')
			                            ->with('errorMessage','Whoops. Something went wrong.');
						}
						else
						{
							$package=Package::find($order->packageId);
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
								$amount=$order->walletType==Wallet::CLP_WALLET?round($order->amountCLP*$rateCLPUSD,8):round($order->amountBTC*$rateBTCUSD);
								$enough=false;

								if(floatval($order->walletType)==Wallet::CLP_WALLET)//clp wallet
								{
									$amount=round($amount/$rateCLPUSD,8);
									if(floatval($amount)<=$balanceCLP)
									{
										$enough=true;
									}
									else
									{
										$enough=false;
									}
								}

								if(floatval($order->walletType)==Wallet::BTC_WALLET){
									$amount=round($amount/$rateBTCUSD,8);
									if(floatval($amount)<=$balanceBTC)
									{
										$enough=true;
									}
									else
									{
										$enough=false;
									}

								}

								if($enough)
								{
									$user = Auth::user();
					                if($user->userData->packageId < $order->packageId)
					                {
					                    $amount_increase = $packageOldId =$amount_newincrease= 0;
							            $userData = $user->userData;
							            $packageOldId = $userData->packageId;
							            $packageOldPrice = isset($userData->package->price) ? $userData->package->price : 0;

							            $userData->packageDate = date('Y-m-d H:i:s');
							            $userData->packageId = $order->packageId;
							            $userData->status = 1;
							            $userData->save();
							            $amount_increase =$amount_newincrease = $order->walletType==Wallet::CLP_WALLET?round($order->amountCLP*$rateCLPUSD,8):round($order->amountBTC*$rateBTCUSD,8);

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
							                $amount_newincrease = $package->price - $packageOldPrice;
							            }

							            //Get weekYear
							            $weeked = date('W');
							            $year = date('Y');
							            $weekYear = $year.$weeked;

							            if($weeked < 10) $weekYear = $year.'0'.$weeked;
							            UserPackage::create([
							                'userId' => $currentuserid,
							                'packageId' => $order->packageId,
							                'amount_increase' => $amount_newincrease,
							                'buy_date' => date('Y-m-d H:i:s'),
							                'release_date' => date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") ."+ 6 months")),
							                'weekYear' => $weekYear,
							            ]);


							            $amountCLPDecrease = round($amount_increase / ExchangeRate::getCLPUSDRate(),8);
							            $amountBTCDecrease = round($amount_increase / ExchangeRate::getBTCUSDRate(),8);

							            $userCoin = $userData->userCoin;

							            if($order->walletType==Wallet::CLP_WALLET)
						            	{
						            		$userCoin->clpCoinAmount = round($userCoin->clpCoinAmount, 8) - $amountCLPDecrease;
						            	}
						            	if($order->walletType==Wallet::BTC_WALLET)
					            		{
					            			$userCoin->btcCoinAmount = round($userCoin->btcCoinAmount, 8) - $amountBTCDecrease;
					            		}
							           
							            $userCoin->save();

							            $walletType=$order->walletType;
							            $famount=$walletType==Wallet::CLP_WALLET?$amountCLPDecrease:$amountBTCDecrease;

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
							            User::investBonus($user->id, $user->refererId, $order->packageId, $amount_newincrease);

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

							            //update order
							            $order->status=UserOrder::STATUS_PAID;
							            $order->paid_date=date('Y-m-d H:i:s');
							            $order->save();

							            $msg='Thank for your purchase. The '.$package->name.' package has been bought successfully.';
							            if(isset($userData->packageId) && $userData->packageId!=0 && isset($userData->package->name))//upgrade
							            	$msg='Thank for your upgrade. Your '.$userData->package->name.' package has been upgraded to '.$package->name.' package successfully.';

							            return redirect()->route('package.buy')
							                            ->with('flash_message',$msg);
					                }
					                else
					                {
					                	return redirect()->route('package.buy')
	                            ->with('errorMessage','Whoops. You selected wrong package!');
					                }

								}
								else
								{
									$wallet='CLP';
									if(floatval($order->walletType)==Wallet::BTC_WALLET)
										$wallet='BTC';
									return redirect()->route('package.buy')
	                            ->with('errorMessage','Your '.$wallet.' balance is not sufficient. Please deposit more coin and try again later.');
								}

							}
							else
							{
								return redirect()->route('package.buy')
	                            ->with('errorMessage','Whoops. Something went wrong!');
							}
						}





	                }
	                else
	                {
	                	return redirect()->route('package.buy')
	                            ->with('errorMessage','Whoops. Order has been expired!');
	                }
        		}
        		else
        		{
        			return redirect()->route('package.buy')
	                            ->with('errorMessage','Whoops. Something went wrong!');
        		}
	        }
	        else{
	        	return 'Restricted Access';
	        }

		}
	}
?>