<ul class="list-unstyled">
      @foreach($data as $val)
      <li class="news_item clearfix">
        <div class="blog-image">
          
          <img alt="{{ ucfirst($val->name) }}" class="img-responsive" src="{{ asset($val->image) }}">
          
        </div>
        <a href="{{ route('posts',$val->alias) }}" class="blog-title">{{ ucfirst($val->name) }}</a>
        <span><i class="fa fa-calendar"></i> {{ Helper::time_stamp(strtotime($val->create_at)) }}</span>
      </li>
      
      @endforeach
      
    </ul>