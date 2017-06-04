<?php

/**
* 
*/


namespace App\Http\Helpers;

use DB;
use Auth;
use Request;
use Route;
use Mail;

class AdminHelper{

	public static function reformatDate($date, $from_format = 'd/m/Y', $to_format = 'Y-m-d') {
        $date_aux = date_create_from_format($from_format, $date);
        return date_format($date_aux,$to_format);
    }

	public static function href_format($link,$cursor,$id){
		if($link){
            if(strpos($link, 'http')){
                $href = $link;
            }else{
                $href = asset($link);
            }
        }else{
            if(empty($cursor)){
                $href = 'javascript:void(0)';
            }else{
                $href = route('menu',$id);
            }
        }
        return $href;
	}

	public static function _substr($str, $length, $minword = 3)
	{
		$sub = '';
		$len = 0;
		foreach (explode(' ', $str) as $word)
		{
		    $part = (($sub != '') ? ' ' : '') . $word;
		    $sub .= $part;
		    $len += strlen($part);
		    if (strlen($word) > $minword && strlen($sub) >= $length)
		    {
		      break;
		    }
		}
		return $sub . (($len < strlen($str)) ? '...' : '');
	}

	public static function check_alias($table,$alias,$id = 0){

	    if($id == 0){

	        $check = DB::table($table)->where('alias','like','%'.$alias.'%')->select('alias')->get();

	    }else{

	        $check = DB::table($table)->where('alias','like','%'.$alias.'%')->whereNotIn('id',[$id])->select('alias')->get();

	    }



	    if(count($check) == 0){

	        return $alias;

	    }else{

	        $num = count($check) + 1;

	        return $alias.'-'.$num;

	    }

	}

	public static function send_mail_check($role){
		if($role == 'admin-content'){
            return 1;
        }else{
            $admin = DB::table('users')->where(['role' => 'admin-content' , 'status' => 1])->where('email','!=',null)->select('email')->get();
            if(isset($admin) && count($admin) > 0){
	            foreach ($admin as $key => $value) {
	                $data['email_check'][] = $value->email;
	            }

	            Mail::send('frontend.mail', $data, function($res) use ($data)
	            {
	                $res->from('tkhomejsc@gmail.com','Kiểm duyệt bài viết');
	                $res->to($data['email_check'])->subject('Kiểm duyệt bài viết');
	            });
	        }
	        return 0;
        }
    }

	public static function logs($content){
		$data['content'] = $content;
		$data['userId'] = Auth::user()->id;
		$data['userName'] = Auth::user()->name;
		$data['created_at'] = date('Y-m-d H:i:s');
		DB::table('logs')->insert($data);
	}

	public static function alert_admin($class,$class_i,$alert){

	    $return = ' <div class="alert alert-'.$class.' alert-custom alert-dismissible">

	                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

	                    <h4><i class="icon fa '.$class_i.'"></i> Thông Báo !</h4>

	                    '.ucfirst($alert).'.

	                </div>';

	    return $return;

	}


	public static function category_list_backend($obj,$arr,$parent = 0,$char = ''){
		$rs = '';
		foreach ($arr as $key => $val) {
			if($val->fk_parentid == $parent){
				$rs .=
					'<tr>
	                  <td><input type="checkbox" class="check_box" name="id[]" value="'.$val->id.'"></td>
	                  <td>';
              	if(file_exists($val->image)){

              	 	$rs .= '<img src="'.asset($val->image).'" width="100">';
              	}
              	$ids = self::child_has_id($arr,$val->id);
            	$count = DB::table($obj.'_category_rela')->whereIn('category_id',$ids)->selectRaw('DISTINCT posts_id')->get();
	            $rs .=      '</td><td><a href="'.route('backend.'.$obj.'.category.edit.get',[$val->id,$val->language]).'">'.$char.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.ucfirst($val->name).' ('.count($count).')</a></td><td><input type="number" name="price" min="0" style="width:45px !important" value="'.$val->order.'" /><img width="20" style="margin: 5px 10px 0 0 ; display: none" src="'.asset('assets/admin/img/loading.gif').'" id="loadding"></td>
	                  <td>'.date('h:i d/m/Y',strtotime($val->create_at)).'</td><td>';
	            	
	            	if(!empty($val->update_at)){
	            		$rs .= date('h:i d/m/Y',strtotime($val->update_at));
	            	}else{
	            		$rs.= 'Chưa có cập nhật';
	            	}
	            	$rs .= '</td><td>';
	            	if($val->status == 1){
	            		$rs .= '<span class="label label-success">Hiển Thị</span>';
	            	}else{
	            		$rs .= '<span class="label label-danger">Không Hiển Thị</span>';
	            	}
	                $rs .= '</td>';  
	                    
	            $rs .= 
	                  '<td>
	                    <a href="'.route('backend.'.$obj.'.category.edit.get',[$val->id,$val->language]).'"><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i></a>
	                  </td>
	                  <td>
	                    <a href="'.route('backend.'.$obj.'.category.delete',$val->id).'"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></a>
	                  </td>
	                </tr>';
	            $rs .= self::category_list_backend($obj,$arr,$val->id,$char.'&boxur;&boxh;');
			}
		}
		return $rs;
	}

	



