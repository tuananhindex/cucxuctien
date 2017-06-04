@if(isset($data) && count($data) > 0)
<ul class="product-grid">
@foreach($data as $val)
  <?php
    $cat = DB::table('product_category')->where(['id' => $val->fk_catid , 'status' => 1])->select('alias')->first();
  ?>
  <li>
    <?php 
        $expDate = date('Y-m-d H:i:s', strtotime(' -7 day'));
    ?>
    @if(strtotime($val->created_at) >= strtotime($expDate))
    <span class="product-label label-new"><img src="{{ asset('assets/frontend/images/iconnew.png') }}"></span>
      @if($val->promotion)
        <style type="text/css">
          .label-sale{
            right: auto;
            left: 0;
          }
        </style>
      @endif
    @endif
    
    @if($val->promotion)
      <span class="product-label label-sale">{{ $val->promotion }}%</span>
    @endif
    
    <a class="product-img" @if(isset($cat)) href="{{ route('product',[$cat->alias,$val->alias]) }} @else javascript:void(0) @endif" title="{{ $val->name }}"><img src="{{ '../../binwin_common/'.$val->image }}"/></a>
      <div class="product-info">
        <a class="product-name" @if(isset($cat)) href="{{ route('product',[$cat->alias,$val->alias]) }} @else javascript:void(0) @endif" title="{{ $val->name }}">{{ $val->name }}</a>
        
        <span class="price">@if($val->price){{ number_format($val->price - $val->price * $val->promotion / 100) }} VNĐ @else Liên hệ @endif</span>
        
      </div>
  </li>
@endforeach  
</ul>
@if($pagi)
  <div class="pagination clearfix pull-right">
    {!! $data->render() !!}
  </div>
@endif
@else
<p>Không có sản phẩm nào</p>
@endif