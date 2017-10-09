<?php
namespace App\Helper;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Helper
 *
 * @author huydk
 */
class Helper {
    
    public function removeAndGetOneElementOfArray($array = array()){
        return array_pop($array);
    }
    
    public function getTimeNow(){
        return \Carbon\Carbon::now();
    }
}
