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
				  	<button type="button" class="btn btn-warning pull-right btn-change-pw" style="margin-right:5px"  data-toggle="modal" data-target="#form-change-pw"><i class="fa fa-refresh fa-spin"></i> Đổi Mật Khẩu</button>
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
						  <label>Tên tài khoản</label>
						  <input type="text" class="form-control" name="username" disabled="" placeholder="Nhập tên tài khoản" value="{{ $index->username }}" required="">
						</div>

						<div class="form-group">
						  <label>Quyền</label>
						  <select class="form-control" name="role">
						  	
						  	@if($__acc->role == 'admin-system')
						  	<option value="content" @if($__acc->role == 'content') selected @endif>Nội dung</option>
						  	<option value="admin-content" @if($__acc->role == 'admin-content') selected @endif>Quản lý nội dung</option>
						  	@endif
						  	@if($__acc->role == 'admin')
						  	<option value="admin-system" @if($__acc->role == 'admin-system') selected @endif>Quản lý hệ thống</option>
						  	<option value="admin" @if($__acc->role == 'admin') selected @endif>Admin</option>
						  	@endif
						  </select>
						</div>
						@if($__acc->role == 'admin-system')
						<div class="form-group">
							<label>Quốc gia</label>
							<select class="form-control" name="nation">
								<option value="vi" @if($index->nation == 'vi') selected @endif>Việt Nam</option>
								<option value="la" @if($index->nation == 'la') selected @endif>Lào</option>
							</select>
						</div>
						@endif

						<div class="form-group">
						  <label>Ảnh đại diện</label>
						  <input type="file" name="image">
						</div>
						<div class="form-group">
							<img src="{{ asset($index->image) }}" width="200">
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
<div id="form-change-pw" class="modal fade" role="dialog">
  <div class="modal-dialog">
  
    <!-- Modal content-->
    <div class="modal-content">
      <div class="box box-success">
      	<form method="post" action="{{ route('backend.account.change_pw',$index->id) }}">
      		<div class="box-header with-border">
				<h3 class="box-title">Đổi mật khẩu</h3>
			</div>
			<div class="box-body">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="form-group">
				  <label>Mật khẩu</label>
				  <input type="password" class="form-control" name="password" placeholder="Nhập mật khẩu" required="">
				</div>
				<div class="form-group">
				  <label>Xác nhận mật khẩu</label>
				  <input type="password" class="form-control" name="password_confirmation" placeholder="Xác nhận mật khẩu" required="">
				</div>

				
			</div>
			<div class="box-footer">
				<button type="submit" class="btn btn-success pull-right save-lang">Lưu</button>
				
			</div>
      	</form>
		
		<!-- /.box-body -->
	</div>

    </div>

  </div>
</div>
<!-- /.content -->
@endsection