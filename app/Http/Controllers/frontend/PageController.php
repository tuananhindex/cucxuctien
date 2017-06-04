<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Helpers\AdminHelper;
use Input;
use DB;
use View;
use Route;
use Block;
use Cache;
use Cart;
use Illuminate\Support\Facades\Auth;
use Mail;
use Validator;
use App;
use Setting;
use Session;

class PageController extends Controller
{
    public $title = '';
    public $description = '';
    public $keywords = '';
    
    public function __construct(){
        
        $meta_default = DB::table('meta_default')->first();
        if(isset($meta_default)){
            $this->title = $meta_default->title;
            $this->description = $meta_default->description;
            $this->keywords = $meta_default->keywords;
        }

        $this->middleware(function ($request, $next) {
           
            return $next($request);
        });

        $lang_df_id = DB::table('language')->where('nation','en')->select('id')->first()->id;
        if(!Session::has('lang_id')){
            Session::put('lang_id',$lang_df_id);
        }
        if(!Session::has('lang_nation')){
            Session::put('lang_nation','en');
        }
    }

    
    public function home(){
        // if(Cache::has('home')) 
        // {
        //     return Cache::get('home'); 
        // }
        $title = $this->title;
        $description = $this->description;
        $keywords = $this->keywords;

        
       // $posts = DB::table('posts_common')->join('posts','posts_common.id','=','posts.fk_commonid')->where('status',1)->where('fk_catid','!=',0)->orderBy('posts_common.id','desc')->select('name','image','alias','fk_catid','create_at','description')->selectRaw('(select name from users where id = posts.authId) as authName')->get(3);
        
        
        //return dd($sanphammoi);
        $view = view('frontend.home',compact('title','description','keywords','posts'))->render();
        Cache::put('home',$view,5);
        return $view; 
       
        
    }

    public function product_category($alias,$filter = ''){
        $index = DB::table('product_category')->where('id',$alias)->orWhere('alias',$alias)->first();
        if(!$index){
            return view('errors.404');
        }
        $cats = DB::table('product_category')->where(['status' => 1])->orderBy('order','desc')->orderBy('id','desc')->select('id','name','alias','fk_parentid')->get();
        $ids = AdminHelper::child_has_id($cats,$index->id);
        $products = DB::table('product')->whereIn('id',DB::table('product_category_rela')->whereIn('category_id',$ids)->select('product_id'))->where('status',1);
        $products_count = $products->count();
        if(isset($_GET['sortby']) && $_GET['sortby']){
            switch ($_GET['sortby']) {
            case 'price-desc':
              $products = $products->orderBy('real_price','desc');
              break;

            case 'price-asc':
              $products = $products->orderBy('real_price','asc');
              break;

            case 'created-desc':
              $products = $products->orderBy('created_at','desc');
              break;

            case 'created-asc':
              $products = $products->orderBy('created_at','asc');
              break;

            default:
              
              break;
          }
            
        }
        $products = $products->orderBy('order','desc')->orderBy('id','desc')->select('price','name','promotion','alias','image','fk_catid','created_at','description','id')->selectRaw('price - price * promotion / 100 as real_price');
       // return dd($products->get());
        $cat_sidebar = DB::table('product_category')->where(['status' => 1 ])->orderBy('order','desc')->orderBy('id','desc')->select('id','name','alias','fk_parentid')->get();//Lấy tất cả các FAQ trong CSDL
        
        $products = $products->paginate(16);
        //dd($products->toArray());
        $title = empty($index->name) ? $this->title : ucfirst($index->name);
        $description = empty($index->meta_description) ? $this->description : ucfirst($index->meta_description);
        $keywords = empty($index->meta_keywords) ? $this->keywords : ucfirst($index->meta_keywords);
        return view('frontend.product_category',compact('cat_sidebar','title','description','keywords','index','products','products_count'), [
            'products' => $products->appends(Input::except('page'))
        ]);
    }

    public function tag($key){
        $index = DB::table('tag')->where('alias',$key)->first();
        if(!$index){
            return view('errors.404');
        }
        $postsObj = DB::table('posts_common')->join('posts','posts_common.id','=','posts.fk_commonid')->where('tags','like','%'.$key.'%')->where(['status' => 1,'language' => Session::get('lang_id')])->orderBy('posts_common.id','desc')->select('name','image','alias','fk_catid','create_at','description')->selectRaw('(select name from users where id = posts_common.authId) as authName');
        $posts = $postsObj->paginate(5);
        $posts_sidebar = $postsObj->limit(3)->get();
        $cat_sidebar = DB::table('posts_category_common')->join('posts_category','posts_category_common.id','=','posts_category.fk_commonid')->where(['status' => 1 , 'fk_parentid' => 0 , 'language' => Session::get('lang_id') , 'nation' => $index->nation])->whereNotIn('posts_category.id',[$index->id])->orderBy('order','desc')->orderBy('id','desc')->select('posts_category.id','name','alias','fk_parentid')->get();//Lấy tất cả các FAQ trong CSDL
        $title = $this->title;
        $description = $this->description;
        $keywords = $this->keywords;
        return view('frontend.tags',compact('cat_sidebar','title','description','keywords','index','posts'));
    }

    

