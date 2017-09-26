<?php

namespace App\Http\Controllers;

use Response;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Auth;
use Session;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    var $ct = 1;
    
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
    
    /** 
     * @author Huynq
     * @param type $data
     * @return JsonData
     */
    public function responseSuccess( $data = null ){
        return Response::json([
                        "success" => true,
                        "result"  => $data
        ] );
    }
    
    /** 
     * @author Huynq
     * @param type $errorCode, $msg=null
     * @return JsonData
     */
    public function responseError( $errorCode, $msg=null ){
        return Response::json([
                        "success"       => false,
                        "error_code"    => $errorCode,
                        "message"       => $msg
        ] );
    }
    /**
     * check admin
     * @author Huynq
     * @return boolean
     */
    public function isAdmin(){
        if(config("app.admin_id") == Auth::user()->id) {
            return true;
        }else{
            return false;
        }
        
        return false;
    }
}
