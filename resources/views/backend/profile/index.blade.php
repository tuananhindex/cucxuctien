@extends('backend.master')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{ ucfirst(trans('common.account')) }}
        
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('backend.home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="javascript:void(0)">{{ ucfirst(trans('common.account')) }}</a></li>
    </ol>
</section>
<!-- Main content -->

<section class="content">
  <div class="row">
  	<div class="col-md-12">
  	@if(Session::has('alert'))
		{!! Session::get('alert') !!}
	@endif
	</div>
    <div class="col-md-3">

      <!-- Profile Image -->
      <div class="box box-primary">
        <div class="box-body box-profile">
          <img class="profile-user-img img-responsive img-circle" src="{{ asset($acc->image) }}" alt="User profile picture">
          <h3 class="profile-username text-center">{{ ucwords($acc->name) }}</h3>
          
          <!-- <ul class="list-group list-group-unbordered">
            <li class="list-group-item">
              <b>Followers</b> <a class="pull-right">1,322</a>
            </li>
            <li class="list-group-item">
              <b>Following</b> <a class="pull-right">543</a>
            </li>
            <li class="list-group-item">
              <b>Friends</b> <a class="pull-right">13,287</a>
            </li>
          </ul> -->

          
          <form method="post" id="form-change-img" action="{{ route('backend.profile.change_img') }}" enctype="multipart/form-data">
          	<input type="hidden" name="_token" value="{{ csrf_token() }}">
          	<input type="hidden" name="id" value="{{ $acc->id }}" >
          	<input type="file" name="image" class="input-change-image" style="display:none">
          	<button href="javascript:void(0)" class="btn btn-primary btn-block btn-change-image"><b>{{ ucfirst(trans('common.change_avatar')) }}</b></button>
          </form>
          <script type="text/javascript">
          	$('.btn-change-image').click(function(e){
          		e.preventDefault();
          		$('.input-change-image').click();
          		$('.input-change-image').change(function(){
          			$('#form-change-img').submit();
          		});

          	});
          </script>

        </div><!-- /.box-body -->
      </div><!-- /.box -->

      
    </div><!-- /.col -->
    <div class="col-md-9">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
        	<li class="active"><a href="#settings" data-toggle="tab">{{ ucfirst(trans('common.profile')) }}</a></li>
          	<li><a href="#activity" data-toggle="tab">{{ ucfirst(trans('common.change_pw')) }}</a></li>
          
        </ul>
        <div class="tab-content">
          <div class="tab-pane" id="activity">
          	<form class="form-horizontal" method="post" action="{{ route('backend.profile.change_pw') }}">
          	  <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" name="id" value="{{ $acc->id }}" >
              <div class="form-group">
                <label for="inputName" class="col-sm-3 control-label">{{ ucfirst(trans('common.pw_cr')) }}</label>
                <div class="col-sm-9">
                  <input type="password" name="password_old" class="form-control" id="inputName" placeholder="{{ ucfirst(trans('common.pw_cr')) }}">
                </div>
              </div>
              <div class="form-group">
                <label for="inputName" class="col-sm-3 control-label">{{ ucfirst(trans('common.pw_new')) }}</label>
                <div class="col-sm-9">
                  <input type="password" name="password" class="form-control" id="inputName" placeholder="{{ ucfirst(trans('common.pw_new')) }}">
                </div>
              </div>
              <div class="form-group">
                <label for="inputName" class="col-sm-3 control-label">{{ ucfirst(trans('common.confirm_pw')) }}</label>
                <div class="col-sm-9">
                  <input type="password" name="password_confirmation" class="form-control" id="inputName" placeholder="{{ ucfirst(trans('common.confirm_pw')) }}">
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-3 col-sm-10">
                  <button type="submit" class="btn btn-primary">{{ ucfirst(trans('common.update')) }}</button>
                </div>
              </div>
            </form>
          </div><!-- /.tab-pane -->
          
          <div class="active tab-pane" id="settings">
            <form class="form-horizontal" method="post" action="{{ route('backend.profile.edit') }}">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" name="id" value="{{ $acc->id }}" >
              <div class="form-group">
                <label for="inputName" class="col-sm-2 control-label">{{ ucfirst(trans('common.username')) }}</label>
                <div class="col-sm-10">
                  <input type="text" name="username" disabled="" value="{{ $acc->username }}" class="form-control" id="inputName" placeholder="Name">
                </div>
              </div>	
              <div class="form-group">
                <label for="inputName" class="col-sm-2 control-label">{{ ucfirst(trans('common.name')) }}</label>
                <div class="col-sm-10">
                  <input type="text" name="name" value="{{ $acc->name }}" class="form-control" id="inputName" placeholder="Name">
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail" class="col-sm-2 control-label">Email</label>
                <div class="col-sm-10">
                  <input type="email" name="email" value="{{ $acc->email }}" class="form-control" id="inputEmail" placeholder="Email">
                </div>
              </div>
              <div class="form-group">
                <label for="inputName" class="col-sm-2 control-label">{{ ucfirst(trans('common.phone')) }}</label>
                <div class="col-sm-10">
                  <input type="text" name="phone" value="{{ $acc->phone }}" class="form-control" id="inputName" placeholder="{{ ucfirst(trans('common.phone')) }}">
                </div>
              </div>
              <div class="form-group">
                <label for="inputExperience" class="col-sm-2 control-label">{{ ucfirst(trans('common.introduce_yourself')) }}</label>
                <div class="col-sm-10">
                  <textarea class="form-control" name="description" id="inputExperience" placeholder="{{ ucfirst(trans('common.introduce_yourself')) }}">{{ $acc->description }}</textarea>
                </div>
              </div>
              
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-primary">{{ ucfirst(trans('common.update')) }}</button>
                </div>
              </div>
            </form>
          </div><!-- /.tab-pane -->
        </div><!-- /.tab-content -->
      </div><!-- /.nav-tabs-custom -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</section>
        
<!-- /.content -->
@endsection