    public function posts_category($alias){
        $index = DB::table('posts_category_common')->join('posts_category','posts_category_common.id','=','posts_category.fk_commonid')->where('posts_category.id',$alias)->orWhere('posts_category_common.alias',$alias)->where('language' , Session::get('lang_id'))->first();
        if(!$index){
            return view('errors.404');
        }
        $cats = DB::table('posts_category_common')->join('posts_category','posts_category_common.id','=','posts_category.fk_commonid')->where(['status' => 1, 'language' => Session::get('lang_id') , 'nation' => $index->nation])->orderBy('order','desc')->orderBy('posts_category.id','desc')->select('posts_category.id','name','alias','fk_parentid')->get();
        $ids = AdminHelper::child_has_id($cats,$index->id);
        //return dd($ids);

        $postsObj = DB::table('posts_common')->join('posts','posts_common.id','=','posts.fk_commonid')->whereIn('fk_catid',$ids)->where(['status' => 1,'language' => Session::get('lang_id')])->orderBy('posts_common.id','desc')->select('name','image','alias','fk_catid','create_at','description','sokyhieu','ngaybanhanh')->selectRaw('(select name from users where id = posts_common.authId) as authName');
        $posts = $postsObj->paginate(5);
        $posts_sidebar = $postsObj->limit(3)->get();
        $cat_sidebar = DB::table('posts_category_common')->join('posts_category','posts_category_common.id','=','posts_category.fk_commonid')->where(['status' => 1 , 'fk_parentid' => 0 , 'language' => Session::get('lang_id') , 'nation' => $index->nation])->whereNotIn('posts_category.id',[$index->id])->orderBy('order','desc')->orderBy('id','desc')->select('posts_category.id','name','alias','fk_parentid')->get();//Lấy tất cả các FAQ trong CSDL
       
        $title = empty($index->name) ? $this->title : ucfirst($index->name);
        $description = empty($index->meta_description) ? $this->description : ucfirst($index->meta_description);
        $keywords = empty($index->meta_keywords) ? $this->keywords : ucfirst($index->meta_keywords);
        if($index->IsDocument){
            return view('frontend.posts_category_document',compact('title','description','keywords','index','posts','cat_sidebar','posts_sidebar','cats'));
        }
        return view('frontend.posts_category',compact('title','description','keywords','index','posts','cat_sidebar','posts_sidebar','cats'));
    }

    

    public function posts($alias){
        
        $index = DB::table('posts_common')->join('posts','posts_common.id','=','posts.fk_commonid')->where('posts_common.id',$alias)->orWhere('alias',$alias)->where('language' , Session::get('lang_id'))->select('*','posts_common.id as posts_common_id')->selectRaw('(select name from users where id = posts_common.authId) as authName')->first();
        $cat_sidebar = DB::table('posts_category_common')->join('posts_category','posts_category_common.id','=','posts_category.fk_commonid')->where(['status' => 1 , 'fk_parentid' => 0 , 'language' => Session::get('lang_id') , 'nation' => $index->nation])->whereNotIn('posts_category.id',[$index->id])->orderBy('order','desc')->orderBy('id','desc')->select('posts_category.id','name','alias','fk_parentid')->get();
        $title = empty($index->name) ? $this->title : ucfirst($index->name);
        $description = empty($index->meta_description) ? $this->description : ucfirst($index->meta_description);
        $keywords = empty($index->meta_keywords) ? $this->keywords : ucfirst($index->meta_keywords);
        if($index->type == 'media'){
            $same = DB::table('posts_common')->join('posts','posts_common.id','=','posts.fk_commonid')->where(['status' => 1 ,'type' => 'media' ,'language' => Session::get('lang_id') ,'nation' => $index->nation])->whereNotIn('posts_common.id',[$index->posts_common_id])->orderBy('posts_common.id','desc')->select('posts_common.id','name','image','alias','fk_catid','create_at','description')->selectRaw('(select name from users where id = posts_common.authId) as authName')->limit(3)->get();
            return view('frontend.media',compact('title','description','keywords','index','cat_sidebar','same'));
        }



        $cats = DB::table('posts_category_common')->join('posts_category','posts_category_common.id','=','posts_category.fk_commonid')->where(['status' => 1, 'language' => Session::get('lang_id') , 'nation' => $index->nation])->orderBy('order','desc')->orderBy('posts_category.id','desc')->select('posts_category.id','name','alias','fk_parentid','show_date')->get();
        if(!$index){
            return view('errors.404');
        }
        

        
        
        $category = DB::table('posts_category_common')->join('posts_category','posts_category_common.id','=','posts_category.fk_commonid')->where('posts_category.id',$index->fk_catid)->select('name','alias')->first();
        $category_root = AdminHelper::category_root($cats,$index->fk_catid);
        $ids = AdminHelper::child_has_id($cats,$category_root);
        $same = DB::table('posts_common')->join('posts','posts_common.id','=','posts.fk_commonid')->whereIn('fk_catid',$ids)->where(['status' => 1 ,'language' => Session::get('lang_id') ,'nation' => $index->nation])->whereNotIn('posts_common.id',[$index->posts_common_id])->orderBy('posts_common.id','desc')->select('posts_common.id','name','image','alias','fk_catid','create_at','description')->selectRaw('(select name from users where id = posts_common.authId) as authName')->limit(3)->get();

        $other = DB::table('posts_common')->join('posts','posts_common.id','=','posts.fk_commonid')->where(['status' => 1])->where('fk_catid',$index->fk_catid)->whereNotIn('posts_common.id',[$index->posts_common_id])->where('create_at','>',date('Y-m-d H:i:s',time() - 2592000))->orderBy('posts_common.id','RAND()')->select('name','image','alias','fk_catid','create_at','description')->limit(10)->get();
        
        $tags = DB::table('tag')->whereIn('alias',explode(',', $index->tags))->get();
        $rs_tags = '';
        if(isset($tags) && count($tags) > 0){
            foreach ($tags as $key => $value) {
                $rs_tags .= "<a href='".route('tag',$value->alias)."'>".$value->name."</a> , ";
            }
            
        }

        $rs_tags = trim($rs_tags,', ');
        if($index->fk_catid == 0){
            return view('frontend.posts_static',compact('cat_sidebar','title','description','keywords','same','other','index','category','rs_tags','cats'));
        }
        if($index->type == 'document'){
            $details = DB::table('document_details')->where('fk_postsId',$index->id)->get();
            return view('frontend.document',compact('title','description','keywords','index','cat_sidebar','same','cats','category','details'));
        }
        return view('frontend.posts',compact('cat_sidebar','title','description','keywords','same','other','index','category','rs_tags','cats'));
    }

    

