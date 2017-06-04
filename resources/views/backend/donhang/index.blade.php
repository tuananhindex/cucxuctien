@extends('backend.master')
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{ ucwords($e['module']) }}
        
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('backend.home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo route($e['route']) ?>">{{ ucwords($e['module']) }}</a></li>
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
            
            
            
            <div class="box">
                <div class="box-header">
                  <h3 class="box-title">
                  

                    <form action="{{ route('backend.donhang') }}">
                      <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
                      <div class="input-group pull-right" style="width: 250px;">
                        <input type="text" name="search_key" value="@if(isset($_GET['search_key']) && $_GET['search_key']){{ $_GET['search_key'] }}@endif" class="form-control input-sm pull-right" placeholder="Search">
                        <div class="input-group-btn">
                          <button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
                        </div>
                      </div>
                    </form>
                    
                  </h3>
                  <div class="box-tools">
                  
                    
            <form method="post" action="{{ route('backend.donhang.trangthai') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button type="submit" name="cancel" value="Ẩn" class="btn btn-danger pull-right btn-sm" style="margin-right:10px; font-weight: bold" ><i class="fa fa-ban"></i> Ẩn</button>
                    <button type="submit" name="wait" value="Chờ xử lý" class="btn btn-primary pull-right btn-sm" style="margin-right:10px; font-weight: bold" ><i class="fa fa-primary"></i> Chờ xử lý</button>
                    <button type="submit" name="success" value="Thành Công" class="btn btn-success pull-right btn-sm" style="margin-right:10px; font-weight: bold" ><i class="fa fa-check"></i> Thành công</button>
                    
                    
                  
                </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  
                  <table class="table table-hover">
                    <tbody>
                    <tr>
                      <th><input type="checkbox" class="check_box_all"></th>
                      <th>Mã đơn hàng</th>
                      <th>Người mua</th>
                      <th>Địa chỉ nhận hàng</th>
                      <th>Ngày đặt</th>
                      <th>Số mặt hàng</th>
                      <th>Số sản phẩm</th>
                      <th>Thành tiền</th>
                      <th>Trạng thái</th>
                      <th></th>
                    </tr>
                    @if(isset($data) && count($data) > 0)
                    @foreach($data as $val)
                    <tr>
                      <td><input type="checkbox" class="check_box" name="id[]" value="{{ $val->id }}"></td>
                      <td>{{ $val->madonhang }}</td>
                      <td>{{ $val->ten }}</td>
                      <td>{{ $val->diachi }}</td>
                      <td>{{ date('H:i d/m/Y',strtotime($val->created_at)) }}</td>
                      <td align="center">{{ $val->somathang }}</td>
                      <td align="center">{{ $val->sosanpham }}</td>
                      <td>{{ number_format($val->tongtien) }} VNĐ</td>
                      <td>
                        @if($val->trangthai == 1)
                        
                        <span class="label label-success">Thành công</span>
                        @elseif($val->trangthai == 2)
                        <span class="label label-danger">Hủy</span>
                        
                        @else
                        <span class="label label-primary">Chờ xử lý</span>
                        
                        @endif
                      </td>
                      <td><a href="?madonhang={{ $val->madonhang }}@if(isset($_GET['page']))&page={{ $_GET['page'] }}@endif @if(isset($_GET['search_key']))&search_key={{ $_GET['search_key'] }} @endif">Xem chi tiết</a></td>
                    </tr>
                    @endforeach
                    @endif
                    
                    </tbody>
                  </table>
                 
                </div><!-- /.box-body -->
            </div>
            <div class="pull-right">
                {!! $data->render() !!}
            </div>
            
            </form>
        </div>
    </div>

</section>
<script type="text/javascript">
  $('input[name="price"]').change(function(){
    var id  = $(this).parent().parent().find($('.check_box')).val();
    $('#loadding').show();

    $.ajax({
      type : 'POST',
      url : "{{ route('change_order') }}",
      data : { _token : $('input[name="_token"]').val() , val : $(this).val() , id : id , table : 'product' },
      success : function(rs){
        if(rs == 'error'){
          alert('Bạn không thể cập nhật sản phẩm này');
        }
      },
      error : function(err){
        alert ('Thay đổi thứ tự không thành công');
      }
    }).always(function(){

          $('#loadding').hide();

      });
  });

  $('input[name="price"]').bind('keypress keyup',function(){
    $('form').submit(function(e){
      e.preventDefault();
    });
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if (keycode == '13') {

      var id  = $(this).parent().parent().find($('.check_box')).val();
        $('#loadding').show();

        $.ajax({
          type : 'POST',
          url : "{{ route('change_order') }}",
          data : { _token : $('input[name="_token"]').val() , val : $(this).val() , id : id , table : 'product' },
          success : function(rs){
            if(rs == 'error'){
              alert('Bạn không thể cập nhật sản phẩm này');
            }
          },
          error : function(err){
            alert ('Thay đổi thứ tự không thành công');
          }
        }).always(function(){

              $('#loadding').hide();

          });
    }
    
  });

  $('select.filter_cat').change(function(){
      var val = $(this).val();
      var lang = getUrlParameter('lang_id');
      if(lang){
        if(val == 0){
          location.href = '{{ route(Route::currentRouteName()) }}?lang_id='+lang;
        }else{
          location.href = '{{ route(Route::currentRouteName()) }}?lang_id='+lang+'&cat_id='+val;
        }
      }else{
        if(val == 0){
          location.href = '{{ route(Route::currentRouteName()) }}';
        }else{
          location.href = '{{ route(Route::currentRouteName()) }}?cat_id='+val;
        }
      }
      
      
  });

  
</script>
<!-- /.content -->

@endsection