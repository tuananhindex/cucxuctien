<?php

namespace App\Http\Controllers\backend\product;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use View;
use App\Http\Helpers\AdminHelper;
use DB;
use Validator;
use Session;
use Cache;
use Input;
use Auth;

class ProductController extends Controller
{
    private $e = [
                    'view' => 'backend.product.product',
                    'route' => 'backend.product.product',
                    'module' => 'sản phẩm',
                    'table' => 'product'
                ];
    public function __construct(){
        View::share('e',$this->e);
    }

    public function add_get(){
        // DB::table('product')->update(['price' => 0]);
        // die();
        $this->e['action'] = 'Thêm';
        $cats = DB::table($this->e['table'].'_category')->orderBy('order','desc')->orderBy('id','desc')->select('id','name','fk_parentid')->get();
        $MultiLevelTreeData = AdminHelper::MultiLevelTreeData($this->e['table'].'_category',$cats);
        $tags = DB::table('tag')->where('status',1)->select('id','name','alias')->get();


        return view($this->e['view'].'.add',compact('cats','MultiLevelTreeData','tags'))->with(['e' => $this->e]);
    }

    public function add_post(Request $req){
        Cache::flush();
        $validator = Validator::make($req->all(), [
            'name' => 'required',
            'alias' => 'required',
            'image.*' => 'image|max:1000'
        ],[
            'name.required' => 'Bạn chưa nhập tên',
            'alias.required' => 'Bạn chưa nhập đường dẫn ảo',
            'image.image' => 'File tải lên phải là ảnh',
            'image.max' => 'Ảnh tải lên vượt quá dung lượng cho phép'
        ]);
        $error = $validator->errors()->first();
        if($error){
            return redirect()->back()->with('alert',AdminHelper::alert_admin('danger','fa-ban',$error));
        }
        

        $data['name'] = $req->name;
        $data['code'] = $req->code;
        $data['alias'] = AdminHelper::check_alias($this->e['table'],$req->alias);
        $data['price'] = $req->price;
        if(explode(',', $req->fk_catId)) $data['fk_catid'] = explode(',', $req->fk_catId)[0];
        $data['special'] = $req->special;
        $data['order'] = $req->order;
        $data['promotion'] = $req->promotion;
        $data['index_order'] = $req->index_order;
        $data['description'] = $req->description;
        $data['baohanh'] = $req->baohanh;
        $data['tinhtrang'] = $req->tinhtrang;
        $data['vanchuyen'] = $req->vanchuyen;
        $data['nhasanxuat'] = $req->nhasanxuat;
        $data['chitietsanpham'] = $req->chitietsanpham;
        $data['thongsosanpham'] = $req->thongsosanpham;
        if($req->tags){
            $data['tags'] = implode(',',$req->tags);
        }
        $data['meta_title'] = $req->meta_title;
        $data['meta_description'] = $req->meta_description;
        $data['meta_keywords'] = $req->meta_keywords;
        $data['status'] = $req->status;
        $data['authId'] = Auth::user()->id;
        $data['authName'] = Auth::user()->name;
        $data['created_at'] = date('Y-m-d H:i:s');
        $id = DB::table($this->e['table'])->insertGetId($data);

        if($req->file('image')){
            foreach ($req->file('image') as $key => $image) {
                if($image == null){
                    break;
                }
                $image_name = $image->getClientOriginalName().'-'.date('H-i-s-d-m-Y');
                // Kiểm tra tên file đã tồn tại trong folder upload hay chưa
                $path = 'upload/'.$this->e['table'];
                // if(file_exists($path.'/'.$image_name)){
                //     return redirect()->back()->with('alert',AdminHelper::alert_admin('danger','fa-ban','Ảnh đã tồn tại . Bạn vui lòng đổi tên ảnh'));
                // }
                // end
                $image->move($path,$image_name);
                DB::table('product_image')->insert(['fk_productid' => $id , 'src' => $path.'/'.$image_name ,'created_at' => date('Y-m-d H:i:s') , 'isMain' => 0]);

            }
        }
        
        $obj = DB::table('product_image')->where(['fk_productid' => $id]);
        if($obj->first()){
            $obj->update(['isMain' => 1]);
            $data['image'] = DB::table('product_image')->where('id',$obj->first()->id)->select('src')->first()->src;

            DB::table($this->e['table'])->where('id',$id)->update(['image' => $data['image']]);
            //return $data['image'];
        }

        
        $fk_catId = explode(',', $req->fk_catId);
        foreach ($fk_catId as $key => $value) {
            DB::table('product_category_rela')->insert(['category_id' => $value , 'product_id' => $id]);
        }
        
        
        if($req->save){
            return redirect(route($this->e['route'].'.edit.get',$id))->with('alert',AdminHelper::alert_admin('success','fa-check','thêm thành công'));
        }else{
            return redirect(route($this->e['route'].'.add.get'))->with('alert',AdminHelper::alert_admin('success','fa-check','thêm thành công'));
        }
    }

