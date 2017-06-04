<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Request;
use DB;
use Validator;
use Cache;
use Auth;
use App\Http\Helpers\AdminHelper;
use Session;


class AjaxController extends Controller
{
   
    public function get_data_cursor()
    {
        $lang_id = DB::table('language')->where('nation',Session::get('locale'))->select('id')->first()->id;
            $data = DB::table($_GET['cursor'])->join($_GET['cursor'].'_common',$_GET['cursor'].'.fk_commonid','=',$_GET['cursor'].'_common.id')->where(['language' => $lang_id , 'nation' => Auth::user()->nation])->select($_GET['cursor'].'.id','name','fk_parentid')->get();
            $html = '';
            $html .= '<div class="form-group">';
            $html .= '<label>Đối tượng trỏ đến</label>';
            $html .= '<select class="form-control" name="cursor_id">';
            if($_GET['cursor'] == 'posts_category'){
                $html .= AdminHelper::MultiLevelSelect($data);
            }else{
                foreach ($data as $key => $value) {
                    $html .= '<option value="'.$value->id.'">'.ucfirst($value->name).'</option>';
                }
            }
            
            $html .= '</select>';
            $html .= '</div>';
            $html .= "<script type='text/javascript'>
                        var config = {
                          '.chosen-select'           : {},
                          '.chosen-select-deselect'  : {allow_single_deselect:true},
                          '.chosen-select-no-single' : {disable_search_threshold:10},
                          '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                          '.chosen-select-width'     : {width:'95%'}
                        }



                        $('select').chosen(config);

                        </script>";
            echo $html;
        //return 123;
    }

    public function add_lang(){
        if(Request::ajax()) {
            $table = $_POST['table'];
            unset($_POST['table']);
            unset($_POST['_token']);
            $validator = Validator::make($_POST, [
                'name' => 'required'
            ],[
                'name.required' => 'Bạn chưa nhập tên'
            ]);
            $error = $validator->errors()->first();
            if($error){
                $rs['status'] = 'error';
                $rs['message'] = $error;
                echo json_encode($rs);
                die();
            }

            DB::table($table)->insert($_POST);
            $rs['status'] = 'success';
            $rs['message'] = 'Thêm ngôn ngữ thành công';
            echo json_encode($rs);
        }
    }

    public function add_attr_product(){
        if(Request::ajax()) {

            $rs = [];
            if($_POST['fk_colorid'] == 0){
                $rs['message'] = 'Bạn chưa chọn màu';
                echo json_encode($rs);
                die();
            }
            //echo json_encode($_FILES);
            // Thực hiển validate ảnh
            $image = $_FILES['attr_image'];
            if($image['name']){
                $image_type = explode('/', $image['type'])[0];
                if($image_type != 'image'){
                    $rs['message'] = 'File tải lên phải là dạng ảnh';
                }
                $image_size_kb = $image['size'] / 1024;
                if($image_size_kb > 1000){
                    $rs['message'] = 'Dung lượng file tải lên không được quả 1000 KB';
                }
                if(empty($rs['message'])){

                    if(file_exists('upload/product/'.$image['name'])){
                        $un_unlink = true;
                        $rs['message'] = 'Ảnh đã tồn tại . Bạn vui lòng đổi tên ảnh';
                    }
                    $image_path = "upload/product/".$image['name'];
                    move_uploaded_file($image['tmp_name'], $image_path);
                }
            }
            
            
            $attr = DB::table('product_attr')->where(['fk_productid' => $_POST['fk_productid'],'fk_colorid' => $_POST['fk_colorid']]);
            if($attr->first()){
                if(isset($image_path)){
                    if(empty($un_unlink)){
                        if(file_exists($attr->first()->image)){
                            unlink($attr->first()->image);
                        }
                        $attr->update(['image' => $image_path , 'price' => $_POST['attr_price']]);
                        $rs['message'] = 'Cập nhật thành công';
                    }
                }else{

                    $attr->update(['price' => $_POST['attr_price']]);
                    $rs['message'] = 'Cập nhật thành công';
                }
                
            }else{
                if(isset($image_path)){
                    DB::table('product_attr')->insert(['fk_productid' => $_POST['fk_productid'],'fk_colorid' => $_POST['fk_colorid'],'image' => $image_path , 'price' => $_POST['attr_price']]);
                    $rs['message'] = 'Thêm thành công';
                }else{
                    $rs['message'] = 'Bạn chưa chọn ảnh';
                }
                
            }

            echo json_encode($rs);
        }
    }

    public function get_attr_product(){
        if(Request::ajax()) {
            $attr = DB::table('product_attr')->where(['fk_productid' => $_POST['fk_productid'],'fk_colorid' => $_POST['fk_colorid']])->first();
            $rs = [];
            if($attr){
                $rs['price'] = $attr->price;
                $rs['image'] = $attr->image;
            }
            echo json_encode($rs);

        }
    }

    
    public function check_code_product(){
        if(Request::ajax()) {
            $check = DB::table('product')->where('code',$_POST['val']);
            if(isset($_POST['id'])){
                $check = $check->whereNotIn('id',[$_POST['id']]);
            }
            $check = $check->select('code')->first();
            if(isset($check)){
                echo 1;
            }else{
                echo 0;
            }
        }
    }
    

    public function change_order(){
        Cache::flush();
        if(Request::ajax()) {
            $index = DB::table($_POST['table'])->join($_POST['table'].'_common','fk_commonid','=',$_POST['table'].'_common.id')->where($_POST['table'].'.id',$_POST['id']);
            
            $index->update(['order' => $_POST['val']]);
            if($_POST['table'] == 'product'){
                $module = 'sản phẩm';
                $route = 'backend.product.product';
            }elseif($_POST['table'] == 'product_category'){
                $module = 'danh mục sản phẩm';
                $route = 'backend.product.category';
            }elseif($_POST['table'] == 'posts_category'){
                $module = 'danh mục bài viết';
                $route = 'backend.posts.category';
            }elseif($_POST['table'] == 'posts'){
                $module = 'bài viết';
                $route = 'backend.posts.posts';
            }
            
        }
    }
}
