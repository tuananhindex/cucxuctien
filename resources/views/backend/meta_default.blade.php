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
						  <label>Title</label>
						  <input type="text" class="form-control" name="title" placeholder="Nhập title" value="@if(isset($data)){{ $data->title }}@endif">
						</div>

						<div class="form-group">
						  <label>Description</label>
						  <textarea class="form-control" name="description" placeholder="Nhập Description">@if(isset($data)){{ $data->description }}@endif</textarea>
						</div>

						<div class="form-group">
						  <label>Keywords</label>
						  <input type="text" class="form-control" name="keywords" placeholder="Nhập Keywords" value="@if(isset($data)){{ $data->keywords }}@endif">
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