    public function edit_get($id){
        $index = DB::table($this->e['table'])->where('id',$id)->first();
        $cats = DB::table($this->e['table'].'_category')->orderBy('order','desc')->orderBy('id','desc')->select('id','name','fk_parentid')->get();
        $fk_catId = DB::table('product_category_rela')->where('product_id',$id)->select('category_id')->get();
        if(count($fk_catId) > 0){
            foreach ($fk_catId as $key => $value) {
                $rs[] = $value->category_id;
            }
            $MultiLevelTreeData = AdminHelper::MultiLevelTreeData($cats,0,$rs);
        }else{
            $MultiLevelTreeData = AdminHelper::MultiLevelTreeData($cats,0);
        }
        $tags = DB::table('tag')->where('status',1)->select('id','name','alias')->get();

        $images = DB::table('product_image')->where('fk_productid',$id)->get();
        
        $this->e['action'] = $index->name;
        return view($this->e['view'].'.edit',compact('tags','index','cats','MultiLevelTreeData','images'))->with(['e' => $this->e]);
    }

    public function edit_post(Request $req,$id){
        //return dd($req->all());
        Cache::flush();
        $index = DB::table($this->e['table'])->where('id',$id);
        if(Auth::user()->role == 'content' &&  Auth::user()->id != $index->first()->authId){
            return redirect()->back()->with('alert',AdminHelper::alert_admin('danger','fa-ban','Bạn không thể cập nhật sản phẩm này'));
        }
        $validator = Validator::make($req->all(), [
            'name' => 'required',
            'alias' => 'required',
            'image.*' => 'image|max:1000'
        ],[
            'name.required' => 'Bạn chưa nhập tên',
            'alias.required' => 'Bạn chưa nhập đường dẫn ảo',
            'image.image' => 'File tải lên phải là ảnh',
            'image.max' => 'Ảnh tải lên vượt quá dung lượng cho phép'
        ]);
        $error = $validator->errors()->first();
        if($error){
            return redirect()->back()->with('alert',AdminHelper::alert_admin('danger','fa-ban',$error));
        }

        $data['name'] = $req->name;
        $data['code'] = $req->code;
        $data['alias'] = AdminHelper::check_alias($this->e['table'],$req->alias,$index->first()->id);
        $data['price'] = $req->price;
        $data['special'] = $req->special;
        if($req->tags){
            $data['tags'] = implode(',',$req->tags);
        }
        if($req->file('image')){
            foreach ($req->file('image') as $key => $image) {
                if($image == null){
                    break;
                }
                $image_name = $image->getClientOriginalName().'-'.date('H-i-s-d-m-Y');
                // Kiểm tra tên file đã tồn tại trong folder upload hay chưa
                $path = 'upload/'.$this->e['table'];
                // if(file_exists($path.'/'.$image_name)){
                //     return redirect()->back()->with('alert',AdminHelper::alert_admin('danger','fa-ban','Ảnh đã tồn tại . Bạn vui lòng đổi tên ảnh'));
                // }
                // end
                $image->move($path,$image_name);
                
                DB::table('product_image')->insert(['fk_productid' => $id , 'src' => $path.'/'.$image_name ,'created_at' => date('Y-m-d H:i:s') , 'isMain' => 0]);
            }
        }
        if($req->pk_img){
            DB::table('product_image')->update(['isMain' => 0]);
            $data['image'] = DB::table('product_image')->where('id',$req->pk_img)->select('src')->first()->src;
            DB::table('product_image')->where('id',$req->pk_img)->update(['isMain' => 1]);
        }

        $check_ismain = DB::table('product_image')->where(['fk_productid' => $id , 'isMain' => 1])->count();
        //return $check_ismain;
        if($check_ismain == 0){
            $obj = DB::table('product_image')->where(['fk_productid' => $id]);
            if($obj->first()){
                $obj->update(['isMain' => 1]);
                $data['image'] = DB::table('product_image')->where('id',$obj->first()->id)->select('src')->first()->src;
            }
        } 


        

        if(explode(',', $req->fk_catId)) $data['fk_catid'] = explode(',', $req->fk_catId)[0];
        $data['price'] = $req->price;
        $data['order'] = $req->order;
        $data['index_order'] = $req->index_order;
        $data['promotion'] = $req->promotion;
        $data['description'] = $req->description;
        $data['baohanh'] = $req->baohanh;
        $data['tinhtrang'] = $req->tinhtrang;
        $data['vanchuyen'] = $req->vanchuyen;
        $data['nhasanxuat'] = $req->nhasanxuat;
        $data['chitietsanpham'] = $req->chitietsanpham;
        $data['thongsosanpham'] = $req->thongsosanpham;
        $data['meta_title'] = $req->meta_title;
        $data['meta_description'] = $req->meta_description;
        $data['meta_keywords'] = $req->meta_keywords;
        $data['status'] = $req->status;
        $data['updated_at'] = date('Y-m-d H:i:s');
        

        $index->update($data);

        $obj = DB::table('product_category_rela');
        $obj->where('product_id' , $index->first()->id)->delete();
        $fk_catId = explode(',', $req->fk_catId);
        foreach ($fk_catId as $key => $value) {
            $obj->insert(['category_id' => $value , 'product_id' => $index->first()->id]);
        }

        
        if($req->save){
            return redirect(route($this->e['route'].'.edit.get',$id))->with('alert',AdminHelper::alert_admin('success','fa-check','cập nhật thành công'));
        }else{
            return redirect(route($this->e['route'].'.list.get'))->with('alert',AdminHelper::alert_admin('success','fa-check','cập nhật thành công'));
        }
    }

