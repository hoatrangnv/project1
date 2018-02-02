<?php
	namespace App\Http\Controllers\Backend;
	use App\Http\Controllers\Controller;
	use Illuminate\Http\Request;
	use App\UserOrder;
	use App\Wallet;
	use App\Package;
	class UserOrderController extends Controller
	{
		public function __construct()
	    {
	        $this->middleware(['auth']);
	        //parent::__construct();
	    }
	    public function index(Request $request)
	    {

	    	$query=UserOrder::whereIn('status',[UserOrder::STATUS_PENDING,UserOrder::STATUS_PAID,UserOrder::STATUS_EXPRIED,UserOrder::STATUS_CANCEL]);
	    	if(isset($request->status) && $request->status!='')
	    	{
	    		$query->where('status',$request->status);
	    	}
	    	if(isset($request->purchased) && $request->purchased!='' && $request->purchased!='all')
	    	{
	    		$query->where('walletType',$request->purchased);
	    	}
	    	if(isset($request->package) && $request->package!='')
	    	{
	    		$query->where('packageId',floatval($request->package));
	    	}
	    	if(isset($request->start) && $request->start!='')
	    	{
	    		$query->where('buy_date','>=',$request->start);
	    	}
	    	if(isset($request->end) && $request->end!='')
	    	{
	    		$query->where('buy_date','<=',$request->end);
	    	}
	    	if(isset($request->orderType) && $request->orderType!='')
	    	{
	    		$query->where('type',floatval($request->orderType));
	    	}
	    	if(isset($request->originalPackage) && $request->originalPackage!='')
	    	{
	    		$query->where('original',floatval($request->originalPackage));
	    	}
	    	$orders=$query->orderBy('id', 'desc')->get();
	    	if(count($orders)>0)
	        {
	            foreach ($orders as $usKey => $usVal) {
	                $buyDate=strtotime($usVal->buy_date)+config('cryptolanding.timeToExpired')*3600;
	                $time=time();
	                if($buyDate<time() && $usVal->status==UserOrder::STATUS_PENDING)
	                {
	                    $usVal->status=UserOrder::STATUS_EXPRIED;//exprired
	                    $usVal->save();
	                }
	                $pack=Package::find($usVal->original);
	                $usVal->original=!empty($pack)?$pack->name:'';
	            }
	        }
	    	$status=[''=>'Select Status',UserOrder::STATUS_PAID=>'Paid',UserOrder::STATUS_PENDING=>'Pending',UserOrder::STATUS_CANCEL=>'Canceled',UserOrder::STATUS_EXPRIED=>'Expired'];
	    	$purchases=[''=>'Purchases By','all'=>'All',Wallet::BTC_WALLET=>'BTC',Wallet::CLP_WALLET=>'CLP'];
	    	$orderTypes=[''=>'All Order Types',UserOrder::TYPE_NEW=>'Buy New',UserOrder::TYPE_UPGRADE=>'Upgrade'];




	    	$packages=Package::all();

	    	return view('adminlte::backend.order.order',compact('status','purchases','packages','orders','orderTypes'));
	    }
	}
?>