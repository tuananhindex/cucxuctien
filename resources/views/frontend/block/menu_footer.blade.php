@if(isset($data) && count($data) > 0)
<?php $i = 1 ?>
@foreach($data as $val)
<?php
    if($i == 3){ break; };
    $menu = DB::table('menu')->where(['status' =>1 , 'fk_parentid' => $val->id])->orderBy('order','desc')->orderBy('id','desc')->select('id','name','alias','cursor','fk_parentid')->get();
?>
<div class="col-xs-6 col-sm-6 col-lg-3">
    <div class="footer-widget">
        <h3><span>{{ ucfirst($val->name) }}</span></h3>
        @if(isset($menu) && count($menu) > 0)
          <ul class="list-menu list-right">
            @foreach($menu as $val2)
            <?php
              if(empty($val2->cursor)){
                  $href = 'javascript:void(0)';
              }else{
                  $href = route('menu',$val->id);
              }
            ?>
            <li><a href="{{ $href }}">{{ ucfirst($val2->name) }}</a></li>
            @endforeach
          </ul>
        @endif
    </div>
</div>
<?php $i++; ?>
@endforeach
@endif