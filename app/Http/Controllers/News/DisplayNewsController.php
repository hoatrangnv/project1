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
    
    //list category
    var $category;
        
    public function __construct(){
        $this->middleware('auth');
        
        $this->category = [
            1 => trans('adminlte_lang::news.crypto_news'),
            2 => trans('adminlte_lang::news.blockchain_news'),
            3 => trans('adminlte_lang::news.clp_news'),
            4 => trans('adminlte_lang::news.p2p_news')
        ];
    }  
    
    /** 
     * @author Huynq
     * @param type $id
     * @return type
     */
    public function displayDetailNews($id){
        $data = News::find($id);
        return view('adminlte::news.detail',['data'=>$data]);
    }
    
    /** 
     * @author Huynq
     * @return type
     */
    public static function getNewsDataDisplay() {
        
        $data = [];
        
        $data["crypto_news"] = self::getDataDisplayWithCategory(News::CRYPTO, config("app.news_crypto"));
        
        $data["blockchain_news"] = self::getDataDisplayWithCategory(News::BLOCKCHAIN, config("app.news_blockchain"));
        
        $data["clp_news"] =  self::getDataDisplayWithCategory(News::CLP, config("app.news_clp"));
        
        $data["p2p_news"] = self::getDataDisplayWithCategory(News::P2P, config("app.news_p2p"));
        
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
                ->get(['id','title','short_desc']);
        
    }
    
}
