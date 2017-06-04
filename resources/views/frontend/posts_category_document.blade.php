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
          <p>{!! Helper::duongdan($cats,$index->id) !!}</p>
          {!! Block::box_search($index->nation) !!}
          @if(isset($posts) && count($posts) > 0)
          <table class="table table-hover" style="padding: 0;">
              <tr style="background-color: beige;font-weight: bold">
                <th>Symbol number</th>
                <th>Date issued</th>
                <th>Document Name</th>
              </tr>
              @foreach($posts as $val)
              <tr>
                <td><a href="{{ route('posts',$val->alias) }}">{{ $val->sokyhieu }}</a></td>
                <td>{{ date('d/m/Y',strtotime($val->ngaybanhanh)) }}</td>
                <td>{{ ucfirst($val->name) }}</td>
              </tr>
              @endforeach
          </table>
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
