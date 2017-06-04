<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use View;
use App\Http\Helpers\AdminHelper;
use DB;
use Cache;
use Validator;
use Helper;

class MailSystemController extends Controller
{
    private $e = [
                    'view' => 'backend.mail_system',
                    'route' => 'backend.mail_system',
                    'module' => 'Mail System',
                    'table' => 'mail_system'
                ];
    public function __construct(){
        View::share('e',$this->e);
    }

    public function get(){
        $data = DB::table($this->e['table'])->first();
        return view($this->e['view'],compact('data'))->with(['e' => $this->e]);
    }

    public function post(Request $req){
        Cache::flush();
        $validator = Validator::make($req->all(), [
            'email' => 'email'
        ],[
            'email.email' => 'Email chưa đúng định dạng'
        ]);
        $error = $validator->errors()->first();
        if($error){
            return redirect()->back()->with('alert',Helper::alert_admin('danger','fa-ban',$error));
        }

        $data['email'] = $req->email;
        $data['password'] = $req->password;
        
        $check = DB::table($this->e['table'])->first();
        if(isset($check)){
            DB::table($this->e['table'])->update($data);
        }else{
            DB::table($this->e['table'])->insert($data);
        }
        
        return redirect(route($this->e['route'].'.get'))->with('alert',AdminHelper::alert_admin('success','fa-check','Lưu thành công'));
    }
}
