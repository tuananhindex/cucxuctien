@extends('backend.master')
@section('content')
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
				  	<h3 class="box-title">{{ ucwords($e['action']) }}</h3>
				  	<a href="<?php echo route($e['route'].'.add.get') ?>" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Thêm Mới</a>
				</div><!-- /.box-header -->
				<!-- form start -->
				<form method="post" enctype="multipart/form-data">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="box-body">
						<div class="form-group">
						  <label>Tên</label>
						  <input type="text" class="form-control" name="name" placeholder="Nhập tên" value="{{ $index->name }}">
						</div>
						<div class="form-group">
							<label>Đường Dẫn Ảo</label>
							<input type="text" class="form-control" name="alias" value="{{ $index->alias }}" placeholder="Nhập đường dẫn ảo" required="">
						</div>
						<div class="form-group">
						  <label>Ảnh</label>
						  <input type="file" name="image[]" multiple="">
						</div>
						@if(isset($images) && count($images) > 0)
						<div class="row">
							@foreach($images as $val)
							<div class="col-xs-6 col-sm-4 col-sm-3 col-lg-2" style="display: block;">
								<a href="{{ route('backend.img_lib.delete_img',$val->id) }}" class="delete_img"><img style="margin-right: 10px" src="{{ asset($val->image) }}" width="100%"></a>
							</div>
							@endforeach
						</div>
						@endif
						
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
						
					</div><!-- /.box-body -->

					<div class="box-footer">
						<input type="submit" class="btn btn-primary" name="save" value="Lưu">
						<input type="submit" class="btn btn-success" name="save&add" value="Lưu & Trở về trang danh sách">

					</div>
				</form>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
	$('.delete_img').click(function(){
		if(!window.confirm('Thao tác này không thể khôi phục . Bạn có thực sự muốn xóa ?')){ 
		    return false; 
		}
	});
</script>
<!-- /.content -->
@endsection