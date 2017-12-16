<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 12/6/2017
 * Time: 7:50 PM
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class FaqController extends Controller
{
    public function index($type){
        if($type == 1){
            return view('adminlte::faq.faq1');
        }else{
            return view('adminlte::faq.faq2');
        }
    }
}