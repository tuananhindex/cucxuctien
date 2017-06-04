@extends('backend.master')
@section('content')
<!-- Content Header (Page header) -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets\admin\plugins\jstree\dist\themes\default\style.min.css') }}">
<section class="content-header">
    <h1>
        {{ ucwords($e['module']) }}
        
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('backend.home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">{{ ucwords($e['action']) }}</li>
        
    </ol>
</section>
<!-- Main content -->
<section class="content">

  <!-- row -->
  <div class="row">
    <div class="col-md-12">
      <!-- The time line -->
      <ul class="timeline">
        <!-- timeline time label -->
        <li class="time-label">
          <span class="bg-blue">
            Nhật ký hoạt động
          </span>
        </li>
        <!-- /.timeline-label -->
       
        <!-- timeline item -->
        @if(isset($data) && count($data) > 0)
        @foreach($data as $val)
        <li>
          <i class="fa fa-user bg-aqua"></i>
          <div class="timeline-item">
            <span class="time"> {{ date('H:i d/m/Y',strtotime($val->created_at)) }}</span>
            <h3 class="timeline-header no-border"><a href="#">{{ ucfirst($val->userName) }}</a> {!! ucfirst($val->content) !!}</h3>
          </div>
        </li>
        @endforeach
        @else
        Không có hoạt động nào
        @endif
        <!-- END timeline item -->
        
        <!-- END timeline item -->
        <li>
          <i class="fa fa-clock-o bg-gray"></i>
        </li>
      </ul>
      <div class="pull-right">
	    {!! $data->render() !!}
	</div>
    </div><!-- /.col -->

  </div><!-- /.row -->

  
</section>
<script type="text/javascript" src="{{ asset('assets\admin\plugins\jstree\dist\jstree.min.js') }}"></script>
<script type="text/javascript">
	$('input[name="code"]').bind('keydown keyup',function(){
		$('#loadding').show();
		$.ajax({
			type : 'POST',
			url : "{{ route('check_code_product') }}",
			data : { _token : $('input[name="_token"]').val() , val : $(this).val() },
			success : function(rs){
				var obj = $('#rs_check_code_product');
				if(rs == 1){
					obj.html('(Mã sản phẩm đã tồn tại)');
					obj.css('color','#f00');
				}else{
					obj.html('(Mã sản phẩm hợp lệ)');
					obj.css('color','blue');
				}
				console.log(rs);
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
		
		
	});
</script>
<!-- /.content -->
@endsection