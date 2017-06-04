@extends('backend.master')
@section('content')
<!-- Editer -->

    <script src="{!! asset('assets/admin/plugins/ckeditor-dev/ckeditor/ckeditor.js') !!}"></script>

    <script src="{!! asset('assets/admin/plugins/ckeditor-dev/ckfinder/ckfinder.js') !!}"></script>

    <script type="text/javascript">

        var baseURL = "{!! url('/') !!}";

    </script>

    <script src="{!! asset('assets/admin/plugins/ckeditor-dev/func_ckfinder.js') !!}"></script>
<script type="text/javascript" src="{{ asset('assets/admin/plugins/daterangepicker/moment.min.js') }}"></script>

<!-- Include Date Range Picker -->
<script type="text/javascript" src="{{ asset('assets/admin/plugins/daterangepicker/daterangepicker.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/plugins/daterangepicker/daterangepicker.css') }}" />
<!-- Content Header (Page header) -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets\admin\plugins\jstree\dist\themes\default\style.min.css') }}">
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
						<div class="form-group form-inline">
						  	<label style="margin-right: 20px">{{ ucwords(trans($e['lang'].'.pos_home_event')) }}</label>
						   	<label class="radio-inline"><input type="radio" name="IsEvent" id="event-yes" value="1">{{ ucwords(trans('common.yes')) }}</label>
							<label class="radio-inline"><input type="radio" name="IsEvent" id="event-no" value="0" checked="">{{ ucwords(trans('common.no')) }}</label>
							<div id="div-eventrange" class="form-inline" style="display: none">
							<div class="form-group">
								<label style="margin-right: 20px">{{ ucwords(trans($e['lang'].'.daterange')) }}</label>
								<input type="text" class="form-control" name="daterange" value="" style="width: 300px" />
							</div>
							</div>
							
						</div>
						
						
						<div class="form-group">
						  <label>{{ ucwords(trans($e['lang'].'.name')) }}</label>
						  <input type="text" class="form-control" name="name" placeholder="{{ ucwords(trans('common.enter')) }} {{ trans($e['lang'].'.name') }}" required="">
						</div>
						<div class="form-group">
						  <label>{{ ucwords(trans($e['lang'].'.alias')) }}</label>
						  <input type="text" class="form-control add-alias" name="alias" placeholder="{{ ucwords(trans('common.enter')) }} {{ trans($e['lang'].'.alias') }}" required="">
						</div>
						<div class="form-group">
						  <label>{{ ucwords(trans($e['lang'].'.image')) }}</label>
						  <input type="file" name="image">
						</div>
						<div class="form-group">
							<label>{{ ucwords(trans($e['lang'].'.category')) }}</label>
							<div id="category_treedata">
								<!-- <li data-jstree='{"opened":true}'>Root node -->
								{!! $MultiLevelTreeData !!}	
							</div>
							<input type="hidden" name="fk_catId" id="fk_catId" value="" />
						</div>
						
						<div class="form-group">
						  <label>{{ ucwords(trans($e['lang'].'.order')) }}</label>
						  <input type="number" class="form-control" name="order" placeholder="{{ ucwords(trans('common.order_des')) }}" >
						</div>
						<div class="form-group">
						  <label>
						  	<input type="checkbox" name="IsCustomer" value="1"> {{ ucwords(trans($e['lang'].'.hot_new')) }}
						  </label>
						  
						</div>
						<div class="form-group">
						  <label>{{ ucwords(trans($e['lang'].'.description')) }}</label>
						  <textarea class="form-control" name="description" id="description"></textarea>
						  
						</div>

						
						<div class="form-group">
						  <label>{{ ucwords(trans($e['lang'].'.content')) }}</label>
						  <textarea class="form-control" name="content"></textarea>
						  <script type="text/javascript">ckeditor('content')</script>
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
						
					</div><!-- /.box-body -->

					<div class="box-footer">
						<input type="submit" class="btn btn-primary" name="save" value="{{ ucwords(trans($e['lang'].'.save')) }}">
						<input type="submit" class="btn btn-success" name="save&add" value="{{ ucwords(trans($e['lang'].'.save_and_add')) }}">
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript" src="{{ asset('assets\admin\plugins\jstree\dist\jstree.min.js') }}"></script>
<script type="text/javascript">
	$(function () {
		$("#category_treedata").jstree({
			"checkbox" : {
				"keep_selected_style" : false
			},
			"plugins" : [ "checkbox" ]
		});
	
		$(document).click(function(){
			var selectedElmsIds = [];
			var selectedElms = $('#category_treedata').jstree("get_checked",true);
			$.each(selectedElms, function() {
			    selectedElmsIds.push(this.id);
			});	
			$('#fk_catId').val(selectedElmsIds.join(","));
		});
		
		$('input[name="daterange"]').daterangepicker({
		        timePicker: false,
		        locale: {
		            format: 'YYYY/MM/DD'
		        }
		});
		
	});

	$('#event-yes').change(function(){
	    if($(this).is(':checked')) {
	        $('#div-eventrange').show();
	    } 
	});

	$('#event-no').change(function(){
	    if($(this).is(':checked')) {
	        $('#div-eventrange').hide();
	    } 
	});


</script>
<!-- /.content -->
@endsection