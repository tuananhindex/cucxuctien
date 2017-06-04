@extends('frontend.master')
@section('content')
<section class="breadc">
    <div class="container breadpos">
        <div class="pull-left">
            <ol class="breadcrumb breadcrumbs">
                <li><a href="/" title="Trở lại trang chủ"><i class="fa fa-home"></i> Trang chủ</a></li>
                <li>Giỏ hàng</li>
            </ol>
        </div>
    </div>
</section>
<section class="main-cart-page main-container col1-layout">
    <div class="main container hidden-xs">
        <div class="col-main cart_desktop_page cart-page">
            <div class="cart page_cart hidden-xs-down">
                <form action="{{ route('update_cart') }}" method="post" novalidate="">
                    @if(Session::has('rs_cart'))
                    @if(Session::get('rs_cart')['result']) 
                    <p style="color:green;margin-top: 10px" id="rs_cart"><img src="{{ asset('assets/frontend/images/success.png') }}" width="15" />  {{ Session::get('rs_cart')['msg'] }}</p>
                    <script type="text/javascript">
                        $('#rs_cart').fadeOut(5000);
                    </script>
                    @endif
                    @endif   
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    @if(isset($data) && count($data) > 0)
                    <div class="bg-scroll">
                        <div class="cart-thead">
                            <div style="width: 17%">Ảnh sản phẩm</div>
                            <div style="width: 33%"><span class="nobr">Tên sản phẩm</span></div>
                            <div style="width: 15%" class="a-center"><span class="nobr">Đơn giá</span></div>
                            <div style="width: 14%" class="a-center">Số lượng</div>
                            <div style="width: 15%" class="a-center">Thành tiền</div>
                            <div style="width: 6%">Xoá</div>
                        </div>
                        <div class="cart-tbody">
                            @foreach($data as $val)
                            <?php
                                $obj = DB::table('product')->where('id',$val->id)->select('fk_catid','alias')->first();
                                $cat = DB::table('product_category')->where(['id' => $obj->fk_catid, 'status' => 1])->select('alias')->first();
                                
                                ?>
                            <div class="item-cart productid-63832">
                                <div style="width: 17%" class="image"><a class="product-image" title="{{ ucfirst($val->name) }}" href="@if(isset($cat)){{ route('product',[$cat->alias,$obj->alias]) }} @else javascript:void(0) @endif"><img alt="{{ ucfirst($val->name) }}" src="@if(Auth::guard('customer')->check()){{ asset($val->image) }}@else{{ asset($val->options->image) }}@endif" height="auto" width="75"></a></div>
                                <div style="width: 33%" class="a-center">
                                    <h2 class="product-name"> <a href="@if(isset($cat)){{ route('product',[$cat->alias,$obj->alias]) }} @else javascript:void(0) @endif">{{ ucfirst($val->name) }}</a> </h2>
                                </div>
                                <div style="width: 15%" class="a-center"><span class="item-price"> <span class="price">{{ number_format($val->price) }}₫</span></span></div>
                                <div style="width: 14%" class="a-center">
                                    <div class="input_qty_pr"><input class="variantID" name="variantId" value="63832" type="hidden"><button onclick="var result = document.getElementById('{{ $val->rowId }}'); var a = result.value; if( !isNaN(a) &amp;&amp; a > 1 ) result.value--;return false;" class="reduced_pop items-count btn-minus" type="button">–</button><input maxlength="12" min="0" class="input-text number-sidebar input_pop input_pop {{ $val->rowId }}" id="{{ $val->rowId }}" name="qty[{{ $val->rowId }}]" size="4" value="{{ $val->qty }}" type="text"><button onclick="var result = document.getElementById('{{ $val->rowId }}'); var a = result.value; if( !isNaN(a)) result.value++;return false;" class="increase_pop items-count btn-plus" type="button">+</button></div>
                                </div>
                                <div style="width: 15%" class="a-center"><span class="cart-price"> <span class="price">{{ number_format($val->price * $val->qty) }}₫</span> </span></div>
                                <div style="width: 6%"><a class="button remove-item remove-item-cart" title="Xóa" href="{{ route('delete_cart',$val->rowId) }}" data-id="63832"><span><span>Xóa</span></span></a></div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div style="margin-top: 10px">
                        <a href="{{ route('destroy_cart') }}"><button class="btn  btn-danger f-left" title="Xóa toàn bộ đơn hàng" type="button">Xóa toàn bộ giỏ hàng</span></button></a>
                        <button class="btn  btn-primary" title="Xóa toàn bộ đơn hàng" type="submit">Cập nhật giỏ hàng</span></button>
                        <a href="{{ route('checkout') }}">
                    </div>
                    @else
                    <p style="margin-top: 10px">Chưa có sản phẩm nào</p>
                    @endif
                </form>
                <div class="cart-collaterals cart_submit row">
                <div class="totals col-sm-6 col-md-5 col-xs-12 col-md-offset-7">
                <div class="totals">
                <div class="inner">
                @if(isset($data) && count($data) > 0)
                <table class="table shopping-cart-table-total" id="shopping-cart-totals-table">
                <colgroup>
                <col>
                <col>
                </colgroup>
                <tfoot>
                <tr>
                <td colspan="1" class="a-left"><strong>Tổng tiền</strong></td>
                <td class="a-right"><strong><span class="totals_price price"> @if(Auth::guard('customer')->check())
                <?php 
                    $total = DB::table('cart')->where('customer_id',$__cus->id)->orderBy('id','desc')->selectRaw('SUM(price * qty) as total')->first()->total;
                    echo number_format($total);
                    ?>
                @else
                {{ explode('.',Cart::subtotal())[0] }} 
                @endif₫</span></strong></td>
                </tr>
                </tfoot>
                </table>
                <ul class="checkout">
                <li><a href="{{ route('checkout') }}"><button class="button btn-proceed-checkout" title="Tiến hành đặt hàng" type="button"><span>Tiến hành đặt hàng</span></button></a></li>
                <li><a href="{{ route('home') }}"><button class="button custom-button " style="    width: 100%;    margin-top: 10px;    line-height: 30px;    text-transform: inherit;    font-size: 15px;" title="Tiếp tục mua sắm" type="button""><span>Tiếp tục mua sắm</span></button></a></li>
                </ul>
                @else
                <ul class="checkout">
                <li><a href="{{ route('home') }}"><button class="button custom-button " style="    width: 100%;    margin-top: 10px;    line-height: 30px;    text-transform: inherit;    font-size: 15px;" title="Tiếp tục mua sắm" type="button""><span>Tiếp tục mua sắm</span></button></a></li>
                </ul>
                @endif
                </div>
                </div>
                </div>
                </div>
            </div>
        </div>
    </div>
    <div class="cart-mobile hidden-md hidden-lg hidden-sm">
        
        @if(isset($data) && count($data) > 0)
        <form action="{{ route('update_cart') }}" method="post" novalidate="">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            @if(Session::has('rs_cart'))
            @if(Session::get('rs_cart')['result']) 
            <p style="color:green;margin-top: 10px" id="rs_cart"><img src="{{ asset('assets/frontend/images/success.png') }}" width="15" />  {{ Session::get('rs_cart')['msg'] }}</p>
            <script type="text/javascript">
                $('#rs_cart').fadeOut(5000);
            </script>
            @endif
            @endif   
            <div class="header-cart" style="background:#fff;">
                <div class="title-cart">
                    <h3>Giỏ hàng của bạn</h3>
                </div>
            </div>
            <div class="header-cart-content" style="background:#fff;">
                <div class="cart_page_mobile content-product-list">
                    @foreach($data as $val)
                    <?php
                        $obj = DB::table('product')->where('id',$val->id)->select('fk_catid','alias')->first();
                        $cat = DB::table('product_category')->where(['id' => $obj->fk_catid, 'status' => 1])->select('alias')->first();
                        
                        ?>
                    <div class="item-product item productid-63832 ">
                        <div class="item-product-cart-mobile"><a href="@if(isset($cat)){{ route('product',[$cat->alias,$obj->alias]) }} @else javascript:void(0) @endif">    </a><a class="product-images1" href="" title="{{ ucfirst($val->name) }}"><img alt="" src="@if(Auth::guard('customer')->check()){{ asset($val->image) }}@else{{ asset($val->options->image) }}@endif" height="150" width="80"></a></div>
                        <div class="title-product-cart-mobile">
                            <h3><a href="@if(isset($cat)){{ route('product',[$cat->alias,$obj->alias]) }} @else javascript:void(0) @endif" title="{{ ucfirst($val->name) }}">{{ ucfirst($val->name) }}</a></h3>
                            <p>Giá: <span>{{ number_format($val->price) }}₫</span></p>
                        </div>
                        <div class="select-item-qty-mobile">
                            <div class="txt_center"><input class="variantID" name="variantId" value="63832" type="hidden"><button onclick="var result = document.getElementById('qtyMobile63832'); var qtyMobile63832 = result.value; if( !isNaN( qtyMobile63832 ) &amp;&amp; qtyMobile63832 > 0 ) result.value--;return false;" class="reduced items-count btn-minus" type="button">–</button><input maxlength="12" min="0" class="input-text number-sidebar qtyMobile63832" id="qtyMobile63832" name="qty[{{ $val->rowId }}]" size="4" value="{{ $val->qty }}" type="text"><button onclick="var result = document.getElementById('qtyMobile63832'); var qtyMobile63832 = result.value; if( !isNaN( qtyMobile63832 )) result.value++;return false;" class="increase items-count btn-plus" type="button">+</button></div>
                            <a class="button remove-item remove-item-cart" href="{{ route('delete_cart',$val->rowId) }}" data-id="63832">Xoá</a>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="header-cart-price" style="">
                    <div class="title-cart ">
                        <h3 class="text-xs-left">Tổng tiền</h3>
                        <a class="text-xs-right totals_price_mobile">@if(Auth::guard('customer')->check())
                                            <?php 
                                              $total = DB::table('cart')->where('customer_id',$__cus->id)->orderBy('id','desc')->selectRaw('SUM(price * qty) as total')->first()->total;
                                              echo number_format($total);
                                            ?>
                                            @else
                                            {{ explode('.',Cart::subtotal())[0] }} 
                                            @endif₫</a>
                    </div>
                    <div class="checkout">
                    <button class="btn  btn-primary " style="    width: 100%;    margin-top: 10px;    line-height: 26px;    text-transform: inherit;    font-size: 14px;" title="Xóa toàn bộ đơn hàng" type="submit">Cập nhật giỏ hàng</span></button>
                    <a href="{{ route('checkout') }}">
                     <button class="btn-proceed-checkout-mobile" style="margin-top: 10px;"" title="Tiến hành thanh toán" type="button"><span>Tiến hành thanh toán</span></button>
                    </a>
                    <a href="{{ route('home') }}">
                        <button class="button custom-button " style="    width: 100%;    margin-top: 10px;    line-height: 26px;    text-transform: inherit;    font-size: 14px;" title="Tiếp tục mua sắm" type="button""><span>Tiếp tục mua sắm</span></button>
                        </a>
                    </div>
                </div>
            </div>
        </form>
        @else
        <div class="header-cart-price" style="">
            <p>Chưa có sản phẩm nào</p>
            <a href="{{ route('home') }}">
            <button class="button custom-button " style="    width: 100%;    margin-top: 10px;    line-height: 26px;    text-transform: inherit;    font-size: 14px;" title="Tiếp tục mua sắm" type="button""><span>Tiếp tục mua sắm</span></button>
            </a>
        </div>
        @endif
    </div>
</section>
@endsection
