@extends('backend.master')
@section('content')
<script type="text/javascript" src="{{ asset('assets/admin/plugins/ckfinder/ckfinder.js') }}"></script>
	<script type="text/javascript">

function BrowseServer()
{
	// You can use the "CKFinder" class to render CKFinder in a page:
	var finder = new CKFinder();
	finder.basePath = '../';	// The path for the installation of CKFinder (default = "/ckfinder/").
	finder.selectActionFunction = SetFileField;
	finder.popup();

	// It can also be done in a single line, calling the "static"
	// popup( basePath, width, height, selectFunction ) function:
	// CKFinder.popup( '../', null, null, SetFileField ) ;
	//
	// The "popup" function can also accept an object as the only argument.
	// CKFinder.popup( { basePath : '../', selectActionFunction : SetFileField } ) ;
}

// This is a sample function which is called when a file is selected in CKFinder.
function SetFileField( fileUrl )
{
	document.getElementById( 'xFilePath' ).value = fileUrl;
}

	</script>
<section class="content-header">
    <h1>
        Media
        
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('backend.home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo route($e['route'].'.list.get') ?>">Media</a></li>
       	<li class="active">{{ ucwords(trans($e['lang'].'.add')) }}</li>
        
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
						  <label>{{ ucwords(trans($e['lang'].'.name')) }}</label>
						  <input type="text" class="form-control" name="name" placeholder="{{ ucwords(trans('common.enter')) }} {{ trans($e['lang'].'.name') }}" required="">
						</div>
						<div class="form-group">
						  <label>{{ ucwords(trans($e['lang'].'.alias')) }}</label>
						  <input type="text" class="form-control add-alias" name="alias" placeholder="{{ ucwords(trans('common.enter')) }} {{ trans($e['lang'].'.alias') }}" required="">
						</div>
						<div class="form-group">
						  <label>{{ ucwords(trans($e['lang'].'.image')) }} ( 400 x 250 )</label>
						  <input type="file" name="image">
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
							<label>Type</label>
							<select name="media_type" id="type" class="form-control">
								<option value="file" selected="">Up File</option>
								<option value="iframe">Iframe</option>
								<option value="link">Link</option>
							</select>
						</div>
						
						<div class="form-group media_content" id="file-div">
							<label>Up file</label>
							<input id="xFilePath" class="form-control" name="FilePath" type="text" size="120" />
							<input type="button" style="margin-top: 10px" value="Browse Server" onclick="BrowseServer();" />
						</div>
						<div class="form-group media_content" id="iframe-div" style="display: none">
							<label>Iframe</label>
							<textarea class="form-control" name="iframe"></textarea>
						</div>
						<div class="form-group media_content" id="link-div" style="display: none">
							<label>Link</label>
							<input class="form-control" type="text" name="link">
						</div>

						<div class="form-group">
						  <label>{{ ucwords(trans($e['lang'].'.order')) }}</label>
						  <input type="number" class="form-control" name="order" placeholder="{{ ucwords(trans('common.order_des')) }}" >
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
<script type="text/javascript">
	$('#type').change(function(){
		var val = $(this).val();
		$('.media_content').hide();
		$('#'+val+'-div').show();
	});
</script>
<!-- /.content -->
@endsection