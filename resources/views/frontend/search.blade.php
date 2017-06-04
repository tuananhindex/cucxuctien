@extends('frontend.master')
@section('content')
<section id="slider">
    <div class="col-md-12 pagelist-title">
        <h2 style="text-transform: uppercase;"> 
        @if($_GET['nation'] == 'vi')
        MOIT
        VIETNAM
        @else
        MOIC 
        LAO
        @endif
        
        </h2>
        <!--<ul class="text">-->
        <!--<li>MOIC LAO</li>-->
        <!--<li>NEWS AND EVENT</li>-->
        <!--</ul>-->
    </div>
    <div class="clearfix"></div>
</section>
<section id="content-center" class="row">
  <div id="content-left">
      <div class="col-md-9 col-xs-12">
          {!! Block::box_search($_GET['nation']) !!}
          @if(isset($posts) && count($posts) > 0)
          <ul class="post-list category" style="padding: 0;">
              @foreach($posts as $val)
              <li>
                  <p>{!! Helper::duongdan($cats,$val->fk_catid) !!}</p>
                  <h3><a href="{{ route('posts',$val->alias) }}" title="{{ ucfirst($val->name) }}">{{ ucfirst($val->name) }}</a></h3>
                  @if(file_exists($val->image))
                  <div class="col-md-2">

                      <div class="row post-list-img">
                          <a href="{{ route('posts',$val->alias) }}" title="{{ ucfirst($val->name) }}"><img src="{{ asset($val->image) }}" title="{{ ucfirst($val->name) }}" alt="{{ ucfirst($val->name) }}" class="img-responsive"/></a>
                      </div>
                  </div>
                  <div class="col-md-10 post-list-info">
                  @else
                  <div>
                  @endif
                      <p class="author">
                          <small><i class="fa fa-clock-o"></i> {{ date_format(date_create($val->create_at), 'jS F Y') }} post by <i>{{ ucwords($val->authName) }}</i></small>
                      </p>
                      <p>{{ ucfirst($val->description) }}</p>
                      
                  </div>
              </li>
              @endforeach
          </ul>
          <nav class="text-center">
              {!! $posts->render() !!}
          </nav>
          @else
          No data
          @endif
          
      </div>
  </div>
  <div id="content-right">
      <div class="col-md-3 col-xs-12">
          {!! Block::cat_sidebar($cat_sidebar) !!}
      </div>
  </div>
</section>
@endsection
