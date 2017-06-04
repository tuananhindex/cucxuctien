<?php

namespace App\Http\Controllers\backend\posts;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use View;
use App\Http\Helpers\AdminHelper;
use DB;
use Validator;
use Session;
use Input;
use Cache;
use Auth;

class PostsController extends Controller
{
    private $e = [
                    'view' => 'backend.posts.posts',
                    'route' => 'backend.posts.posts',
                    'frontend_route' => 'posts',
                    'module' => 'bài viết',
                    'table' => 'posts',
                    'lang' => 'posts'
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

    public function add_get(){
        
        $this->e['action'] = 'Thêm';
        $lang_id = DB::table('language')->where('nation',Session::get('locale'))->select('id')->first()->id;
        $cats = DB::table($this->e['table'].'_category')->join($this->e['table'].'_category_common',$this->e['table'].'_category'.'.fk_commonid','=',$this->e['table'].'_category_common.id')->where('nation',$this->__acc->nation)->where('language',$lang_id)->orderBy('order','desc')->orderBy('id','desc')->select($this->e['table'].'_category'.'.id','name','fk_parentid')->get();   
        $MultiLevelTreeData = AdminHelper::MultiLevelTreeData($this->e['table'].'_category',$cats);
        //$posts = DB::table($this->e['table'])->join($this->e['table'].'_common','fk_commonid','=',$this->e['table'].'_common.id')->where(['status' => 1 ,'language' => $this->df_lang->id])->select('name','alias')->get();
        $tags = DB::table('tag')->where('status',1)->select('id','name','alias')->get();

        return view($this->e['view'].'.add',compact('cats','MultiLevelTreeData','posts','tags'))->with(['e' => $this->e]);
    }

    public function add_post(Request $req){
        
        Cache::flush();
        $validator = Validator::make($req->all(), [
            'name' => 'required',
            'alias' => 'required',
            'image' => 'image|max:1000'
        ],[
            'name.required' => 'Bạn chưa nhập tên',
            'alias.required' => 'Bạn chưa nhập đường dẫn ảo',
            'image.image' => 'File tải lên phải là ảnh',
            'image.max' => 'Ảnh tải lên vượt quá dung lượng cho phép'
        ]);
        $error = $validator->errors()->first();
        if($error){
            return redirect()->back()->with('alert',AdminHelper::alert_admin('danger','fa-ban',$error));
        }
        
        // Những phần riêng
        $data_private['name'] = $req->name;
        $data_private['description'] = $req->description;
        $data_private['content'] = $req->content;
        $data_private['language'] = $this->df_lang->id;
        
        // end

        $data['alias'] = AdminHelper::check_alias($this->e['table'].'_common',$req->alias);

        if($req->file('image')){
            $image = $req->file('image');
            $image_name = time().'.'.$image->getClientOriginalExtension();
            $path = 'upload/'.$this->e['table'];
            $image->move($path,$image_name);
            $data['image'] = $path.'/'.$image_name;
        }
        

        
        if($req->tags){
            $data['tags'] = implode(',',$req->tags);
        }
        
        if(explode(',', $req->fk_catId)) $data['fk_catid'] = explode(',', $req->fk_catId)[0];        
        $data['order'] = $req->order;
        $data['authId'] = Auth::user()->id;
        $data['authName'] = Auth::user()->name;
        $data['meta_title'] = $req->meta_title;
        $data['meta_description'] = $req->meta_description;
        $data['meta_keywords'] = $req->meta_keywords;
        $data['nation'] = $this->__acc->nation;
        $data['status'] = AdminHelper::send_mail_check($this->__acc->role);
        $data['create_at'] = date('Y-m-d H:i:s');
        $data['IsEvent'] = $req->IsEvent;
        if($data['IsEvent']){
           // return $req->daterange;
            $arr = explode('-', $req->daterange);
            $data['startdate'] = str_replace('/','-',trim($arr[0]));
            $data['enddate'] = str_replace('/','-',trim($arr[1]));
        }
        $data['IsCustomer'] = 0;
        if(isset($req->IsCustomer)){
            $data['IsCustomer'] = $req->IsCustomer;
        }
        
        $data_private['fk_commonid'] = DB::table($this->e['table'].'_common')->insertGetId($data);
        $id = DB::table($this->e['table'])->insertGetId($data_private);

        $fk_catId = explode(',', $req->fk_catId);
        foreach ($fk_catId as $key => $value) {
            DB::table($this->e['table'].'_category_rela')->insert(['category_id' => $value , $this->e['table'].'_id' => $id]);
        }
        

        if($req->save){
            return redirect(route($this->e['route'].'.edit.get',$id))->with('alert',AdminHelper::alert_admin('success','fa-check','thêm thành công'));
        }else{
            return redirect(route($this->e['route'].'.add.get'))->with('alert',AdminHelper::alert_admin('success','fa-check','thêm thành công'));
        }
    }

    public function edit_get($id,$lang = ''){

        if(empty($lang)){
            $lang = $this->df_lang->id;
        }
        $lang_id = DB::table('language')->where('nation',Session::get('locale'))->select('id')->first()->id;
        $cats = DB::table($this->e['table'].'_category')->join($this->e['table'].'_category_common',$this->e['table'].'_category'.'.fk_commonid','=',$this->e['table'].'_category_common.id')->where('nation',$this->__acc->nation)->where('language',$lang_id)->orderBy('order','desc')->orderBy('id','desc')->select($this->e['table'].'_category'.'.id','name','fk_parentid')->get();   
        $fk_catId = DB::table($this->e['table'].'_category_rela')->where($this->e['table'].'_id',$id)->select('category_id')->get();
        if(count($fk_catId) > 0){
            foreach ($fk_catId as $key => $value) {
                $rs[] = $value->category_id;
            }
            $MultiLevelTreeData = AdminHelper::MultiLevelTreeData($this->e['table'].'_category',$cats,0,$rs);
        }else{
            $MultiLevelTreeData = AdminHelper::MultiLevelTreeData($this->e['table'].'_category',$cats,0);
        }
        $index = DB::table($this->e['table'])->join($this->e['table'].'_common','fk_commonid','=',$this->e['table'].'_common.id')->where([$this->e['table'].'.id' => $id ,'language' => $lang ,'nation' => $this->__acc->nation])->select('*',$this->e['table'].'.id as id')->first();

        //quyền 
        if($this->__acc->role == 'content' && $this->__acc->id != $index->authId){
            return redirect(route('backend.home'))->with('alert',AdminHelper::alert_admin('danger','fa-ban','Bạn chỉ có thể cập nhật bài viết bạn đăng lên'));
        }
        //
        
        $this->e['action'] = ucfirst($index->name);
       
        
        $tags = DB::table('tag')->where('status',1)->select('id','name','alias')->get();
        // Lấy ra các ngôn ngữ đã có
        $has_languages = DB::table($this->e['table'])->where($this->e['table'].'.id' , $id )->select('language')->get();
        
        foreach ($has_languages as $key => $value) {
            $common_id[] = $value->language;
        }
        $languages = DB::table('language')->whereNotIn('id',$common_id)->where('status',1)->get();
        $languages2 = DB::table('language')->whereIn('id',$common_id)->where('status',1)->get();

        

        return view($this->e['view'].'.edit',compact('index','posts_lang','cats','MultiLevelTreeData','posts','tags','languages','languages2'))->with(['e' => $this->e]);
    }

    public function edit_post(Request $req,$id,$lang = ''){

        Cache::flush();
        if(empty($lang)){
            $lang = $this->df_lang->id;
        }

        $validator = Validator::make($req->all(), [
            'name' => 'required',
            'alias' => 'required',
            'image' => 'image|max:1000'
        ],[
            'name.required' => 'Bạn chưa nhập tên',
            'alias.required' => 'Bạn chưa nhập đường dẫn ảo',
            'image.image' => 'File tải lên phải là ảnh',
            'image.max' => 'Ảnh tải lên vượt quá dung lượng cho phép'
        ]);
        $error = $validator->errors()->first();
        if($error){
            return redirect()->back()->with('alert',AdminHelper::alert_admin('danger','fa-ban',$error));
        }

        $index = DB::table($this->e['table'])->where(['id' => $id,'language' => $lang]);
        $common = DB::table($this->e['table'].'_common')->where('id',$index->first()->fk_commonid)->where('nation',$this->__acc->nation);
        // quyền
        if($this->__acc->role == 'content' && $this->__acc->id != $common->first()->authId){
            return redirect(route('backend.home'))->with('alert',AdminHelper::alert_admin('danger','fa-ban','Bạn chỉ có thể cập nhật bài viết bạn đăng lên'));
        }
        //
        
        

        $data_private['name'] = $req->name;
        $data_private['description'] = $req->description;
        $data_private['content'] = $req->content;

        $data['alias'] = AdminHelper::check_alias($this->e['table'].'_common',$req->alias,$common->first()->id);

        
        if($req->file('image')){
            if(file_exists($common->first()->image)){
                unlink($common->first()->image);
            }
            $image = $req->file('image');
            $image_name = time().'.'.$image->getClientOriginalExtension();
            $path = 'upload/'.$this->e['table'];
            $image->move($path,$image_name);
            $data['image'] = $path.'/'.$image_name;
        }

        if($req->tags){
            $data['tags'] = implode(',',$req->tags);
        }
        if(explode(',', $req->fk_catId)) $data['fk_catid'] = explode(',', $req->fk_catId)[0];
        $data['order'] = $req->order;
        $data['IsCustomer'] = 0;
        if(isset($req->IsCustomer)){
            $data['IsCustomer'] = $req->IsCustomer;
        }
        
        $data['meta_title'] = $req->meta_title;
        $data['meta_description'] = $req->meta_description;
        $data['meta_keywords'] = $req->meta_keywords;
        $data['update_at'] = date('Y-m-d H:i:s');
        if($this->__acc->role == 'admin-content'){
            $data['status'] = $req->status;
        }
        $data['IsEvent'] = $req->IsEvent;
        if($data['IsEvent']){
           // return $req->daterange;
            $arr = explode('-', $req->daterange);
            $data['startdate'] = str_replace('/','-',trim($arr[0]));
            $data['enddate'] = str_replace('/','-',trim($arr[1]));
        }

        
        $index->update($data_private);
        $common->update($data);

        $obj = DB::table($this->e['table'].'_category_rela');
        $obj->where($this->e['table'].'_id' , $index->first()->id)->delete();
        $fk_catId = explode(',', $req->fk_catId);
        foreach ($fk_catId as $key => $value) {
            $obj->insert(['category_id' => $value , $this->e['table'].'_id' => $index->first()->id]);
        }

        
        if($req->save){
            return redirect(route($this->e['route'].'.edit.get',[$id,$lang]))->with('alert',AdminHelper::alert_admin('success','fa-check','cập nhật thành công'));
        }else{
            return redirect(route($this->e['route'].'.list.get'))->with('alert',AdminHelper::alert_admin('success','fa-check','cập nhật thành công'));
        }
    }

    public function list_get($key = ''){
        $this->e['action'] = 'Danh Sách';
        if(isset($_GET['lang_id']) && $_GET['lang_id']){
            $lang = $_GET['lang_id'];
        }else{
            $lang = $this->df_lang->id;
        }
        $cats = DB::table($this->e['table'].'_category')->join($this->e['table'].'_category_common',$this->e['table'].'_category'.'.fk_commonid','=',$this->e['table'].'_category_common.id')->where('nation',$this->__acc->nation)->where('language',$lang)->orderBy('order','desc')->orderBy('id','desc')->select($this->e['table'].'_category'.'.id','name','fk_parentid')->get();        
        if(Input::has('cat_id')){
            $MultiLevelSelect = AdminHelper::MultiLevelSelect($cats,0,'',Input::get('cat_id'));
        }else{
            $MultiLevelSelect = AdminHelper::MultiLevelSelect($cats);
        }

        $languages = DB::table('language')->where('status',1)->get();
        
        $data = DB::table($this->e['table'])->join($this->e['table'].'_common','fk_commonid','=',$this->e['table'].'_common.id')->where('nation',$this->__acc->nation)->where('type',null);
        if($this->__acc->role == 'content'){
            $data = $data->where('authId',$this->__acc->id);
        }
        $data = $data->orderBy('order','desc')->orderBy($this->e['table'].'.id','desc');
        
        if(isset($_GET['cat_id']) && $_GET['cat_id']){
            $ids = AdminHelper::child_has_id($cats,Input::get('cat_id'));
            $data = $data->whereIn($this->e['table'].'.id',DB::table($this->e['table'].'_category_rela')->whereIn('category_id',$ids)->select($this->e['table'].'_id'));
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
        if(!empty($key)){
            $data = $data->where('name','like','%'.$key.'%')->orWhere('description','like','%'.$key.'%')->orWhere('content','like','%'.$key.'%');
        }
        $data = $data->select('image','name','create_at','authName','update_at','IsCustomer','status','order','language',$this->e['table'].'.id as id')->paginate(10);
        //return dd($data);
        return view($this->e['view'].'.list',compact('data','MultiLevelSelect','languages'), [
            'data' => $data->appends(Input::except('page'))
        ])->with(['e' => $this->e]);
    }

    public function list_user_get($key = ''){
        $this->e['action'] = 'Danh Sách';
        $cats = DB::table($this->e['table'].'_category')->where('status',1)->get();
        if(Input::has('cat_id')){
            $MultiLevelSelect = AdminHelper::MultiLevelSelect($cats,0,'',Input::get('cat_id'));
        }else{
            $MultiLevelSelect = AdminHelper::MultiLevelSelect($cats);
        }

        $languages = DB::table('language')->where('status',1)->get();
        
        
        $data = DB::table($this->e['table'])->join($this->e['table'].'_common','fk_commonid','=',$this->e['table'].'_common.id')->orderBy('order','desc')->orderBy($this->e['table'].'.id','desc')->where('authId',Auth::user()->id);
        if(!empty($key)){
            $data = $data->where('name','like','%'.$key.'%');
        }
        if(Input::has('cat_id')){
            $data = $data->where('fk_catid',Input::get('cat_id'));
        }
        if(Input::has('lang_id')){
            $data = $data->where('language',Input::get('lang_id'));
        }else{
            $data = $data->where('language',$this->df_lang->id);
        }
        $data = $data->select('image','name','create_at','update_at','status','language',$this->e['table'].'.id as id')->paginate(10);
        return view($this->e['view'].'.list',compact('data','MultiLevelSelect','languages'), [
            'data' => $data->appends(Input::except('page'))
        ])->with(['e' => $this->e]);
    }

    public function list_post(Request $request){
        //return dd($request->all());
        
        if($request->show || $request->hide){
            $ids = $request->id;
            if($request->show){
                $status = 1;
            }else{
                $status = 0;
            }
            if(count($ids) == 0){
                return redirect()->back()->with(['alert' => AdminHelper::alert_admin('danger','fa-ban','Bạn chưa chọn bản ghi nào')]);
            }
            foreach ($ids as $key => $id) {
                $index = DB::table($this->e['table'])->join($this->e['table'].'_common','fk_commonid','=',$this->e['table'].'_common.id')->where([$this->e['table'].'.id' => $id])->select('*',$this->e['table'].'.id as id')->first();
                if(Auth::user()->role == 'content' &&  Auth::user()->id != $index->authId){
                    return redirect()->back()->with('alert',AdminHelper::alert_admin('danger','fa-ban','Trong danh sách bạn chọn tồn tại sản phẩm bạn không thể cập nhật'));
                }
                DB::table($this->e['table'].'_common')->where('id',$index->fk_commonid)->update(['status' => $status]);
            }
            
            return redirect()->back()->with(['alert' => AdminHelper::alert_admin('success','fa-check','Cập nhật trạng thái thành công')]);
        }else{
            if($request->cat_id){
                $cat_id = $request->cat_id;
            }else{
                $cat_id = 0;
            }
            if($request->lang_id){
                $lang_id = $request->lang_id;
            }else{
                $lang_id = 0;
            }
            if($request->hot){
                $hot = $request->hot;
            }else{
                $hot = 0;
            }
            $par = '?cat_id='.$cat_id.'&lang_id='.$lang_id.'&hot='.$hot;
            return redirect(route($this->e['route'].'.list.get',$request->search).$par);
        }
        
    }

    public function delete($id,$lang = ''){
        $index = DB::table($this->e['table'])->where('id',$id);
        $common = DB::table($this->e['table'].'_common')->where('id',$index->first()->fk_commonid);
        if($this->__acc->role == 'content' && $common->first()->authId != $this->__acc->id){
            return redirect(route('backend.home'))->with('alert',AdminHelper::alert_admin('danger','fa-ban','Bạn chỉ có thể xóa bài viết bạn đăng lên'));
        }
        if(file_exists($common->first()->image)){
            unlink($common->first()->image);
        }
        DB::table('posts_category_rela')->where('posts_id',$index->first()->id)->delete();
        $index->delete();
        $common->delete();
        return redirect()->back()->with(['alert' => AdminHelper::alert_admin('success','fa-check','Xóa thành công')]);
        //return redirect()->back();
    }
}
