<?php
	namespace App;
	use Illuminate\Database\Eloquent\Model;
	class UserOrder extends Model
	{
		const STATUS_PENDING=1;
		const STATUS_PAID=2;
		const STATUS_EXPRIED=3;
		const TYPE_NEW=1;
		const TYPE_UPGRADE=2;
		
		protected $fillable = ['userId', 'packageId','walletType','amountCLP','amountBTC','status','buy_date','paid_date','type','original'];
		    public function package() {
		        return $this->hasOne(Package::class, 'id', 'packageId');
		    }
		    public function user(){
		    	return $this->hasOne(User::class, 'id', 'userId');
		    }
	}
?>