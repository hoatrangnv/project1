<?php
	namespace App;
	use Illuminate\Database\Eloquent\Model;
	class APIExchangeRate extends Model{
		//protected $table='api_exchange_rates';
		protected $fillable=['lastPrice','type','nextId'];
		public function __construct(array $attributes = [])
	    {
	        parent::__construct($attributes);
	        $this->setTable('api_exchange_rates');
	    }
	}
?>