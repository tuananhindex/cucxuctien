
<h3><a href="{{ route('posts',$data->alias) }}" class="blog-title">{{ ucfirst($data->name) }}</a></h3>
<div class="author">
    <span><i class="fa fa-pencil-square-o"></i> {{ ucfirst($data->authName) }}</span>
    <!-- <span><i class="fa fa-comment-o"></i> 1 Nhận xét</span> -->
</div>
<div class="blog-image">
    <a title="{{ ucfirst($data->name) }}" href="{{ route('posts',$data->alias) }}">
    <img alt="{{ ucfirst($data->name) }}" src="{{ asset($data->image) }}" class="img-responsive">
    </a>
    <div class="date">
        <p class="entry-month">Tháng {{ date('m',strtotime($data->create_at)) }}</p>
        <p class="entry-year">{{ date('Y',strtotime($data->create_at)) }}</p>
    </div>
</div>
<div class="blog-summary" style="height: 96px;
	overflow: hidden;
	text-overflow: ellipsis;"> {{ ucfirst($data->description) }}</div>