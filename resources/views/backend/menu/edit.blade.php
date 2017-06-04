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
				  	<a href="<?php echo route($e['route'].'.add.get') ?>" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> {{ trans($e['lang'].'.add_new') }}</a>
				  	<button type="button" class="btn btn-success pull-right btn-add-lang" style="margin-right:5px"  data-toggle="modal" data-target="#form-add-lang"><i class="fa fa-plus"></i> {{ trans($e['lang'].'.add_lang') }}</button>
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
						  <input type="text" class="form-control" name="name" placeholder="Nhập tên" value="{{ $index->name }}" required="">
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
						  		<option value="posts" @if($index->cursor == 'posts') selected @endif>{{ ucfirst(trans('common.posts')) }}</option>
						  		<option value="posts_category" @if($index->cursor == 'posts_category') selected @endif>{{ ucfirst(trans('common.posts_category')) }}</option>
						  		
						  	</select>
						</div>
						<div class="data-cursor">
							@if($data_cursor)
							<div class="form-group">
							  	<label>Đối tượng trỏ đến</label>
							  	<select class="form-control" name="cursor_id">
							  		@foreach($data_cursor as $val)
							  			<option value="{{ $val->id }}" @if($index->cursor_id == $val->id) selected @endif>{{ ucfirst($val->name) }}</option>
							  		@endforeach
							  	</select>
							</div>
							@endif
						</div>
						<div class="form-group">
						  <label>{{ trans($e['lang'].'.order') }}</label>
						  <input type="number" class="form-control" name="order" placeholder="{{ trans($e['lang'].'.order_des') }}" value="{{ $index->order }}" >
						</div>
						<div class="form-group">
							<label>Target</label>
							<select class="form-control" name="target">
								<option value="0">No choice</option>
								<option value="_blank" @if($index->target == '_blank') selected @endif>_blank</option>
								<option value="_self" @if($index->target == '_self') selected @endif>_self</option>
								<option value="_parent" @if($index->target == '_parent') selected @endif>_parent</option>
								<option value="_top" @if($index->target == '_top') selected @endif>_top</option>
							</select>
						</div>
						<div class="form-group">
						  <label>Link</label>
						  <input type="text" class="form-control" name="link2" placeholder="{{ ucwords(trans('common.enter')) }} link" value="{{ $index->link2 }}">
						</div>
						<div class="form-group">
							<label>Position</label>
							<select class="form-control" name="pos">
								<option value="0">No choice</option>
								<option value="footer" @if($index->pos == 'footer') selected @endif>Footer</option>
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
</section>
<!-- /.content -->
@endsection