@extends('frontend.master')
@section('content')
<section id="slider">
    <div class="col-md-12 pagelist-title">
        <h2 style="text-transform: uppercase;"> 
        @if($index->nation == 'vi')
        MOIT
        VIETNAM
        @else
        MOIC 
        LAO
        @endif
        | {{ $index->name }}
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
      <div class="col-xs-12">
          <p>{!! Helper::duongdan($cats,$index->fk_catid) !!}</p>
          <h3>{{ ucfirst($index->name) }}</h3>
          <p class="author">
              @if(Helper::check_date_created($cats,$index->fk_catid))
              <small><i class="fa fa-clock-o"></i> {{ date_format(date_create($index->create_at), 'jS F Y') }} post by <i>{{ ucwords($index->authName) }}</i></small>
              @endif
          </p>
          <div class="news-content">
              {!! ucfirst($index->content) !!}
          </div>

          @if(isset($rs_tags) && $rs_tags)
          <p>Tags : {!! $rs_tags !!}</p>
          @endif
          
          
      </div>
  </div>
  
</section>
@endsection
