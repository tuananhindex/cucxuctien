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
						  <label>Link ( Hướng dẫn : Link tên miền.com.vn/abc/xyz  =>  <span style="color: #f00"> Nhập abc/xyz </span>)</label>
						  <input type="text" class="form-control" name="link" placeholder="Nhập link" value="{{ $index->link }}">
						</div>
						
						<div class="form-group">
						  <label>Ảnh</label>
						  <input type="file" name="image">
						</div>
						@if(file_exists($index->image))
						<div class="form-group">
							<img src="{{ asset($index->image) }}" width="200">
						</div>
						@endif
						<div class="form-group">
		                    <label>Vị trí</label>
		                    <select class="form-control" name="pos">
		                      <option value="main" @if($index->pos == 'main') selected @endif>Banner chính</option>
		                      
		                      <option value="sub" @if($index->pos == 'sub') selected @endif>Banner phụ</option>
		                    </select>
		                  </div>
		                  <div class="form-group">
		                    <label>Thứ Tự</label>
		                    <input type="number" class="form-control" name="order" value="{{ $index->order }}">
		                  </div>
		                  
		                  <div class="form-group">
		                    <label>Trạng Thái</label>
		                    <select name="status" class="form-control">
		                      @if($index->status == 1)
		                      <option value="1">Hiển Thị</option>
		                      <option value="0">Không Hiển Thị</option>
		                      @else
		                      <option value="0">Không Hiển Thị</option>
		                      <option value="1">Hiển Thị</option>
		                      
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