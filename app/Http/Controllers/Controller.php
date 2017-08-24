<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Auth;
use Session;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(){
        $this->middleware(function ($request, $next) {
            if (Auth::user() && Auth::user()->is2fa) {
                if (Session::get('google2fa') == null || Session::get('google2fa') == false) {
                    return redirect('authenticator');
                }
            }
            return $next($request);
        });
    }
}
