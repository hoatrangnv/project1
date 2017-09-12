<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\BonusFastStart;
use App\BonusBinary;
use App\LoyaltyUser;
use Auth;
use Session;

class MyBonusController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

	public function faststart(Request $request){
		$currentuserid = Auth::user()->id;
        //$fastStart = User::findOrFail($currentuserid);
        //$fastStart = BonusFastStart::where('userId', '=',$currentuserid)->first();
        //print_r($fastStart->users->name); die;
        $fastStarts = BonusFastStart::where('userId', '=',$currentuserid)->paginate();

        return view('adminlte::mybonus.faststart')->with('fastStarts', $fastStarts);
    }
	
	public function binary(Request $request){
		$currentuserid = Auth::user()->id;
        $binarys = BonusBinary::where('userId', '=',$currentuserid)->paginate();
        return view('adminlte::mybonus.binary')->with('binarys', $binarys);
    }
    public function binaryCalculatorBonus(Request $request){
	    $totalBonus = 0;
        $currentuserid = Auth::user()->id;
        $user = User::findOrFail($currentuserid);
        $totalBonusPercent = self::binaryCalculatorBonusPercent($user->packageId);
        $weeked = date('W');
        $year = date('Y');
        $weekYear = $year.$weeked;
        if($weeked < 10)$weekYear = $year.'0'.$weeked;
        $binary = BonusBinary::where('userId', '=',$currentuserid)->where('weekYear', '=',$weekYear)->get();
        $totalBonus = round($totalBonusPercent * $binary->settled);
        return $totalBonus;
    }
    function binaryCalculatorBonusPercent($packageId = 1){
        $totalBonusPercent = 0;
        $numLeft = User::where('refererId', '=',$currentuserid)->where('leftRight', '=','left')->where('packageId', $packageId+1)->count();
        $numRight = User::where('refererId', '=',$currentuserid)->where('leftRight', '=','right')->where('packageId', $packageId+1)->count();
        if($numLeft>=3 && $numRight>=3){
            if($packageId == 1) {
                $totalBonusPercent = 0.05;
            }elseif($packageId == 2){
                $totalBonusPercent = 0.06;
            }elseif($packageId == 3){
                $totalBonusPercent = 0.07;
            }elseif($packageId == 4){
                $totalBonusPercent = 0.08;
            }elseif($packageId == 5){
                $totalBonusPercent = 0.09;
            }elseif($packageId == 6){
                $totalBonusPercent = 0.1;
            }
        }else{
            if($packageId>1)
                $totalBonusPercent = self::binaryCalculatorBonusPercent($packageId - 1);
        }
        return $totalBonusPercent;
    }
    public function loyaltys(){

    }
    public function loyalty(){
        $loyaltyBonus = array('silver' => 5000, 'gold' => 10000, 'pear' => 20000, 'emerald' => 50000, 'diamond' => 100000);
        $currentuserid = Auth::user()->id;
        $loyaltyUser = LoyaltyUser::find($currentuserid);
        $loyaltyUserData = array();
        if($loyaltyUser){
            $loyaltyUserData = array(
                'silverLeft' => LoyaltyUser::where('refererId', '=', $currentuserid)->where('isSilver', 1)->where('leftRight', '=', 'left')->count(),
                'silverRight' => LoyaltyUser::where('refererId', '=', $currentuserid)->where('isSilver', 1)->where('leftRight', '=', 'right')->count(),
                'goldLeft' => LoyaltyUser::where('refererId', '=', $currentuserid)->where('isGold', 1)->where('leftRight', '=', 'left')->count(),
                'goldRight' => LoyaltyUser::where('refererId', '=', $currentuserid)->where('isGold', 1)->where('leftRight', '=', 'right')->count(),
                'pearLeft' => LoyaltyUser::where('refererId', '=', $currentuserid)->where('isPear', 1)->where('leftRight', '=', 'left')->count(),
                'pearRight' => LoyaltyUser::where('refererId', '=', $currentuserid)->where('isPear', 1)->where('leftRight', '=', 'right')->count(),
                'emeraldLeft' => LoyaltyUser::where('refererId', '=', $currentuserid)->where('isEmerald', 1)->where('leftRight', '=', 'left')->count(),
                'emeraldRight' => LoyaltyUser::where('refererId', '=', $currentuserid)->where('isEmerald', 1)->where('leftRight', '=', 'right')->count(),
                'diamondLeft' => LoyaltyUser::where('refererId', '=', $currentuserid)->where('isDiamond', 1)->where('leftRight', '=', 'left')->count(),
                'diamondRight' => LoyaltyUser::where('refererId', '=', $currentuserid)->where('isDiamond', 1)->where('leftRight', '=', 'right')->count(),
            );
        }

        return view('adminlte::mybonus.loyalty', array('loyaltyUser' => $loyaltyUser, 'loyaltyBonus' => $loyaltyBonus, 'loyaltyUserData' => $loyaltyUserData));
    }
    public function show($id)
    {
        echo $id;
        //return redirect('members/genealogy');
    }
}
