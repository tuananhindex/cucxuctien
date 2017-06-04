<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use View;
use App\Http\Helpers\AdminHelper;
use DB;
use Cache;

class MetaController extends Controller
{
    private $e = [
					'view' => 'backend.meta_default',
					'route' => 'backend.meta_default',
					'module' => 'Meta mặc định',
					'table' => 'meta_default'
				];
	public function __construct(){
		View::share('e',$this->e);
	}

    public function get(){
    	$data = DB::table('meta_default')->first();
    	return view($this->e['view'],compact('data'))->with(['e' => $this->e]);
    }

    public function post(Request $req){
        Cache::flush();
    	$data['title'] = $req->title;
    	$data['description'] = $req->description;
    	$data['keywords'] = $req->keywords;

    	$check = DB::table('meta_default')->first();
    	if(isset($check)){
    		DB::table($this->e['table'])->update($data);
    	}else{
    		DB::table($this->e['table'])->insert($data);
    	}
    	
    	return redirect(route($this->e['route'].'.get'))->with('alert',AdminHelper::alert_admin('success','fa-check','Lưu thành công'));
    }
}
