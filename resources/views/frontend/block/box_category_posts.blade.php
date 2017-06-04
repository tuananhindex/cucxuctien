<div class="box categories" style="margin-top: -18px;">
  <ul>
  	<!-- @if(isset($types) && count($types) > 0)
    <li class="filter-title"><span>Loại sản phẩm</span></li>
    @foreach($types as $val)
    <li><a>{{ ucfirst($val->name) }}</a></li>
    @endforeach
    @endif -->
   
    @if(isset($categories) && count($categories) > 0)
    <li class="filter-title"><span>Danh mục</span></li>
    @foreach($categories as $val)
    <li @if(Route::getCurrentRoute()->getName() == 'posts.category' && $val->alias == Route::current()->parameter('alias')) class="active" @endif><a href="{{ route('posts.category',$val->alias) }}" title="{{ ucfirst($val->name) }}">{{ ucfirst($val->name) }}</a></li>
    @endforeach
    @endif
    
    
    
  </ul>
</div>