	public static function MultiLevelSelect($arr,$parent = 0,$char='',$select = 0){

		$result = '';

		foreach ($arr as $value) {

			if($value->fk_parentid == $parent){
				$ids = self::child_has_id($arr,$value->id);
            	$count = DB::table('posts_category_rela')->whereIn('category_id',$ids)->selectRaw('DISTINCT posts_id')->get();
            	$a = '';
            	if($parent != 0){
            		$a = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            	}
            	if($select != 0 && $value->id == $select){

					$result .= '<option value="'.$value->id.'" selected="selected" >'.$char.$a.ucfirst($value->name).' ('.count($count).')</option>';

				}else{

					$result .= '<option value="'.$value->id.'">'.$char.$a.ucfirst($value->name).' ('.count($count).')</option>';

				}

				$result .= self::MultiLevelSelect($arr,$value->id,$char.$a,$select);

			}

		}

		return $result;

	}

	public static function MultiLevelSelect_frontend($arr,$parent = 0,$char='',$select = 0){

		$result = '';

		foreach ($arr as $value) {

			if($value->fk_parentid == $parent){
				
            	$a = '';
            	if($parent != 0){
            		$a = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            	}
            	if($select != 0 && $value->id == $select){

					$result .= '<option value="'.$value->id.'" selected="selected" >'.$char.$a.ucfirst($value->name).'</option>';

				}else{

					$result .= '<option value="'.$value->id.'">'.$char.$a.ucfirst($value->name).'</option>';

				}

				$result .= self::MultiLevelSelect_frontend($arr,$value->id,$char.$a,$select);

			}

		}

		return $result;

	}

	public static function MultiLevelSelectMenu($arr,$parent = 0,$char='',$select = 0){

		$result = '';

		foreach ($arr as $value) {

			if($value->fk_parentid == $parent){
				if($select != 0 && $value->id == $select){

					$result .= '<option value="'.$value->id.'" selected="selected" >'.$char.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.ucfirst($value->name).'</option>';

				}else{

					$result .= '<option value="'.$value->id.'">'.$char.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.ucfirst($value->name).'</option>';

				}

				$result .= self::MultiLevelSelectMenu($arr,$value->id,$char.'&boxur;&boxh;',$select);

			}

		}

		return $result;

	}

	// public static function MultiLevelSelect_frontend($arr,$parent = 0,$char='',$select = 0){

	// 	$result = '';

	// 	foreach ($arr as $value) {

	// 		if($value->fk_parentid == $parent){
	// 			$ids = self::child_id($arr,$value->id);
 //            	$count = DB::table('product')->whereIn('fk_catid',$ids)->count();
	// 			if($select != 0 && $value->id == $select){

	// 				$result .= '<option value="'.$value->alias.'" selected="selected" >'.$char.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.ucfirst($value->name).' ('.$count.')</option>';

	// 			}else{

	// 				$result .= '<option value="'.$value->alias.'">'.$char.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.ucfirst($value->name).' ('.$count.')</option>';

	// 			}

