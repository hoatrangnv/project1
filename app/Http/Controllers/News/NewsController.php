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
//        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->check($request);
            return $next($request);
        });
    }
    
    public function check($request){
        if(News::find($request->id)->created_by == 
               Auth::user()->id){
            return redirect("home");
        }
    }
    /** 
     * @author huynq
     * @return type
     */
    public function newManagent(Request $request) {
        $news=News::paginate(5);
        return view('adminlte::news.manage',compact('news'))->with('i', ($request->input('page', 1) - 1) * 5);
    }
    
    /** 
     * @author Huynq
     * @param Request $request
     * @return type
     */
    public function newAdd(Request $request) {
        if ($request->isMethod("post")) {
            
            //action add a new
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
    public function newEdit(Request $request ,$id) {
//        $this->check($request);
        if ( $request->isMethod("put") ) {
            
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

            if( News::where('id',$id)
                    ->update($dataInsert) ){
                $request->session()->flash( 'successMessage', 
                        trans("adminlte_lang::news.success_update") );
            }else{
                Log::error("Loi ko tao duoc post new");
                $request->session()->flash( 'errorMessage', 
                        trans("adminlte_lang::news.error_update") );
            }

        }
        //get data news   
        $dataNew = News::withTrashed()
                ->where('id',$id)->first();
        
        return view('adminlte::news.edit',["news"=>$dataNew]);
    }
    
    /** 
     * @author Huynq
     * @param Request $request
     * @param type $id
     * @return type
     */
    public function newDelete(Request $request ,$id) {
        if( $request->isMethod("get") ){
            //delete
            $del = News::where('id', $id)->delete(); 
            
            if($del){
                $request->session()->flash( 'successMessage', 
                        trans("adminlte_lang::news.success_delete") );
            }else{
                $request->session()->flash( 'errorMessage', 
                        trans("adminlte_lang::news.error_delete") );
            }
            return redirect()->route('news.manage');
        }
    }
 
}
