<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Http\Controllers\News;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\News;
use Log;
use Auth;

/**
 * Description of NewsController
 *
 * @author huydk
 */

class DisplayNewsController extends Controller{
    
    public function __construct(){
        $this->middleware('auth');
    }  
    
    public function displayDetailNews($id){
        
        return view('adminlte::news.detail');
    }
    /** 
     * @author Huynq
     * @return type
     */
    public static function getNewsDataDisplay() {
        
        $data = [];
        
        $data["crypto_news"] = self::getDataDisplayWithCategory(News::CRYPTO, 3);
        
        $data["blockchain_news"] = self::getDataDisplayWithCategory(News::BLOCKCHAIN, 3);
        
        $data["clp_news"] =  self::getDataDisplayWithCategory(News::CLP, 3);
        
        $data["p2p_news"] = self::getDataDisplayWithCategory(News::P2P, 3);
        
        return $data;
    }
    
    /** 
     * @author Huynq
     * @param type $type
     * @param type $limit
     * @return type
     */
    private static function getDataDisplayWithCategory( $type, $limit) {
        
        return News::where("category_id",$type)
                ->orderBy('id','DESC')
                ->limit($limit)
                ->get(['id','desc']);
        
    }
    
}