	// 			$result .= self::MultiLevelSelect_frontend($arr,$value->id,$char.'&boxur;&boxh;',$select);

	// 		}

	// 	}

	// 	return $result;

	// }


	public static function MultiLevelTreeData($table,$arr,$parent = 0,$select = []){
		$result = '';
		$result .= '<ul>';

		foreach ($arr as $value) {

			if($value->fk_parentid == $parent){
				$ids = self::child_has_id($arr,$value->id);
            	$count = DB::table('posts_category_rela')->whereIn('category_id',$ids)->selectRaw('DISTINCT posts_id')->get();
				if(count($select) > 0 && in_array($value->id , $select)){

					$result .= '<li id="'.$value->id.'" data-jstree=\'{ "selected" : true }\'>'.ucfirst($value->name).' ('.count($count).')';

				}else{

					$result .= '<li id="'.$value->id.'">'.ucfirst($value->name).' ('.count($count).')';

				}

				$result .= self::MultiLevelTreeData($table,$arr,$value->id,$select);
				$result .= '</li>';

			}

		}

		$result .= '</ul>';

		return $result;

	}

	







	public static function category_root($arr,$parent){

		$result = '';

		foreach ($arr as $value) {

			if($value->id == $parent){

				if($value->fk_parentid != 0){

					$result = self::category_root($arr,$value->fk_parentid);

				}else{

					$result = $value->id;

					break;

				}

				

				

			}



		}

		return $result;

	}



	



	public static function menu($arr,$parent = 0,$select = 0,$level = 1){
		$rs = '';
		if($parent != 0){
			$rs .= '<ul class="dropdown-menu">';
		}
        
        foreach ($arr as $key => $val) {
        	if($parent == 0){
        		$level = 1;
        	}
            if($val->fk_parentid == $parent){
                if(empty($val->cursor)){
                    $href = 'javascript:void(0)';
                }else{
                    $href = route('menu',$val->id);
                }
                $active = '';
                if(Request::url() == $val->link || in_array(Request::url(), self::child_alias($arr,$val->id))){
                	$active = 'active';
                }
                if(!empty(self::child_id($arr,$val->id))){
                	if($level > 1){
                		$rs .= '<li class="dropdown-submenu nav-item-lv'.$level.' '.$active.'">';
                	}else{
                		$rs .= '<li class="dropdown-submenu nav-item '.$active.'">';
                	}
                	
			        	$rs .= '<a class="nav-link" href="'.$href.'"> '. ucfirst ($val->name);
			        if($parent != 0){
						$rs .= ' <i class="fa fa-angle-right"></i>';
					}else{
						$rs .= ' <i class="fa fa-angle-down"></i>';
					}
	                
	                $rs .= '</a>';
	                $rs .= self::menu($arr,$val->id,$select,$level+=1);
	                $rs .= '</li>';
                }else{
                	if($parent == 0){
		        		$level = 1;
		        	}
                	if($level > 1){
                		$rs .= '<li class="nav-item-lv'.$level.' '.$active.'">';
                	}else{
                		$rs .= '<li class="nav-item '.$active.'">';	
                	}
                	
	                $rs .= '<a class="nav-link" href="'.$href.'"> '. ucfirst ($val->name);
	                $rs .= '</a>';
	                $rs .= '</li>';
		        }
                
                
            }
            
        }
        

        if($parent != 0){
            $rs .= '</ul>';
        }
        return $rs;
	}

