<?php
    $cat = DB::table('product_category')->where(['id' => $data->fk_catid , 'status' => 1])->select('alias')->first();
?>
<div class="product-box clearfix">                              
  <div class="product-thumbnail f-left">

    
    @if($data->promotion)
      <div class="sale-flash">- 
          {{ $data->promotion }}% 
      </div>
      @endif
    

    <a href="@if(isset($cat)){{ route('product',[$cat->alias,$data->alias]) }} @else javascript:void(0) @endif" title="{{ ucfirst($data->name) }}">
      <img src="{{ asset($data->image) }}" alt="" style="padding-top: 0px;">
    </a>    
  </div>
  <div class="product-info f-left">
    <h3 class="product-name"><a href="@if(isset($cat)){{ route('product',[$cat->alias,$data->alias]) }} @else javascript:void(0) @endif" title="{{ ucfirst($data->name) }}">{{ ucfirst($data->name) }}</a></h3>
    
    <div class="price-box clearfix">      
      <div class="special-price f-left">
        <span class="price product-price">{{ number_format($data->price - $data->price * $data->promotion / 100) }}₫</span>
      </div>
      
      <div class="old-price">                              
        <span class="price product-price-old">
          @if($data->price)
              {{ number_format($data->price) }}₫    
              @else
              Liên hệ
              @endif       
        </span>
      </div>
            
    </div>    
    
    
    <div class="product-summary">
      
       {{ ucfirst($data->description) }}
      
    </div>
  </div>

</div>

