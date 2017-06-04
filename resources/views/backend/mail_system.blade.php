@extends('backend.master')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{ ucwords($e['module']) }}
        
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('backend.home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">{{ ucwords($e['module']) }}</li>
        
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
				  	<h3 class="box-title">{{ ucwords($e['module']) }}</h3>
				  	
				</div><!-- /.box-header -->
				<!-- form start -->
				<form method="post" enctype="multipart/form-data">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="box-body">
						<div class="form-group">
						  <label>Email</label>
						  <input type="email" class="form-control" name="email" placeholder="Nhập email" value="@if(isset($data)){{ $data->email }}@endif">
						</div>

						

						<div class="form-group">
						  <label>Password</label>
						  <input type="password" class="form-control" name="password" placeholder="Nhập password" value="@if(isset($data)){{ $data->password }}@endif">
						</div>
						
						
					</div><!-- /.box-body -->

					<div class="box-footer">
						<input type="submit" class="btn btn-primary" name="save" value="Lưu">
						
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
<!-- /.content -->
@endsection