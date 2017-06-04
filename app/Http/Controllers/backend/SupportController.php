<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;
use Input;
use Cache;
use View;
use Validator;
use App\Http\Helpers\AdminHelper;

class SupportController extends Controller
{
    public $e = array(
        'module' => 'Hỗ trợ trực tuyến',
        'route' => 'backend.support',
        'view' => 'backend.support',
        'table' => 'support'
    );

    
    public function __construct(){
        View::share('e',$this->e);
    }

    public function add_get(){
        $this->e['action'] = 'Thêm';
        return view($this->e['view'].'.add',with(['e' => $this->e]));
    }

    public function add_post(Request $request){
        Cache::flush();
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'image' => 'image|max:1000',
            'mail' => 'email'
        ],[
            'name.required' => 'Bạn chưa nhập tên',
            'mail.email' => 'Email sai định dạng',
            'image.image' => 'File tải lên phải là ảnh',
            'image.max' => 'Ảnh tải lên vượt quá dung lượng cho phép'
        ]);
        $error = $validator->errors()->first();
        if($error){
            return redirect()->back()->with('alert',AdminHelper::alert_admin('danger','fa-ban',$error));
        }
        

        $data['name'] = $request->name;
	$data['order'] = $request->order;
        $data['phone'] = $request->phone;
        $data['skype'] = $request->skype;
        $data['mail'] = $request->mail;
        $data['status'] = $request->status;
        if($request->file('image')){
            $image = $request->file('image');
            $image_name = time().'.'.$image->getClientOriginalExtension();
            $path = 'upload/'.$this->e['table'];
            $image->move($path,$image_name);
            $data['image'] = $path.'/'.$image_name;
        }

        $id = DB::table($this->e['table'])->insertGetId($data);
        
        if($request->save){
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

    public function edit_post(Request $request,$id){
        Cache::flush();
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'image' => 'image|max:1000',
            'mail' => 'email'
        ],[
            'name.required' => 'Bạn chưa nhập tên',
            'mail.email' => 'Email sai định dạng',
            'image.image' => 'File tải lên phải là ảnh',
            'image.max' => 'Ảnh tải lên vượt quá dung lượng cho phép'
        ]);
        $error = $validator->errors()->first();
        if($error){
            return redirect()->back()->with('alert',AdminHelper::alert_admin('danger','fa-ban',$error));
        }
        $index = DB::table($this->e['table'])->where('id',$id);
        
        $data['name'] = $request->name;
	$data['order'] = $request->order;
        $data['phone'] = $request->phone;
        $data['skype'] = $request->skype;
        $data['mail'] = $request->mail;
        $data['status'] = $request->status;
        if($request->file('image')){
            if(file_exists($index->first()->image)){
                unlink($index->first()->image);
            }
            $image = $request->file('image');
            $image_name = time().'.'.$image->getClientOriginalExtension();
            $path = 'upload/'.$this->e['table'];
            $image->move($path,$image_name);
            $data['image'] = $path.'/'.$image_name;
        }

        $index->update($data);
        if($request->save){
            return redirect(route($this->e['route'].'.edit.get',$id))->with('alert',AdminHelper::alert_admin('success','fa-check','cập nhật thành công'));
        }else{
            return redirect(route($this->e['route'].'.list.get'))->with('alert',AdminHelper::alert_admin('success','fa-check','cập nhật thành công'));
        }
    }

    public function list_get(){
        $this->e['action'] = 'Danh Sách';
        $data = DB::table($this->e['table'])->orderBy('id','desc');
        if(!empty($key)){
            $data = $data->where('name','like','%'.$key.'%');
        }
        $data = $data->paginate(10);
        return view($this->e['view'].'.list',compact('data'))->with(['e' => $this->e]);
    }

    public function list_post(Request $request){
        Cache::flush();
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
            DB::table($this->e['table'])->whereIn('id',$ids)->update(['status' => $status]);
            return redirect()->back()->with(['alert' => AdminHelper::alert_admin('success','fa-check','Cập nhật trạng thái thành công')]);
        }else{
            return redirect(route($this->e['route'].'.list.get',$request->search));
        }
    }

    public function delete($id){
        Cache::flush();
        $index = DB::table($this->e['table'])->where('id',$id);
        if(file_exists($index->first()->image)){
            unlink($index->first()->image);
        }
        $index->delete();
        return redirect()->back()->with(['alert' => AdminHelper::alert_admin('success','fa-check','Xóa thành công')]);
    }
}
