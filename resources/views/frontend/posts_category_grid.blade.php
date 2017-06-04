@extends('frontend.master')
@section('content')
<div class="main-wrap">
    <section class="row_section" style='  margin:20px 0px !important;'>
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <div>
                        {!! Block::support_online() !!}
                    </div>
                    <div>
                        <!-- Vertical Menu --> 
                        {!! Block::box_category() !!}
                    </div>
                    <div>
                        <!--$css_item,$box_width,$position,$num_item_row,$sidebar -->
                        <!--begin box <=4.5-->
                        {!! Block::box_sidebar($title_posts_sidebar,$posts_sidebar) !!}
                        <!--end box <=4.5-->
                    </div>
                    <div>
                        <script language="javascript">
                            <!--
                                function newsletter_form(id,num)
                                {
                                    
                                    //var frm=document+id;
                                    var frm=document.forms[id];
                                    //alert(frm);
                                    // alert(frm.newsletter_email.value);return false;
                                     if(frm.newsletters_email.value=='')
                                     {
                                         alert('Vui lòng nhập địa chỉ email');
                                         return false;
                                         }
                                         var domain="http://demot402.web4s.vn/?site=newsletters";
                                         $.post(domain, {newsletters_email: frm.newsletters_email.value,action:'request'})
                                        .done(function( data ) {
                                            $("#newsletters_result_"+num).html(data);
                                        });
                                        return false; 
                                    }
                                -->
                        </script>
                        
                    </div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <section class="banner-big clearfix">                 
                                @if(file_exists($index->image))
                                <img src="{{ asset($index->image) }}">
                                @endif
                            </section>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <section class="clearfix">
                                <section class="breadcrumbs clearfix">
                                    <a href="{{ route('home') }}" title="Trang chủ">Trang chủ</a>
                                    &nbsp;&nbsp;/&nbsp;&nbsp;<a href="demot402_web4s_default_42.html">{{ $index->name }}</a>                   
                                </section>
                            </section>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
                            <!-- thanh order san pham -->
                            <section class="utilities col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                
                                <div class="view pull-right">
                                    <span>Hiển thị</span>
                                    <a href="http://demot402.web4s.vn/?site=global&displaytype=grid"><i class="fa fa-th "></i></a>
                                    <a href="http://demot402.web4s.vn/?site=global&displaytype=list"><i class="fa fa-th-list active"></i></a>
                                </div>
                            </section>
                            <!-- thanh order san pham -->
                            <!--grid-->
                            <!--end grid-->
                            <section id="product-listitem">
                                <div class="listitem">
                                    <h1>
                                        <span>{{ $index->name }}</span>
                                    </h1>
                                    @if(count($posts) > 0)
                                    @foreach($posts as $val)
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 col93 mg">
                                        <div class="product">
                                            <div class="image">
                                                <div class="img-overflow">
                                                    <a href="{{ route('posts',$val->alias) }}" title="{{ $val->name }}">
                                                    <img src="{{ '../../binwin_common/'.$val->image }}" alt="">
                                                    </a>
                                                    <div class="ImageOverlayBe"></div>
                                                    
                                                </div>
                                            </div>
                                            <div class="des-product">
                                                <a href="{{ route('posts',$val->alias) }}" title="{{ $val->name }}">
                                                    <h3>{{ $val->name }}</h3>
                                                </a>
                                                <p>{{ $val->description }}.</p>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif
                                    {!! $posts->render() !!}
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

 




 



 
 
 
 






 





 




 



 
 
 
 






 





 




 



 
 
 
 







 




 



 
 
 
 







 




 



 
 
 
 







 




 



 
 
 
 







 




 



 
 
 
 




