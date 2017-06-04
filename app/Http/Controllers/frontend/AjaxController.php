<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Request;
use DB;
use Validator;
use Cache;
use Auth;
use Session;
use App\Http\Helpers\AdminHelper;


class AjaxController extends Controller
{
   
    public function getsubcategory()
    {
        if(Request::ajax()) {
            $val = $_REQUEST['val'];
            $nation = $_REQUEST['nation'];
            $cats = DB::table('posts_category')->join('posts_category_common','posts_category'.'.fk_commonid','=','posts_category_common.id')->where('nation',$nation)->where('language',Session::get('lang_id'))->orderBy('order','desc')->orderBy('id','desc')->select('posts_category.id','name','fk_parentid')->get(); 
            $rs = ''; 
            $rs .= '<option value="0">Sub Category</option>'; 
            $rs .= AdminHelper::MultiLevelSelect($cats,$val);
            echo $rs;
        }
        //return 123;
    }

    
}
