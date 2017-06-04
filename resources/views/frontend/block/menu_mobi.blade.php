<ul id="nav-mobile" class="nav hidden-md hidden-lg">
    <li class="nav-item @if(Route::getCurrentRoute()->getName() == 'home') active @endif"><a class="nav-link" href="{{ route('home') }}">Trang chủ</a></li>
    {!! $data !!}
    <li class="nav-item @if(Route::getCurrentRoute()->getName() == 'contact') active @endif"><a class="nav-link" href="{{ route('contact') }}">Liên hệ</a></li>

</ul>