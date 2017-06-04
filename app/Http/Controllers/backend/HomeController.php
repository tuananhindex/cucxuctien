<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use View;
use DB;
use App\Http\Helpers\AdminHelper;
use Auth;
use Input;


class HomeController extends Controller
{
	private $e = [
					'view' => 'backend.home',
					'route' => 'backend.home',
					'module' => 'trang chủ',
                    'lang' => 'home'
				];
	private $df_lang;
    private $__acc;

	public function __construct(){
		View::share('e',$this->e);

		$this->df_lang = DB::table('language')->where('default',1)->first();
        View::share('df_lang',$this->df_lang);
        $this->middleware(function ($request, $next) {
            $this->__acc = Auth::user();
            View::share('__acc',$this->__acc);
            return $next($request);
        });
	}

    public function index(){
        $languages = DB::table('language')->where('status',1)->get();
        if(isset($_GET['lang_id']) && $_GET['lang_id']){
            $lang = $_GET['lang_id'];
        }else{
            $lang = $this->df_lang->id;
        }
        $cats = DB::table('posts_category')->join('posts_category_common','posts_category'.'.fk_commonid','=','posts_category_common.id')->where('nation',$this->__acc->nation)->where('language',$lang)->orderBy('order','desc')->orderBy('id','desc')->select('posts_category'.'.id','name','fk_parentid')->get();        
        if(Input::has('cat_id')){
            $MultiLevelSelect = AdminHelper::MultiLevelSelect($cats,0,'',Input::get('cat_id'));
        }else{
            $MultiLevelSelect = AdminHelper::MultiLevelSelect($cats);
        }
        $data = DB::table('posts')->join('posts_common','fk_commonid','=','posts_common.id')->where('nation',$this->__acc->nation)->where('status',0);
        if($this->__acc->role == 'content'){
            $data = $data->where('authId',$this->__acc->id);
        }
        $data = $data->orderBy('order','desc')->orderBy('posts.id','desc');
        
        if(isset($_GET['cat_id']) && $_GET['cat_id']){
            $ids = AdminHelper::child_has_id($cats,Input::get('cat_id'));
            $data = $data->whereIn('posts.id',DB::table('posts_category_rela')->whereIn('category_id',$ids)->select('posts_id'));
        }
        if(isset($_GET['lang_id']) && $_GET['lang_id']){
            $data = $data->where('language',Input::get('lang_id'));
        }else{
            $data = $data->where('language',$this->df_lang->id);
        }
        if(isset($_GET['hot']) && $_GET['hot']){
            $data = $data->where('IsCustomer',1);
        }
        if(isset($_GET['event']) && $_GET['event']){
            $data = $data->where('IsEvent',1);
        }
        $data = $data->select('image','name','create_at','authName','update_at','IsCustomer','status','order','language','posts.id as id')->paginate(10);
    	return view('backend.home',compact('data','MultiLevelSelect','languages'));
    }

    public function history(){
    	$this->e['module'] = '';
    	$this->e['action'] = 'Nhật ký hoạt động';
    	$data = DB::table('logs')->orderBy('id','desc')->paginate(10);
    	return view('backend.history',compact('data'))->with(['e' => $this->e]);
    }
    

}
