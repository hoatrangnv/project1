<?php
	namespace App;
	use Illuminate\Database\Eloquent\Model;
	class UserOrder extends Model
	{
		const STATUS_PENDING=1;
		const STATUS_PAID=2;
		const STATUS_EXPRIED=3;
		protected $fillable = ['userId', 'packageId','walletType','amountCLP','amountBTC','status','buy_date','paid_date'];
		    public function package() {
		        return $this->hasOne(Package::class, 'id', 'packageId');
		    }
	}
?>