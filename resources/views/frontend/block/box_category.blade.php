<div class="box categories" style="margin-top: -18px;">
  <ul>
  	<!-- @if(isset($types) && count($types) > 0)
    <li class="filter-title"><span>Loại sản phẩm</span></li>
    @foreach($types as $val)
    <li><a>{{ ucfirst($val->name) }}</a></li>
    @endforeach
    @endif -->
    <li class="filter-title"><span>Loại sản phẩm</span></li>
    <li @if(Route::getCurrentRoute()->getName() == 'sanphambanchay') class="active" @endif><a title="sản phẩm bán chạy" href="{{ route('sanphambanchay') }}">Sản phẩm bán chạy</a></li>
    <li @if(Route::getCurrentRoute()->getName() == 'sanphammoi') class="active" @endif><a title="sản phẩm mới" href="{{ route('sanphammoi') }}">Sản phẩm mới</a></li>
    <li @if(Route::getCurrentRoute()->getName() == 'sanphamkhuyenmai') class="active" @endif><a title="sản phẩm khuyến mãi" href="{{ route('sanphamkhuyenmai') }}">Sản phẩm khuyển mãi</a></li>
    

    @if(isset($categories) && count($categories) > 0)
    <li class="filter-title"><span>Danh mục</span></li>
    @foreach($categories as $val)
    <li @if(Route::getCurrentRoute()->getName() == 'product_category' && $val->alias == Route::current()->parameter('alias')) class="active" @endif><a href="{{ route('product_category',$val->alias) }}" title="{{ ucfirst($val->name) }}">{{ ucfirst($val->name) }}</a></li>
    @endforeach
    @endif
    
    
    
  </ul>
</div>
