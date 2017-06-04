<?php

namespace App\Http\Controllers\frontend;
session_start();
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Helpers\AdminHelper;
use DB;
use View;
use Cache;
use Session;

class BlockController extends Controller
{
    
    public static function about_footer($nation){
        $data =  DB::table('menu_common')->join('menu','menu_common.id','=','menu.fk_commonid')->where(['status' => 1 ,'language' => Session::get('lang_id') ,'nation' => $nation ,'pos' => 'footer'])->orderBy('order','desc')->select('menu.id','name','alias','cursor','cursor_id','target','link2')->get()->toArray();
        return view('frontend.block.about_footer',compact('data','nation'));
    }
    
    public static function slider(){
        $data = DB::table('banner')->where(['status' => 1])->orderBy('order','desc')->orderBy('id','desc')->select('name','image','link')->get();
        return view('frontend.block.slider',compact('data'));
    }

    public static function media(){
        $data = DB::table('posts_common')->join('posts','posts_common.id','=','posts.fk_commonid')->where(['status' => 1 , 'type' => 'media' ,'language' => Session::get('lang_id')])->orderBy('order','desc')->orderBy('posts_common.id','desc')->select('posts.id','name','alias','image','description','media','create_at')->get(10);
        return view('frontend.block.media',compact('data'));
    }

    public static function event($nation){
        $data = DB::table('posts_common')->join('posts','posts_common.id','=','posts.fk_commonid')->where(['status' => 1 ,'language' => Session::get('lang_id') ,'IsEvent' => 1 ,'nation' => $nation])->whereRaw('MONTH(startdate) = MONTH(CURRENT_DATE())')->orderBy('order','desc')->orderBy('posts_common.id','desc')->select('posts.id','name','alias','image','description','media','startdate')->get();
        return view('frontend.block.event',compact('data','nation'));
    }

    public static function posts_hot($nation){
        $menu =  DB::table('menu_common')->join('menu','menu_common.id','=','menu.fk_commonid')->where(['status' => 1 ,'language' => Session::get('lang_id') ,'nation' => $nation ,'fk_parentid' => 0,'pos' => null])->orderBy('order','desc')->orderBy('menu_common.id','desc')->select('menu.id','name','alias','cursor','cursor_id','target','link2')->get()->toArray();
        $obj =  DB::table('posts_common')->join('posts','posts_common.id','=','posts.fk_commonid')->where(['status' => 1 ,'language' => Session::get('lang_id') ,'nation' => $nation])->where(function ($query) {
                $query->where('type',null)
                      ->orWhere('type','media');
            });
        $top1 = $obj->where('IsCustomer' , 1)->orderBy('order','desc')->orderBy('posts.id','desc')->select('posts.id','name','alias','image','description','media','startdate','create_at')->first();
        $data = $obj->whereNotIn('posts.id',[$top1->id])->orderBy('posts.id','desc')->select('posts.id','name','alias','image','description','media','startdate','create_at')->limit(4)->get()->toArray();
        return view('frontend.block.posts_hot',compact('data','nation','menu','top1'));
    }

    public static function box_search($nation){
        $cats = DB::table('posts_category')->join('posts_category_common','posts_category'.'.fk_commonid','=','posts_category_common.id')->where('nation',$nation)->where('language',Session::get('lang_id'))->where('status' , 1 )->orderBy('order','desc')->orderBy('id','desc')->select('posts_category.id','name','fk_parentid')->get();   
        if(isset($_GET['cat'])){
            $MultiLevelSelect = AdminHelper::MultiLevelSelect_frontend($cats,0,'',$_GET['cat']);
        }else{
            $MultiLevelSelect = AdminHelper::MultiLevelSelect_frontend($cats);
        }
        
        return view('frontend.block.box_search',compact('cats','nation','MultiLevelSelect'));
    }

    public static function partner(){
        $data = DB::table('customer')->where('status',1)->orderBy('id','desc')->get();
        return view('frontend.block.partner',compact('data'));
    }

    public static function search($key){
        View::share('key',$key);
        $posts = DB::table('posts')->where('name','like',"%$key%")->orWhere('description','like',"%$key%")->where('status',1)->orderBy('order','desc')->orderBy('id','desc')->select('id','name','alias','image','description','create_at')->paginate(10);
        return view('frontend.block.search',compact('posts'));
    }

    public static function box_category(){
        $categories = DB::table('product_category')->where(['status' => 1 , 'fk_parentid' => 0])->orderBy('order','desc')->orderBy('id','desc')->select('name','alias')->get();
        return view('frontend.block.box_category',compact('types','categories'));
    }

    public static function box_category_posts(){
        $categories = DB::table('posts_category')->where(['status' => 1 , 'fk_parentid' => 0])->orderBy('order','desc')->orderBy('id','desc')->select('name','alias')->get();
        return view('frontend.block.box_category_posts',compact('types','categories'));
    }

    public static function static_block($pos){
        $data = DB::table('static_block')->where(['position' => $pos ,'status' => 1])->select('content')->first();
        return $data->content;
    }

