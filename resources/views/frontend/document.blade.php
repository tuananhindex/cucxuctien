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
          <p>{!! Helper::duongdan($cats,$index->fk_catid) !!}</p>
          <table class="table table-hover" style="padding: 0;">
            <tr style="background-color: beige;font-weight: bold">
              <td colspan="4" align="center">Information Document Number : {{ $index->sokyhieu }}</td>
            </tr>
            <tr>
              <td>Effect Document</td>
              <td colspan="3">@if($index->IsEffect) Còn hiệu lực @else Hết hiệu lục @endif</td>
            </tr>
            <tr>
              <td>Symbol Number</td>
              <td colspan="3">{{ $index->sokyhieu }}</td>
            </tr>
            <tr>
              <td>Document Name</td>
              <td colspan="3">{{ ucfirst($index->name) }}</td>
            </tr>
            <tr>
              <td>Date Issued</td>
              <td colspan="3">{{ date('d/m/Y',strtotime($index->ngaybanhanh)) }}</td>
            </tr>
            <tr>
              <td>Effective Date</td>
              <td colspan="3">{{ date('d/m/Y',strtotime($index->ngayhieuluc)) }}</td>
            </tr>
            <tr>
              <td>Document Type</td>
              <td colspan="3">{{ ucfirst($category->name) }}</td>
            </tr>
            @if(isset($details) && count($details) > 0)
            @foreach($details as $key => $val)
            <tr>
              @if($key == 0)
              <td rowspan="{{ count($details) }}">Issuing unit / The signer / Regency</td>
              @endif
              <td>{{ ucwords($val->donvibanhanh) }}</td>
              <td>{{ ucwords($val->nguoiky) }}</td>
              <td>{{ ucwords($val->chucvu) }}</td>
            </tr>
            @endforeach
            @endif
            <tr>
              <td>File</td>
              <td colspan="3"><a href="{{ $index->file }}">Download</a></td>
            </tr>
          </table>

          @if(isset($rs_tags) && $rs_tags)
          <p>Tags : {!! $rs_tags !!}</p>
          @endif
          
          @if(isset($same) && count($same) > 0)
          <ul style="margin-top: 50px ; padding: 0" class="post-list category" >
              <h3 style="border-bottom: 1px solid #000; margin-bottom: 20px"><span style="background: #fff; padding-right: 10px">Other Documents</span></h3>
              @foreach($same as $val)
              <li>
                  <p>{!! Helper::duongdan($cats,$val->fk_catid) !!}</p>
                  <h5><i class="fa fa-file"></i> <a href="{{ route('posts',$val->alias) }}" title="{{ ucfirst($val->name) }}">{{ ucfirst($val->name) }}</a></h5>

                  
                  <div class="post-list-info">
                      <p class="author">
                          <small><i class="fa fa-clock-o"></i> {{ date_format(date_create($val->create_at), 'jS F Y') }} post by <i>{{ ucwords($val->authName) }}</i></small>
                      </p>
                      <p title="{{ ucfirst($val->description) }}">{{ ucfirst(mb_strimwidth($val->description, 0, 150, '...')) }}</p>
                      
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
