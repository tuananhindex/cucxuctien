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
				  	<h3 class="box-title">{{ ucwords($e['action']) }}</h3>

				  	<a href="<?php echo route($e['route'].'.add.get') ?>" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> {{ trans($e['lang'].'.add_new') }}</a>
				  	<button type="button" class="btn btn-success pull-right btn-add-lang" style="margin-right:5px"  data-toggle="modal" data-target="#form-add-lang"><i class="fa fa-plus"></i> {{ trans($e['lang'].'.add_lang') }}</button>
				  	@if($index->status == 1)
				  	<a href="<?php echo route($e['frontend_route'],$index->alias) ?>" target="_blank" class="btn btn-warning pull-right" style="margin-right:5px"><i class="fa fa-eye"></i> {{ trans($e['lang'].'.view') }}</a>
				  	@endif
				</div><!-- /.box-header -->
				<!-- form start -->
				<form method="post" enctype="multipart/form-data">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="box-body">
						<div class="form-group">
							<label>{{ trans($e['lang'].'.language') }}</label>
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
						  <label>{{ trans($e['lang'].'.name') }}</label>
						  <input type="text" class="form-control" name="name" placeholder="{{ ucwords(trans('common.enter')) }} {{ trans($e['lang'].'.name') }}" value="{{ $index->name }}" required="">
						</div>
						<div class="form-group">
						  <label>{{ trans($e['lang'].'.alias') }}</label>
						  <input type="text"  class="form-control" name="alias" placeholder="{{ ucwords(trans('common.enter')) }} {{ trans($e['lang'].'.name') }}" value="{{ $index->alias }}" required="">
						</div>
						<div class="form-group">
						  <label>{{ trans($e['lang'].'.image') }}</label>
						  <input type="file" name="image">
						</div>
						@if(file_exists($index->image))
						<div class="form-group">
							<img src="{{ asset($index->image) }}" width="200">
						</div>
						@endif
						<div class="form-group">
						  	<label>{{ trans($e['lang'].'.parent') }}</label>
						  	<select class="form-control" name="fk_parentid">
								<option value="0">Không</option>
								{!! $MultiLevelSelect !!}
							</select>
						</div>
						<div class="form-group form-inline">
						  	<label style="margin-right: 20px">Show date created</label>
						   	<label class="radio-inline"><input type="radio" name="show_date" id="show_date" value="1"  @if($index->show_date) checked @endif>{{ ucwords(trans('common.yes')) }}</label>
							<label class="radio-inline"><input type="radio" name="show_date" id="show_date" value="0"  @if(!$index->show_date) checked @endif>{{ ucwords(trans('common.no')) }}</label>
							
							
						</div>
						<div class="form-group form-inline">
						  	<label style="margin-right: 20px">Document</label>
						   	<label class="radio-inline"><input type="radio" name="IsDocument" id="document" value="1"  @if($index->IsDocument) checked @endif>{{ ucwords(trans('common.yes')) }}</label>
							<label class="radio-inline"><input type="radio" name="IsDocument" id="document" value="0"  @if(!$index->IsDocument) checked @endif>{{ ucwords(trans('common.no')) }}</label>
							
							
						</div>
						<div class="form-group">
						  <label>{{ trans($e['lang'].'.order') }}</label>
						  <input type="number" class="form-control" name="order" placeholder="{{ ucwords(trans('common.order_des')) }}" value="{{ $index->order }}" >
						</div>
						
						<div class="form-group">
						  <label>{{ trans($e['lang'].'.description') }}</label>
						  <textarea class="form-control" name="description" id="description">{!! $index->description !!}</textarea>
						  
						</div>

						<div class="form-group">
						  <label>{{ trans($e['lang'].'.pos_home') }}</label>
						  <select class="form-control" name="pos_home">
						  	<option value="0" @if($index->pos_home == 0) selected @endif>{{ trans($e['lang'].'.pos_home_none') }}</option>
						  	<option value="1" @if($index->pos_home == 1) selected @endif>{{ trans($e['lang'].'.pos_home_news') }}</option>
						  	<option value="2" @if($index->pos_home == 2) selected @endif>{{ trans($e['lang'].'.pos_home_event') }}</option>
						  </select>
						</div>
						
						<div class="form-group">
						  <label>Meta Title</label>
						  <input type="text" class="form-control" name="meta_title" value="{{ $index->meta_title }}">
						</div>
						<div class="form-group">
						  <label>Meta Description</label>
						  <textarea class="form-control" name="meta_description">{{ $index->meta_description }}</textarea>
						</div>
						<div class="form-group">
						  <label>Meta Keywords</label>
						  <input type="text" class="form-control" name="meta_keywords" placeholder="eg : abc,xyz,qwe,..." value="{{ $index->meta_keywords }}">
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
						<div class="form-group">
							<label>{{ trans($e['lang'].'.status') }}</label>
							<select class="form-control" name="status">
								@if($index->status == 1)
								<option value="1">{{ trans($e['lang'].'.status_show') }}</option>
								<option value="0">{{ trans($e['lang'].'.status_hide') }}</option>
								@else
								<option value="0">{{ trans($e['lang'].'.status_hide') }}</option>
								<option value="1">{{ trans($e['lang'].'.status_show') }}</option>
								@endif
							</select>
						</div>
						
					</div><!-- /.box-body -->

					<div class="box-footer">
						<input type="submit" class="btn btn-primary" name="save" value="{{ trans($e['lang'].'.save') }}">
						<input type="submit" class="btn btn-success" name="save&add" value="{{ trans($e['lang'].'.save_add_list') }}">

					</div>
				</form>
			</div>
		</div>
	</div>
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
			<h3 class="box-title">{{ trans($e['lang'].'.add_lang') }}</h3>
		</div>
		<div class="box-body">
			<input type="hidden" name="table" value="{{ $e['table'] }}">
			<input type="hidden" name="id" value="{{ $index->id }}">
			<input type="hidden" name="fk_commonid" value="{{ $index->fk_commonid }}">
			<div class="form-group">
			  <label>{{ trans($e['lang'].'.language') }}</label>
			  <select class="form-control" name="language" class="language">
                @foreach($languages as $val)
                <option value="{{ $val->id }}">{{ ucfirst($val->name) }}</option>
                @endforeach
              </select>
			</div>
			<div class="form-group">
			  <label>{{ trans($e['lang'].'.name') }}</label>
			  <input type="text" class="form-control" name="lang_name" placeholder="Nhập tên"  required="">
			</div>

			
			<div class="form-group">
			  <label>{{ trans($e['lang'].'.description') }}</label>
			  <textarea class="form-control" name="lang_description" id="lang_description"></textarea>
			  
			</div>

			
		</div>
		<div class="box-footer">
			<button type="button" class="btn btn-success pull-right save-lang">{{ trans($e['lang'].'.save') }}</button>
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
</section>
<!-- /.content -->
@endsection