	public static function cat_sidebar($arr,$parent = 0,$select = 0){
		$rs = '';
		if($parent != 0){
			$rs .= '<ul class="dropdown-menu">';
		}
		if(Route::currentRouteName() == 'product_category'){
			$route = 'product_category';
		}else{
			$route = 'posts.category';
		}
        
        foreach ($arr as $key => $val) {
        	
            if($val->fk_parentid == $parent){
                
                $active = '';
                // if(Request::url() == $val->link || in_array(Request::url(), self::child_alias($arr,$val->id))){
                // 	$active = 'active';
                // }
                if(!empty(self::child_id($arr,$val->id))){
            	    $rs .= '<li class="dropdown-submenu nav-item '.$active.'">';
					$rs .= '<i class="fa fa-caret-right"></i>';
		        	$rs .= '<a class="nav-link" href="'.route($route,$val->alias).'"> '. ucfirst ($val->name);
			       	$rs .= '</a>';
	                $rs .= ' <i class="fa fa-angle-down"></i>';
	                $rs .= self::cat_sidebar($arr,$val->id,$select);
	                $rs .= '</li>';
                }else{
                	
                	$rs .= '<li class="nav-item '.$active.'">';	
                	$rs .= '<i class="fa fa-caret-right"></i>';
	                $rs .= '<a class="nav-link" href="'.route($route,$val->alias).'"> '. ucfirst ($val->name);
	                $rs .= '</a>';
	                $rs .= '</li>';
		        }
                
                
            }
            
        }
        

        if($parent != 0){
            $rs .= '</ul>';
        }
        return $rs;
	}


	public static function sidebar($arr,$parent = 0,$select = 0){
		
		$result = '';

		if($parent == 0){

			$result .= '<ul class="sidebar-menu">';

		}else{

			
			$result .= '<ul>';

		}

		foreach ($arr as $value) {

			if($value->fk_parentid == $parent){
				
				

				if(count(self::child_id($arr,$value->id)) > 0){
					if($parent == 0){
						$result .= '<li class="has-child">
						<a class="parent" href="'.route('product_category',$value->alias).'" title="'.$value->name.'">'.$value->name.'</a>';
					}else{
						$result .= '<li class="has-child">
						<a class="parent" href="'.route('product_category',$value->alias).'" title="'.$value->name.'" >'.$value->name.'</a>';
					}
					

				}else{
					$result .= '<li class=" ">
					<a href="'.route('product_category',$value->alias).'" title="'.$value->name.'" > '.$value->name.'</a>';
				}

				$result .= self::sidebar($arr,$value->id,$select);

				$result .= '</li>';

			}

		}

		$result .= '</ul>';

		

		return $result;

	}

	public static function menu_product_category($arr,$parent = 0,$select = 0){
		$rs = '<ul class="dropdown-menu">';
        foreach ($arr as $key => $val) {
            if($val->fk_parentid == $parent){
                $href = route('product_category',$val->alias);
                if(!empty(self::child_id($arr,$val->id))){

                	$rs .= '<li class="dropdown">';
			        	$rs .= '<a href="'.$href.'"> '. ucfirst($val->name);
	                
		            $rs .= ' <span class="caret"></span>';
		            $rs .= '</a>';
	                $rs .= self::menu_product_category($arr,$val->id,$select);
	                $rs .= '</li>';
                }else{
                	$rs .= '<li>';
	                $rs .= '<a href="'.$href.'"> '. ucfirst($val->name);
	                $rs .= '</a>';
	                $rs .= '</li>';
		        }
                
                
            }
            
        }
        

        $rs .= '</ul>';
        return $rs;
	}

	public static function menu_mobi($arr,$parent = 0,$select = 0){
		$rs = '';
        if($parent != 0){
            $rs .= '<div class="collapse" id="menu_'.$parent.'">';
        }
        
        foreach ($arr as $key => $val) {
            if($val->fk_parentid == $parent){
                if(empty($val->cursor)){
                    $href = 'javascript:void(0)';
                }else{
                    $href = route('menu',$val->alias);
                }
                if($parent != 0){
		            $rs .= '<i class="fa fa-angle-right"></i>';
		        }
                if(!empty(self::child_id($arr,$val->id))){
                	if($parent != 0){
			            $rs .= '<a href="'.$href.'" target="_self" class="list-group-item-stmenu sub">
                            <i class="fa fa-angle-right"></i>'
                        . $val->name.'                           </a>';
			        }else{
			        	$rs .= '<a href="'.$href.'" target="_self" class="list-group-item-stmenu">'
                        . $val->name.'                           </a>';
			        }
	                
	                $rs .= '<a href="#menu_'.$val->id.'" data-toggle="collapse" class="arrow-sub">';
		            $rs .= '<i class="fa fa-angle-down"></i>';
                }else{
                	if($parent != 0){
                		$rs .= '<a href="'.$href.'" target="_self" class="list-group-item-stmenu sub">
            				<i class="fa fa-angle-right"></i>'
                        . $val->name.'                </a> ';
                	}else{
                		$rs .= '<a href="'.$href.'" target="_self" class="list-group-item-stmenu">'
                        . $val->name.'                </a> ';
                	}
                	
	                
		        }
                
                $rs .= self::menu_mobi($arr,$val->id,$select);
                
            }
            
        }
        

        if($parent != 0){
            $rs .= '</div>';
        }
        return $rs;
	}

