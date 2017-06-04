@extends('backend.master')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('assets\admin\plugins\jstree\dist\themes\default\style.min.css') }}">
<!-- Content Header (Page header) -->
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
					<h3 class="box-title">{{ ucwords($e['action']) }} <span style="color: #bbb">( {{ $index->authName }} )</span></h3>
					<a href="<?php echo route($e['route'].'.add.get') ?>" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Thêm Mới</a>
				</div>
				<!-- /.box-header -->
				<!-- form start -->
				<form method="post" enctype="multipart/form-data">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="box-body">
						<div class="form-group">
							<label>Tên</label>
							<input type="text" class="form-control" name="name" placeholder="Nhập tên" value="{{ $index->name }}" required="">
						</div>
						<div class="form-group">
							<label>Đường Dẫn Ảo</label>
							<input type="text"  class="form-control" name="alias" placeholder="Nhập đường dẫn ảo" value="{{ $index->alias }}" required="">
						</div>
						<div class="form-group">
							<label>Mã sản phẩm
							<img width="20" style="margin: 5px 10px 0 0 ; display: none" src="{{ asset('assets/admin/img/loading.gif') }}" id="loadding">
							<span id="rs_check_code_product" style="font-weight: normal;"></span>
							</label>
							<input type="text" class="form-control" name="code" placeholder="Nhập mã sản phẩm" value="{{ $index->code }}">
						</div>
						<div class="form-group">
							<label>Giá</label>
							<input type="number" class="form-control" name="price" min="0" placeholder="Nhập giá" value="{{ $index->price }}" required="">
						</div>
						<div class="form-group">
							<label>Khuyến mãi</label>
							<input type="number" class="form-control" name="promotion" placeholder="Nhập khuyến mãi" value="{{ $index->promotion }}" >
						</div>
						<div class="form-group">
							<label>Ảnh đại diện</label>
							<input type="file" name="image[]" multiple>
						</div>
						@if(isset($images) && count($images) > 0)
						<div class="row">
							@foreach($images as $val)
							<div class="col-xs-6 col-sm-4 col-sm-3 col-lg-2" style="display: block;">
								<input @if($val->isMain == 1) checked @endif type="radio" name="pk_img" value="{{ $val->id }}">
								<a href="{{ route('backend.product.product.delete_img',$val->id) }}" class="delete_img"><img style="margin-right: 10px" src="{{ asset($val->src) }}" width="100%"></a>
							</div>
							@endforeach
						</div>
						@endif
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
							<input type="number" class="form-control" name="order" value="{{ $index->order }}" placeholder="Hiển thị theo thứ tự từ lớn đến bé" >
						</div>
						<div class="form-group">
							<label>Hiển thị trên trang chủ</label>
							<select name="index_order" class="form-control">
								@if($index->index_order == 1)
								<option value="1">Hiển Thị</option>
								<option value="0">Không Hiển Thị</option>
								@else
								<option value="0">Không Hiển Thị</option>
								<option value="1">Hiển Thị</option>
								@endif
							</select>
						</div>
						<div class="form-group">
							<label>Đặc biệt</label>
							<select name="special" class="form-control">
							<option value="N" @if($index->special == 'N') selected="selected" @endif>Không</option>
							<option value="Y" @if($index->special == 'Y') selected="selected" @endif>Có</option>
							</select>
						</div>
						<div class="form-group">
							<label>Mô tả</label>
							<textarea class="form-control" name="description">{{ $index->description }}</textarea>
						</div>
						<div class="form-group">
							<label>Bảo hành</label>
							<textarea class="form-control" name="baohanh">{{ $index->baohanh }}</textarea>
						</div>
						<div class="form-group">
							<label>Vận chuyển</label>
							<textarea class="form-control" name="vanchuyen">{{ $index->vanchuyen }}</textarea>
						</div>
						<div class="form-group">
							<label>Nhà sản xuất</label>
							<textarea class="form-control" name="nhasanxuat">{{ $index->nhasanxuat }}</textarea>
						</div>
						<div class="form-group">
							<label>Chi tiết sản phẩm</label>
							<textarea class="form-control" name="chitietsanpham" id="chitietsanpham">{!! $index->chitietsanpham !!}</textarea>
							<script type="text/javascript">ckeditor('chitietsanpham')</script>
						</div>
						<div class="form-group">
							<label>Thông số sản phẩm</label>
							<textarea class="form-control" name="thongsosanpham" id="thongsosanpham">{!! $index->thongsosanpham !!}</textarea>
							<script type="text/javascript">ckeditor('thongsosanpham')</script>
						</div>
						<div class="form-group">
							<label>Meta Title</label>
							<input type="text" class="form-control" name="meta_title" value="{{ $index->meta_title }}">
						</div>
						<div class="form-group">
							<label>Meta Description</label>
							<textarea class="form-control" name="meta_description">{{ $index->meta_description }}</textarea>
						</div>
						<div class="form-group">
							<label>Meta Keywords</label>
							<input type="text" class="form-control" name="meta_keywords" placeholder="eg : abc,xyz,qwe,..." value="{{ $index->meta_keywords }}">
						</div>
						<div class="form-group">
							<label>Tình trạng</label>
							<select class="form-control" name="tinhtrang">
								
								@if($index->tinhtrang == 1)
								<option value="1">Còn hàng</option>
								<option value="0">Hết hàng</option>
								@else
								<option value="0">Hết hàng</option>
								<option value="1">Còn hàng</option>
								
								@endif
							</select>
						</div>
						<div class="form-group">
							<label>Tags</label>
							<select data-placeholder="Tags" multiple class="form-control chosen-select" tabindex="8" name="tags[]">
								@if(isset($tags) && count($tags) > 0)
								<?php
									$tags_arr = explode(',', $index->tags);
								?>
								@foreach($tags as $val)
					            <option value="{{ $val->alias }}" @if(in_array($val->alias,$tags_arr)) selected @endif>{{ $val->name }}</option>
					            @endforeach
					            @endif
		                    </select>
	                    </div>
						<div class="form-group">
							<label>Trạng Thái</label>
							<select class="form-control" name="status">
								@if($index->status == 1)
								<option value="1">Hiển Thị</option>
								<option value="0">Không Hiển Thị</option>
								@else
								<option value="0">Không Hiển Thị</option>
								<option value="1">Hiển Thị</option>
								@endif
							</select>
						</div>
					</div>
					<!-- /.box-body -->
					<div class="box-footer">
						<input type="submit" class="btn btn-primary" name="save" value="Lưu">
						<input type="submit" class="btn btn-success" name="save&add" value="Lưu & Trở về trang danh sách">
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript" src="{{ asset('assets\admin\plugins\jstree\dist\jstree.min.js') }}"></script>
<script type="text/javascript">
	$('.delete_img').click(function(){
		if(!window.confirm('Thao tác này không thể khôi phục . Bạn có thực sự muốn xóa ?')){ 
		    return false; 
		}
	});

	$('input[name="code"]').bind('keydown keyup',function(){
		$('#loadding').show();
		$.ajax({
			type : 'POST',
			url : "{{ route('check_code_product') }}",
			data : { _token : $('input[name="_token"]').val() , val : $(this).val() , id : {{ $index->id }} },
			success : function(rs){
				var obj = $('#rs_check_code_product');
				if(rs == 1){
					obj.html('(Mã sản phẩm đã tồn tại)');
					obj.css('color','#f00');
				}else{
					obj.html('(Mã sản phẩm hợp lệ)');
					obj.css('color','blue');
				}
				//console.log(rs);
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
