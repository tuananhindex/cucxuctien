@if(isset($data) && count($data) > 0)
  <style type="text/css">
    .posts_list{
      padding-bottom: 50px;
      border-bottom: 1px solid !important;
    }
    .posts_list p{
      margin: 0px !important;
    }
  </style>
    @foreach($data as $val)
    <div class="posts_list">
      <a title="{{ $val->name }}" href="{{ route('posts',$val->alias) }}"><img src="{{ '../../binwin_common/'.$val->image }}" width="100" height="100" style="float:left;margin-right:10px"></a>
      <h4><a title="{{ $val->name }}" href="{{ route('posts',$val->alias) }}">{{ ucfirst($val->name) }}</a></h4>
      <p style="color:#666; font-size:11px"><i>{{ Helper::time_stamp(strtotime($val->create_at)) }}</i></p>
      <p>{{ ucfirst($val->description) }}</p>
    </div>
    @endforeach
    @if($pagi)
    <div class="pagination clearfix pull-right">
      {!! $data->render() !!}
    </div>
    @endif
    @else
    Không có bài viết nào
    @endif
    