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
                  <table class="table table-hover">
                    <tbody>
                    <tr>
                      <th><input type="checkbox" class="check_box_all"></th>
                      <th>Tên</th>
                      <th>Trạng thái</th>
                      <th colspan="2">Chức năng</th>
                    </tr>
                    @foreach($data as $val)
                    <tr>
                      <td><input type="checkbox" class="check_box" name="id[]" value="{{ $val->id }}"></td>
                      <td><a href="<?php echo route($e['route'].'.edit.get',$val->id) ?>">{{ ucfirst($val->name) }}</a></td>
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
<!-- /.content -->
@endsection