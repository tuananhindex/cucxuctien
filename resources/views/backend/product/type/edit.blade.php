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
				  	<h3 class="box-title">{{ ucwords($e['action']) }} (<a href="<?php echo route('backend.product.product.list.get').'?cat_id='.$index->id ?>"  style="color: #930">{{ $count }}</a> sản phẩm)</h3>
				  	<a href="<?php echo route($e['route'].'.add.get') ?>" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Thêm Mới</a>
				  	<a href="<?php echo route('backend.product.product.list.get').'?cat_id='.$index->id ?>" style="margin-right: 10px" class="btn btn-warning pull-right"><i class="fa fa-eye"></i> Xem sản phẩm</a>
				</div><!-- /.box-header -->
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
						  <input type="text" class="form-control" name="alias" placeholder="Nhập đường dẫn ảo" value="{{ $index->alias }}" required="">
						</div>
						
						
						<div class="form-group">
						  <label>Thứ Tự</label>
						  <input type="number" class="form-control" name="order" placeholder="Hiển thị theo thứ tự từ lớn đến bé" value="{{ $index->order }}" >
						</div>
						<div class="form-group">
						  <label>Mô tả</label>
						  <textarea class="form-control" name="description" id="description">{!! $index->description !!}</textarea>
						  <script type="text/javascript">ckeditor('description')</script>
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
<!-- /.content -->
@endsection