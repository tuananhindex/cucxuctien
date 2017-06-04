@extends('backend.master')
@section('content')
<!-- Content Header (Page header) -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets\admin\plugins\jstree\dist\themes\default\style.min.css') }}">
<section class="content-header">
	<h1>
		{{ ucwords($e['module']) }}
	</h1>
	<ol class="breadcrumb">
		<li><a href="{{ route('backend.home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="<?php echo route($e['route'].'.list.get') ?>">{{ ucwords($e['module']) }}</a></li>
		<li class="active">{{ ucwords($e['action']) }}</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			@if(Session::has('alert'))
			{!! Session::get('alert') !!}
			@endif
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">{{ ucwords($e['action']) }}</h3>
				</div>
				<!-- /.box-header -->
				<!-- form start -->
				<form method="post" enctype="multipart/form-data">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="box-body">
						<div class="form-group">
							<label>Tên</label>
							<input type="text" class="form-control" name="name" placeholder="Nhập tên" required="">
						</div>
						<div class="form-group">
							<label>Đường Dẫn Ảo</label>
							<input type="text" class="form-control add-alias" name="alias" placeholder="Nhập đường dẫn ảo" required="">
						</div>
						<div class="form-group">
							<label>Mã sản phẩm 
							<img width="20" style="margin: 5px 10px 0 0 ; display: none" src="{{ asset('assets/admin/img/loading.gif') }}" id="loadding">
							<span id="rs_check_code_product" style="font-weight: normal;"></span>
							</label>
							<input type="text" class="form-control" name="code" placeholder="Nhập mã sản phẩm" >
						</div>
						<div class="form-group">
							<label>Giá</label>
							<input type="number" class="form-control" name="price" placeholder="Nhập giá" min="0" >
						</div>
						<div class="form-group">
							<label>Khuyến mãi</label>
							<input type="number" class="form-control" value="0" min="0" name="promotion" placeholder="Nhập khuyến mãi" >
						</div>
						<div class="form-group">
							<label>Ảnh đại diện</label>
							<input type="file" name="image[]" multiple>
						</div>
						<div class="form-group">
							<label>Danh mục sản phẩm</label>
							<div id="product_category_treedata">
								<!-- <li data-jstree='{"opened":true}'>Root node -->
								{!! $MultiLevelTreeData !!}	
							</div>
							<input type="hidden" name="fk_catId" id="fk_catId" value="" />
						</div>
						<div class="form-group">
							<label>Thứ Tự</label>
							<input type="number" class="form-control" name="order" placeholder="Hiển thị theo thứ tự từ lớn đến bé" >
						</div>
						<div class="form-group">
							<label>Hiển thị trên trang chủ</label>
							<select name="index_order" class="form-control">
								<option value="0">Không Hiển Thị</option>
								<option value="1">Hiển Thị</option>
							</select>
						</div>
						<div class="form-group">
							<label>Đặc biệt</label>
							<select name="special" class="form-control">
								<option value="N">Không</option>
								<option value="Y">Có</option>
							</select>
						</div>
						<div class="form-group">
							<label>Mô tả</label>
							<textarea class="form-control" name="description"></textarea>
						</div>
						<div class="form-group">
							<label>Bảo hành</label>
							<textarea class="form-control" name="baohanh"></textarea>
						</div>
						<div class="form-group">
							<label>Vận chuyển</label>
							<textarea class="form-control" name="vanchuyen"></textarea>
						</div>
						<div class="form-group">
							<label>Nhà sản xuất</label>
							<textarea class="form-control" name="nhasanxuat"></textarea>
						</div>
						<div class="form-group">
							<label>Chi tiết sản phẩm</label>
							<textarea class="form-control" name="chitietsanpham" id="chitietsanpham"></textarea>
							<script type="text/javascript">ckeditor('chitietsanpham')</script>
						</div>
						<div class="form-group">
							<label>Thông số sản phẩm</label>
							<textarea class="form-control" name="thongsosanpham" id="thongsosanpham"></textarea>
							<script type="text/javascript">ckeditor('thongsosanpham')</script>
						</div>
						<div class="form-group">
							<label>Meta Title</label>
							<input type="text" class="form-control" name="meta_title">
						</div>
						<div class="form-group">
							<label>Meta Description</label>
							<textarea class="form-control" name="meta_description"></textarea>
						</div>
						<div class="form-group">
							<label>Meta Keywords</label>
							<input type="text" class="form-control" name="meta_keywords" placeholder="eg : abc,xyz,qwe,...">
						</div>
						<div class="form-group">
							<label>Tình trạng</label>
							<select class="form-control" name="tinhtrang">
								<option value="1">Còn hàng</option>
								<option value="0">Hết hàng</option>
							</select>
						</div>
						<div class="form-group">
							<label>Tags</label>
							<select data-placeholder="Tags" multiple class="form-control chosen-select" tabindex="8" name="tags[]">
								@if(isset($tags) && count($tags) > 0)
								@foreach($tags as $val)
					            <option value="{{ $val->alias }}">{{ $val->name }}</option>
					            @endforeach
					            @endif
		                    </select>
	                    </div>
						<div class="form-group">
							<label>Trạng Thái</label>
							<select class="form-control" name="status">
								<option value="1">Hiển Thị</option>
								<option value="0">Không Hiển Thị</option>
							</select>
						</div>
					</div>
					<!-- /.box-body -->
					<div class="box-footer">
						<input type="submit" class="btn btn-primary" name="save" value="Lưu">
						<input type="submit" class="btn btn-success" name="save&add" value="Lưu & Thêm Mới">
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript" src="{{ asset('assets\admin\plugins\jstree\dist\jstree.min.js') }}"></script>
<script type="text/javascript">
	$('input[name="code"]').bind('keydown keyup',function(){
		$('#loadding').show();
		$.ajax({
			type : 'POST',
			url : "{{ route('check_code_product') }}",
			data : { _token : $('input[name="_token"]').val() , val : $(this).val() },
			success : function(rs){
				var obj = $('#rs_check_code_product');
				if(rs == 1){
					obj.html('(Mã sản phẩm đã tồn tại)');
					obj.css('color','#f00');
				}else{
					obj.html('(Mã sản phẩm hợp lệ)');
					obj.css('color','blue');
				}
				console.log(rs);
			},
			error : function(err){
				console.log('Quá trình ajax không thành công');
			}
		}).always(function(){
	
	           $('#loadding').hide();
	
	       });
	});
	
	$(function () {
		$("#product_category_treedata").jstree({
			"checkbox" : {
				"keep_selected_style" : false
			},
			"plugins" : [ "checkbox" ]
		});
	
		$(document).click(function(){
			var selectedElmsIds = [];
			var selectedElms = $('#product_category_treedata').jstree("get_checked",true);
			$.each(selectedElms, function() {
			    selectedElmsIds.push(this.id);
			});	
			$('#fk_catId').val(selectedElmsIds.join(","));
		});
		
		
	});
</script>
<!-- /.content -->
@endsection
