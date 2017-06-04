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
				  	<h3 class="box-title">{{ ucwords(trans($e['lang'].'.add')) }} <span style="color: #f00">( Please enter english )</span></h3>
				</div><!-- /.box-header -->
				<!-- form start -->
				<form method="post" enctype="multipart/form-data">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="box-body">
						<div class="form-group">
						  <label>{{ trans($e['lang'].'.name') }}</label>
						  <input type="text" class="form-control" name="name" placeholder="{{ ucwords(trans('common.enter')) }} {{ trans($e['lang'].'.name') }}" required="">
						</div>
						
						
						<div class="form-group">
						  	<label>{{ trans($e['lang'].'.parent') }}</label>
						  	<select class="form-control" name="fk_parentid">
								<option value="0">Không</option>
								{!! $MultiLevelSelect !!}
							</select>
						</div>
						<div class="form-group">
						  	<label>{{ ucfirst(trans($e['lang'].'.cursor')) }}</label>
						  	<select class="form-control cursor" name="cursor">
						  		<option value="">{{ ucfirst(trans('common.no')) }}</option>
						  		<option value="posts">{{ ucfirst(trans('common.posts')) }}</option>
						  		<option value="posts_category">{{ ucfirst(trans('common.posts_category')) }}</option>
						  		
						  	</select>
						</div>
						<div class="data-cursor">
							
						</div>
						<div class="form-group">
						  <label>{{ trans($e['lang'].'.order') }}</label>
						  <input type="number" class="form-control" name="order" placeholder="{{ ucfirst(trans('common.order_des')) }}" >
						</div>
						<div class="form-group">
							<label>Target</label>
							<select class="form-control" name="target">
								<option value="0">No choice</option>
								<option value="_blank">_blank</option>
								<option value="_self">_self</option>
								<option value="_parent">_parent</option>
								<option value="_top">_top</option>
							</select>
						</div>
						<div class="form-group">
						  <label>Link</label>
						  <input type="text" class="form-control" name="link2" placeholder="{{ ucwords(trans('common.enter')) }} link">
						</div>
						<!-- <div class="form-group">
							<label>Hiển thị ở menu header</label>
							<select class="form-control" name="menu_header">
								<option value="0">Không</option>
								<option value="1">Có</option>
								
							</select>
						</div>
						<div class="form-group">
							<label>Hiển thị ở menu footer</label>
							<select class="form-control" name="menu_footer">
								<option value="0">Không</option>
								<option value="1">Có</option>
								
							</select>
						</div> -->
						<div class="form-group">
							<label>Position</label>
							<select class="form-control" name="pos">
								<option value="0">No choice</option>
								<option value="footer">Footer</option>
							</select>
						</div>
						<div class="form-group">
							<label>{{ trans($e['lang'].'.status') }}</label>
							<select class="form-control" name="status">
								<option value="1">{{ trans($e['lang'].'.status_show') }}</option>
								<option value="0">{{ trans($e['lang'].'.status_hide') }}</option>
							</select>
						</div>
						
					</div><!-- /.box-body -->

					<div class="box-footer">
						<input type="submit" class="btn btn-primary" name="save" value="{{ trans($e['lang'].'.save') }}">
						<input type="submit" class="btn btn-success" name="save&add" value="{{ trans($e['lang'].'.save_and_add') }}">
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
	$('select.cursor').change(function(){
	    var cursor = $(this).val();
	    //alert(baseURL+'/backend/ajax/get_data_cursor');
	    $.ajax({
	        type: "GET",
	        url: '{{ route("get_data_cursor") }}',
	        data: { 'cursor' : cursor },
	        dataType: "html",
	        success: function(result){
	            //alert(1);
	            $('.data-cursor').html(result);
	        },
	        error: function() {
	            //alert(0);
	            $('.data-cursor').html('');
	        }
	    });
	});
</script>
<!-- /.content -->
@endsection