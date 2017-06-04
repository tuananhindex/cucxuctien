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
use Cache;
use Input;
use Auth;

class CategoryController extends Controller
{
	private $e = [
					'view' => 'backend.posts.category',
                    'route' => 'backend.posts.category',
                    'frontend_route' => 'posts_category',
                    'module' => 'danh mục bài viết',
                    'table' => 'posts_category',
                    'lang' => 'posts_category'
				];
    private $__acc;
    private $df_lang;
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
    	$cats = DB::table($this->e['table'])->join($this->e['table'].'_common',$this->e['table'].'.fk_commonid','=',$this->e['table'].'_common.id')->where('nation',$this->__acc->nation)->where('language',$lang_id)->select($this->e['table'].'.id','name','fk_parentid')->get();
    	$MultiLevelSelect = AdminHelper::MultiLevelSelect($cats);
        $tags = DB::table('tag')->where('status',1)->select('id','name','alias')->get();
    	return view($this->e['view'].'.add',compact('cats','MultiLevelSelect','tags'))->with(['e' => $this->e]);
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
        $data_private['language'] = $this->df_lang->id;
        
        // end

    	$data['alias'] = AdminHelper::check_alias($this->e['table'].'_common',$req->alias);

    	if($req->file('image')){
    		$image = $req->file('image');
            $image_name = $image->getClientOriginalName();
            // Kiểm tra tên file đã tồn tại trong folder upload hay chưa
            if(file_exists('upload/'.$this->e['table'].'/'.$image_name)){
                return redirect()->back()->with('alert',AdminHelper::alert_admin('danger','fa-ban','Ảnh đã tồn tại . Bạn vui lòng đổi tên ảnh'));
            }
            // end
            $image->move('upload/'.$this->e['table'],$image_name);
            $data['image'] = 'upload/'.$this->e['table'].'/'.$image_name;
    	}
    	
        if($req->tags){
            $data['tags'] = implode(',',$req->tags);
        }
        $data['IsDocument'] = $req->IsDocument;
        $data['show_date'] = $req->show_date;
    	$data['fk_parentid'] = $req->fk_parentid;
    	$data['order'] = $req->order;
        $data['meta_title'] = $req->meta_title;
    	$data['meta_description'] = $req->meta_description;
    	$data['meta_keywords'] = $req->meta_keywords;
        $data['nation'] = $this->__acc->nation;
        if($req->pos_home){
            $check = DB::table($this->e['table'].'_common')->where(['status' => 1 ,'pos_home' => $req->pos_home])->first();
            if(isset($check)){
                return redirect()->back()->with('alert',AdminHelper::alert_admin('danger','fa-ban','Vị trí này đã được sử dụng'));
            }
        }
        $data['pos_home'] = $req->pos_home;
    	$data['status'] = $req->status;
    	$data['create_at'] = date('Y-m-d H:i:s');
    	

    	$data_private['fk_commonid'] = DB::table($this->e['table'].'_common')->insertGetId($data);
        $id = DB::table($this->e['table'])->insertGetId($data_private);
        