    public static function product_grid($data,$pagi = true){
        return view('frontend.block.product_grid',compact('data','pagi'));
    }

    public static function product_box($data){
        return view('frontend.block.product_box',compact('data'));
    }

    public static function posts_box($data){
        return view('frontend.block.posts_box',compact('data'));
    }

    public static function product_box_list($data){
        return view('frontend.block.product_box_list',compact('data'));
    }

    public static function posts_grid($data,$pagi = true){
        return view('frontend.block.posts_grid',compact('data','pagi'));
    }

    public static function product_grid_home($data){
        return view('frontend.block.product_grid_home',compact('data'));
    }

    public static function menu($key_search = ''){
        $product_category = DB::table('product_category')->where(['status' => 1 ,'pos_top' => 1])->orderBy('order','desc')->orderBy('id','desc')->select('id','alias','name','image')->limit(4)->get();
        $data = DB::table('menu')->where(['status' => 1 , 'pos' => 0 , 'fk_parentid' => 0])->orderBy('order','desc')->orderBy('id','desc')->select('id','name','alias','cursor','fk_parentid','link')->get();//Lấy tất cả các FAQ trong CSDL
        //$data = AdminHelper::menu($data);
        
        $view = view('frontend.block.menu',compact('data','product_category','key_search'))->render();
        return $view; 
        
    }

    public static function menu_mobi(){
        
        $data = DB::table('menu')->where(['status' => 1 , 'pos' => 0])->orderBy('order','desc')->orderBy('id','desc')->select('id','name','alias','cursor','fk_parentid','link')->get();//Lấy tất cả các FAQ trong CSDL
        $data = AdminHelper::menu($data);
        
        $view = view('frontend.block.menu_mobi',compact('data'))->render();
        return $view; 
        
    }

    public static function cat_sidebar($data){
        $view = view('frontend.block.cat_sidebar',compact('data'))->render();
        return $view; 
        
    }

    public static function posts_sidebar($data){
        $view = view('frontend.block.posts_sidebar',compact('data'))->render();
        return $view; 
        
    }


    public static function menu_footer(){
        $data = DB::table('menu')->where(['status' =>1 , 'pos' => '1' ,'fk_parentid' => 0])->orderBy('order','desc')->orderBy('id','desc')->select('id','name','alias','cursor','fk_parentid')->limit(4)->get();
        return view('frontend.block.menu_footer',compact('data'));
    }

    public static function breadcrumbs($data){
        $data = implode(' / ', $data);

        return view('frontend.block.breadcrumbs',compact('data'));
    }

    public static function access(){
        function get_real_ip()
        {

            if (isset($_SERVER["HTTP_CLIENT_IP"]))
            {
                return $_SERVER["HTTP_CLIENT_IP"];
            }
            elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
            {
                return $_SERVER["HTTP_X_FORWARDED_FOR"];
            }
            elseif (isset($_SERVER["HTTP_X_FORWARDED"]))
            {
                return $_SERVER["HTTP_X_FORWARDED"];
            }
            elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]))
            {
                return $_SERVER["HTTP_FORWARDED_FOR"];
            }
            elseif (isset($_SERVER["HTTP_FORWARDED"]))
            {
                return $_SERVER["HTTP_FORWARDED"];
            }
            else
            {
                return $_SERVER["REMOTE_ADDR"];
            }
        }
        $time_now = time();    // lưu thời gian hiện tại
        $time_out = 600; // khoảng thời gian chờ để tính một kết nối mới (tính bằng giây)
        $ip_address = get_real_ip();    // lưu lại IP của kết nối

        $check = DB::select("SELECT `ip_address` FROM `counter` WHERE UNIX_TIMESTAMP(`last_visit`) + $time_out > $time_now AND `ip_address` = '$ip_address'");
        if(!count($check)){
            DB::table('counter')->insert(['ip_address' => $ip_address , 'last_visit' => date('Y-m-d H:i:s')]);
            //DB::select("INSERT INTO `counter` VALUES ('$ip_address', NOW())");
        }

        $online = DB::select("SELECT `ip_address` FROM `counter` WHERE UNIX_TIMESTAMP(`last_visit`) + $time_out > $time_now");
        $day = DB::select("SELECT `ip_address` FROM `counter` WHERE DAYOFYEAR(`last_visit`) = " . (date('z') + 1) . " AND YEAR(`last_visit`) = " . date('Y'));
        
        $month = DB::select("SELECT `ip_address` FROM `counter` WHERE MONTH(`last_visit`) = " . date('n') . " AND YEAR(`last_visit`) = " . date('Y'));
        $visit = DB::select("SELECT `ip_address` FROM `counter`");
        
       
        $data['online'] = count($online);
        $data['day'] = count($day);
        $data['month'] = count($month);
        $data['visit'] = count($visit);
        $view = view('frontend.block.access',compact('data'))->render();
        return $view; 
        
    }


}
