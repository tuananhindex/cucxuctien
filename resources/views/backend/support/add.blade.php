﻿@extends('backend.master')
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
				</div><!-- /.box-header -->
				<!-- form start -->
				<form method="post" enctype="multipart/form-data">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="box-body">
						<div class="form-group">
		                    <label>Tên</label>
		                    <input type="text" class="form-control" name="name" required>
		                  </div>
		                <div class="form-group">
						  <label>Ảnh</label>
						  <input type="file" name="image">
						</div>
					<div class="form-group">
		                    <label>Thứ tự</label>
		                    <input type="text" class="form-control" name="order" >
		                  </div>
		                  <div class="form-group">
		                    <label>Số điện thoại</label>
		                    <input type="text" class="form-control" name="phone" required>
		                  </div>
		                  <div class="form-group">
		                    <label>Skype</label>
		                    <input type="text" class="form-control" name="skype" >
		                  </div>
		                  <div class="form-group">
		                    <label>Mail</label>
		                    <input type="text" class="form-control" name="mail"  >
		                  </div>
		                  
		                  <div class="form-group">
		                    <label>Trạng Thái</label>
		                    <select name="status" class="form-control">
		                      <option value="1">Hiển Thị</option>
		                      <option value="0">Không Hiển Thị</option>
		                    </select>
		                  </div>
						
					</div><!-- /.box-body -->

					<div class="box-footer">
						<input type="submit" class="btn btn-primary" name="save" value="Lưu">
						<input type="submit" class="btn btn-success" name="save&add" value="Lưu & Thêm Mới">
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
<!-- /.content -->
@endsection