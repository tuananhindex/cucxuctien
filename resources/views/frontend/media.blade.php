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
      <div class="col-md-9 col-xs-12">
          <h3>{{ ucfirst($index->name) }}</h3>
          <p class="author">
              <small><i class="fa fa-clock-o"></i> {{ date_format(date_create($index->create_at), 'jS F Y') }} post by <i>{{ ucwords($index->authName) }}</i></small>
              
          </p>
          <div class="news-content">
            <div class="row col-xs-12 col-md-9">
              @if($index->media_type == 'file')
              <video width="100%" controls>
                <source src="{{ $index->media }}" type="video/mp4">
                
              </video>
              @elseif($index->media_type == 'iframe')
              {!! $index->media !!}
              @elseif($index->media_type == 'link')
              <iframe width="100%"  src="{{ $index->media }}"></iframe>
              @endif
            </div>
              
              

          </div>
          <div class="clearfix"></div>

          @if(isset($rs_tags) && $rs_tags)
          <p>Tags : {!! $rs_tags !!}</p>
          @endif
          @if(isset($same) && count($same) > 0)
          <ul style="margin-top: 50px ; padding: 0" class="post-list category" >
              <h3 style="border-bottom: 1px solid #000; margin-bottom: 20px"><span style="background: #fff; padding-right: 10px">Other Videos</span></h3>
              @foreach($same as $val)
              <li>
                  <h5><a href="{{ route('posts',$val->alias) }}" title="{{ ucfirst($val->name) }}">{{ ucfirst($val->name) }}</a></h5>

                  <div class="col-md-2">
                      <div class="row post-list-img">
                          <a href="{{ route('posts',$val->alias) }}" title="{{ ucfirst($val->name) }}"><img src="{{ asset($val->image) }}" title="{{ ucfirst($val->name) }}" alt="{{ ucfirst($val->name) }}" class="img-responsive"/></a>
                      </div>
                  </div>
                  <div class="col-md-10 post-list-info">
                      <p class="author">
                          <small><i class="fa fa-clock-o"></i> {{ date_format(date_create($val->create_at), 'jS F Y') }} post by <i>{{ ucwords($val->authName) }}</i></small>
                      </p>
                      <p>{{ ucfirst($val->description) }}</p>
                      
                  </div>
              </li>
              @endforeach
          </ul>
          
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