    public function list_get($key = ''){
        $this->e['action'] = 'Danh Sách';
        $cats = DB::table($this->e['table'].'_category')->orderBy('order','desc')->orderBy('id','desc')->select('id','fk_parentid','name')->get();
        if(Input::has('cat_id')){
            $MultiLevelSelect = AdminHelper::MultiLevelSelect($cats,0,'',Input::get('cat_id'));
        }else{
            $MultiLevelSelect = AdminHelper::MultiLevelSelect($cats);
        }

        $data = DB::table($this->e['table'])->orderBy('order','desc')->orderBy('id','desc');
        if(!empty($key)){
            $data = $data->where('name','like','%'.$key.'%');
        }
        if(Input::has('cat_id')){
            $ids = AdminHelper::child_id($cats,Input::get('cat_id'));
            $data = $data->whereIn('id',DB::table('product_category_rela')->whereIn('category_id',$ids)->select('product_id'));
        }
        //return dd($cats);
        $data = $data->select('id','name','image','created_at','updated_at','status','order','authName')->paginate(10);
        return view($this->e['view'].'.list',compact('data','MultiLevelSelect'), [
            'data' => $data->appends(Input::except('page'))
        ])->with(['e' => $this->e]);
    }

    public function list_user_get($key = ''){
        $this->e['action'] = 'Danh Sách';
        $cats = DB::table($this->e['table'].'_category')->orderBy('order','desc')->orderBy('id','desc')->select('id','fk_parentid','name')->get();
        if(Input::has('cat_id')){
            $MultiLevelSelect = AdminHelper::MultiLevelSelect($cats,0,'',Input::get('cat_id'));
        }else{
            $MultiLevelSelect = AdminHelper::MultiLevelSelect($cats);
        }
        $data = DB::table($this->e['table'])->orderBy('order','desc')->orderBy('id','desc')->where('authId',Auth::user()->id);
        if(!empty($key)){
            $data = $data->where('name','like','%'.$key.'%');
        }
        if(Input::has('cat_id')){
            $ids = AdminHelper::child_id($cats,Input::get('cat_id'));
            $data = $data->whereIn('id',DB::table('product_category_rela')->whereIn('category_id',$ids)->select('product_id'));
        }
        //return dd($cats);
        $data = $data->select('id','name','image','created_at','updated_at','status','order','authName')->paginate(10);
        return view($this->e['view'].'.list',compact('data','MultiLevelSelect'), [
            'data' => $data->appends(Input::except('page'))
        ])->with(['e' => $this->e]);
    }

    public function list_post(Request $request){
        Cache::flush();

        //return dd($request->all());
        if($request->show || $request->hide){
            $ids = $request->id;
            foreach ($ids as $key => $id) {
                $index = DB::table($this->e['table'])->where('id',$id)->select('id','name','authId')->first();
                if(Auth::user()->role == 'content' &&  Auth::user()->id != $index->authId){
                    return redirect()->back()->with('alert',AdminHelper::alert_admin('danger','fa-ban','Trong danh sách bạn chọn tồn tại sản phẩm bạn không thể cập nhật'));
                }
            }
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
        // DB::table($this->e['table'])->where('id',$id)->delete();
        // return redirect()->back()->with(['alert' => AdminHelper::alert_admin('success','fa-check','Xóa thành công')]);
        // return redirect()->back();
    }

    public function delete_img($id){
        $index = DB::table($this->e['table'].'_image')->where('id',$id);
        if(file_exists($index->first()->src)){
            unlink($index->first()->src);
        }
        $index->delete();
        return redirect()->back()->with(['alert' => AdminHelper::alert_admin('success','fa-check','Xóa thành công')]);
    }

   
}
