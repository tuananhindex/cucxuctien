<div class="box-header">
  <h3 class="box-title">{{ ucwords(trans('common.list')) }}
  @if(Route::currentRouteName() == 'backend.product.product.list.get')
    @if(isset($_GET['cat_id']) && !empty($_GET['cat_id']))
    <?php
      $cat = DB::table('product_category')->where('id',$_GET['cat_id'])->select('name','id')->first();
    ?>
    <span>(Danh Mục : <a href="{{ route('backend.product.category.edit.get',$cat->id) }}">{{ ucfirst($cat->name) }}</a>)</span>

    @endif
  @endif
  </h3>
  @if(Route::current()->parameter('key'))( Kết quả tìm kiếm với từ khóa <a href="javascript:void(0)">{{ Route::current()->parameter('key') }}</a> ) @endif
  <div class="box-tools">
  
    <div class="input-group pull-right" style="width: 150px;">
      <input type="text" name="search" value="@if(Route::current()->parameter('key')){{ Route::current()->parameter('key') }}@endif" class="form-control input-sm pull-right" placeholder="Search">
      <div class="input-group-btn">
        <button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
      </div>
    </div>
    
    <a style="margin-right:10px; font-weight: bold" href="<?php echo route($e['route'].'.add.get') ?>" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus"></i> {{ ucwords(trans('common.add_new')) }}</a>
    @if(Auth::user()->role != 'content')
    <button type="submit" name="hide" value="Ẩn" class="btn btn-danger pull-right btn-sm" style="margin-right:10px; font-weight: bold" ><i class="fa fa-ban"></i> {{ ucwords(trans('common.status_hide')) }}</button>

    <button type="submit" name="show" value="Hiện" class="btn btn-success pull-right btn-sm" style="margin-right:10px; font-weight: bold" ><i class="fa fa-eye"></i> {{ ucwords(trans('common.status_show')) }}</button>
    @endif
    
    @if(Route::currentRouteName() == 'backend.language.list.get')
    <button type="submit" name="default" value="Đặt làm ngôn ngữ mặc định" class="btn btn-warning pull-right btn-sm" style="margin-right:10px; font-weight: bold" ><i class="fa fa-check"></i> Đặt làm ngôn ngữ mặc định</button>
    @endif
  </div>
  
</div>