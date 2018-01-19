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
	    public function index()
	    {

	    	$orders=UserOrder::all();
	    	$status=[''=>'Select Status',UserOrder::STATUS_PAID=>'Paid',UserOrder::STATUS_PENDING=>'Not Paid',UserOrder::STATUS_EXPRIED=>'Expired'];
	    	$purchases=[''=>'Purchases By','all'=>'All',Wallet::BTC_WALLET=>'BTC',Wallet::CLP_WALLET=>'CLP'];



	    	$packages=Package::all();

	    	return view('adminlte::backend.order.order',compact('status','purchases','packages','orders'));
	    }
	}
?>