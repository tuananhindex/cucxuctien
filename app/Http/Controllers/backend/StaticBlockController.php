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

class StaticBlockController extends Controller
{
	private $e = [
					'view' => 'backend.static_block',
					'route' => 'backend.static_block',
                    'module' => 'Block tĩnh',
					'table' => 'static_block'
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
            'position' => 'required'
        ],[
            'name.required' => 'Bạn chưa nhập tên',
            'position.required' => 'Bạn chưa nhập thứ tự'
        ]);
        $error = $validator->errors()->first();
        if($error){
            return redirect()->back()->with('alert',AdminHelper::alert_admin('danger','fa-ban',$error));
        }
    	$data['name'] = $req->name;
    	$data['content'] = $req->content;
        $data['position'] = $req->position;
        $data['status'] = 1;
    	$data['create_at'] = date('Y-m-d H:i:s');
    	

    	$id = DB::table($this->e['table'])->insertGetId($data);
    	if($req->save){
    		return redirect(route($this->e['route'].'.edit.get',$id))->with('alert',AdminHelper::alert_admin('success','fa-check','thêm thành công'));
    	}else{
    		return redirect(route($this->e['route'].'.add.get'))->with('alert',AdminHelper::alert_admin('success','fa-check','thêm thành công'));
    	}
    }

    public function edit_get($id){
    	
    	$index = DB::table($this->e['table'])->where('id',$id)->first();
    	$this->e['action'] = ucfirst($index->name);
    	
    	return view($this->e['view'].'.edit',compact('index'))->with(['e' => $this->e]);
    }

    public function edit_post(Request $req,$id){
    	Cache::flush();
         $validator = Validator::make($req->all(), [
            'name' => 'required'
        ],[
            'name.required' => 'Bạn chưa nhập tên'
        ]);
        $error = $validator->errors()->first();
        if($error){
            return redirect()->back()->with('alert',AdminHelper::alert_admin('danger','fa-ban',$error));
        }
        $index = DB::table($this->e['table'])->where('id',$id);
        

    	$data['name'] = $req->name;
        $data['content'] = $req->content;
        $data['status'] = 1;
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
    	$data = DB::table($this->e['table'])->orderBy('id','desc');
        if(!empty($key)){
            $data = $data->where('name','like','%'.$key.'%')->orWhere('content','like','%'.$key.'%');
        }
        $data = $data->paginate(10);
    	return view($this->e['view'].'.list',compact('data'))->with(['e' => $this->e]);
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
            return redirect(route($this->e['route'].'.list.get',$request->search));
        }
        
    }

    public function delete($id){
        Cache::flush();
        $index = DB::table($this->e['table'])->where('id',$id);
        
        $index->delete();
        return redirect()->back()->with(['alert' => AdminHelper::alert_admin('success','fa-check','Xóa thành công')]);
    }
}
