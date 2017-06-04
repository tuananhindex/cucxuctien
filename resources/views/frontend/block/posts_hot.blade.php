@if(isset($data) && count($data) > 0)
<div id="top-news">
    <div class="top-news-nav box-nav">
        <!-- Single button -->
        <div class="iconbox btn-group">
            <a id="dropdown-news-{{ $nation }}" class="dropdown-toggle" data-toggle="dropdown"
               aria-haspopup="true"
               aria-expanded="false">
                
                @if($nation == 'vi')
                MOIT 
                VIETNAM
                @else
                MOIC 
                LAO
                @endif 
                <span class="caret"></span>
            </a>

        </div>
        <div class=" btn-group">
            <!-- <a href="">
                NEWS AND EVENTS
            </a> -->
        </div>
        <ul id="dropdownmenu-news-{{ $nation }}" class="dropdown-menu">
            @if(isset($menu) && count($menu) > 0)
            @foreach($menu as $val)
            
            <li><a href="{{ Helper::href_format($val->link2,$val->cursor,$val->id) }}" @if($val->target) target="{{ $val->target }}" @endif><i class="fa fa-chevron-circle-right" aria-hidden="true"></i>
                {{ ucfirst($val->name) }}</a>
                
            </li>
            @endforeach
            @else
            <li><a href="javascript:void(0)">No data</a></li>
            @endif
            <li role="separator" class="divider"></li>
            <li><a href="#">Separated link</a></li>
        </ul>
        <hr/>
    </div>
    
    <div class="col-md-6 newshot">
        <div class="row">
            <a href="{{ route('posts',$top1->alias) }}" title="{{ ucfirst($top1->name) }}"><img class="rounded-0" src="{{ asset($top1->image) }}" alt="{{ ucfirst($top1->name) }}" class="img-rounded"></a>
            <!--<img src="..." alt="..." class="img-circle">-->
            <!--<img src="..." alt="..." class="img-thumbnail">-->
            <a href="{{ route('posts',$top1->alias) }}" title="{{ ucfirst($top1->name) }}"><h2>{{ ucfirst($top1->name) }}</h2></a>
            <p>
                <small><i class="fa fa-calendar" data-original-title="" title=""></i> {{ date_format(date_create($top1->create_at), 'jS F Y') }}
                </small>
            </p>
           <!--  <p>{{ ucfirst($top1->description) }}</p> -->
        </div>
    </div>
    <ul class="col-md-6 post-list">
    @foreach($data as $val)
        <li>
            <div class="post-img">
                <a href="{{ route('posts',$val->alias) }}" title="{{ ucfirst($val->name) }}"><img src="{{ asset($val->image) }}" class="img-responsive"/></a>
            </div>
            <p><a href="{{ route('posts',$val->alias) }}" title="{{ ucfirst($val->name) }}">{{ ucfirst(mb_strimwidth($val->name, 0, 70, '...')) }}</a></p>
            <p class="date">
                <small><i class="fa fa-calendar" data-original-title="" title=""></i> {{ date_format(date_create($val->create_at), 'jS F Y') }}
                </small>
            </p>
        </li>
    @endforeach 
    </ul>
</div>

@endif