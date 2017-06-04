<?php
    $cat = DB::table('product_category')->where(['id' => $data->fk_catid , 'status' => 1])->select('alias')->first();
?>

<div class="product-grid">
    <div class="prod-image">
        <div class="image-wrapper">
            <a href="@if(isset($cat)){{ route('product',[$cat->alias,$data->alias]) }}@else javascript:void(0) @endif">
            <img alt="Ghế sopha kem" class="img-responsive" src="{{ asset($data->image) }}">
            </a>
            @if($data->promotion)
            <span class="flag sale">- 
            {{ $data->promotion }}% 
            </span>
            @endif
        </div>
    </div>
    <form id="product-actions-32585" action="{{ route('add_cart') }}" method="post" enctype="multipart/form-data">
        <?php 
          $giathucte = $data->price - $data->price * $data->promotion / 100;
          ?>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="id" value="{{ $data->id }}">
        <input type="hidden" name="image" value="{{ $data->image }}">
        <input type="hidden" name="name" value="{{ $data->name }}">
        <input type="hidden" name="price" value="{{ $giathucte }}">
        <input type="hidden" name="qty" value="1">
        <div class="prod-detail">
            <h3><a href="@if(isset($cat)){{ route('product',[$cat->alias,$data->alias]) }}@else javascript:void(0) @endif">{{ ucfirst($data->name) }}</a></h3>
            <!-- <div class="grid-review">
                <div class="bizweb-product-reviews-badge" data-id="32585"></div>
            </div> -->
            <div class="prod-price">
                @if($data->price)
                <span class="price">{{ number_format($data->price - $data->price * $data->promotion / 100) }}₫</span>
                @else
                <span class="price">Liên hệ</span>
                @endif
                @if($data->promotion)
                <span class="compare-price">{{ number_format($data->price) }}₫</span>
                @endif
            </div>
            <div class="prod-btn">
                <a href="@if(isset($cat)){{ route('product',[$cat->alias,$data->alias]) }}@else javascript:void(0) @endif" ><i class="fa fa-search" ></i></a>              
                <button type="submit" href="@if(isset($cat)){{ route('product',[$cat->alias,$data->alias]) }}@else javascript:void(0) @endif">
                <i class="fa fa-shopping-cart"></i><span> Chọn hàng</span>
                </button>
            </div>
        </div>
    </form>
</div>
