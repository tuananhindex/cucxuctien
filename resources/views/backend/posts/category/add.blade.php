@extends('backend.master')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{ ucwords(trans($e['lang'].'.module')) }}
        
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('backend.home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo route($e['route'].'.list.get') ?>">{{ ucwords(trans($e['lang'].'.module')) }}</a></li>
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
						  <label>{{ trans($e['lang'].'.alias') }}</label>
						  <input type="text" class="form-control add-alias" name="alias" placeholder="{{ ucwords(trans('common.enter')) }} {{ trans($e['lang'].'.alias') }}" required="">
						</div>
						<div class="form-group">
						  <label>{{ trans($e['lang'].'.image') }}</label>
						  <input type="file" name="image">
						</div>
						<div class="form-group">
						  	<label>{{ trans($e['lang'].'.parent') }}</label>
						  	<select class="form-control" name="fk_parentid">
								<option value="0">Không</option>
								{!! $MultiLevelSelect !!}
							</select>
						</div>
						<div class="form-group form-inline">
						  	<label style="margin-right: 20px">Show date created</label>
						   	<label class="radio-inline"><input type="radio" name="show_date" id="show_date" value="1" checked="">{{ ucwords(trans('common.yes')) }}</label>
							<label class="radio-inline"><input type="radio" name="show_date" id="show_date" value="0">{{ ucwords(trans('common.no')) }}</label>
							
							
						</div>
						<div class="form-group form-inline">
						  	<label style="margin-right: 20px">Document</label>
						  	<label class="radio-inline"><input type="radio" name="IsDocument" id="IsDocument" value="0" checked="">{{ ucwords(trans('common.no')) }}</label>
						   	<label class="radio-inline"><input type="radio" name="IsDocument" id="IsDocument" value="1" >{{ ucwords(trans('common.yes')) }}</label>
							
							
							
						</div>
						<div class="form-group">
						  <label>{{ trans($e['lang'].'.order') }}</label>
						  <input type="number" class="form-control" name="order" placeholder="{{ ucwords(trans('common.order_des')) }}" >
						</div>
						
						<div class="form-group">
						  <label>{{ trans($e['lang'].'.description') }}</label>
						  <textarea class="form-control" name="description" id="description"></textarea>
						  
						</div>

						<div class="form-group">
						  <label>{{ trans($e['lang'].'.pos_home') }}</label>
						  <select class="form-control" name="pos_home">
						  	<option value="0">{{ trans($e['lang'].'.pos_home_none') }}</option>
						  	<option value="1">{{ trans($e['lang'].'.pos_home_news') }}</option>
						  	<option value="2">{{ trans($e['lang'].'.pos_home_event') }}</option>
						  </select>
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
<!-- /.content -->
@endsection