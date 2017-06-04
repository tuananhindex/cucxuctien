<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use View;
use Auth;
use Validator;
use DB;
use Helper;
use Hash;

class ProfileController extends Controller
{
	private $e = [
					'view' => 'backend.profile',
					'route' => 'backend.profile',
					'module' => 'Tài Khoản'
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
    	$acc = Auth::user();
    	//return dd($acc);
    	return view('backend.profile.index',compact('acc'));
    }

    public function edit(Request $req){
    	$validator = Validator::make($req->all(), [
            'name' => 'required',
            'email' => 'email|unique:users'
        ],[
        	'name.required' => 'Bạn chưa nhập tên',
        	'email.email' => 'Email chưa đúng định dạng',
            'email.unique' => 'Email này đã được đăng ký'
        ]);
        $error = $validator->errors()->first();
        if($error){
        	return redirect()->back()->with('alert',Helper::alert_admin('danger','fa-ban',$error));
        }


    	$data['name'] = $req->name;
    	$data['email'] = $req->email;
    	$data['phone'] = $req->phone;
    	$data['description'] = $req->description;
    	$data['updated_at'] = date('Y-m-d H:i:s');
    	DB::table('users')->where('id',$req->id)->update($data);

    	return redirect(route($this->e['route']))->with('alert',Helper::alert_admin('success','fa-check','cập nhật thành công'));
    }

    public function change_pw(Request $req){
    	$validator = Validator::make($req->all(), [
    		'password_old' => 'required',
            'password' => 'required|confirmed'
        ],[
        	'password_old.required' => 'Bạn chưa nhập mật khẩu cũ',
        	'password.required' => 'Bạn chưa nhập mật khẩu mới',
        	'password.confirmed' => 'Xác nhận mật khẩu mới không chính xác'
        ]);
        $error = $validator->errors()->first();
        if($error){
        	return redirect()->back()->with('alert',Helper::alert_admin('danger','fa-ban',$error));
        }

        //return Auth::user()->password.'<br>'.bcrypt('Tuananh93');
        //if(bcrypt($req->password_old) == Auth::user()->password){
        if(Hash::check($req->password_old,Auth::user()->password)){

        	DB::table('users')->where('id',$req->id)->update(['password' => bcrypt($req->password)]);
        	return redirect(route($this->e['route']))->with('alert',Helper::alert_admin('success','fa-check','cập nhật thành công'));
        }

    	
    	return redirect(route($this->e['route']))->with('alert',Helper::alert_admin('danger','fa-ban','Mật khẩu hiện tại không chính xác'));
    }

    public function change_img(Request $req){
    	$validator = Validator::make($req->all(), [
    		'image' => 'image|max:1000'
        ],[
        	'image.image' => 'File tải lên phải là ảnh',
        	'image.max' => 'Ảnh tải lên vượt quá dung lượng cho phép'
        ]);
        $error = $validator->errors()->first();
        if($error){
        	return redirect()->back()->with('alert',Helper::alert_admin('danger','fa-ban',$error));
        }

        $index = DB::table('users')->where('id',$req->id);
        if($req->file('image')){
    		if(file_exists($index->first()->image)){
	    		unlink($index->first()->image);
	    	}
    		$image = $req->file('image');
            $image_name = $image->getClientOriginalName();
            // Kiểm tra tên file đã tồn tại trong folder upload hay chưa
            if(file_exists('upload/profile/'.$image_name)){
                return redirect()->back()->with('alert',AdminHelper::alert_admin('danger','fa-ban','Ảnh đã tồn tại . Bạn vui lòng đổi tên ảnh'));
            }
            // end
            $image->move('upload/profile',$image_name);
            $data['image'] = 'upload/profile/'.$image_name;
    	}
    	$index->update($data);
    	return redirect(route($this->e['route']))->with('alert',Helper::alert_admin('success','fa-check','Cập nhật ảnh thành công'));
    }
}
