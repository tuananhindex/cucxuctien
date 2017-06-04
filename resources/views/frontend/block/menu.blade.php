<div class="menu-nav container-fluid">
    <nav class="navbar hidden-md hidden-lg">
        <div class="logo">
            <a class="navbar-brand" href="{{ route('home') }}">
            {!! Block::static_block(2) !!}
            </a>
        </div>
        <div class="collapse navbar-collapse mobile-menu" id="bs-example-navbar-collapse-5">
            <div class="pull-right visible-xs visible-sm">
                <div class="search-form pull-left">
                    <a href="javascript:void(0);" id="search-btn"><img src="{{ asset('assets/frontend/images/search-icon.png') }}" alt="tìm kiếm">
                    </a>
                    <div id="hidden-search" class="css-dis-none">
                        <form action="{{ route('search.post') }}" method="post" class="search-form">
                            <input name="_token" type="hidden" value="{{ csrf_token() }}">
                            <div class="input-group">
                                <input type="text" class="form-control" name="key_search" placeholder="Tìm kiếm..." value="@if(isset($key_search)){{ $key_search }}@endif">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <a class="pull-right bars-navigation visible-xs visible-sm" href="javascript:void(0);"><img src="{{ asset('assets/frontend/images/menu-mobile.png') }}" alt="Danh mục"></a>
            <ul class="submenu list-unstyled clearb css-dis-none">
                <li>
                    <ul class="topnav list-unstyled">
                        <li class="level0 level-top"> <a class="level-top " href="{{ route('home') }}"> <span>Trang chủ</span> </a> </li>
                        @if(isset($product_category) && count($product_category) > 0)
                        <li class="level0 level-top">
                            <a class="level-top" href="javascript:void(0)"> <span>Sản phẩm</span> </a>
                            <ul class="list-unstyled level0"style="display:none" >
                            	@foreach($product_category as $val)
                            	<?php
                            		$product_category_sub = DB::table('product_category')->where(['status' => 1 ,'fk_parentid' => $val->id])->orderBy('order','desc')->orderBy('id','desc')->select('id','alias','name','image')->get();
    
                            	?>
                                <li class="level1 level-top">
                                    <a href="{{ route('product_category',$val->alias) }}"> <span>{{ $val->name }}</span> </a>
                                    @if(isset($product_category_sub) && count($product_category_sub) > 0)
                                    <ul class="level1 list-unstyled" style="display:none">
                                    	@foreach($product_category_sub as $val2)
                                        <li class="level2"><a href="{{ route('product_category',$val2->alias) }}"><span>{{ $val2->name }}</span></a></li>
                                       	@endforeach
                                    </ul>
                                    @endif
                                </li>
                                @endforeach
                            </ul>
                        </li>
                        @endif
                        @if(isset($data) && count($data) > 0)
	                        @foreach($data as $val)
	                        <?php 
	                        	if(empty($val->cursor)){
				                    $href = 'javascript:void(0)';
				                }else{
				                    $href = route('menu',$val->id);
				                }
	                        ?>
	                        <li class="level0 level-top"> <a class="level-top  @if(Request::url() == $val->link) active @endif" href="{{ $href }}"> <span>{{ $val->name }}</span> </a> </li>
	                        @endforeach
                        @endif
                        <li class="level0 level-top"> <a class="level-top " href="{{ route('mauthietke','all') }}"> <span>mẫu thiết kế</span> </a> </li>
                        <li class="level0 level-top"> <a class="level-top " href="{{ route('contact') }}"> <span>Liên hệ</span> </a> </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    <nav class="navbar hidden-sm hidden-xs">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ route('home') }}">
            {!! Block::static_block(2) !!}
            </a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-5">
            <ul class="site-nav navbar-right">
                <li><a href="{{ route('home') }}" class="@if(Route::currentRouteName() == 'home') current @endif"><span>Trang chủ</span></a></li>
                @if(isset($product_category) && count($product_category) > 0)
                <li class="drop-down  mega-menu ">
                    <a href="javascript:void(0)" class="@if(Route::currentRouteName() == 'product_category' || Route::currentRouteName() == 'product' ) current @endif"><span>Sản phẩm</span> </a>   
                    <div class="site-nav-dropdown">
                        <div class="container">
                            <div class="col-md-9 parent-mega-menu">
                                <div class="row">
                                	@foreach($product_category as $val)
                                	<?php
                                		$product_category_sub = DB::table('product_category')->where(['status' => 1 ,'fk_parentid' => $val->id])->orderBy('order','desc')->orderBy('id','desc')->select('id','alias','name','image')->get();
        
                                	?>
                                    <div class="inner col-md-3">
                                        <!-- Menu level 2 -->
                                        <a href="{{ route('product_category',$val->alias) }}"> <span>{{ $val->name }} </span></a>
                                        @if(isset($product_category_sub) && count($product_category_sub) > 0)
                                        <ul class="drop-down">
                                        	@foreach($product_category_sub as $val2)
                                            <li>
                                                <a href="{{ route('product_category',$val2->alias) }}">"> <span>{{ ucfirst($val2->name) }} </span></a>
                                            </li>
                                            @endforeach
                                            <li class="mega-img" onclick="window.location.href='#'">
                                                <img src='{{ asset($val->image) }}' alt='mega' />
                                            </li>
                                        </ul>
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="banner-image">
                                    <a href="javascript:void(0)" title="Menu Image">
                                    <img src='{{ asset("assets/frontend/images/menu-banner.jpg") }}' alt='menu banner' />
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                @endif
                @if(isset($data) && count($data) > 0)
                    @foreach($data as $val)
                    <?php 
                    	if(empty($val->cursor)){
		                    $href = 'javascript:void(0)';
		                }else{
		                    $href = route('menu',$val->id);
		                }
                    ?>
                    <li class="level0 level-top @if(Request::url() == $val->link) current @endif"> <a class="level-top  @if(Request::url() == $val->link) current @endif" href="{{ $href }}"> <span>{{ $val->name }}</span> </a> </li>
                    @endforeach
                @endif
                <li><a href="{{ route('mauthietke','all') }}" class="@if(Route::currentRouteName() == 'mauthietke') current @endif""><span>mẫu thiết kế</span></a></li>
                <li><a href="{{ route('contact') }}" class="@if(Route::currentRouteName() == 'contact') current @endif""><span>Liên hệ</span></a></li>
                <li class="navbar-right">
                    <div class="search-form">
                        <a href="javascript:void(0);" id="search-btn"><img src="{{ asset('assets/frontend/images/search-icon.png') }}" alt="tìm kiếm">
                        </a>
                        <div id="hidden-search" class="css-dis-none">
                            <form action="{{ route('search.post') }}" method="post" class="search-form">
                            	<input name="_token" type="hidden" value="{{ csrf_token() }}">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="key_search" placeholder="Tìm kiếm..." value="@if(isset($key_search)){{ $key_search }}@endif">
                                    <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</div>