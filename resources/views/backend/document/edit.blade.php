@extends('backend.master')
@section('content')
<!-- Editer -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/css/datepicker3.css') }}">
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
<script type="text/javascript" src="{{ asset('assets/admin/plugins/daterangepicker/moment.min.js') }}"></script>

<!-- Include Date Range Picker -->
<script type="text/javascript" src="{{ asset('assets/admin/plugins/daterangepicker/daterangepicker.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/plugins/daterangepicker/daterangepicker.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets\admin\plugins\jstree\dist\themes\default\style.min.css') }}">
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
						  <label>Symbol number</label>
						  <input type="text" class="form-control add-alias" name="sokyhieu" value="{{ $index->sokyhieu }}" placeholder="Symbol number" required="">
						</div>
						<div class="form-group">
							<label style="margin-right: 20px">Date issued</label>
							
							<input type="text" class="form-control datepicker" name="ngaybanhanh" value="{{ date('d/m/Y',strtotime($index->ngaybanhanh)) }}" style="width: 300px" />
						</div>
						<div class="form-group">
							<label style="margin-right: 20px">Effective date</label>
							
							<input type="text" class="form-control datepicker" name="ngayhieuluc" value="{{ date('d/m/Y',strtotime($index->ngayhieuluc)) }}" style="width: 300px" />
						</div>
						<div class="form-group">
						  <table id="table2" class="table table-bordered">
						  	<tr>
						  		<th width="200">Unit issued</th>
						  		<th width="200">The signer</th>
						  		<th width="200">Regency</th>
						  		<th width="200">Delete</th>
						  	</tr>
						  	@if(isset($details) && count($details) > 0)
						  	@foreach($details as $val)
						  	<tr>
						  		<td>{{ $val->donvibanhanh }}</td>
						  		<td>{{ $val->nguoiky }}</td>
						  		<td>{{ $val->chucvu }}</td>
						  		<td><a href="{{ route('backend.document.delete_details',$val->id) }}"><i class="fa fa-trash-o"></i></a></td>
						  	</tr>
						  	@endforeach
						  	@endif
						  	<tr>
						  		<td><input style="width: 100%" type="text" name="donvibanhanh[]"></td>
						  		<td><input style="width: 100%" type="text" name="nguoiky[]"></td>
						  		<td><input style="width: 100%" type="text" name="chucvu[]"></td>
						  		<td></td>
						  	</tr>
						  </table>
						  <a href="javascript:void(0)" id="add2"><i class="fa fa-plus"></i> Add</a>
						</div>
						<div class="form-group">
							<label>{{ ucwords(trans($e['lang'].'.category')) }}</label>
							<div id="product_category_treedata">
								<!-- <li data-jstree='{"opened":true}'>Root node -->
								{!! $MultiLevelTreeData !!}	
							</div>
							<input type="hidden" name="fk_catId" id="fk_catId" value="" />
						</div>
						<label>Up file</label>
						<div class="form-group">
							
							<input id="xFilePath" name="FilePath" type="text" size="120" />
							<input type="button" value="Browse Server" onclick="BrowseServer();" />
						</div>
						<a href="{{ $index->file }}" target="_blank">{{ $index->file }}</a>
						<div class="form-group form-inline">
						  	<label style="margin-right: 20px">Effect</label>
						  	<label class="radio-inline"><input type="radio" name="IsEffect"  value="1" @if($index->IsEffect) checked="" @endif>{{ ucwords(trans('common.yes')) }}</label>
						  	<label class="radio-inline"><input type="radio" name="IsEffect"value="0" @if(!$index->IsEffect) checked="" @endif>{{ ucwords(trans('common.no')) }}</label>
						</div>
						<div class="form-group">
						  <label>{{ ucwords(trans($e['lang'].'.order')) }}</label>
						  <input type="number" class="form-control" name="order" value="{{ $index->order }}" placeholder="{{ ucwords(trans('common.order_des')) }}" >
						</div>
						<div class="form-group">
						  <label>
						  	<input type="checkbox" name="IsCustomer" value="1" @if($index->IsCustomer == 1) checked @endif> {{ ucwords(trans($e['lang'].'.hot_new')) }}
						  </label>
						  
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

	$('.btn-add-link-lang').click(function(){
	    var value = $('select.add_posts-lang').val();
	    var res = value.split("hihihihi");
	    var arr = res[0].split('/');
	    var href = '/'+arr[3]+'/'+arr[4];
	    CKEDITOR.instances.lang_content.insertHtml('<a href=\x22' + href + '\x22>'+ res[1] +'</a>');

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

                    language : $('select[name="language"]').val()
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
<script type="text/javascript" src="{{ asset('assets\admin\plugins\jstree\dist\jstree.min.js') }}"></script>
<script type="text/javascript">
	$('.delete_img').click(function(){
		if(!window.confirm('Thao tác này không thể khôi phục . Bạn có thực sự muốn xóa ?')){ 
		    return false; 
		}
	});

	$('input[name="code"]').bind('keydown keyup',function(){
		$('#loadding').show();
		$.ajax({
			type : 'POST',
			url : "{{ route('check_code_product') }}",
			data : { _token : $('input[name="_token"]').val() , val : $(this).val() , id : {{ $index->id }} },
			success : function(rs){
				var obj = $('#rs_check_code_product');
				if(rs == 1){
					obj.html('(Mã sản phẩm đã tồn tại)');
					obj.css('color','#f00');
				}else{
					obj.html('(Mã sản phẩm hợp lệ)');
					obj.css('color','blue');
				}
				//console.log(rs);
			},
			error : function(err){
				console.log('Quá trình ajax không thành công');
			}
		}).always(function(){
	
	           $('#loadding').hide();
	
	       });
	});
	
	$(function () {
		$("#product_category_treedata").jstree({
			"checkbox" : {
				"keep_selected_style" : false
			},
			"plugins" : [ "checkbox" ]
		});
	
		$(document).click(function(){
			var selectedElmsIds = [];
			var selectedElms = $('#product_category_treedata').jstree("get_checked",true);
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

	$('#add2').click(function(){
		$('#table2').append('<tr><td><input style="width: 100%" type="text" name="donvibanhanh[]"></td><td><input style="width: 100%" type="text" name="nguoiky[]"></td><td><input style="width: 100%" type="text" name="chucvu[]"></td></tr>');
	});
</script>
<script type="text/javascript" src="{{ asset('assets/frontend/js/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript">
    $('.datepicker').datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy',
    });

    
</script>
<!-- /.content -->
@endsection