	public static function menu_sidebar($arr,$parent = 0,$select = 0){
		$rs = '';
        if($parent != 0){
            $rs .= '<div  class="collapse" id="path_8_6937">';
        }
        
        foreach ($arr as $key => $val) {
            if($val->fk_parentid == $parent){
                if(empty($val->cursor)){
                    $href = 'javascript:void(0)';
                }else{
                    $href = route('menu',$val->alias);
                }
                if($parent != 0){
		            $rs .= '<i class="fa fa-angle-right"></i>';
		        }
                if(!empty(self::child_id($arr,$val->id))){
                	
	                $rs .= '<a href="'.$href.'" target="_self"  class="list-group-item-vmenu">
                            <i class="fa fa-angle-right"></i>'
                        . $val->name.'                           </a>';
	                $rs .= '<a href="'.$href.'" data-toggle="collapse" data-parent="#MainMenu" class="arrow-sub-vmenu">';
		            $rs .= '<i class="fa fa-angle-down"></i>';
                }else{
                	$rs .= '<a href="'.$href.'" target="_self" class="list-group-item-vmenu"'
                        . $val->name.'                </a> ';
	                
		        }
                
                $rs .= self::menu_sidebar($arr,$val->id,$select);
                
            }
            
        }
        

        if($parent != 0){
            $rs .= '</ul>';
        }
        return $rs;
	}



	public static function child_id_str($data,$id){

		$result = '';

		foreach ($data as $value) {

			if($value->fk_parentid == $id){
				$result .= $value->id.',';

				$result .= self::child_id_str($data,$value->id);

			}

			

		}

		return $result;

	}

	public static function child_id($data,$id){

		$str = self::child_id_str($data,$id);

		$arr = explode(',', $str);



		array_pop($arr);

		//$arr[] = $id;

		$arr = array_unique($arr);

		

		return $arr;

	}

	public static function child_alias_str($data,$id){

		$result = '';

		foreach ($data as $value) {

			if($value->fk_parentid == $id){
				$result .= $value->link.',';

				$result .= self::child_alias_str($data,$value->id);

			}

			

		}

		return $result;

	}

	public static function child_alias($data,$id){

		$str = self::child_alias_str($data,$id);

		$arr = explode(',', $str);



		array_pop($arr);

		//$arr[] = $id;

		$arr = array_unique($arr);

		

		return $arr;

	}

	public static function child_has_id($data,$id){

		$arr = self::child_id($data,$id);
		$arr[] = $id;

		

		return $arr;

	}

	public static function parent_id_str($data,$id){

		$result = '';

		foreach ($data as $value) {

			if($value->id == $id){

				$result .= $value->id.',';

				$result .= self::parent_id_str($data,$value->fk_parentid);

			}

			

		}

		return $result;

	}

	public static function parent_id($data,$id){

		$str = self::parent_id_str($data,$id);

		$arr = explode(',', $str);



		array_pop($arr);

		//$arr[] = $id;

		$arr = array_unique($arr);

		

		return $arr;

	}

	public static function parent_has_id($data,$id){

		$arr = self::parent_id($data,$id);
		$arr[] = $id;

		

		return $arr;

	}


	public static function duongdan_str($data,$id){

		$result = '';

		foreach ($data as $value) {

			if($value->id == $id){

				$result .= '<a href='.route('posts_category',$value->alias).'>'.ucfirst($value->name).'</a>,';

				$result .= self::duongdan_str($data,$value->fk_parentid);

			}

			

		}

		return trim($result,'/');

	}