    public function search_get(){
       
        $title = $this->title;
        $description = $this->description;
        $keywords = $this->keywords;
        $cats = DB::table('posts_category_common')->join('posts_category','posts_category_common.id','=','posts_category.fk_commonid')->where(['status' => 1, 'language' => Session::get('lang_id') , 'nation' => $_GET['nation']])->orderBy('order','desc')->orderBy('posts_category.id','desc')->select('posts_category.id','name','alias','fk_parentid')->get();
        $ids = AdminHelper::child_has_id($cats,$_GET['cat']);
        //return dd($ids);

        $posts = DB::table('posts_common')->join('posts','posts_common.id','=','posts.fk_commonid')->whereIn('fk_catid',$ids)->where(['status' => 1,'language' => Session::get('lang_id') , 'nation' => $_GET['nation']]);
        if(isset($_GET['keywords']) && $_GET['keywords']){
            $posts = $posts->where(function ($query) {
                $query->where('name','like','%'.$_GET['keywords'].'%')
                      ->orWhere('description','like','%'.$_GET['keywords'].'%')
                      ->orWhere('content','like','%'.$_GET['keywords'].'%');
            });
        }
        if(isset($_GET['start']) && $_GET['start']){
            $posts = $posts->where('create_at','>',AdminHelper::reformatDate($_GET['start']));
        }
        if(isset($_GET['end']) && $_GET['end']){
            $posts = $posts->where('create_at','<',AdminHelper::reformatDate($_GET['end']));
        }
        $posts = $posts->orderBy('posts_common.id','desc')->select('name','image','alias','fk_catid','create_at','description')->selectRaw('(select name from users where id = posts_common.authId) as authName')->paginate(5);
        
        $cat_sidebar = DB::table('posts_category_common')->join('posts_category','posts_category_common.id','=','posts_category.fk_commonid')->where(['status' => 1 , 'fk_parentid' => 0 , 'language' => Session::get('lang_id') , 'nation' => $_GET['nation']])->orderBy('order','desc')->orderBy('id','desc')->select('posts_category.id','name','alias','fk_parentid')->get();
        return view('frontend.search',compact('title','description','keywords','posts','key_search','cat_sidebar','cats'), [
            'data' => $posts->appends(Input::except('page'))
        ]);
    }

    public function search_post(Request $request){
        if(empty($request->key_search)){
            return redirect(route('home'));
        }
        return redirect(route('search.get',$request->key_search));
    }

    public function contact(){
        // if(Cache::has('contact')) 
        // {
        //     return Cache::get('contact'); 
        // }
        $title = 'Liên hệ';
        $description = $this->description;
        $keywords = $this->keywords;
        $view = view('frontend.contact',compact('title','description','keywords'))->render();
        Cache::put('contact',$view,5);
        return $view; 
    }

    public function menu($alias){
        $index = DB::table('menu_common')->join('menu','menu_common.id','=','menu.fk_commonid')->where('menu.id',$alias)->select('cursor','cursor_id')->first();

        $alias = DB::table($index->cursor.'_common')->join($index->cursor,$index->cursor.'_common.id','=',$index->cursor.'.fk_commonid')->where($index->cursor.'.id',$index->cursor_id)->select('alias')->first()->alias;
        return redirect(route($index->cursor,$alias));
        
    }

    
    

    public function change_lang($id,$nation){
        Session::put('lang_id',$id);
        Session::put('lang_nation',$nation);
        return redirect()->back();
    }

}
