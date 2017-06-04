<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use View;
use App\Http\Helpers\AdminHelper;
use DB;
use Validator;
use Session;
use Cache;
use Auth;
use Input;

class MenuController extends Controller
{
	private $e = [
					'view' => 'backend.menu',
					'route' => 'backend.menu',
					'module' => 'Menu',
					'table' => 'menu',
                    'lang' => 'menu'
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

    	return view($this->e['view'].'.add',compact('cats','MultiLevelSelect'))->with(['e' => $this->e]);
    }

    public function add_post(Request $req){
        Cache::flush();
    	$validator = Validator::make($req->all(), [
            'name' => 'required',
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
        

    	$data_private['name'] = $req->name;
        $data_private['language'] = $this->df_lang->id;
    	
    	if($req->file('image')){
    		$image = $req->file('image');
	    	$image_name = time().'.'.$image->getClientOriginalExtension();
	    	$image->move('upload',$image_name);
	    	$data['image'] = 'upload/'.$image_name;
    	}
    	

    	$data['fk_parentid'] = $req->fk_parentid;
        $data['cursor'] = $req->cursor;
        $data['cursor_id'] = $req->cursor_id;

        if($data['cursor']){
            switch ($data['cursor']) {
                case 'posts':
                    $route = $data['cursor'];
                    $posts = DB::table($data['cursor'])->join($data['cursor'].'_common',$data['cursor'].'.fk_commonid','=',$data['cursor'].'_common.id')->where($data['cursor'].'.id',$data['cursor_id'])->select('alias','fk_catid')->first();
                    $cat = DB::table($data['cursor'].'_category')->join($data['cursor'].'_category_common',$data['cursor'].'_category.fk_commonid','=',$data['cursor'].'_category_common.id')->where($data['cursor'].'_category.id',$posts->fk_catid)->select('alias')->first();
                    if($posts && $cat){
                        $link = $cat->alias.'/'.$posts->alias;
                    }
                    break;
                case 'posts_category':
                    $route = $data['cursor'];
                    $obj = DB::table($data['cursor'])->join($data['cursor'].'_common',$data['cursor'].'.fk_commonid','=',$data['cursor'].'_common.id')->where($data['cursor'].'.id',$data['cursor_id'])->select('alias')->first();
                    if($obj){
                        $link = $obj->alias;
                    }
                    break;
                
                default:
                    
                    break;
            }
            $data['link'] = '';
            if(isset($link) && $link){
                $data['link'] = $link;
            }
        }
        $data['link2'] = $req->link2;
        $data['target'] = $req->target;
    	$data['order'] = $req->order;
        $data['pos'] = null;
        if($req->pos){
            $data['pos'] = $req->pos;
        }
        
    	$data['status'] = $req->status;
    	$data['create_at'] = date('Y-m-d H:i:s');
        $data['nation'] = $this->__acc->nation;
    	

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
    	$this->e['action'] = ucfirst($index->name);
        $data_cursor = !empty($index->cursor) ? DB::table($index->cursor)->join($index->cursor.'_common',$index->cursor.'.fk_commonid','=',$index->cursor.'_common.id')->select($index->cursor.'.id','name')->where(['language' => $lang_id , 'nation' => $index->nation])->get() : false;
        //return dd($data_cursor);
        $MultiLevelSelect = AdminHelper::MultiLevelSelect($cats,0,'',$index->fk_parentid);
        // Lấy ra các ngôn ngữ đã có
        $has_languages = DB::table($this->e['table'])->where($this->e['table'].'.id' , $id )->select('language')->get();
        
        foreach ($has_languages as $key => $value) {
            $common_id[] = $value->language;
        }
        $languages = DB::table('language')->whereNotIn('id',$common_id)->where('status',1)->get();
        $languages2 = DB::table('language')->whereIn('id',$common_id)->where('status',1)->get();

    	return view($this->e['view'].'.edit',compact('index','cats','MultiLevelSelect','data_cursor','languages2','languages'))->with(['e' => $this->e]);
    }

    public function edit_post(Request $req,$id,$lang = ''){
        Cache::flush();
        if(empty($lang)){
            $lang = $this->df_lang->id;
        }
    	$validator = Validator::make($req->all(), [
            'name' => 'required',
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
        
    	$data_private['name'] = $req->name;
    	
    	
    	if($req->file('image')){
    		if(file_exists($index->first()->image)){
	    		unlink($index->first()->image);
	    	}
    		$image = $req->file('image');
	    	$image_name = time().'.'.$image->getClientOriginalExtension();
	    	$image->move('upload',$image_name);
	    	$data['image'] = 'upload/'.$image_name;
    	}
        $data['link2'] = $req->link2;
        $data['target'] = $req->target;
    	$data['fk_parentid'] = $req->fk_parentid;
    	$data['order'] = $req->order;
        $data['cursor'] = $req->cursor;
        $data['cursor_id'] = $req->cursor_id;
        if($data['cursor']){
            switch ($data['cursor']) {
                case 'posts':
                    $route = $data['cursor'];
                    $posts = DB::table($data['cursor'])->join($data['cursor'].'_common',$data['cursor'].'.fk_commonid','=',$data['cursor'].'_common.id')->where($data['cursor'].'.id',$data['cursor_id'])->select('alias','fk_catid')->first();
                    $cat = DB::table($data['cursor'].'_category')->join($data['cursor'].'_category_common',$data['cursor'].'_category.fk_commonid','=',$data['cursor'].'_category_common.id')->where($data['cursor'].'_category.id',$posts->fk_catid)->select('alias')->first();
                    if($posts && $cat){
                        $link = $cat->alias.'/'.$posts->alias;
                    }
                    break;
                case 'posts_category':
                    $route = $data['cursor'];
                    $obj = DB::table($data['cursor'])->join($data['cursor'].'_common',$data['cursor'].'.fk_commonid','=',$data['cursor'].'_common.id')->where($data['cursor'].'.id',$data['cursor_id'])->select('alias')->first();
                    if($obj){
                        $link = $obj->alias;
                    }
                    break;
                
                default:
                    
                    break;
            }
            $data['link'] = '';
            if(isset($link) && $link){
                $data['link'] = $link;
            }
        }
        
        
        $data['pos'] = null;
        if($req->pos){
            $data['pos'] = $req->pos;
        }
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
        //return dd($data->first());
        if(Input::has('lang_id')){
            $data = $data->where('language',Input::get('lang_id'));
        }else{
            $data = $data->where('language',$this->df_lang->id);
        }

        if(Input::has('cat_id')){
            $MultiLevelSelect = AdminHelper::MultiLevelSelectMenu($data->get(),0,'',Input::get('cat_id'));
            $data = $data->where('fk_parentid',Input::get('cat_id'));
        }else{
            $MultiLevelSelect = AdminHelper::MultiLevelSelectMenu($data->get());
        }

        if(!empty($key)){
            $data = $data->where('name','like','%'.$key.'%');
        }
        $data = $data->paginate(10);
    	return view($this->e['view'].'.list',compact('data','MultiLevelSelect','languages'))->with(['e' => $this->e]);
    }

    public function list_post(Request $request){
        //return dd($request->all());
        if($request->show || $request->hide){
            $ids = $request->id;
            if(count($ids) == 0){
                return redirect()->back()->with(['alert' => AdminHelper::alert_admin('danger','fa-ban','Bạn chưa chọn bản ghi nào')]);
            }
            if(count($ids) == 0){
                return redirect()->back()->with(['alert' => AdminHelper::alert_admin('danger','fa-ban','Bạn chưa chọn bản ghi nào')]);
            }
            if(count($ids) == 0){
                return redirect()->back()->with(['alert' => AdminHelper::alert_admin('danger','fa-ban','Bạn chưa chọn bản ghi nào')]);
            }
            if(count($ids) == 0){
                return redirect()->back()->with(['alert' => AdminHelper::alert_admin('danger','fa-ban','Bạn chưa chọn bản ghi nào')]);
            }
            if($request->show){
                $status = 1;
            }else{
                $status = 0;
            }
            DB::table($this->e['table'])->whereIn('id',$ids)->update(['status' => $status]);
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
        
        
        $index->delete();
        $common->delete();
        return redirect()->back()->with(['alert' => AdminHelper::alert_admin('success','fa-check','Xóa thành công')]);
    }
}
