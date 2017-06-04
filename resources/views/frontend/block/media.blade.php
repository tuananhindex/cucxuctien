@if(isset($data) && count($data) > 0)
<section id="media">

    <div class="top-news-nav box-nav">
        <!-- Single button -->
        <div class="iconbox btn-group">
            <a id="test" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
               aria-expanded="false">Media</a>
        </div>
        <div class="media-slider-nav pull-right">
            <a href="" id="ms-nav-left" style="width: 40px;"></a>
            <a href="" id="ms-nav-right" style="width: 40px;"></a>
        </div>
        <hr/>
    </div>

    <div class="media-slider">
        <!--<div class="col-sm-6 col-md-4"></div>-->
        @foreach($data as $val)
        <div class="thumbnail">
            <a href="{{ route('posts',$val->alias) }}" title="{{ ucfirst($val->name) }}"><img src="{{ asset($val->image) }}" alt="{{ $val->name }}" title="{{ $val->name }}"></a>
            <style type="text/css">
                .caption h4,.caption p{
                    overflow: hidden;
                    white-space: nowrap;
                    text-overflow: ellipsis;
                }
            </style>
            <div class="caption">
                <h4><a href="{{ route('posts',$val->alias) }}" title="{{ ucfirst($val->name) }}">{{ ucfirst($val->name) }}</a></h4>
                <p title="{{ ucfirst($val->description) }}">{{ ucfirst($val->description) }}</p>
            </div>
        </div>
        @endforeach

    </div>
</section>
@endif