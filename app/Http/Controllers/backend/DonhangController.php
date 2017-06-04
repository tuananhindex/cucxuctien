<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Helpers\AdminHelper;
use DB;
use View;

class DonhangController extends Controller
{
	private $e = [
					'view' => 'backend.donhang',
					'route' => 'backend.donhang',
					'module' => 'Đơn hàng',
					'table' => 'donhang'
				];
	public function __construct(){
		View::share('e',$this->e);
	}


    public function index(){
    	$this->e['action'] = 'Danh sách';
    	$data = DB::table('donhang');
    	if(isset($_GET['search_key']) && $_GET['search_key']){
    		$data = $data->where('madonhang','like','%'.$_GET['search_key'].'%')->orWhere('ten','like','%'.$_GET['search_key'].'%')->orWhere('diachi','like','%'.$_GET['search_key'].'%');
    	}
    	$data = $data->orderBy('id','desc')->select('ten','tongtien','diachi','created_at','madonhang','id','trangthai')->selectRaw('(select count(id) from chitietdonhang where chitietdonhang.donhang_id = donhang.id) as somathang')->selectRaw('(select Sum(Soluong) from chitietdonhang where chitietdonhang.donhang_id = donhang.id) as sosanpham')->paginate(10);
    	$thongtindonhang = '';
        $chitietdonhang = '';
    	if(isset($_GET['madonhang']) && $_GET['madonhang']){
    		$thongtindonhang = DB::table('donhang')->where('madonhang',$_GET['madonhang'])->first();
            $chitietdonhang = DB::table('chitietdonhang')->where('donhang_id',$thongtindonhang->id)->select('product_id','ten','soluong','anh','gia')->get();
        }
    	//return dd($chitietdonhang);
    	return view('backend.donhang.index',compact('data','chitietdonhang','thongtindonhang'))->with(['e' => $this->e]);
    }

    public function trangthai(Request $request){
    	$ids = $request->id;
    	if(count($ids) == 0){
            return redirect()->back()->with(['alert' => AdminHelper::alert_admin('danger','fa-ban','Bạn chưa chọn bản ghi nào')]);
        }
    	if($request->success){
    		DB::table('donhang')->whereIn('id',$ids)->update(['trangthai' => 1]);
    	}elseif($request->cancel){
    		DB::table('donhang')->whereIn('id',$ids)->update(['trangthai' => 2]);
    	}else{
    		DB::table('donhang')->whereIn('id',$ids)->update(['trangthai' => NULL]);
    	}
        return redirect()->back()->with(['alert' => AdminHelper::alert_admin('success','fa-check','Cập nhật tình trạng thành công')]);
    }

    public function search_post(Request $request){

    }
}
