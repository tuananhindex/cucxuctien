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
            <form method="post" action="<?php echo route($e['route'].'.list.post') ?>">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="box">
                @include('backend.widget.list_box_header')
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <div class="form-inline">
                      <label style="margin:0 5px 0 12px;">{{ trans($e['lang'].'.category') }}</label>
                      <select class="form-control filter_cat">
                        <option value="0">Không</option>
                        {!! $MultiLevelSelect !!}
                      </select>

                      <label style="margin:0 5px 0 12px;">{{ trans($e['lang'].'.language') }}</label>
                      <select class="form-control filter_language">
                        @foreach($languages as $val)
                        <option value="{{ $val->id }}" @if(empty($_GET['lang_id'])) @if($val->id == $df_lang->id) selected @endif @else
                        @if($val->id == $_GET['lang_id']) selected @endif @endif>{{ ucfirst($val->name) }} @if($val->id == $df_lang->id) - Default @endif</option>
                        @endforeach
                      </select>
                  </div>
                  <table class="table table-hover">
                    <tbody>
                    <tr>
                      <th><input type="checkbox" class="check_box_all"></th>
                      <th>{{ ucwords(trans($e['lang'].'.name')) }}</th>
                      <th>{{ ucwords(trans($e['lang'].'.order')) }}</th>
                      <th>{{ ucwords(trans($e['lang'].'.created_at')) }}</th>
                      <th>{{ ucwords(trans($e['lang'].'.updated_at')) }}</th>
                      <th>{{ ucwords(trans($e['lang'].'.status')) }}</th>
                      <th colspan="2">{{ ucwords(trans($e['lang'].'.action')) }}</th>
                    </tr>
                    @foreach($data as $val)
                    <tr>
                      <td><input type="checkbox" class="check_box" name="id[]" value="{{ $val->id }}"></td>
                      <td><a href="<?php echo route($e['route'].'.edit.get',$val->id) ?>">{{ ucfirst($val->name) }}</a></td>
                      <td><input type="number" name="price" min="0" style="width:45px !important" value="{{ $val->order }}" /><img width="20" style="margin: 5px 10px 0 0 ; display: none" src="{{ asset('assets/admin/img/loading.gif') }}" id="loadding"></td>
                      <td>{{ date('h:i d/m/Y',strtotime($val->created_at)) }}</td>
                      <td>@if(!empty($val->update_at)){{ date('h:i d/m/Y',strtotime($val->updated_at)) }}@else Chưa có cập nhật @endif</td>
                      <td>
                        @if($val->status == 1)
                            <span class="label label-success">Hiển Thị</span>
                        @else
                            <span class="label label-danger">Không Hiển Thị</span>
                        @endif
                      </td>
                      <td>
                        <a href="<?php echo route($e['route'].'.edit.get',$val->id) ?>"><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i></a>
                      </td>
                      <td>
                        <a href="<?php echo route($e['route'].'.delete',$val->id) ?>"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></a>
                      </td>
                    </tr>
                    @endforeach
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
      data : { _token : $('input[name="_token"]').val() , val : $(this).val() , id : id , table : 'menu' },
      success : function(rs){
        //alert(rs);
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
          data : { _token : $('input[name="_token"]').val() , val : $(this).val() , id : id , table : 'menu' },
          success : function(rs){
            //alert(rs);
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
          location.href = '{{ route(Route::currentRouteName()) }}@if(Route::current()->parameter("key"))/{{ Route::current()->parameter("key") }}@endif?lang_id='+lang;
        }else{
          location.href = '{{ route(Route::currentRouteName()) }}@if(Route::current()->parameter("key"))/{{ Route::current()->parameter("key") }}@endif?lang_id='+lang+'&cat_id='+val;
        }
      }else{
        if(val == 0){
          location.href = '{{ route(Route::currentRouteName()) }}@if(Route::current()->parameter("key"))/{{ Route::current()->parameter("key") }}@endif';
        }else{
          location.href = '{{ route(Route::currentRouteName()) }}@if(Route::current()->parameter("key"))/{{ Route::current()->parameter("key") }}@endif?cat_id='+val;
        }
      }
      
      
  });

  $('select.filter_language').change(function(){
      var val = $(this).val();
      var cat = getUrlParameter('cat_id');
      if(cat){
        if(val == 0){
          location.href = '{{ route(Route::currentRouteName()) }}@if(Route::current()->parameter("key"))/{{ Route::current()->parameter("key") }}@endif?cat_id='+cat;
        }else{
          location.href = '{{ route(Route::currentRouteName()) }}@if(Route::current()->parameter("key"))/{{ Route::current()->parameter("key") }}@endif?cat_id='+cat+'&lang_id='+val;
        }
      }else{
        if(val == 0){
          location.href = '{{ route(Route::currentRouteName()) }}@if(Route::current()->parameter("key"))/{{ Route::current()->parameter("key") }}@endif';
        }else{
          location.href = '{{ route(Route::currentRouteName()) }}@if(Route::current()->parameter("key"))/{{ Route::current()->parameter("key") }}@endif?lang_id='+val;
        }
      }
  });
  
</script>
<!-- /.content -->
@endsection