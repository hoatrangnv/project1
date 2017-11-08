<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Http\Controllers\Backend\News;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\News;
use Log;
use Auth;
use Session;
use App\Authorizable;

/**
 * Description of NewsController
 *
 * @author huydk
 */
class NewsController extends Controller{

    use Authorizable;

    public function __construct(Request $request){
        $this->middleware('auth');
    }
    
    public function check($id){
        if(News::find($id)->created_by !=
               Auth::user()->id){
            if(!$this->isAdmin()){
                header('Location: '."/home");
            }
        }
    }
    /** 
     * @author huynq
     * @return type
     */
    public function index (Request $request) {

        $news=News::orderBy('id', 'desc')->paginate(5);
        return view('adminlte::backend.news.manage',compact('news'))->with('i', ($request->input('page', 1) - 1) * 5);

    }
    
    /** 
     * @author Huynq
     * @param Request $request
     * @return type
     */
    public function create(Request $request) {
        return view('adminlte::backend.news.add');
    }

    /** 
     * @author Huynq
     * @param Request $request
     * @return type
     */
    public function store(Request $request) {
        if ($request->isMethod("post")) {

            //action add a new
            $this->validate($request, [
                'title'=>'required',
                'category'=>'required|numeric|isTypeCategory'
            ]);
            //category ??
            $new = new News;
            $new->title = $request->title;
            $new->category_id = $request->category;
            $new->desc = $request->body;
            $new->short_desc = $this->shortDescription($request->body);
            $new->created_by = Auth::user()->id;
            if($new->save()){
                $request->session()->flash( 'successMessage', 
                        trans("adminlte_lang::news.success") );
            }else{
                $request->session()->flash( 'errorMessage', 
                        trans("adminlte_lang::news.error") );
            }

            return redirect("news");
        }
    }

    /** 
     * @author Huynq
     * @param Request $request
     * @return type
     */
    public function show(Request $request) {
        if ($request->isMethod("post")) {

            //action add a new
            $this->validate($request, [
                'title'=>'required',
                'category'=>'required|numeric|isTypeCategory'
            ]);
            //category ??
            $new = new News;
            $new->title = $request->title;
            $new->category_id = $request->category;
            $new->desc = $request->body;
            $new->short_desc = $this->shortDescription($request->body);
            $new->created_by = Auth::user()->id;
            if($new->save()){
                $request->session()->flash( 'successMessage', 
                        trans("adminlte_lang::news.success") );
            }else{
                $request->session()->flash( 'errorMessage', 
                        trans("adminlte_lang::news.error") );
            }

            return redirect("news/manage");
        }
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
    public function edit(Request $request ,$id) {
        
        //get data news   
        $dataNew = News::withTrashed()
                ->where('id',$id)->first();
        
        return view('adminlte::backend.news.edit',["news"=>$dataNew]);
    }

    /** 
     * @author Huynq
     * @param type $id
     * @return type
     */
    public function update(Request $request ,$id) {
        //$this->check($request,$id);
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
                Log::error("Cannot create post new");
                $request->session()->flash( 'errorMessage', 
                        trans("adminlte_lang::news.error_update") );
            }

            return redirect("news");
        }
    }
    
    /** 
     * @author Huynq
     * @param Request $request
     * @param type $id
     * @return type
     */
    public function destroy(Request $request ,$id) {
        $this->check($request);
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