    	if($req->save){
    		return redirect(route($this->e['route'].'.edit.get',$id))->with('alert',AdminHelper::alert_admin('success','fa-check','thêm thành công'));
    	}else{
    		return redirect(route($this->e['route'].'.add.get'))->with('alert',AdminHelper::alert_admin('success','fa-check','thêm thành công'));
    	}
    }

    public function edit_get($id,$lang = ''){
        $lang_id = DB::table('language')->where('nation',Session::get('locale'))->select('id')->first()->id;
        $cats = DB::table($this->e['table'])->join($this->e['table'].'_common',$this->e['table'].'.fk_commonid','=',$this->e['table'].'_common.id')->where('nation',$this->__acc->nation)->where('language',$lang_id)->select($this->e['table'].'.id','name','fk_parentid')->get();
        if(empty($lang)){
            $lang = $this->df_lang->id;
        }
    	$index = DB::table($this->e['table'])->join($this->e['table'].'_common','fk_commonid','=',$this->e['table'].'_common.id')->where([$this->e['table'].'.id' => $id ,'language' => $lang ,'nation' => $this->__acc->nation])->select('*',$this->e['table'].'.id as id')->first();
        $ids = AdminHelper::child_id($cats,$index->id);
        $count = DB::table('product')->whereIn('fk_catid',$ids)->count();
    	$this->e['action'] = ucfirst($index->name);
    	$MultiLevelSelect = AdminHelper::MultiLevelSelect($cats,0,'',$index->fk_parentid);
        $tags = DB::table('tag')->where('status',1)->select('id','name','alias')->get();
        // Lấy ra các ngôn ngữ đã có
        $has_languages = DB::table($this->e['table'])->where($this->e['table'].'.id' , $id )->select('language')->get();
        
        foreach ($has_languages as $key => $value) {
            $common_id[] = $value->language;
        }
        $languages = DB::table('language')->whereNotIn('id',$common_id)->where('status',1)->get();
        $languages2 = DB::table('language')->whereIn('id',$common_id)->where('status',1)->get();

        
    	return view($this->e['view'].'.edit',compact('index','cats','MultiLevelSelect','count','tags','languages2','languages'))->with(['e' => $this->e]);
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
        

    	// Những phần riêng
        $data_private['name'] = $req->name;
        $data_private['description'] = $req->description;
        
        // end
    	$data['alias'] = AdminHelper::check_alias($this->e['table'].'_common',$req->alias,$common->first()->id);
        //$data['alias'] = $req->alias;

    	
    	if($req->file('image')){
    		if(file_exists($index->first()->image)){
	    		unlink($index->first()->image);
	    	}
    		$image = $req->file('image');
            $image_name = $image->getClientOriginalName();
            // Kiểm tra tên file đã tồn tại trong folder upload hay chưa
            if(file_exists('upload/'.$this->e['table'].'/'.$image_name)){
                return redirect()->back()->with('alert',AdminHelper::alert_admin('danger','fa-ban','Ảnh đã tồn tại . Bạn vui lòng đổi tên ảnh'));
            }
            // end
            $image->move('upload/'.$this->e['table'],$image_name);
            $data['image'] = 'upload/'.$this->e['table'].'/'.$image_name;
    	}
        if($req->tags){
            $data['tags'] = implode(',',$req->tags);
        }else{
            $data['tags'] = '';
        }
        $data['IsDocument'] = $req->IsDocument;
        $data['show_date'] = $req->show_date;
    	$data['fk_parentid'] = $req->fk_parentid;
    	$data['order'] = $req->order;
        $data['meta_title'] = $req->meta_title;
    	$data['meta_description'] = $req->meta_description;
    	$data['meta_keywords'] = $req->meta_keywords;
        $data['nation'] = $this->__acc->nation;
        if($req->pos_home){
            $check = DB::table($this->e['table'].'_common')->where('id','!=',$common->first()->id)->where(['status' => 1 ,'pos_home' => $req->pos_home])->first();
            if(isset($check)){
                return redirect()->back()->with('alert',AdminHelper::alert_admin('danger','fa-ban','Vị trí này đã được sử dụng'));
            }
        }
        $data['pos_home'] = $req->pos_home;
    	$data['status'] = $req->status;
    	$data['update_at'] = date('Y-m-d H:i:s');
    	

    	$index->update($data_private);
        $common->update($data);
        
    	if($req->save){
    		return redirect(route($this->e['route'].'.edit.get',[$id,$lang]))->with('alert',AdminHelper::alert_admin('success','fa-check','cập nhật thành công'));
    	}else{
    		return redirect(route($this->e['route'].'.list.get'))->with('alert',AdminHelper::alert_admin('success','fa-check','cập nhật thành công'));
    	}
    }

    public function list_get($key = ''){
    	$this->e['action'] = 'Danh Sách';

        $languages = DB::table('language')->where('status',1)->get();
        $data = DB::table($this->e['table'])->join($this->e['table'].'_common',$this->e['table'].'.fk_commonid','=',$this->e['table'].'_common.id')->where('nation',$this->__acc->nation)->orderBy('order','desc')->orderBy($this->e['table'].'_common.id','desc')->select('*',$this->e['table'].'.id as id');

        if(Input::has('lang_id')){
            $data = $data->where('language',Input::get('lang_id'));
        }else{
            $data = $data->where('language',$this->df_lang->id);
        }

        //return dd($data->get());
        if(!empty($key)){
            if(Input::has('cat_id')){
                $MultiLevelSelect = AdminHelper::MultiLevelSelect($data->get(),0,'',Input::get('cat_id'));
                $data = $data->where('fk_parentid',Input::get('cat_id'));
            }else{
                $MultiLevelSelect = AdminHelper::MultiLevelSelect($data->get());
            }
            $data = $data->where('name','like','%'.$key.'%');
            $data = $data->get();
        }else{
            $data = $data->get();
            if(Input::has('cat_id')){
                $MultiLevelSelect = AdminHelper::MultiLevelSelect($data,0,'',Input::get('cat_id'));
                $data = AdminHelper::category_list_backend('posts',$data,Input::get('cat_id'));
            }else{
                $MultiLevelSelect = AdminHelper::MultiLevelSelect($data);
                $data = AdminHelper::category_list_backend('posts',$data);
            }
            
        }
        return view($this->e['view'].'.list',compact('data','key','MultiLevelSelect','languages'))->with(['e' => $this->e]);
    }

    public function list_post(Request $request){
        //return dd($request->all());
        if($request->show || $request->hide){
            $ids = $request->id;
            
            if(count($ids) == 0){
                return redirect()->back()->with(['alert' => AdminHelper::alert_admin('danger','fa-ban','Bạn chưa chọn bản ghi nào')]);
            }
            
            if($request->show){
                $status = 1;
            }else{
                $status = 0;
            }
            DB::table($this->e['table'])->join($this->e['table'].'_common',$this->e['table'].'.fk_commonid','=',$this->e['table'].'_common.id')->whereIn($this->e['table'].'.id',$ids)->update(['status' => $status]);

            
            
            return redirect()->back()->with(['alert' => AdminHelper::alert_admin('success','fa-check','Cập nhật trạng thái thành công')]);
        }else{
            $par = '';
            if($request->cat_id){
                //return 1;
                $par .= '?cat_id='.$request->cat_id;
                if($request->lang_id){
                    $par .= '&lang_id='.$request->lang_id;
                }
            }else{
                //return 2;
                if($request->lang_id){
                    $par .= '?lang_id='.$request->lang_id;
                }
            }
            return redirect(route($this->e['route'].'.list.get',$request->search).$par);
        }
        
    }

    public function delete($id){
    	$index = DB::table($this->e['table'])->where('id',$id);
        $common = DB::table($this->e['table'].'_common')->where('id',$index->first()->fk_commonid);
        
        if(file_exists($common->first()->image)){
            unlink($common->first()->image);
        }
        $index->delete();
        $common->delete();
        return redirect()->back()->with(['alert' => AdminHelper::alert_admin('success','fa-check','Xóa thành công')]);
        //return redirect()->back();
    }
}
