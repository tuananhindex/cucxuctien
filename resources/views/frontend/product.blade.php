@extends('frontend.master')
@section('content')

<section class="breadc">
  <div class="container breadpos">
    <div class="pull-left">
      <ol class="breadcrumb breadcrumbs">
        <li><a href="{{ route('home') }}" title="Trở lại trang chủ"><i class="fa fa-home"></i> Trang chủ</a></li>
        <li>
          <a  href="{{ route('product_category',$category->alias) }}">Quầy bar / Cafe</a>        
        </li>
        <li class="active">{{ ucfirst($index->name) }}</li>
      </ol>
    </div>
  </div>
</section>
<section class="p20">
  <div class="container">
    <div class="row p20">
      <div itemscope itemtype="http://schema.org/Product" class="product">
        <meta itemprop="shop-currency" content="VND">
        <div class="col-md-6 product-image-block ">
          <div class="featured-image">            
            <img id="product-featured-image" class="img-responsive" src="{{ asset($index->image) }}" 
              alt="{{ ucfirst($index->name) }}"
              />       
          </div>
          @if(isset($product_images) && count($product_images) > 0)
          <div class="swiper-container more-views" data-margin="10" data-items="5" data-direction="vertical" >
            <div class="swiper-wrapper">
              @foreach($product_images as $val)
              <div class="swiper-slide">
                <a href="{{ asset($val->src) }}" class="thumb-link" title="" rel="{{ asset($val->src) }}">
                <img src="{{ asset($val->src) }}" alt="{{ $index->name }}">
                </a>
              </div>
              @endforeach
            </div>
          </div>
          @endif
        </div>
        <div class="col-md-6 detail">
          @if(Session::has('rs_cart'))
          @if(Session::get('rs_cart')['result']) 
          <p style="color:green" id="rs_cart"><img src="{{ asset('assets/frontend/images/success.png') }}" width="15" />  Thêm giỏ hàng thành công</p>     
          @else
          <p style="color:red" id="rs_cart"><img src="{{ asset('assets/frontend/images/error.png') }}" width="15" />  Thêm giỏ hàng thất bại</p> 
          @endif
          <script type="text/javascript">
            $('#rs_cart').fadeOut(5000);
          </script>
          @endif
          <form action="{{ route('add_cart') }}" method="post" enctype="multipart/form-data">
            <?php 
              $giathucte = $index->price - $index->price * $index->promotion / 100;
              ?>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="id" value="{{ $index->id }}">
            <input type="hidden" name="image" value="{{ $index->image }}">
            <input type="hidden" name="name" value="{{ $index->name }}">
            <input type="hidden" name="price" value="{{ $giathucte }}">
            <div class="prod-detail">
              <h1 itemprop="name" class="product-title">{{ ucfirst($index->name) }}</h1>
              <div class="prod-price">
                @if($index->price)
                <span class="price">{{ number_format($index->price - $index->price * $index->promotion / 100) }}₫</span>
                @else
                <span class="price">Liên hệ</span>
                @endif
                @if($index->promotion)
                <span class="compare-price">{{ number_format($index->price) }}₫</span>
                @endif
              </div>
              <p><strong>Bảo hành</strong> :@if($index->baohanh) {{ $index->baohanh }}@else Không có thông tin bảo hành @endif</p>
              <div class="product-summary rte">
                {{ $index->description }}
              </div>
              <div class="product-variant" style="display: none">
                <select id="product-selectors" class="form-control" name="variantId" style="display:none">
                  <option  selected="selected"  value="63835">Ghi - 2.000.000₫</option>
                  <option  value="63836">Trắng - 2.000.000₫</option>
                </select>
              </div>
              <div class="check-contact product-quantity clearfix ">
                <label>Số lượng: </label>
                <div class="input-group">
                  <span class="input-group-btn data-dwn">
                    <div class="btn mathbtn" data-dir="dwn"><span class="fa fa-minus"></span></div>
                  </span>
                  <input type="text" class="form-control text-center"  value="1"  name="qty" 
                    min="1" step="1" >
                  <span class="input-group-btn data-up">
                    <div class="btn mathbtn" data-dir="up"><span class="fa fa-plus"></span></div>
                  </span>
                </div>
              </div>
              <div class="check-contact prod-btn clearfix ">
                <button type="submit">
                <i class="fa fa-shopping-cart"></i><span>Mua hàng</span>
                </button>
              </div>
             
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="row p20">
      <div class="col-md-8">
        <div class="detail_tab">
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#tab_1" aria-controls="home" role="tab" data-toggle="tab">Chi tiết sản phẩm</a></li>
            <li role="presentation"><a href="#tab_3" aria-controls="messages" role="tab" data-toggle="tab">Tags</a></li>
          </ul>
          <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="tab_1">
              {!! ucfirst($index->chitietsanpham) !!}
            </div>
            <div role="tabpanel" class="tab-pane" id="tab_3">
              <div class="tag-product">
                <label class="inline">Tags: </label>
                <span>@if($rs_tags) {!! $rs_tags !!} @else Không có thẻ @endif</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <aside>
          <div class="banner-list-col">
            <a href="javascript:void(0)">
            <img src="{{ asset('assets/frontend/images/prod-detail-banner.png') }}" alt="Future">
            </a>
          </div>
        </aside>
      </div>
    </div>
  </div>
</section>
@if(isset($product_same) && count($product_same) > 0)
<section class="p20 product-grid" style="border: none;">
  <div class="container">
    <div class="relate-title">
      <span>Sản phẩm liên quan</span>
    </div>
    <div class="row">
      <div id="owl-relate" class="owl-theme">
        @foreach($product_same as $val)
        {!! Block::product_box($val) !!}
        @endforeach
      </div>
    </div>
  </div>
</section>
@endif
<script type="text/javascript">
  window.onload = function() {
     if($(window).width() > 767){
       $(".swiper-container").each( function(){
         var config = {
           spaceBetween: $(this).data('margin'),
           slidesPerView: $(this).data('items'),
           direction: $(this).data('direction'),
           paginationClickable: true,
           grabCursor: true 
         };   
         var swiper = new Swiper(this, config);
         console.log(".swiper-container");
       });
     }
     $('.thumb-link').click(function(e){
       e.preventDefault();
       var hr = $(this).attr('href');
       $('#product-featured-image').attr('src',hr);
     })
   };
  
   $('span.input-group-btn.data-up').click(function(e){
       var val = $(this).parent().find('input').val();
       val ++;
       $(this).parent().find('input').val(val);
  
     });
     $('span.input-group-btn.data-dwn').click(function(e){
       var val = $(this).parent().find('input').val();
       if(val > 1){
         val --;
         $(this).parent().find('input').val(val);
       }
     });
  
</script>
<link href='{{ asset("assets/frontend/css/swiper.min.css") }}' rel='stylesheet' type='text/css' />
<script src='{{ asset("assets/frontend/js/swiper.min.js") }}' type='text/javascript'></script>
@endsection
