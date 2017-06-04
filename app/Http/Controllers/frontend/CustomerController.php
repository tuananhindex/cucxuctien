<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Gregwar\Captcha\CaptchaBuilder;
use DB;
use Validator;
use Session;
use Auth;
use View;
use Hash;

class CustomerController extends Controller
{
    private $__cus;

    public function __construct(){
        
        
        $this->__cus = Auth::guard('customer')->user();
        View::share('__cus', $this->__cus);
    }


    public function dangky(Request $req){
    	$validator = Validator::make($req->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:customers',
            'password' => 'required|confirmed|min:6',
            'image' => 'image|max:1000',
            'phone' => 'required',
            'captcha_xacnhan' => 'required'
        ],[
        	'name.required' => 'Bạn chưa nhập tên',
        	'email.required' => 'Bạn chưa nhập email',
        	'email.email' => 'Email không đúng định dạng',
        	'email.unique' => 'Email này đã được đăng ký',
        	'password.required' => 'Bạn chưa nhập mật khẩu',
        	'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
        	'password.confirmed' => 'Xác nhận mật khẩu không chính xác',
        	'image.image' => 'File tải lên phải là ảnh',
        	'image.max' => 'Ảnh tải lên vượt quá dung lượng cho phép',
        	'phone.required' => 'Bạn chưa nhập số điện thoại',
        	'captcha_xacnhan.required' => 'Bạn chưa nhập mã xác nhận',
        ]);

        $error = $validator->errors()->first();
        if(empty($error)){
        	$builder = new CaptchaBuilder;
	        $builder->setPhrase(Session::get('captchaPhrase'));
	        if(!$builder->testPhrase($req->captcha_xacnhan)) {
	            $error = 'Mã xác nhận không hợp lệ';
	        }
        }
        
        if($error){
        	$rs['msg'] = $error;
        	$rs['result'] = false;
        	return redirect()->back()->with('rs',$rs);
        }

        $data['name'] = $req->name;
        $data['phone'] = $req->phone;
        $data['email'] = $req->email;
        $data['password'] = bcrypt($req->password);
        $data['created_at'] = date('Y-m-d H:i:s');
        DB::table('customers')->insert($data);
        $rs['result'] = true;
        return redirect()->back()->with('rs',$rs);

    }

    public function dangnhap(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'captcha_xacnhan' => 'required'
        ],[
            'email.required' => 'Bạn chưa nhập email',
            'email.email' => 'Email không đúng định dạng',
            'captcha_xacnhan.required' => 'Bạn chưa nhập mã xác nhận',
        ]);

        $error = $validator->errors()->first();
        if(empty($error)){
            $builder = new CaptchaBuilder;
            $builder->setPhrase(Session::get('captchaPhrase2'));
            if(!$builder->testPhrase($request->captcha_xacnhan)) {
                $error = 'Mã xác nhận không hợp lệ';
            }
        }
        
        if($error){
            $rs['msg'] = $error;
            $rs['result'] = false;
            return redirect()->back()->with('rs_dangnhap',$rs);
        }

        $remember = 0;
        if($request->remember){
            $remember = 3600 * 3; //3 ngay`
        }
	    if (Auth::guard('customer')->attempt(['email' => $request->email, 'password' => $request->password ],$remember)) {
            // Authentication passed...
            $rs['result'] = true;
            return redirect()->back()->with('rs_dangnhap',$rs);
        }else{
        	$rs['result'] = false;
            $rs['msg'] = 'Sai tài khoản hoặc mật khẩu';
        	return redirect()->back()->with('rs_dangnhap',$rs);
        }
    }

    public function dangxuat(){
        Auth::guard('customer')->logout();
        return redirect(route('home'));
    }

    public function suadiachi(Request $req){
        DB::table('customers')->where('id',$this->__cus->id)->update(['address' => $req->address]);
        $rs['result'] = true;
        $rs['msg'] = 'Sửa địa chỉ thành công';
        return redirect(route('quanlycustomer'))->with('rs_quanly',$rs);
    }
    
    public function suadiachinhanhang(Request $req){
        DB::table('customers')->where('id',$this->__cus->id)->update(['df_address' => $req->diachinhanhang_df]);
        $rs['result'] = true;
        $rs['msg'] = 'Sửa địa chỉ nhận hàng mặc định thành công';
        return redirect(route('quanlycustomer'))->with('rs_quanly',$rs);
    }

    public function themdiachinhanhang(Request $req){
        DB::table('customer_address')->insert(['address' => $req->address , 'cus_id' => $this->__cus->id]);
        $rs['result'] = true;
        $rs['msg'] = 'Thêm địa chỉ nhận hàng thành công';
        return redirect(route('quanlycustomer'))->with('rs_quanly',$rs);
    }


    public function doimatkhau(Request $req){
        $validator = Validator::make($req->all(), [
            'password' => 'required|confirmed|min:6'
        ],[
            'password.required' => 'Bạn chưa nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'password.confirmed' => 'Xác nhận mật khẩu không chính xác'
        ]);
        $error = $validator->errors()->first();
        
        if($error){
            $rs['result'] = false;
            $rs['msg'] = $error;
            return redirect(route('quanlycustomer'))->with('rs_doimatkhau',$rs);
        }

        $data['password'] = bcrypt($req->password);

        DB::table('customers')->where('id',$this->__cus->id)->update($data);
        $rs['result'] = true;
        return redirect(route('quanlycustomer'))->with('rs_doimatkhau',$rs);
    }

    public function suathongtintaikhoan(Request $req){
        $validator = Validator::make($req->all(), [
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required'

        ],[
            'name.required' => 'Bạn chưa nhập tên',
            'address.required' => 'Bạn chưa nhập địa chỉ',
            'phone.required' => 'Bạn chưa nhập số điện thoại'
        ]);

        $error = $validator->errors()->first();

        
        if($error){
            $rs['result'] = false;
            $rs['msg'] = $error;
            return redirect(route('quanlycustomer'))->with('rs_suathongtintaikhoan',$rs);
        }

        $data['name'] = $req->name;
        $data['phone'] = $req->phone;
        $data['address'] = $req->address;

        DB::table('customers')->where('id',$this->__cus->id)->update($data);

        $rs['result'] = true;
        return redirect(route('quanlycustomer'))->with('rs_suathongtintaikhoan',$rs);

        
    }

    public function dangkynhanthongtin_get(){
        //return dd($this->__cus->email);
        $check['email'] = $this->__cus->email;
        $validator = Validator::make($check, [
            'email' => 'unique:nhanthongtin'
        ],[
            'email.unique' => 'Email này đã được đăng ký'
        ]);

        $error = $validator->errors()->first();

        if($error){
            $rs['result'] = false;
            $rs['msg'] = $error;
            return redirect(route('quanlycustomer'))->with('rs_dangkynhanthongtin',$rs);
        }

        DB::table('nhanthongtin')->insert(['email' => $this->__cus->email ,'hoten' => $this->__cus->name ,'sodienthoai' => $this->__cus->phone ]);
        $rs['result'] = true;
        $rs['msg'] = 'Đăng ký nhận thông tin thành công';
        return redirect(route('quanlycustomer'))->with('rs_dangkynhanthongtin',$rs);
    }

    public function dangkynhanthongtin_delete(){
        
        DB::table('nhanthongtin')->where('email',$this->__cus->email)->delete();
        $rs['result'] = true;
        $rs['msg'] = 'Bạn đã ngưng nhận thông báo bản tin từ chúng tôi';
        return redirect(route('quanlycustomer'))->with('rs_dangkynhanthongtin',$rs);
    }
}
