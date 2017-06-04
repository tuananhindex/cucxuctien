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

class ImgLibController extends Controller
{
	private $e = [
					'view' => 'backend.img_lib',
					'route' => 'backend.img_lib',
					'module' => 'thư viện ảnh',
					'table' => 'img_lib'
				];
	public function __construct(){
		View::share('e',$this->e);
	}

    public function add_get(){
    	$this->e['action'] = 'Thêm';
    	
    	return view($this->e['view'].'.add')->with(['e' => $this->e]);
    }

    public function add_post(Request $req){
        Cache::flush();
    	$validator = Validator::make($req->all(), [
            'image.*' => 'image|max:1000'
        ],[
        	'image.*.image' => 'File tải lên phải là ảnh',
        	'image.*.max' => 'Ảnh tải lên vượt quá dung lượng cho phép'
        ]);
        $error = $validator->errors()->first();
        if($error){
        	return redirect()->back()->with('alert',AdminHelper::alert_admin('danger','fa-ban',$error));
        }
        

    	$data['name'] = $req->name;
        $data['alias'] = $req->alias;
    	$data['status'] = $req->status;
        $data['create_at'] = date('Y-m-d H:i:s');
        $id = DB::table($this->e['table'])->insertGetId($data);
        if(count($req->file('image')) > 0){
            foreach ($req->file('image') as $key => $image) {
                if($image == null){
                    break;
                }
                $image_name = time().'.'.$image->getClientOriginalExtension();
                $image->move('upload/mauthietke',$image_name);
                $data_details['image'] = 'upload/mauthietke/'.$image_name;
                $data_details['img_lib_id'] = $id;
                DB::table($this->e['table'].'_details')->insertGetId($data_details);
                sleep(1);
            }
    	}
    	
        
    	return redirect(route($this->e['route'].'.list.get'))->with('alert',AdminHelper::alert_admin('success','fa-check','thêm thành công'));
    }

    public function edit_get($id){
    	$index = DB::table($this->e['table'])->where('id',$id)->first();
        $images = DB::table($this->e['table'].'_details')->where('img_lib_id',$index->id)->orderBy('id','desc')->get();
        $this->e['action'] = ucfirst($index->name);
    	
    	return view($this->e['view'].'.edit',compact('index','images'))->with(['e' => $this->e]);
    }

    public function edit_post(Request $req,$id){
        Cache::flush();
    	$validator = Validator::make($req->all(), [
            'image.*' => 'image|max:1000'
        ],[
            'image.*.image' => 'File tải lên phải là ảnh',
            'image.*.max' => 'Ảnh tải lên vượt quá dung lượng cho phép'
        ]);
        $error = $validator->errors()->first();
        if($error){
        	return redirect()->back()->with('alert',AdminHelper::alert_admin('danger','fa-ban',$error));
        }

        $index = DB::table($this->e['table'])->where('id',$id);
        

    	$data['name'] = $req->name;
    	$data['alias'] = $req->alias;
    	if(count($req->file('image')) > 0){
            foreach ($req->file('image') as $key => $image) {
                if($image == null){
                    break;
                }
                $image_name = time().'.'.$image->getClientOriginalExtension();
                $image->move('upload/mauthietke',$image_name);
                $data_details['image'] = 'upload/mauthietke/'.$image_name;
                $data_details['img_lib_id'] = $id;
                DB::table($this->e['table'].'_details')->insertGetId($data_details);
                sleep(1);
            }
        }
    	$data['order'] = $req->order;
        $data['status'] = $req->status;
    	$data['update_at'] = date('Y-m-d H:i:s');
    	

    	$index->update($data);
    	if($req->save){
    		return redirect(route($this->e['route'].'.edit.get',$id))->with('alert',AdminHelper::alert_admin('success','fa-check','cập nhật thành công'));
    	}else{
    		return redirect(route($this->e['route'].'.list.get'))->with('alert',AdminHelper::alert_admin('success','fa-check','cập nhật thành công'));
    	}
    }

    public function list_get($key = ''){
    	$this->e['action'] = 'Danh Sách';
    	$data = DB::table($this->e['table'])->orderBy('order','desc')->orderBy('id','desc');
        if(!empty($key)){
            $data = $data->where('name','like','%'.$key.'%');
        }
        $data = $data->paginate(10);
    	return view($this->e['view'].'.list',compact('data'))->with(['e' => $this->e]);
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
            DB::table($this->e['table'])->whereIn('id',$ids)->update(['status' => $status]);
            return redirect()->back()->with(['alert' => AdminHelper::alert_admin('success','fa-check','Cập nhật trạng thái thành công')]);
        }else{
            return redirect(route($this->e['route'].'.list.get',$request->search));
        }
        
    }

    public function delete($id){
        // DB::table($this->e['table'])->where('id',$id)->delete();
     //    return redirect()->back()->with(['alert' => AdminHelper::alert_admin('success','fa-check','Xóa thành công')]);
        return redirect()->back();
    }

    public function delete_img($id){
        $index = DB::table($this->e['table'].'_details')->where('id',$id);
        if(file_exists($index->first()->image)){
            unlink($index->first()->image);
        }
        $index->delete();
        return redirect()->back()->with(['alert' => AdminHelper::alert_admin('success','fa-check','Xóa thành công')]);
    }
}
