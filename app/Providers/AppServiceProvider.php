<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\DuskServiceProvider;
use Validator;
use DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Validator::extend('isTypeCategory', function($attribute, $value, $parameters, $validator) {
            if( $value == 1 || $value == 2 || $value == 3 || $value ==4 ){
                return true;
            }
                return false;
        });

        //Get CLP news
        $clpNews = DB::table('news')
                ->where('category_id', 3)
                ->select('id')
                ->get();

        $aCLPNews = [];
        foreach($clpNews as $news) {
            $aCLPNews[] = $news->id;
        }
        $aCLPNews = json_encode($aCLPNews);

        View::share('aCLPNews', $aCLPNews);


        $exchanges=DB::table('exchange_rates')->get();
        $ExchangeRate['CLP_USD']=1;
        $ExchangeRate['BTC_USD']=1;
        $ExchangeRate['CLP_BTC']=1;
        if(count($exchanges)>0)
        {
            foreach ($exchanges as $key => $value) {
                if($value->from_currency=='clp' && $value->to_currency=='usd')
                {
                    $ExchangeRate['CLP_USD']=$value->exchrate;
                }
                if($value->from_currency=='btc' && $value->to_currency=='usd')
                {
                    $ExchangeRate['BTC_USD']=$value->exchrate;
                }
                if($value->from_currency=='clp' && $value->to_currency=='btc')
                {
                    $ExchangeRate['CLP_BTC']=$value->exchrate;
                }
            }
        }
        View::share('ExchangeRate',$ExchangeRate);


        $packages = DB::table('packages')->get();
        View::share('packages',$packages);

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
        }
    }
}
