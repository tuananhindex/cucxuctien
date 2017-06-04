@extends('frontend.master')
@section('content')
<section class="breadc">
  <div class="container breadpos">
    <div class="pull-left">
      <ol class="breadcrumb breadcrumbs">
        <li><a href="{{ route('home') }}" title="Trở lại trang chủ"><i class="fa fa-home"></i> Trang chủ</a></li>
        <li>{{ ucfirst($index->name) }}</li>
      </ol>
    </div>
  </div>
</section>

  <div class="container">
    <div class="col-md-8 col-md-offset-2">
      <header class="section-title fix-margin-col-xs">
        <h2>{{ ucfirst($index->name) }}</h2>
        <p></p>
      </header>
    </div>
    
  </div>
</section>
@if(isset($products) && count($products) > 0)
<section class="grid-collection p20">
  <div class="container">
    <div class="row">
      <div class="toolbar clearfix">
        <div class="pull-left col-lg-6 col-md-4 col-xs-6 col-sm-6">
          <div class="tt hidden-sm hidden-xs">
            <span class="hidden-sm hidden-xs">
            Hiển thị {{ count($products) }} của {{ $products->toArray()['total'] }} sản phẩm (  {{ $products->toArray()['last_page'] }} trang )</span>
          </div>
        </div>
        <div class="pull-right col-lg-6 col-md-8 col-sm-6 col-xs-6">
          
          <div id="sort-by">
            <label class="left hidden-xs">Sắp xếp: </label>
            <ul>
              <li>
                <span>
                @if(isset($_GET['sortby']))
                <?php 
                  switch ($_GET['sortby']) {
                    case 'price-desc':
                      echo 'Giá giảm dần';
                      break;

                    case 'price-asc':
                      echo 'Giá tăng dần';
                      break;

                    case 'created-desc':
                      echo 'Hàng mới nhất';
                      break;

                    case 'created-asc':
                      echo 'Hàng cũ nhất';
                      break;

                    default:
                      echo 'Mặc định';
                      break;
                  }
                ?>
                @else
                Thứ tự
                @endif
                </span>
                <ul>
                  <li><a href="?sortby=default">Mặc định</a></li>
                  <li><a href="?sortby=price-asc">Giá tăng dần</a></li>
                  <li><a href="?sortby=price-desc">Giá giảm dần</a></li>
                  <li><a href="?sortby=created-desc">Hàng mới nhất</a></li>
                  <li><a href="?sortby=created-asc">Hàng cũ nhất</a></li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="filter-container">
        <div class="filter-container__selected-filter" style="display: none;">
          <div class="filter-container__selected-filter-header clearfix">
            <span class="filter-container__selected-filter-header-title"><i class="fa fa-arrow-left hidden-sm-up"></i> Bạn chọn</span>
            <a href="javascript:void(0)" onclick="clearAllFiltered()" class="filter-container__clear-all">Bỏ hết <i class="fa fa-angle-right"></i></a>
          </div>
          <div class="filter-container__selected-filter-list">
            <ul></ul>
          </div>
        </div>
        <div class="fix-border-filter">
          <div class="row2 clearfix">
            <div class="col-md-3">
              <div class="filter-group">
                <div class="filter-group-title filter-group-title--green">
                  Giá
                </div>
                <ul>
                  <li class="filter-item filter-item--check-box filter-item--green">
                    <a href="javascript:void(0)">
                    <label for="filter-duoi-500-000d">
                    <input type="checkbox" id="filter-duoi-500-000d" onchange="toggleFilter(this)" data-group="Khoảng giá" data-field="price_min" data-text="Dưới 500.000đ" value="(<500000)" data-operator="OR">
                    <i class="fa"></i>
                    Dưới 500.000vnđ
                    </label>
                    </a>
                  </li>
                  <li class="filter-item filter-item--check-box filter-item--green">
                    <a href="javascript:void(0)">
                    <label for="filter-500-000d-1-000-000d">
                    <input type="checkbox" id="filter-500-000d-1-000-000d" onchange="toggleFilter(this)" data-group="Khoảng giá" data-field="price_min" data-text="500.000đ - 1.000.000đ" value="(>500000 AND <1000000)" data-operator="OR">
                    <i class="fa"></i>
                    Từ 500.000 - 1.000.000vnđ
                    </label>
                    </a>
                  </li>
                  <li class="filter-item filter-item--check-box filter-item--green">
                    <a href="javascript:void(0)">
                    <label for="filter-1-000-000d-5-000-000d">
                    <input type="checkbox" id="filter-1-000-000d-5-000-000d" onchange="toggleFilter(this)" data-group="Khoảng giá" data-field="price_min" data-text="1.000.000đ - 5.000.000đ" value="(>1000000 AND <5000000)" data-operator="OR">
                    <i class="fa"></i>
                    Từ 1.000.000 - 5.000.000vnđ
                    </label>
                    </a>
                  </li>
                  <li class="filter-item filter-item--check-box filter-item--green">
                    <a href="javascript:void(0)">
                    <label for="filter-5-000-000d-10-000-000d">
                    <input type="checkbox" id="filter-5-000-000d-10-000-000d" onchange="toggleFilter(this)" data-group="Khoảng giá" data-field="price_min" data-text="5.000.000đ - 10.000.000đ" value="(>5000000 AND <10000000)" data-operator="OR">
                    <i class="fa"></i>
                    Từ 5.000.000 - 10.000.000vnđ
                    </label>
                    </a>
                  </li>
                  <li class="filter-item filter-item--check-box filter-item--green">
                    <a href="javascript:void(0)">
                    <label for="filter-tren-10-000-000d">
                    <input type="checkbox" id="filter-tren-10-000-000d" onchange="toggleFilter(this)" data-group="Khoảng giá" data-field="price_min" data-text="Trên 10.000.000đ" value="(>10000000)" data-operator="OR">
                    <i class="fa"></i>
                    Trên 10.000.000vnđ
                    </label>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="col-md-3">
              <div class="filter-group">
                <div class="filter-group-title filter-group-title--green">
                  Thương hiệu
                </div>
                <ul>
                  <li class="filter-item filter-item--check-box filter-item--green ">
                    <a href="javascript:void(0)">
                    <label for="filter-awesome">
                    <input type="checkbox" id="filter-awesome" onchange="toggleFilter(this)"  data-group="Hãng" data-field="vendor" data-text="Awesome" value="(Awesome)" data-operator="OR">
                    <i class="fa"></i>
                    Awesome
                    </label>
                    </a>
                  </li>
                  <li class="filter-item filter-item--check-box filter-item--green ">
                    <a href="javascript:void(0)">
                    <label for="filter-bizweb">
                    <input type="checkbox" id="filter-bizweb" onchange="toggleFilter(this)"  data-group="Hãng" data-field="vendor" data-text="Bizweb" value="(Bizweb)" data-operator="OR">
                    <i class="fa"></i>
                    Bizweb
                    </label>
                    </a>
                  </li>
                  <li class="filter-item filter-item--check-box filter-item--green ">
                    <a href="javascript:void(0)">
                    <label for="filter-dqdt">
                    <input type="checkbox" id="filter-dqdt" onchange="toggleFilter(this)"  data-group="Hãng" data-field="vendor" data-text="DQDT" value="(DQDT)" data-operator="OR">
                    <i class="fa"></i>
                    DQDT
                    </label>
                    </a>
                  </li>
                  <li class="filter-item filter-item--check-box filter-item--green ">
                    <a href="javascript:void(0)">
                    <label for="filter-hoa-phat">
                    <input type="checkbox" id="filter-hoa-phat" onchange="toggleFilter(this)"  data-group="Hãng" data-field="vendor" data-text="Hòa Phát" value="(Hòa Phát)" data-operator="OR">
                    <i class="fa"></i>
                    Hòa Phát
                    </label>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="col-md-3">
              <div class="filter-group">
                <div class="filter-group-title filter-group-title--green">
                  Loại
                </div>
                <ul>
                  <li class="filter-item filter-item--check-box filter-item--green">
                    <a href="javascript:void(0)">
                    <label for="filter-ban-ghe">
                    <input type="checkbox" id="filter-ban-ghe" onchange="toggleFilter(this)"  data-group="Loại" data-field="product_type" data-text="Bàn ghế" value="(Bàn ghế)" data-operator="OR">
                    <i class="fa"></i>
                    Bàn ghế
                    </label>
                    </a>
                  </li>
                  <li class="filter-item filter-item--check-box filter-item--green">
                    <a href="javascript:void(0)">
                    <label for="filter-giuong">
                    <input type="checkbox" id="filter-giuong" onchange="toggleFilter(this)"  data-group="Loại" data-field="product_type" data-text="Giường" value="(Giường)" data-operator="OR">
                    <i class="fa"></i>
                    Giường
                    </label>
                    </a>
                  </li>
                  <li class="filter-item filter-item--check-box filter-item--green">
                    <a href="javascript:void(0)">
                    <label for="filter-sofa">
                    <input type="checkbox" id="filter-sofa" onchange="toggleFilter(this)"  data-group="Loại" data-field="product_type" data-text="Sofa" value="(Sofa)" data-operator="OR">
                    <i class="fa"></i>
                    Sofa
                    </label>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="col-md-3">
              <div class="filter-group">
                <div class="filter-group-title filter-group-title--green">
                  Kích thước
                </div>
                <ul>
                  <li class="filter-item filter-item--check-box filter-item--green">
                    <a href="javascript:void(0)">
                    <label for="filter-lon">
                    <input type="checkbox" id="filter-lon" onchange="toggleFilter(this)" data-group="tag2" data-field="tags" data-text="Lớn" value="(Lớn)" data-operator="OR">
                    <i class="fa"></i>
                    Lớn
                    </label>
                    </a>
                  </li>
                  <li class="filter-item filter-item--check-box filter-item--green">
                    <a href="javascript:void(0)">
                    <label for="filter-nho">
                    <input type="checkbox" id="filter-nho" onchange="toggleFilter(this)" data-group="tag2" data-field="tags" data-text="Nhỏ" value="(Nhỏ)" data-operator="OR">
                    <i class="fa"></i>
                    Nhỏ
                    </label>
                    </a>
                  </li>
                  <li class="filter-item filter-item--check-box filter-item--green">
                    <a href="javascript:void(0)">
                    <label for="filter-vua">
                    <input type="checkbox" id="filter-vua" onchange="toggleFilter(this)" data-group="tag2" data-field="tags" data-text="Vừa" value="(Vừa)" data-operator="OR">
                    <i class="fa"></i>
                    Vừa
                    </label>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <script>
        var selectedSortby;
        var tt = 'Thứ tự';
        var selectedViewData = "data";
        var filter = new Bizweb.SearchFilter()
        
        filter.addValue("collection", "collections", "841582", "AND");
         
         function toggleFilter(e) {
           _toggleFilter(e);
           renderFilterdItems();
           doSearch(1);
         }
        
          function _toggleFilter(e) {
            var $element = $(e);
            var group = $element.attr("data-group");
            var field = $element.attr("data-field");
            var text = $element.attr("data-text");
            var value = $element.attr("value");
            var operator = $element.attr("data-operator");
            var filterItemId = $element.attr("id");
        
            if (!$element.is(':checked')) {
              filter.deleteValue(group, field, value, operator);
            }
            else{
              filter.addValue(group, field, value, operator);
            }
        
            $(".catalog_filters li[data-handle='" + filterItemId + "']").toggleClass("active");
          }
        
          function renderFilterdItems() {
            var $container = $(".filter-container__selected-filter-list ul");
            $container.html("");
        
            $(".filter-container input[type=checkbox]").each(function(index) {
              if ($(this).is(':checked')) {
                var id = $(this).attr("id");
                var name = $(this).closest("label").text();
        
                addFilteredItem(name, id);
              }
            });
        
            if($(".filter-container input[type=checkbox]:checked").length > 0)
              $(".filter-container__selected-filter").show();
            else
              $(".filter-container__selected-filter").hide();
          }
        
          function addFilteredItem(name, id) {
            var filteredItemTemplate = "<li class='filter-container__selected-filter-item' for='{3}'><a href='javascript:void(0)' onclick=\"{0}\"><i class='fa fa-close'></i> {1}</a></li>";
            filteredItemTemplate = filteredItemTemplate.replace("{0}", "removeFilteredItem('" + id + "')");
            filteredItemTemplate = filteredItemTemplate.replace("{1}", name);
            filteredItemTemplate = filteredItemTemplate.replace("{3}", id);
            var $container = $(".filter-container__selected-filter-list ul");
            $container.append(filteredItemTemplate);
          }
        
          function removeFilteredItem(id) {
            $(".filter-container #" + id).trigger("click");
          }
        
          function clearAllFiltered() {
            filter = new Bizweb.SearchFilter();
            
            filter.addValue("collection", "collections", "841582", "AND");
             
        
             $(".filter-container__selected-filter-list ul").html("");
            $(".filter-container input[type=checkbox]").attr('checked', false);
            $(".filter-container__selected-filter").hide();
        
            doSearch(1);
             }
        
             function doSearch(page, options) {
               if(!options) options = {};
        
               //NProgress.start();
               $('.aside.aside-mini-products-list.filter').removeClass('active');
               dqdt.showPopup('.loading');
               filter.search({
                 view: selectedViewData,
                 page: page,
                 sortby: selectedSortby,
                 success: function (html) {
                   var $html = $(html);
                   // Muốn thay thẻ DIV nào khi filter thì viết như này
                   var $categoryProducts = $($html[0]); 
                   var xxx = $categoryProducts.find('.call-count');
                   
                   $('.tt').text(xxx.text());
                   $(".category-products").html($categoryProducts.html());
                   pushCurrentFilterState({sortby: selectedSortby, page: page});
                   dqdt.hidePopup('.loading');
                   initQuickView();
                   $('.add_to_cart').click(function(e){
                     e.preventDefault();
                     var $this = $(this);              
                     var form = $this.parents('form');               
                     $.ajax({
                       type: 'POST',
                       url: '/cart/add.js',
                       async: false,
                       data: form.serialize(),
                       dataType: 'json',
                       error: addToCartFail,
                       beforeSend: function() {  
                         if(window.theme_load == "icon"){
                           dqdt.showLoading('.btn-addToCart');
                         } else{
                           dqdt.showPopup('.loading');
                         }
                       },
                       success: addToCartSuccess,
                       cache: false
                     });
                   });
        
                   $('.product-box .product-thumbnail a img').each(function(){
                     var t1 = (this.naturalHeight/this.naturalWidth);
                     var t2 = ($(this).parent().height()/$(this).parent().width());
                     if(t1< t2){
                       $(this).addClass('bethua');
                     }
                     var m1 = $(this).height();
                     var m2 = $(this).parent().height();
                     if(m1 < m2){
                       $(this).css('padding-top',(m2-m1)/2 + 'px');
                     }
                   })            
                   resortby(selectedSortby);
                    return window.BPR.initDomEls(), window.BPR.loadBadges();
                 }
               });    
        
             }
        
             function sortby(sort) {       
               switch(sort) {
                 case "price-asc":
                   selectedSortby = "price_min:asc";             
                   break;
                 case "price-desc":
                   selectedSortby = "price_min:desc";
                   break;
                 case "alpha-asc":
                   selectedSortby = "name:asc";
                   break;
                 case "alpha-desc":
                   selectedSortby = "name:desc";
                   break;
                 case "created-desc":
                   selectedSortby = "created_on:desc";
                   break;
                 case "created-asc":
                   selectedSortby = "created_on:asc";
                   break;
                 default:
                   selectedSortby = "";
                   break;
               }
        
               switch(sort) {         
                 case "price-asc":
                   tt = "Giá tăng dần";
                   break;
                 case "price-desc":
                   tt = "Giá giảm dần";
                   break;
                 case "alpha-asc":
                   tt = "Tên A → Z";
                   break;
                 case "alpha-desc":
                   tt = "Tên Z → A";
                   break;
                 case "created-desc":
                   tt = "Hàng mới nhất";
                   break;
                 case "created-asc":
                   tt = "Hàng cũ nhất";
                   break;
                 default:
                   tt = "Mặc định";
                   break;
               }
        
               $('#sort-by > ul > li > span').html(tt);
        
               doSearch(1);
             }
        
             function resortby(sort) {
               switch(sort) {         
                 case "price_min:asc":
                   tt = "Giá tăng dần";
                   break;
                 case "price_min:desc":
                   tt = "Giá giảm dần";
                   break;
                 case "name:asc":
                   tt = "Tên A → Z";
                   break;
                 case "name:desc":
                   tt = "Tên Z → A";
                   break;
                 case "created_on:desc":
                   tt = "Hàng mới nhất";
                   break;
                 case "created_on:asc":
                   tt = "Hàng cũ nhất";
                   break;
                 default:
                   tt = "Mặc định";
                   break;
               }
        
               $('#sort-by > ul > li > span').html(tt);
        
             }
        
        
             function _selectSortby(sort) {      
               resortby(sort);
               switch(sort) {
                 case "price-asc":
                   selectedSortby = "price_min:asc";
                   break;
                 case "price-desc":
                   selectedSortby = "price_min:desc";
                   break;
                 case "alpha-asc":
                   selectedSortby = "name:asc";
                   break;
                 case "alpha-desc":
                   selectedSortby = "name:desc";
                   break;
                 case "created-desc":
                   selectedSortby = "created_on:desc";
                   break;
                 case "created-asc":
                   selectedSortby = "created_on:asc";
                   break;
                 default:
                   selectedSortby = sort;
                   break;
               }
             }
        
             function toggleCheckbox(id) {
               $(id).click();
             }
        
             function pushCurrentFilterState(options) {
        
               if(!options) options = {};
               var url = filter.buildSearchUrl(options);
               var queryString = url.slice(url.indexOf('?'));       
               if(selectedViewData == 'data_list'){
                 queryString = queryString + '&view=list';         
               }
               else{
                 queryString = queryString + '&view=grid';           
               }
        
               pushState(queryString);
             }
        
             function pushState(url) {
               window.history.pushState({
                 turbolinks: true,
                 url: url
               }, null, url)
             }
             function switchView(view) {        
               switch(view) {
                 case "list":
                   selectedViewData = "data_list";             
                   break;
                 default:
                   selectedViewData = "data";
        
                   break;
               }         
               doSearch(1);
             }
        
             function selectFilterByCurrentQuery() {
               var isFilter = false;
               var url = window.location.href;
               var queryString = decodeURI(window.location.search);
               var filters = queryString.match(/\(.*?\)/g);
        
               if(filters && filters.length > 0) {
                 filters.forEach(function(item) {
                   item = item.replace(/\(\(/g, "(");
                   var element = $(".filter-container input[value='" + item + "']");
                   element.attr("checked", "checked");
                   _toggleFilter(element);
                 });
        
                 isFilter = true;
               }
        
               var sortOrder = getParameter(url, "sortby");
               if(sortOrder) {
                 _selectSortby(sortOrder);
               }
        
               if(isFilter) {
                 doSearch(1);
               }
             }
        
             function getParameter(url, name) {
               name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
               var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
                 results = regex.exec(url);
               return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
             }
        
             $( document ).ready(function() {
               selectFilterByCurrentQuery();
               $('.filter-group .filter-group-title').click(function(e){
                 $(this).parent().toggleClass('active');
               });
        
               $('.filter-mobile').click(function(e){
                 $('.aside.aside-mini-products-list.filter').toggleClass('active');
               });
        
               $('#show-admin-bar').click(function(e){
                 $('.aside.aside-mini-products-list.filter').toggleClass('active');
               });
        
               $('.filter-container__selected-filter-header-title').click(function(e){
                 $('.aside.aside-mini-products-list.filter').toggleClass('active');
               });
             });
      </script>
      <div class="category-products">
        <div class="col-md-12">
          <div class="row">
            @foreach($products as $val)
            <div class="col-md-3 col-sm-6 col-xs-12 grid-item-col">
              {!! Block::product_box($val) !!}
            </div>
            @endforeach
          </div>
          
          <nav class="clearfix">
            {!! $products->render() !!}
          </nav>
        </div>
      </div>
    </div>
  </div>
</section>
@else
<div class="container" style="min-height: 300px">
  <p>Không có sản phẩm nào</p>
</div>
@endif
@endsection
