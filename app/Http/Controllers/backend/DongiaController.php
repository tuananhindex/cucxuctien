<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class DongiaController extends Controller
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
    	$this->e['action'] = 'Thêm';
    	$data = DB::table('donhang')->get();
    	return view('backend.donhang.index',compact('data'))->with(['e' => $this->e]);
    }
}
