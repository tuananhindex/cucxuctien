@extends('frontend.master')
@section('content')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/css/checkout.css') }}">
<style type="text/css">
  .top-bar .tb-left{
    margin-top: 10px;
  }
</style>
<section class="breadc">
    <div class="container breadpos">
        <div class="pull-left">
            <ol class="breadcrumb breadcrumbs">
                <li><a href="/" title="Trở lại trang chủ"><i class="fa fa-home"></i> Trang chủ</a></li>
                <li>Thanh toán</li>
            </ol>
        </div>
    </div>
</section>
<div class="container checkout">
<div class="main">
  <form method="post" id="fm-checkout" action="{{ route('checkout_post') }}">

    <div class="wrap clearfix">
        <div class="row">
            
            <div class="col-md-4 col-sm-12 customer-info">
              
                <div define="{billing_address: {}, billing_expand:true}" class="form-group m0">
                    <h2>
                        <label class="control-label">Thông tin thanh toán</label>
                    </h2>
                    @if(!Auth::guard('customer')->check())
                    <div class="form-group">
                        <a href="#" data-toggle="modal" data-target="#dangky">Đăng ký tài khoản mua hàng</a>
                        <span style="padding: 0 5px;">/</span>
                        <a href="#" data-toggle="modal" data-target="#dangnhap">Đăng nhập </a>
                    </div>
                    @endif
                </div>
                <hr class="divider">
                
                <div class="billing">
                    
                    <div bind-show="billing_expand || !otherAddress">
                      @if(Auth::guard('customer')->check())
                      <?php 
                        $address = DB::table('customer_address')->where('cus_id',Auth::guard('customer')->user()->id)->select('id','address')->get();
                      ?>
                      @if(isset($address) && count($address) > 0)
                      <div class="form-group">
                        <div class="next-select__wrapper">
                        
                          <select name="diachi_select" class="form-control next-select">
                            @foreach($address as $val)
                            <option value="{{ $val->address }}">{{ $val->address }}</option>
                            @endforeach
                          </select>
                          <span class="next-icon next-icon--size-12">
                            <img src="{{ asset('assets/frontend/images/angle-down.png') }}" alt="" class="img-responsive">
                            </span>
                        </div>
                      </div>
                      <p>Thêm <span id="diachikhac" style="color:green;cursor:pointer">địa chỉ khác</span></p>
                      
                      <div class="form-group" id="diachi" style="display:none">
                          <input bind="billing_address.full_name" name="diachi" class="form-control" placeholder="Địa chỉ">
                          <div class="help-block with-errors"></div>
                      </div>
                      @else
                      <div class="billing_field" id="diachi">
                        <label class="billing_field_title">Địa chỉ</label>
                        <input value="" name="diachi" type="text">
                      </div>
                      @endif
                      
                      <div class="form-group">
                          <textarea name="yeucaukhac" value="" class="form-control" placeholder="Ghi chú"></textarea>
                      </div>
                      <script type="text/javascript">
                        $('#diachikhac').click(function(){
                          $('#diachi').show();
                        });
                      </script>

                      @else

                      <div class="form-group">
                          <input data-error="Vui lòng nhập họ tên" bind="billing_address.full_name" name="ten" class="form-control" placeholder="Họ và tên">
                          <div class="help-block with-errors"></div>
                      </div>
                      <div class="form-group">
                          <input data-error="Vui lòng nhập họ tên"  bind="billing_address.full_name" name="diachi" class="form-control" placeholder="Địa chỉ">
                          <div class="help-block with-errors"></div>
                      </div>
                      <div class="form-group">
                          <input data-error="Vui lòng nhập họ tên" bind="billing_address.full_name" name="sodienthoai" class="form-control" placeholder="Điện thoại">
                          <div class="help-block with-errors"></div>
                      </div>
                      <div class="form-group">
                          <input data-error="Vui lòng nhập họ tên" bind="billing_address.full_name" name="email" class="form-control" placeholder="Email">
                          <div class="help-block with-errors"></div>
                      </div>
                      <div class="form-group">
                          <textarea name="yeucaukhac" value="" class="form-control" placeholder="Ghi chú"></textarea>
                      </div>
                      @endif
                    </div>
                  
                </div>
                
            </div>
            <div class="col-md-4 col-sm-12 order-info" define="{order_expand: false}">
                <div class="order-summary order-summary--custom-background-color ">
                    <div class="order-summary-header summary-header--thin summary-header--border">
                        <h2>
                            <label class="control-label" style="display:inline-block !important">Đơn hàng</label>
                            <label class="control-label" style="display:inline-block !important">(<span style="color:#f00">{{ $cart_count }}</span> sản phẩm)</label>
                        </h2>
                        <a class="underline-none expandable expandable--pull-right mobile" bind-event-click="toggle(this, '.order-items')" bind-class="{open: order_expand}" href="javascript:void(0)">
                        Xem chi tiết
                        </a>
                    </div>
                    <div class="order-items mobile--is-collapsed" bind-class="{'mobile--is-collapsed': !order_expand}">
                        <div class="summary-body summary-section summary-product">
                            <div class="summary-product-list">
                                <ul class="product-list">
                                  @foreach($data as $val)
                                  <?php
                                    $obj = DB::table('product')->where('id',$val->id)->select('fk_catid','alias')->first();
                                    $cat = DB::table('product_category')->where(['id' => $obj->fk_catid, 'status' => 1])->select('alias')->first();

                                  ?>
                                    <li class="product product-has-image clearfix">
                                        <div class="product-thumbnail pull-left">
                                            <div class="product-thumbnail__wrapper">
                                                <img src="@if(Auth::guard('customer')->check()){{ asset($val->image) }}@else{{ asset($val->options->image) }}@endif" alt="{{ ucfirst($val->name) }}" class="product-thumbnail__image">
                                            </div>
                                            <span class="product-thumbnail__quantity" aria-hidden="true">{{ $val->qty }}</span>
                                        </div>
                                        <div class="product-info pull-left">
                                            <span class="product-info-name">
                                            <a href="@if(isset($cat)){{ route('product',[$cat->alias,$obj->alias]) }} @else javascript:void(0) @endif"><strong>{{ ucfirst($val->name) }}</strong></a>
                                            </span>
                                            <span class="product-info-name">
                                            <i>{{ number_format($val->price) }} ₫</i>
                                            </span>
                                        </div>
                                        <strong class="product-price pull-right" style="font-weight:bold">
                                        {{ number_format($val->price * $val->qty) }}₫
                                        </strong>
                                    </li>
                                  @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="summary-section border-top-none--mobile">
                        
                        <div class="total-line total-line-total clearfix">
                            <span class="total-line-name pull-left">
                            Tổng cộng : <b style="color:#f00">@if(Auth::guard('customer')->check())
                          <?php 
                            $total = DB::table('cart')->where('customer_id',$__cus->id)->orderBy('id','desc')->selectRaw('SUM(price * qty) as total')->first()->total;
                            echo number_format($total);
                          ?>
                          @else
                          {{ explode('.',Cart::subtotal())[0] }} 
                          @endif ₫</b>
                            </span>
                            <img src="{{ asset('assets/frontend/images/ajax-load.gif') }}" style="display:none; margin-left:10px" id="ajax-load">
                        </div>
                    </div>
                </div>
                <div class="form-group clearfix hidden-sm hidden-xs">
                    <input class="btn btn-primary col-md-12" onclick="$(this).hide();$('#ajax-load').show();" value="ĐẶT HÀNG" name="dathang" type="submit">
                </div>
                <div class="form-group has-error">
                    <div class="help-block ">
                        <ul class="list-unstyled">
                        </ul>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
 
</form>
</div>

</div>
@if(Session::has('rs_checkout'))
@if(!Session::get('rs_checkout')['result'])
<script type="text/javascript">alert("{!! Session::get('rs_checkout')['msg'] !!}")</script>
@endif
@endif
@endsection
