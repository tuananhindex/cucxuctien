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
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Media
        
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('backend.home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo route($e['route'].'.list.get') ?>">Media</a></li>
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
				  	<div class="col-xs-5 pull-right">
				  		@if($__acc->role != 'content_check')
				  		<a href="<?php echo route($e['route'].'.add.get') ?>" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> {{ ucwords(trans($e['lang'].'.add_new')) }}</a>
				  		
					  	<button type="button" class="btn btn-success pull-right btn-add-lang" style="margin-right:5px"  data-toggle="modal" data-target="#form-add-lang"><i class="fa fa-plus"></i> {{ ucwords(trans($e['lang'].'.add_lang')) }}</button>
					  	@endif
					  	@if($index->status == 1)
					  	
					  	<a href="<?php echo route($e['frontend_route'],$index->alias); ?>" target="_blank" class="btn btn-warning pull-right" style="margin-right:5px"><i class="fa fa-eye"></i> {{ ucwords(trans($e['lang'].'.view')) }}</a>
					  	@endif
					  	
				  	</div>
				  	
				</div><!-- /.box-header -->
				<!-- form start -->
				<form method="post" enctype="multipart/form-data">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="box-body">
						<div class="form-group">
							<label>{{ ucwords(trans($e['lang'].'.language')) }}</label>
							<?php 

						  		$lang = !empty(Route::current()->parameter('lang')) ? Route::current()->parameter('lang') : $df_lang->id ;
						  		
						  	?>
						  	<select class="form-control filter_language">
		                        @foreach($languages2 as $val)
		                        <option value="{{ $val->id }}" @if($val->id == $lang) selected @endif>{{ ucfirst($val->name) }} @if($val->id == $df_lang->id) - Default @endif</option>
		                        @endforeach
		                     </select>
						</div>
						
						<div class="form-group">
						  <label>{{ ucwords(trans($e['lang'].'.name')) }}</label>
						  <input type="text" class="form-control" name="name" placeholder="{{ ucwords(trans('common.enter')) }} {{ trans($e['lang'].'.name') }}" value="{{ $index->name }}" required="">
						</div>
						<div class="form-group">
						  <label>{{ ucwords(trans($e['lang'].'.alias')) }}</label>
						  <input type="text" class="form-control" name="alias" placeholder="{{ ucwords(trans('common.enter')) }} {{ trans($e['lang'].'.alias') }}" value="{{ $index->alias }}" required="">
						</div>
						<div class="form-group">
						  <label>{{ ucwords(trans($e['lang'].'.image')) }} ( 400 x 250 )</label>
						  <input type="file" name="image">
						</div>
						@if(file_exists($index->image))
						<div class="form-group">
							<img src="{{ asset($index->image) }}" width="200">
						</div>
						@endif
						<div class="form-group">
						  <label>
						  	<input type="checkbox" name="IsCustomer" value="1" @if($index->IsCustomer == 1) checked @endif> {{ ucwords(trans($e['lang'].'.hot_new')) }}
						  </label>
						  
						</div>
						
						
						
						<div class="form-group">
						  <label>{{ ucwords(trans($e['lang'].'.description')) }}</label>
						  <textarea class="form-control" name="description" id="description">{{ $index->description }}</textarea>
						  
						</div>

						<div class="form-group">
							<label>Type</label>
							<select name="media_type" id="type" class="form-control">
								<option value="file" @if($index->media_type == 'file') selected @endif>Up File</option>
								<option value="iframe" @if($index->media_type == 'iframe') selected @endif>Iframe</option>
								<option value="link" @if($index->media_type == 'link') selected @endif>Link</option>
							</select>
						</div>
						
						<div class="form-group media_content" id="file-div"  @if($index->media_type != 'file') style="display: none" @endif>
							<label>Up file</label>
							<input id="xFilePath" class="form-control" name="FilePath" type="text" size="120" />
							<input type="button" style="margin-top: 10px" value="Browse Server" onclick="BrowseServer();" />
						</div>
						<div class="form-group media_content" id="iframe-div" @if($index->media_type != 'iframe') style="display: none" @endif>
							<label>Iframe</label>
							<textarea class="form-control" name="iframe"></textarea>
						</div>
						<div class="form-group media_content" id="link-div" @if($index->media_type != 'link') style="display: none" @endif>
							<label>Link</label>
							<input class="form-control" type="text" name="link">
						</div>

						@if($index->media_type == 'file')
						<video width="320" height="240" controls>
						  <source src="{{ $index->media }}" type="video/mp4">
						  
						</video>
						@elseif($index->media_type == 'iframe')
						{!! $index->media !!}
						@elseif($index->media_type == 'link')
						<iframe src="{{ $index->media }}"></iframe>
						@endif
						

						<div class="form-group">
						  <label>{{ ucwords(trans($e['lang'].'.order')) }}</label>
						  <input type="number" class="form-control" name="order" value="{{ $index->order }}" placeholder="{{ ucwords(trans('common.order_des')) }}" >
						</div>
						
						<div class="form-group">
							<label>Tags</label>
							<select data-placeholder="Tags" multiple class="form-control chosen-select" tabindex="8" name="tags[]">
								@if(isset($tags) && count($tags) > 0)
								<?php
									$tags_arr = explode(',', $index->tags);
								?>
								@foreach($tags as $val)
					            <option value="{{ $val->alias }}" @if(in_array($val->alias,$tags_arr)) selected @endif>{{ $val->name }}</option>
					            @endforeach
					            @endif
		                    </select>
	                    </div>
	                    @if($__acc->role != 'content')
						<div class="form-group">
							<label>{{ ucwords(trans($e['lang'].'.status')) }}</label>
							<select class="form-control" name="status">
								@if($index->status == 1)
								<option value="1">{{ ucwords(trans($e['lang'].'.status_show')) }}</option>
								<option value="0">{{ ucwords(trans($e['lang'].'.status_hide')) }}</option>
								@else
								<option value="0">{{ ucwords(trans($e['lang'].'.status_hide')) }}</option>
								<option value="1">{{ ucwords(trans($e['lang'].'.status_show')) }}</option>
								@endif
							</select>
						</div>
						@endif
						
					</div><!-- /.box-body -->

					<div class="box-footer">
						<input type="submit" class="btn btn-primary" name="save" value="{{ ucwords(trans($e['lang'].'.save')) }}">
						<input type="submit" class="btn btn-success" name="save&add" value="{{ ucwords(trans($e['lang'].'.save_add_list')) }}">

					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- popup -->
<!-- Modal -->
@if(isset($languages) && count($languages) > 0)
<div id="form-add-lang" class="modal fade" role="dialog">
  <div class="modal-dialog">
  <style type="text/css">
  	.chosen-container{
  		width: 100% !important;
  	}
  </style>
    <!-- Modal content-->
    <div class="modal-content">
      <div class="box box-success">
		<div class="box-header with-border">
			<h3 class="box-title">{{ ucwords(trans($e['lang'].'.add_lang')) }}</h3>
		</div>
		<div class="box-body">
			<input type="hidden" name="table" value="{{ $e['table'] }}">
			<input type="hidden" name="id" value="{{ $index->id }}">
			<input type="hidden" name="fk_commonid" value="{{ $index->fk_commonid }}">
			<div class="form-group">
			  <label>{{ ucwords(trans($e['lang'].'.language')) }}</label>
			  <select class="form-control" name="language" class="language">
                @foreach($languages as $val)
                <option value="{{ $val->id }}">{{ ucfirst($val->name) }}</option>
                @endforeach
              </select>
			</div>
			<div class="form-group">
			  <label>{{ ucwords(trans($e['lang'].'.name')) }}</label>
			  <input type="text" class="form-control" name="lang_name" placeholder="Nhập tên"  required="">
			</div>

			
			<div class="form-group">
			  <label>{{ ucwords(trans($e['lang'].'.description')) }}</label>
			  <textarea class="form-control" name="lang_description" id="lang_description"></textarea>
			  
			</div>

			
		</div>
		<div class="box-footer">
			<button type="button" class="btn btn-success pull-right save-lang">{{ ucwords(trans($e['lang'].'.save')) }}</button>
			<img width="20" style="margin: 5px 10px 0 0 ; display: none" class="pull-right" src="{{ asset('assets/admin/img/loading.gif') }}" id="loadding">

		</div>
		<!-- /.box-body -->
	</div>

    </div>

  </div>
</div>
@else
<script type="text/javascript">
	$('.btn-add-lang').click(function(){
		alert('Bạn đã thêm đầy đủ các ngôn ngữ');
	});
</script>
@endif
<script type="text/javascript">
	$('select.filter_language').change(function(){
	      var val = $(this).val();
	      location.href = '{{ route(Route::currentRouteName(),'') }}/'+'{{ $index->id }}/'+val;
  	});

	
	var ajax_sendding = false;

    $(".save-lang").click(function(e){
        if (ajax_sendding == true){

            return false;

        }
		ajax_sendding = true;

        // Bật span loaddding lên

        $('#loadding').show();

        $.ajax({

            type: "POST",

            url: "{{ route('add_lang') }}",

            data: { 
            		_token : $('input[name="_token"]').val(),

            		table : $('input[name="table"]').val(),

            		id : $('input[name="id"]').val(),

            		fk_commonid : $('input[name="fk_commonid"]').val(),

                    name : $('input[name="lang_name"]').val(),

                    language : $('select[name="language"]').val() , 

                    description : $('textarea[name="lang_description"]').val() 
                },

            success:function(x)

            {
            	var obj = JSON.parse(x);
            	if(obj.status == 'success'){
            		alert(obj.message);
            		$('#form-add-lang').modal('hide');
            		location.reload(); 
            	}else{
            		alert(obj.message);
            	}
                
			},
            error:function()
            {
                alert('Thêm ngôn ngữ không thành công');
            }

        }).always(function(){

            ajax_sendding = false;

            $('#loadding').hide();

        });

    });

</script>
<!-- popup end -->
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