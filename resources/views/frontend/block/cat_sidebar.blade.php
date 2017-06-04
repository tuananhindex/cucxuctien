@if(isset($data) && count($data) > 0)
<ul class="sidebar-box1">
  <h4 style="margin-top: 0;
border-bottom: 1px solid #fff;
padding-bottom: 10px;">Categories</h4>
  @foreach($data as $val)
  <li><a href="{{ route('posts_category',$val->alias) }}"><i class="fa fa-chevron-circle-right" aria-hidden="true" title="{{ ucfirst($val->name) }}"></i>
      {{ ucfirst($val->name) }}</a>

  </li>
  @endforeach
</ul>
@else
No data
@endif

{!! Block::static_block(5) !!}