<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="@if(isset($keywords)){{ $keywords }}@endif" />
    <meta name="description" content="@if(isset($description)){{ $description }}@endif" />
    <meta charset="utf-8">
    <meta name="author" content="">

    <!-- Le styles -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/bootstrap-reboot.min.css') }}" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('assets/frontend/libs/bootstrap/css/bootstrap.min.css') }}" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('assets/frontend/libs/font-awesome-4.7.0/css/font-awesome.min.css') }}" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('assets/frontend/libs/jquery.bxslider/jquery.bxslider.css') }}" type="text/css"/>
    <!--<link rel="stylesheet" href="assets/css/home-datepicker.css" type="text/css"/>-->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/style.css') }}" type="text/css"/>

    <script src="{{ asset('assets/frontend/js/jquery-3.2.1.min.js') }}"></script>

    <style type="text/css">

    </style>

    <title>@if(isset($title)){{ $title }}@endif</title>

</head>
<body>
<div id="main-body" class="container-fluid">
    <div class="row">

        <header>
            <div id="header-top">
                <div class="container">
                    <div class="navbar">
                        <ul class="nav navbar-nav pull-right">
                            <!-- <?php
                                $lang = DB::table('language')->select('id','name','nation')->get(); 
                            ?>
                            @foreach($lang as $val)
                            <li><a class="@if($val->id == Session::get('lang_id')) active @endif" href="{{ route('change_lang',[$val->id,$val->nation]) }}">{{ ucfirst($val->name) }}</a></li>
                            @endforeach -->
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><a href="javascript:void(0)">Contact</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div id="header-bottom" class="row">
                <div class="container">
                    <div class="col-md-4 text-center hidden-xs">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('assets/frontend/img/logo-Vn1.png') }}" alt="VIETNAM - LAO" class="">
                        </a>
                        
                    </div>
                    <div class="col-md-4 col-xs-12 text-center">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('assets/frontend/img/logo-VietLao.png') }}" alt="VIETNAM - LAO" class="">
                        </a>
                    </div>
                    <div class="col-md-4 text-center hidden-xs">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('assets/frontend/img/logo-Lao1.png') }}" alt="VIETNAM - LAO" class="">
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <div id="main-content" class="container border-30">
            <div class="row">
                @yield('content')
                {!! Block::about_footer('vi') !!}
                {!! Block::about_footer('la') !!}
            </div>
        </div>

        <footer class="container">
            <div class="row">
                <div class="col-md-12 footer-info">
                    <div class="col-md-6 text-center">
                        <img class="logo" src="{{ asset('assets/frontend/img/logo-Vn1.png') }}" alt="..." class="">
                        <p>Address: 54 Hai Ba Trung Str, Hoan Kiem District, Ha Noi, Viet Nam</p>
                        <p>Tel: +84-4 22202222</p>
                        <p>Fax: +84-4 22202525</p>
                        <p>Email: bbt@moit.gov.vn</p>
                    </div>
                    <div class="col-md-6 text-center">
                        <img class="logo" src="{{ asset('assets/frontend/img/logo-Lao1.png') }}" alt="..." class="">
                        <br/>
                        <p>
Address: Phon Xay Rd
P.O.Box 4107 Vientiane, Lao People's Democratic Republic</p>
                        <p>Tel: +856-21 453493</p>
                        <p>Fax: +856-21 416140</p>
                        <p>Email: moicpsi@yahoo.com</p>
                    </div>
                </div>
                <div class="col-md-12 copyright">
                    <span>&copy; 2017, Vietnam - Lao Economic and Trade Relations  |  </span>
                    <a href="#">Terms Conditions</a> | <a href="#">Privacy</a>
                </div>
            </div>
        </footer>

    </div>
</div>


<script src="{{ asset('assets/frontend/libs/jquery.bxslider/jquery.bxslider.min.js') }}"></script>
<script src="{{ asset('assets/frontend/libs/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/frontend/js/main.js') }}"></script>


<!--<script src="assets/js/bootstrap-transition.js"></script>-->
<!--<script src="assets/js/bootstrap-alert.js"></script>-->
<!--<script src="assets/js/bootstrap-modal.js"></script>-->
<!--<script src="assets/js/bootstrap-dropdown.js"></script>-->
<!--<script src="assets/js/bootstrap-scrollspy.js"></script>-->
<!--<script src="assets/js/bootstrap-tab.js"></script>-->
<!--<script src="assets/js/bootstrap-tooltip.js"></script>-->
<!--<script src="assets/js/bootstrap-popover.js"></script>-->
<!--<script src="assets/js/bootstrap-button.js"></script>-->
<!--<script src="assets/js/bootstrap-collapse.js"></script>-->
<!--<script src="assets/js/bootstrap-carousel.js"></script>-->
<!--<script src="assets/js/bootstrap-typeahead.js"></script>-->
<!--<script src="assets/js/bootstrap-typeahead.js"></script>-->

</body>
</html>
