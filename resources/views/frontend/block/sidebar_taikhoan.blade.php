<div class="box categories">
  <ul>
    <li class="filter-title"><span>Tài khoản</span></li>
    <li @if(Route::getCurrentRoute()->getName() == 'quanlycustomer') class="active" @endif><a href="{{ route('quanlycustomer') }}">Thông tin chung</a></li>
    <li @if(Route::getCurrentRoute()->getName() == 'quanlytaikhoancustomer') class="active" @endif><a href="{{ route('quanlytaikhoancustomer') }}">Thông tin tài khoản</a></li>
    <li @if(Route::getCurrentRoute()->getName() == 'quanlydonhangcustomer') class="active" @endif><a href="{{ route('quanlydonhangcustomer') }}">Thông tin đơn hàng</a></li>
  </ul>
</div>