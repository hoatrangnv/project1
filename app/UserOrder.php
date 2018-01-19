<?php
	namespace App;
	use Illuminate\Database\Eloquent\Model;
	class UserOrder extends Model
	{
		protected $fillable = ['userId', 'packageId','walletType','amountCLP','amountBTC','status','buy_date','paid_date'];
		    public function package() {
		        return $this->hasOne(Package::class, 'id', 'packageId');
		    }
	}
?>