	public static function duongdan($data,$id){

		$str = self::duongdan_str($data,$id);

		$arr = explode(',', $str);
		array_pop($arr);
		krsort($arr);

		$rs = implode(' / ', $arr);
		$rs = '<a href="'.route('home').'"><i class="fa fa-home"></i></a> / '.$rs;
		// $result .= '<a href='.route('posts_category',$value->alias).'>'.ucfirst($value->name).'</a> /';

		return $rs;

	}

	public static function parent_show_date_str($data,$id){

		$result = '';

		foreach ($data as $value) {

			if($value->id == $id){

				$result .= $value->show_date.',';

				$result .= self::parent_show_date_str($data,$value->fk_parentid);

			}

			

		}

		return $result;

	}

	public static function parent_show_date($data,$id){

		$str = self::parent_show_date_str($data,$id);

		$arr = explode(',', $str);



		array_pop($arr);

		//$arr[] = $id;

		$arr = array_unique($arr);

		

		return $arr;

	}

	public static function parent_has_show_date($data,$id){

		$arr = self::parent_show_date($data,$id);
		$arr[] = $id;

		

		return $arr;

	}

	public static function check_date_created($data,$catid){
		$cats = self::parent_has_show_date($data,$catid);
		foreach ($cats as $key => $value) {
			if(!$value){
				return false;
			}
		}
		return true;
	}
	

	public static function count_product($id){
		$cats = DB::table('product_category')->where(['status' => 1])->orderBy('order','desc')->orderBy('id','desc')->select('id','name','alias','fk_parentid')->get();
		$ids = self::child_has_id($cats,$id);
        $count = DB::table('product')->whereIn('id',DB::table('product_category_rela')->whereIn('category_id',$ids)->select('product_id'))->where('status',1)->count();
        return $count;
    }

	public static function time_stamp($time_ago)
 
	{
	 
		$cur_time=time();
		 
		$time_elapsed = $cur_time - $time_ago;
		 
		$seconds = $time_elapsed ;
		 
		$minutes = round($time_elapsed / 60 );
		 
		$hours = round($time_elapsed / 3600);
		 
		$days = round($time_elapsed / 86400 );
		 
		$weeks = round($time_elapsed / 604800);
		 
		$months = round($time_elapsed / 2600640 );
		 
		$years = round($time_elapsed / 31207680 );
		 
		// Seconds
		 
		if($seconds <= 60)
		 
		{
		 
		echo " Cách đây $seconds giây ";
		 
		}
		 
		//Minutes
		 
		else if($minutes <=60)
		 
		{
		 
		if($minutes==1)
		 
		{
		 
		echo " Cách đây 1 phút ";
		 
		}
		 
		else
		 
		{
		 
		echo " Cách đây $minutes phút";
		 
		}
		 
		}
		 
		//Hours
		 
		else if($hours <=24)
		 
		{
		 
		if($hours==1)
		 
		{
		 
		echo "Cách đây 1 tiếng ";
		 
		}
		 
		else
		 
		{
		 
		echo " Cách đây  $hours tiếng ";
		 
		}
		 
		}
		 
		//Days
		 
		else if($days <= 7)
		 
		{
		 
		if($days==1)
		 
		{
		 
		echo " Ngày hôm qua ";
		 
		}
		 
		else
		 
		{
		 
		echo " Cách đây  $days ngày ";
		 
		}
		 
		}
		 
		//Weeks
		 
		else if($weeks <= 4.3)
		 
		{
		 
		if($weeks==1)
		 
		{
		 
		echo " Cách đây 1 tuần ";
		 
		}
		 
		else
		 
		{
		 
		echo " Cách đây  $weeks tuần";
		 
		}
		 
		}
		 
		//Months
		 
		else if($months <=12)
		 
		{
		 
		if($months==1)
		 
		{
		 
		echo " Cách đây 1 tháng ";
		 
		}
		 
		else
		 
		{
		 
		echo " Cách đây $months tháng";
		 
		}
		 
		}
		 
		//Years
		 
		else
		 
		{
		 
		if($years==1)
		 
		{
		 
		echo " Cách đây 1 năm ";
		 
		}
		 
		else
		 
		{
		 
		echo date('d/m/Y',$time_ago);
		 
		}
		 
		}
		 
		}
	 


		
		
	}

	

	



?>