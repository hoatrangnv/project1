<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\DuskServiceProvider;
use Validator;
use DB;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
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
