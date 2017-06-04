<?php

namespace App\Http\Controllers\backend\product;

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

class TypeController extends Controller
{
	private $e = [
					'view' => 'backend.product.type',
					'route' => 'backend.product.type',
					'module' => 'loại sản phẩm',
					'table' => 'product_type'
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
            'name' => 'required',
            'alias' => 'required'
        ],[
        	'name.required' => 'Bạn chưa nhập tên',
        	'alias.required' => 'Bạn chưa nhập đường dẫn ảo'
        ]);
        $error = $validator->errors()->first();
        if($error){
        	return redirect()->back()->with('alert',AdminHelper::alert_admin('danger','fa-ban',$error));
        }
        

    	$data['name'] = $req->name;
    	$data['alias'] = AdminHelper::check_alias($this->e['table'],$req->alias);

    	
    	$data['order'] = $req->order;
    	$data['description'] = $req->description;
    	$data['meta_title'] = $req->meta_title;
    	$data['meta_description'] = $req->meta_description;
    	$data['meta_keywords'] = $req->meta_keywords;
    	$data['status'] = $req->status;
    	$data['created_at'] = date('Y-m-d H:i:s');
    	

    	$id = DB::table($this->e['table'])->insertGetId($data);
        $index = DB::table($this->e['table'])->where('id',$id)->select('id','name')->first();
        $logs = 'Thêm '.$this->e['module'].' <a href='.route($this->e['route'].'.edit.get',$id).'>'.$index->name.'</a>';
        AdminHelper::logs($logs);
    	if($req->save){
    		return redirect(route($this->e['route'].'.edit.get',$id))->with('alert',AdminHelper::alert_admin('success','fa-check','thêm thành công'));
    	}else{
    		return redirect(route($this->e['route'].'.add.get'))->with('alert',AdminHelper::alert_admin('success','fa-check','thêm thành công'));
    	}
    }

    public function edit_get($id){
    	
    	$index = DB::table($this->e['table'])->where('id',$id)->first();
        $count = DB::table('product')->where('fk_typeid',$id)->count();
    	$this->e['action'] = ucfirst($index->name);
    	
    	return view($this->e['view'].'.edit',compact('index','count'))->with(['e' => $this->e]);
    }

    public function edit_post(Request $req,$id){
        Cache::flush();
    	$validator = Validator::make($req->all(), [
            'name' => 'required',
            'alias' => 'required'
        ],[
        	'name.required' => 'Bạn chưa nhập tên',
        	'alias.required' => 'Bạn chưa nhập đường dẫn ảo'
        ]);
        $error = $validator->errors()->first();
        if($error){
        	return redirect()->back()->with('alert',AdminHelper::alert_admin('danger','fa-ban',$error));
        }

        $index = DB::table($this->e['table'])->where('id',$id);
        

    	$data['name'] = $req->name;
    	$data['alias'] = $req->alias;

    	
    	$data['order'] = $req->order;
    	$data['description'] = $req->description;
    	$data['meta_title'] = $req->meta_title;
    	$data['meta_description'] = $req->meta_description;
    	$data['meta_keywords'] = $req->meta_keywords;
    	$data['status'] = $req->status;
    	$data['updated_at'] = date('Y-m-d H:i:s');
    	

    	$index->update($data);
        $logs = 'Cập nhật '.$this->e['module'].' <a href='.route($this->e['route'].'.edit.get',$index->select('id','name')->first()->id).'>'.$index->first()->name.'</a>';
        AdminHelper::logs($logs);
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
            $data = $data->where('name','like','%'.$key.'%')->get();
        }else{
            $data = $data->get();
        }
        return view($this->e['view'].'.list',compact('data','key'))->with(['e' => $this->e]);
    }

    public function list_post(Request $request){
        //return dd($request->all());
        if($request->show || $request->hide){
            $ids = $request->id;
            $logs = '';
            foreach ($ids as $key => $id) {
                $index = DB::table($this->e['table'])->where('id',$id)->first();
                $logs .= '<a href='.route($this->e['route'].'.edit.get',$index->id).'>'.$index->name.'</a>,';
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

            $logs = trim($logs,',');
            $logs = 'Cập nhật trạng thái '.$this->e['module'].' '.$logs;
            AdminHelper::logs($logs);
            
            return redirect()->back()->with(['alert' => AdminHelper::alert_admin('success','fa-check','Cập nhật trạng thái thành công')]);
        }else{
            return redirect(route($this->e['route'].'.list.get',$request->search));
        }
        
    }

    public function delete($id){
    	$index = DB::table($this->e['table'])->where('id',$id);
        $logs = 'Xóa '.$this->e['module'].' <a href='.route($this->e['route'].'.edit.get',$index->select('id')->first()->id).'>'.$index->select('name')->first()->name.'</a>';
        AdminHelper::logs($logs);
        $index->delete();
        return redirect()->back()->with(['alert' => AdminHelper::alert_admin('success','fa-check','Xóa thành công')]);
        //return redirect()->back();
    }
}
