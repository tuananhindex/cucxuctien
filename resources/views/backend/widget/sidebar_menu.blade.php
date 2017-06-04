<ul class="sidebar-menu">
    <li class="header">MAIN NAVIGATION</li>
    <li class="@if(strlen(strstr(Route::currentRouteName(), 'backend.home')) > 0) active @endif"><a href="{{ route('backend.home') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('sidebar.home') }}</span></a></li>

    
    
   @if(in_array(Auth::user()->role,['admin','admin-system']))
    <!-- <li class="@if(strlen(strstr(Route::currentRouteName(), 'backend.account')) > 0) active @endif treeview">
        <a href="#"><i class="fa fa-users"></i> {{ trans('sidebar.role_group') }} <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li class="@if(strlen(strstr(Route::currentRouteName(), 'backend.role.add.get')) > 0) active @endif">
                <a href="{{ route('backend.account.add.get') }}"><i class="fa fa-plus"></i> {{ trans('sidebar.add') }}</a>
                
            </li>
            <li class="@if(strlen(strstr(Route::currentRouteName(), 'backend.role.list.get')) > 0) active @endif"><a href="{{ route('backend.account.list.get') }}"><i class="fa fa-list"></i> {{ trans('sidebar.list') }}</a></li>
        </ul>
    </li> -->

    <li class="@if(strlen(strstr(Route::currentRouteName(), 'backend.account')) > 0) active @endif treeview">
        <a href="#"><i class="fa fa-user"></i> {{ trans('sidebar.account') }} <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li class="@if(strlen(strstr(Route::currentRouteName(), 'backend.account.add.get')) > 0) active @endif">
                <a href="{{ route('backend.account.add.get') }}"><i class="fa fa-plus"></i> {{ trans('sidebar.add') }}</a>
                
            </li>
            <li class="@if(strlen(strstr(Route::currentRouteName(), 'backend.account.list.get')) > 0) active @endif"><a href="{{ route('backend.account.list.get') }}"><i class="fa fa-list"></i> {{ trans('sidebar.list') }}</a></li>
        </ul>
    </li>

    @if(in_array(Auth::user()->role,['admin']))
    <li class="@if(strlen(strstr(Route::currentRouteName(), 'backend.language')) > 0) active @endif treeview">
        <a href="#"><i class="fa fa-language"></i> {{ trans('sidebar.language') }} <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li class="@if(strlen(strstr(Route::currentRouteName(), 'backend.language.add.get')) > 0) active @endif">
                <a href="{{ route('backend.language.add.get') }}"><i class="fa fa-plus"></i> {{ trans('sidebar.add') }}</a>
                
            </li>
            <li class="@if(strlen(strstr(Route::currentRouteName(), 'backend.language.list.get')) > 0) active @endif"><a href="{{ route('backend.language.list.get') }}"><i class="fa fa-list"></i> {{ trans('sidebar.list') }}</a></li>
        </ul>
    </li>
    @endif
    @endif
    
    @if(in_array(Auth::user()->role,['admin-content']))
    <li class="@if(strlen(strstr(Route::currentRouteName(), 'backend.menu')) > 0) active @endif treeview">
        <a href="#"><i class="fa fa-bars"></i> Module {{ trans('sidebar.menu') }} <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li class="@if(strlen(strstr(Route::currentRouteName(), 'backend.menu.add.get')) > 0) active @endif">
                <a href="{{ route('backend.menu.add.get') }}"><i class="fa fa-plus"></i> {{ trans('sidebar.add') }}</a>
                
            </li>
            <li class="@if(strlen(strstr(Route::currentRouteName(), 'backend.menu.list.get')) > 0) active @endif"><a href="{{ route('backend.menu.list.get') }}"><i class="fa fa-list"></i> {{ trans('sidebar.list') }}</a></li>
        </ul>
    </li>
    @endif

    @if(in_array(Auth::user()->role,['content','admin-content']))
    <li class="@if(strlen(strstr(Route::currentRouteName(), 'backend.posts')) > 0) active @endif treeview">
        <a href="#">
            <i class="fa fa-newspaper-o"></i> <span>Module {{ trans('sidebar.posts.main') }}</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            @if(in_array(Auth::user()->role,['admin-content']))
            <li class="@if(strlen(strstr(Route::currentRouteName(), 'backend.posts.category')) > 0) active @endif treeview">
                <a href="#"><i class="fa fa-tags"></i> {{ trans('sidebar.posts.category') }} <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li class="@if(strlen(strstr(Route::currentRouteName(), 'backend.posts.category.add.get')) > 0) active @endif">
                        <a href="{{ route('backend.posts.category.add.get') }}"><i class="fa fa-plus"></i> {{ trans('sidebar.add') }}</a>
                        
                    </li>
                    <li class="@if(strlen(strstr(Route::currentRouteName(), 'backend.posts.category.list.get')) > 0) active @endif"><a href="{{ route('backend.posts.category.list.get') }}"><i class="fa fa-list"></i> {{ trans('sidebar.list') }}</a></li>
                </ul>
            </li>
            @endif
            <li class="@if(strlen(strstr(Route::currentRouteName(), 'backend.posts.posts')) > 0) active @endif treeview">
                <a href="#"><i class="fa fa-tags"></i> {{ trans('sidebar.posts.main') }} <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li class="@if(strlen(strstr(Route::currentRouteName(), 'backend.posts.posts.add.get')) > 0) active @endif">
                        <a href="{{ route('backend.posts.posts.add.get') }}"><i class="fa fa-plus"></i> {{ trans('sidebar.add') }}</a>
                        
                    </li>
                    <li class="@if(strlen(strstr(Route::currentRouteName(), 'backend.posts.posts.list.get')) > 0) active @endif"><a href="{{ route('backend.posts.posts.list.get') }}"><i class="fa fa-list"></i> {{ trans('sidebar.list') }}</a></li>
                </ul>
            </li>
        </ul>
    </li>

    <li class="@if(strlen(strstr(Route::currentRouteName(), 'backend.media')) > 0) active @endif treeview">
        <a href="#"><i class="fa fa-video-camera"></i> Module Media <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li class="@if(strlen(strstr(Route::currentRouteName(), 'backend.media.add.get')) > 0) active @endif">
                <a href="{{ route('backend.media.add.get') }}"><i class="fa fa-plus"></i> {{ trans('sidebar.add') }}</a>
                
            </li>
            <li class="@if(strlen(strstr(Route::currentRouteName(), 'backend.media.list.get')) > 0) active @endif"><a href="{{ route('backend.media.list.get') }}"><i class="fa fa-list"></i> {{ trans('sidebar.list') }}</a></li>
        </ul>
    </li>

    <li class="@if(strlen(strstr(Route::currentRouteName(), 'backend.document')) > 0) active @endif treeview">
        <a href="#"><i class="fa fa-file"></i> Module Document <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li class="@if(strlen(strstr(Route::currentRouteName(), 'backend.document.add.get')) > 0) active @endif">
                <a href="{{ route('backend.document.add.get') }}"><i class="fa fa-plus"></i> {{ trans('sidebar.add') }}</a>
                
            </li>
            <li class="@if(strlen(strstr(Route::currentRouteName(), 'backend.document.list.get')) > 0) active @endif"><a href="{{ route('backend.document.list.get') }}"><i class="fa fa-list"></i> {{ trans('sidebar.list') }}</a></li>
        </ul>
    </li>
    @endif
    
    @if(in_array(Auth::user()->role,['admin-content']))
    <li class="@if(strlen(strstr(Route::currentRouteName(), 'backend.tag')) > 0) active @endif treeview">
        <a href="#"><i class="fa fa-tags"></i> Tags <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li class="@if(strlen(strstr(Route::currentRouteName(), 'backend.tag.add.get')) > 0) active @endif">
                <a href="{{ route('backend.tag.add.get') }}"><i class="fa fa-plus"></i> {{ trans('sidebar.add') }}</a>
                
            </li>
            <li class="@if(strlen(strstr(Route::currentRouteName(), 'backend.tag.list.get')) > 0) active @endif"><a href="{{ route('backend.tag.list.get') }}"><i class="fa fa-list"></i> {{ trans('sidebar.list') }}</a></li>
        </ul>
    </li>
    <li class="@if(strlen(strstr(Route::currentRouteName(), 'backend.banner')) > 0) active @endif treeview">
        <a href="#"><i class="fa fa-picture-o"></i> Module Banner <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li class="@if(strlen(strstr(Route::currentRouteName(), 'backend.banner.add.get')) > 0) active @endif">
                <a href="{{ route('backend.banner.add.get') }}"><i class="fa fa-plus"></i> {{ trans('sidebar.add') }}</a>
                
            </li>
            <li class="@if(strlen(strstr(Route::currentRouteName(), 'backend.banner.list.get')) > 0) active @endif"><a href="{{ route('backend.banner.list.get') }}"><i class="fa fa-list"></i> {{ trans('sidebar.list') }}</a></li>
        </ul>
    </li>

    

    <li class="@if(strlen(strstr(Route::currentRouteName(), 'backend.static_block')) > 0) active @endif treeview">
        <a href="#"><i class="fa fa-ban"></i> {{ trans('sidebar.static_block') }} <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li class="@if(strlen(strstr(Route::currentRouteName(), 'backend.static_block.add.get')) > 0) active @endif">
                <a href="{{ route('backend.static_block.add.get') }}"><i class="fa fa-plus"></i> {{ trans('sidebar.add') }}</a>
                
            </li>
            <li class="@if(strlen(strstr(Route::currentRouteName(), 'backend.static_block.list.get')) > 0) active @endif"><a href="{{ route('backend.static_block.list.get') }}"><i class="fa fa-list"></i> {{ trans('sidebar.list') }}</a></li>
        </ul>
    </li>
    @endif
    @if(in_array(Auth::user()->role,['admin','admin-system']))
    

    

    
    <li class="@if(strlen(strstr(Route::currentRouteName(), 'backend.meta_default')) > 0) active @endif"><a href="{{ route('backend.meta_default.get') }}"><i class="fa fa-gear"></i> <span>{{ trans('sidebar.meta_df') }}</span></a></li>
    <li class="@if(strlen(strstr(Route::currentRouteName(), 'backend.mail_system')) > 0) active @endif"><a href="{{ route('backend.mail_system.get') }}"><i class="fa fa-envelope "></i> <span>Mail System</span></a></li>
    @endif
</ul>