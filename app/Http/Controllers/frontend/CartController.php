<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Cart;
use Illuminate\Support\Facades\Auth;
use DB;
use Mail;
use Validator;

class CartController extends Controller
{
    private $__auth;
    private $__cart_count;

    public function __construct(){
        $this->middleware(function ($request, $next) {
            $this->__auth = Auth::guard('customer');
            if(Auth::guard('customer')->check()){
                $this->__cart_count = DB::table('cart')->where('customer_id',Auth::guard('customer')->user()->id)->selectRaw('SUM(qty) as total')->first()->total;
                if(!$this->__cart_count){
                    $this->__cart_count = 0;
                }
            }else{
                $this->__cart_count = Cart::count();
            }
            return $next($request);
        });
    }

    public function add_cart(Request $req){
    	

    	
    	try {
		    $data['name'] = $req->name;
		    $data['qty'] = $req->qty;
	    	$data['price'] = $req->price;
            if($this->__auth->check()){
                $data['product_id'] = $req->id;
                $data['image'] = $req->image;
                $data['customer_id'] = $this->__auth->user()->id;
                DB::table('cart')->insert($data);
            }else{
                $data['id'] = $req->id;
                $data['options']['image'] = $req->image;
                Cart::add($data);
            }
	    	
	    	$rs['result'] = true;
	    } catch (Exception $e) {
		    $rs['result'] = false;
		}
		return redirect()->back()->with('rs_cart',$rs);
    }

    

    public function delete_cart($rowId){
        if($this->__auth->check()){
            DB::table('cart')->where('id',$rowId)->delete();
        }else{
            Cart::remove($rowId);
        }
    	
    	$rs['result'] = true;
    	$rs['msg'] = 'Xóa thành công';
    	return redirect()->back()->with('rs_cart',$rs);
    }

    public function update_cart(Request $req){
    	foreach($req->all()['qty'] as $key => $val){
            if($this->__auth->check()){
                DB::table('cart')->where('id',$key)->update(['qty' => $val]);
            }else{
                Cart::update($key, $val);
            }
    		
    	}
    	$rs['result'] = true;
    	$rs['msg'] = 'Cập nhật giỏ hàng thành công';
    	return redirect()->back()->with('rs_cart',$rs);
    }

    public function destroy_cart(){
        if($this->__auth->check()){
            DB::table('cart')->where('customer_id',$this->__auth->user()->id)->delete();
        }else{
            Cart::destroy();
        }
    	
    	$rs['result'] = true;
    	$rs['msg'] = 'Xóa giỏ hàng thành công';
    	return redirect()->back()->with('rs_cart',$rs);
    }

    public function checkout_post(Request $req){
        if($this->__cart_count < 1){
            $rs['result'] = false;
            $rs['msg'] = 'Không có sản phẩm nào trong giỏ hàng';
            return redirect()->route('home')->with('rs_checkout',$rs);
        }
        try {

        	if(Auth::guard('customer')->check()){
                $a = true;
        		$cus = Auth::guard('customer')->user();
        		$data['ten'] = $cus->name;
        		$data['email'] = $cus->email;
        		$data['sodienthoai'] = $cus->phone;
        		$data['diachi'] = $cus->address;
        		$data['customer_id'] = $cus->id;
                $data['diachi'] = $req->diachi_select;
        		if($req->diachi){
        			$data['diachi'] = $req->diachi;
                    DB::table('customer_address')->insert(['cus_id' => $cus->id,'address' => $req->diachi]);;
        		}
                $cart_data = DB::table('cart')->groupBy('product_id')->where('customer_id',$this->__auth->user()->id)->orderBy('id','desc')->select('name','price','image','qty','id as rowId','product_id as id')->selectRaw('SUM(qty) as qty')->get();
                $data['tongtien'] = DB::table('cart')->where('customer_id',$this->__auth->user()->id)->orderBy('id','desc')->selectRaw('SUM(price * qty) as total')->first()->total;
                            
        	}else{
                $validator = Validator::make($req->all(), [
                    'ten' => 'required',
                    'email' => 'required|email',
                    'sodienthoai' => 'required',
                    'diachi' => 'required'
                ],[
                    'ten.required' => 'Bạn chưa nhập tên',
                    'email.required' => 'Bạn chưa nhập email',
                    'email.email' => 'Email không đúng định dạng',
                    'sodienthoai.required' => 'Bạn chưa nhập số điện thoại',
                    'diachi.required' => 'Bạn chưa nhập địa chỉ nhận hàng'
                    
                ]);

                $error = $validator->errors()->first();
                if($error){
                    $rs['msg'] = $error;
                    $rs['result'] = false;
                    return redirect()->route('checkout')->with('rs_checkout',$rs);
                }
                $a = false;
        		$data['ten'] = $req->ten;
        		$data['email'] = $req->email;
        		$data['sodienthoai'] = $req->sodienthoai;
        		$data['diachi'] = $req->diachi;
                $data['tongtien'] = str_replace(',','',Cart::subtotal(false));
        		$cart_data = Cart::content()->all();
        	}
        	$data['yeucaukhac'] = $req->yeucaukhac;
    		$data['madonhang'] = 'BW'.time();
    		$data['created_at'] = date('Y-m-d H:i:s');

        	$id = DB::table('donhang')->insertGetId($data);

        	foreach ($cart_data as $val) {
        		$data_chitiet['ten'] = $val->name;
                $data_chitiet['product_id'] = $val->id;
        		$data_chitiet['soluong'] = $val->qty;
                if($a){
                    $data_chitiet['anh'] = $val->image;
                }else{
                    $data_chitiet['anh'] = $val->options->image;
                }
        		
        		$data_chitiet['gia'] = $val->price;
        		$data_chitiet['donhang_id'] = $id;
        		$data['chitiet'][] = $data_chitiet;
        		DB::table('chitietdonhang')->insert($data_chitiet);
        	}
        	
        	//return dd($data);
        	
        	Mail::send('frontend.mail', $data, function($res) use ($data)
            {
            	$res->from($data['email'],'Đơn hàng TKHOME');
                $res->to('anhtuananh2008@gmail.com')->subject('Đơn hàng TKHOME');
            });
        } catch (Exception $e) {
            $rs['msg'] = 'Đặt hàng không thành công . Quý khách vui lòng thử lại';
            $rs['result'] = false;
            return redirect()->route('checkout')->with('rs_checkout',$rs);
        }

        if($a){
            DB::table('cart')->where('customer_id',$this->__auth->user()->id)->delete();
        }else{
            Cart::destroy();
        }
    	
    	$rs['result'] = true;
    	return redirect()->route('home')->with('rs_checkout',$rs);
    }

}
