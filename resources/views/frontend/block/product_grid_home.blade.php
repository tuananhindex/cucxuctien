<div class="products row row-gutter-14">
  @if(isset($data) && count($data) > 0)
  
    @foreach($data as $val)
      <div class="col-xs-6 col-sm-4 col-lg-3">
      {!! Block::product_box($val) !!}
      </div>
    @endforeach
  
  @else
  <p>Không có sản phẩm nào</p>
  @endif
</div>
