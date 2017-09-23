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
class NewsController extends Controller{
    
    public function __construct(){
        $this->middleware('auth');
    }
    
    /** 
     * @author huynq
     * @return type
     */
    public function newManagent(Request $request) {
        $news=News::paginate(5);
        $request->session()->flash( 'not_show_news' , true);
        return view('adminlte::news.manage',compact('news'))->with('i', ($request->input('page', 1) - 1) * 5);
    }
    
    /** 
     * @author Huynq
     * @param Request $request
     * @return type
     */
    public function newAdd(Request $request) {
        if ($request->isMethod("post")) {
            $this->validate($request, [
                'title'=>'required',
                'category'=>'required|numeric|isTypeCategory'
            ]);
            //category ??
            
            $dataInsert = [
                'title' => $request->title,
                'category_id' => $request->category,
                'desc'  => $request->body,
                'short_desc' => $this->shortDescription($request->body),
                'created_by'=> Auth::user()->id
            ];
            
            if(News::insert($dataInsert)){
                $request->session()->flash( 'successMessage', 
                        trans("adminlte_lang::news.success") );
            }else{
                Log::error("Loi ko tao duoc post new");
                $request->session()->flash( 'errorMessage', 
                        trans("adminlte_lang::news.error") );
            }
        }
        $request->session()->flash( 'not_show_news' , true);
        return view('adminlte::news.add');
    }
    
    /** 
     * @author Huynq
     * @param type $fullDescription
     * @return string
     */
    private function shortDescription($fullDescription) {
        $shortDescription = "";

        $fullDescription = trim(strip_tags($fullDescription));

        if ($fullDescription) {
            $initialCount = 125;
            if (strlen($fullDescription) > $initialCount) {
                 //$shortDescription = substr(strip_tags($fullDescription),0,$initialCount).”…”;
                $shortDescription = substr($fullDescription,0,$initialCount)."…";
            }
            else {
                return $fullDescription;
            }
        }

        return $shortDescription;
    }
    
    /** 
     * @author Huynq
     * @param type $id
     * @return type
     */
    public function newEdit($id) {
        $dataNew = News::withTrashed()
                ->where('id',$id)->first();
        $request->session()->flash( 'not_show_news' , true);
        return view('adminlte::news.edit',["news"=>$dataNew]);
    }
    
}
