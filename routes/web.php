<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::group(['prefix' => 'customer'], function () {
  Route::get('/login', 'CustomerAuth\LoginController@showLoginForm');
  Route::post('/login', 'CustomerAuth\LoginController@login');
  Route::post('/logout', 'CustomerAuth\LoginController@logout');

  Route::get('/register', 'CustomerAuth\RegisterController@showRegistrationForm');
  Route::post('/register', 'CustomerAuth\RegisterController@register');

  Route::post('/password/email',['as' => 'sendResetLinkEmail' , 'uses' => 'CustomerAuth\ForgotPasswordController@sendResetLinkEmail']);
  Route::post('/password/reset', 'CustomerAuth\ResetPasswordController@reset');
  Route::get('/password/reset', 'CustomerAuth\ForgotPasswordController@showLinkRequestForm');
  Route::get('/password/reset/{token}', 'CustomerAuth\ResetPasswordController@showResetForm');
});

Route::get('/',['as' => 'home' , 'uses' => 'frontend\PageController@home']);

  
Route::get('getsubcategory',['as' => 'getsubcategory' , 'uses' => 'frontend\AjaxController@getsubcategory']);

Route::get('mau-thiet-ke/{alias?}.html',['as' => 'mauthietke' , 'uses' => 'frontend\PageController@mauthietke']);

Route::get('hang-san-xuat/{alias}',['as' => 'producer' , 'uses' => 'frontend\PageController@producer']);

Route::get('san-pham-moi',['as' => 'sanphammoi' , 'uses' => 'frontend\PageController@sanphammoi']);
Route::get('san-pham-ban-chay',['as' => 'sanphambanchay' , 'uses' => 'frontend\PageController@sanphambanchay']);
Route::get('san-pham-khuyen-mai',['as' => 'sanphamkhuyenmai' , 'uses' => 'frontend\PageController@sanphamkhuyenmai']);

Route::get('change_lang/{id}/{nation}',['as' => 'change_lang' , 'uses' => 'frontend\PageController@change_lang']);
Route::post('dang-ky',['as' => 'dangkycustomer' , 'uses' => 'frontend\CustomerController@dangky']);
Route::post('dang-nhap',['as' => 'dangnhapcustomer' , 'uses' => 'frontend\CustomerController@dangnhap']);
Route::group(['middleware' => ['customer']], function () {
  Route::get('dang-xuat',['as' => 'dangxuatcustomer' , 'uses' => 'frontend\CustomerController@dangxuat']);
  Route::get('quan-ly/{madonhang?}',['as' => 'quanlycustomer' , 'uses' => 'frontend\PageController@quanly']);
  Route::get('quan-ly-tai-khoan',['as' => 'quanlytaikhoancustomer' , 'uses' => 'frontend\PageController@quanlytaikhoan']);
  Route::get('quan-ly-don-hang/{madonhang?}',['as' => 'quanlydonhangcustomer' , 'uses' => 'frontend\PageController@quanlydonhang']);
  Route::post('suadiachi',['as' => 'suadiachi' , 'uses' => 'frontend\CustomerController@suadiachi']);
  Route::post('suadiachinhanhang',['as' => 'suadiachinhanhang' , 'uses' => 'frontend\CustomerController@suadiachinhanhang']);
  Route::post('themdiachinhanhang',['as' => 'themdiachinhanhang' , 'uses' => 'frontend\CustomerController@themdiachinhanhang']);
  Route::post('doimatkhau',['as' => 'doimatkhau' , 'uses' => 'frontend\CustomerController@doimatkhau']);
  Route::post('suathongtintaikhoan',['as' => 'suathongtintaikhoan' , 'uses' => 'frontend\CustomerController@suathongtintaikhoan']);
  Route::get('dang-ky-nhan-thong-tin',['as' => 'dangkynhanthongtin_get' , 'uses' => 'frontend\CustomerController@dangkynhanthongtin_get']);
  Route::get('dang-ky-nhan-thong-tin-delete',['as' => 'dangkynhanthongtin_delete' , 'uses' => 'frontend\CustomerController@dangkynhanthongtin_delete']);
});

Route::post('dangkynhantinkhuyenmai',['as' => 'dangkynhantinkhuyenmai' , 'uses' => 'frontend\PageController@dangkynhantinkhuyenmai']);
Route::get('xacnhandangkynhantinkhuyenmai/{name}/{email}',['as' => 'xacnhandangkynhantinkhuyenmai' , 'uses' => 'frontend\PageController@xacnhandangkynhantinkhuyenmai']);


Route::post('add_cart',['as' => 'add_cart' , 'uses' => 'frontend\CartController@add_cart']);
Route::post('update_cart',['as' => 'update_cart' , 'uses' => 'frontend\CartController@update_cart']);
Route::get('delete_cart/{rowId}',['as' => 'delete_cart' , 'uses' => 'frontend\CartController@delete_cart']);
Route::get('destroy_cart',['as' => 'destroy_cart' , 'uses' => 'frontend\CartController@destroy_cart']);
Route::get('gio-hang',['as' => 'cart' , 'uses' => 'frontend\PageController@cart']);
Route::get('checkout',['as' => 'checkout' , 'uses' => 'frontend\PageController@checkout']);
Route::post('checkout_post',['as' => 'checkout_post' , 'uses' => 'frontend\CartController@checkout_post']);

Route::get('y-kien-khach-hang',['as' => 'customer_reviews' , 'uses' => 'frontend\PageController@customer_reviews']);

Route::post('search',['as' => 'search.post' , 'uses' => 'frontend\PageController@search_post']);
Route::get('search',['as' => 'search.get' , 'uses' => 'frontend\PageController@search_get']);
Route::get('tags/{key}',['as' => 'tag' , 'uses' => 'frontend\PageController@tag']);

Route::get('menu/{alias}',['as' => 'menu' , 'uses' => 'frontend\PageController@menu']);

Route::get('capcha',['as' => 'capcha' , 'uses' => 'CapchaController@getBuild']);
Route::get('capcha2',['as' => 'capcha2' , 'uses' => 'CapchaController@getBuild2']);
Route::get('captcha_login_backend',['as' => 'captcha_login_backend' , 'uses' => 'CapchaController@captcha_login_backend']);
Route::post('danhgia',['as' => 'danhgia' , 'uses' => 'CapchaController@danhgia']);

Route::get('lien-he',['as' => 'contact' , 'uses' => 'frontend\PageController@contact']);



  Route::group(['prefix' => 'backend'],function(){
    Route::group(['middleware' => ['guest']], function () {
    Route::get('login',['as' => 'login' , 'uses' => 'backend\LoginController@getLogin']);
    Route::post('login',['as' => 'backend.login.post' , 'uses' => 'backend\LoginController@postLogin']);
  });

    Route::group(['middleware' => ['auth','LanguageSwitcher']], function () {
      Route::get('logout',['as' => 'backend.logout' , 'uses' => 'backend\LoginController@logout']);
      Route::get('/',['as' => 'backend.home' , 'uses' => 'backend\HomeController@index']);
      
      
      Route::group(['middleware' => ['manager']], function () {
        Route::group(['prefix' => 'account'],function(){
          Route::get('add',['as' => 'backend.account.add.get' , 'uses' => 'backend\AccountController@add_get']);
          Route::post('add',['as' => 'backend.account.add.post' , 'uses' => 'backend\AccountController@add_post']);
          Route::get('edit/{id}',['as' => 'backend.account.edit.get' , 'uses' => 'backend\AccountController@edit_get']);
          Route::post('edit/{id}',['as' => 'backend.account.edit.post' , 'uses' => 'backend\AccountController@edit_post']);
          Route::get('{key?}',['as' => 'backend.account.list.get' , 'uses' => 'backend\AccountController@list_get']);
          Route::post('/',['as' => 'backend.account.list.post' , 'uses' => 'backend\AccountController@list_post']);
          Route::post('change_pw/{id}',['as' => 'backend.account.change_pw' , 'uses' => 'backend\AccountController@change_pw']);
          Route::get('delete/{id}',['as' => 'backend.account.delete' , 'uses' => 'backend\AccountController@delete']);
        });
        

        Route::group(['prefix' => 'role'],function(){
          Route::get('add',['as' => 'backend.role.add.get' , 'uses' => 'backend\RoleController@add_get']);
          Route::post('add',['as' => 'backend.role.add.post' , 'uses' => 'backend\RoleController@add_post']);
          Route::get('edit/{id}',['as' => 'backend.role.edit.get' , 'uses' => 'backend\RoleController@edit_get']);
          Route::post('edit/{id}',['as' => 'backend.role.edit.post' , 'uses' => 'backend\RoleController@edit_post']);
          Route::get('{key?}',['as' => 'backend.role.list.get' , 'uses' => 'backend\RoleController@list_get']);
          Route::post('/',['as' => 'backend.role.list.post' , 'uses' => 'backend\RoleController@list_post']);
          Route::post('change_pw/{id}',['as' => 'backend.role.change_pw' , 'uses' => 'backend\RoleController@change_pw']);
          Route::get('delete/{id}',['as' => 'backend.role.delete' , 'uses' => 'backend\RoleController@delete']);
        });
        

        

        

        Route::group(['prefix' => 'language'],function(){
          Route::get('add',['as' => 'backend.language.add.get' , 'uses' => 'backend\LanguageController@add_get']);
          Route::post('add',['as' => 'backend.language.add.post' , 'uses' => 'backend\LanguageController@add_post']);
          Route::get('edit/{id}',['as' => 'backend.language.edit.get' , 'uses' => 'backend\LanguageController@edit_get']);
          Route::post('edit/{id}',['as' => 'backend.language.edit.post' , 'uses' => 'backend\LanguageController@edit_post']);
          Route::get('{key?}',['as' => 'backend.language.list.get' , 'uses' => 'backend\LanguageController@list_get']);
          Route::post('/',['as' => 'backend.language.list.post' , 'uses' => 'backend\LanguageController@list_post']);
          Route::get('delete/{id}',['as' => 'backend.language.delete' , 'uses' => 'backend\LanguageController@delete']);
        });

        Route::get('meta_default',['as' => 'backend.meta_default.get' , 'uses' => 'backend\MetaController@get']);
        Route::post('meta_default',['as' => 'backend.meta_default.post' , 'uses' => 'backend\MetaController@post']);

        Route::get('mail_system',['as' => 'backend.mail_system.get' , 'uses' => 'backend\MailSystemController@get']);
        Route::post('mail_system',['as' => 'backend.mail_system.post' , 'uses' => 'backend\MailSystemController@post']);

        Route::group(['prefix' => 'banner'],function(){
          Route::get('add',['as' => 'backend.banner.add.get' , 'uses' => 'backend\BannerController@add_get']);
          Route::post('add',['as' => 'backend.banner.add.post' , 'uses' => 'backend\BannerController@add_post']);
          Route::get('edit/{id}',['as' => 'backend.banner.edit.get' , 'uses' => 'backend\BannerController@edit_get']);
          Route::post('edit/{id}',['as' => 'backend.banner.edit.post' , 'uses' => 'backend\BannerController@edit_post']);
          Route::get('{key?}',['as' => 'backend.banner.list.get' , 'uses' => 'backend\BannerController@list_get']);
          Route::post('/',['as' => 'backend.banner.list.post' , 'uses' => 'backend\BannerController@list_post']);
          Route::get('delete/{id}',['as' => 'backend.banner.delete' , 'uses' => 'backend\BannerController@delete']);
        });

        
        
      
    });
  
    Route::group(['middleware' => ['admin-content']], function () {
      Route::group(['prefix' => 'static_block'],function(){
        Route::get('add',['as' => 'backend.static_block.add.get' , 'uses' => 'backend\StaticBlockController@add_get']);
        Route::post('add',['as' => 'backend.static_block.add.post' , 'uses' => 'backend\StaticBlockController@add_post']);
        Route::get('edit/{id}',['as' => 'backend.static_block.edit.get' , 'uses' => 'backend\StaticBlockController@edit_get']);
        Route::post('edit/{id}',['as' => 'backend.static_block.edit.post' , 'uses' => 'backend\StaticBlockController@edit_post']);
        Route::get('{key?}',['as' => 'backend.static_block.list.get' , 'uses' => 'backend\StaticBlockController@list_get']);
        Route::post('/',['as' => 'backend.static_block.list.post' , 'uses' => 'backend\StaticBlockController@list_post']);
        Route::get('delete/{id}',['as' => 'backend.static_block.delete' , 'uses' => 'backend\StaticBlockController@delete']);
      });

      Route::group(['prefix' => 'banner'],function(){
        Route::get('add',['as' => 'backend.banner.add.get' , 'uses' => 'backend\BannerController@add_get']);
        Route::post('add',['as' => 'backend.banner.add.post' , 'uses' => 'backend\BannerController@add_post']);
        Route::get('edit/{id}',['as' => 'backend.banner.edit.get' , 'uses' => 'backend\BannerController@edit_get']);
        Route::post('edit/{id}',['as' => 'backend.banner.edit.post' , 'uses' => 'backend\BannerController@edit_post']);
        Route::get('{key?}',['as' => 'backend.banner.list.get' , 'uses' => 'backend\BannerController@list_get']);
        Route::post('/',['as' => 'backend.banner.list.post' , 'uses' => 'backend\BannerController@list_post']);
        Route::get('delete/{id}',['as' => 'backend.banner.delete' , 'uses' => 'backend\BannerController@delete']);
      });

      Route::group(['prefix' => 'menu'],function(){
        Route::get('add',['as' => 'backend.menu.add.get' , 'uses' => 'backend\MenuController@add_get']);
        Route::post('add',['as' => 'backend.menu.add.post' , 'uses' => 'backend\MenuController@add_post']);
        Route::get('edit/{id}/{lang?}',['as' => 'backend.menu.edit.get' , 'uses' => 'backend\MenuController@edit_get']);
        Route::post('edit/{id}/{lang?}',['as' => 'backend.menu.edit.post' , 'uses' => 'backend\MenuController@edit_post']);
        Route::get('{key?}',['as' => 'backend.menu.list.get' , 'uses' => 'backend\MenuController@list_get']);
        Route::post('/',['as' => 'backend.menu.list.post' , 'uses' => 'backend\MenuController@list_post']);
        Route::get('delete/{id}',['as' => 'backend.menu.delete' , 'uses' => 'backend\MenuController@delete']);
      });
    });

    Route::group(['prefix' => 'tag'],function(){
      Route::get('add',['as' => 'backend.tag.add.get' , 'uses' => 'backend\TagController@add_get']);
      Route::post('add',['as' => 'backend.tag.add.post' , 'uses' => 'backend\TagController@add_post']);
      Route::get('edit/{id}',['as' => 'backend.tag.edit.get' , 'uses' => 'backend\TagController@edit_get']);
      Route::post('edit/{id}',['as' => 'backend.tag.edit.post' , 'uses' => 'backend\TagController@edit_post']);
      Route::get('{key?}',['as' => 'backend.tag.list.get' , 'uses' => 'backend\TagController@list_get']);
      Route::post('/',['as' => 'backend.tag.list.post' , 'uses' => 'backend\TagController@list_post']);
      Route::get('delete/{id}',['as' => 'backend.tag.delete' , 'uses' => 'backend\TagController@delete']);
    });
     
    Route::group(['prefix' => 'posts'],function(){
        Route::group(['middleware' => ['admin-content']], function () {
          Route::group(['prefix' => 'category'],function(){
            Route::get('add',['as' => 'backend.posts.category.add.get' , 'uses' => 'backend\posts\CategoryController@add_get']);
            Route::post('add',['as' => 'backend.posts.category.add.post' , 'uses' => 'backend\posts\CategoryController@add_post']);
            Route::get('edit/{id}/{lang?}',['as' => 'backend.posts.category.edit.get' , 'uses' => 'backend\posts\CategoryController@edit_get']);
            Route::post('edit/{id}/{lang?}',['as' => 'backend.posts.category.edit.post' , 'uses' => 'backend\posts\CategoryController@edit_post']);
            Route::get('{key?}',['as' => 'backend.posts.category.list.get' , 'uses' => 'backend\posts\CategoryController@list_get']);
            Route::post('/',['as' => 'backend.posts.category.list.post' , 'uses' => 'backend\posts\CategoryController@list_post']);
            Route::get('delete/{id}',['as' => 'backend.posts.category.delete' , 'uses' => 'backend\posts\CategoryController@delete']);
          });
        });

        Route::group(['prefix' => 'posts'],function(){
          Route::get('add',['as' => 'backend.posts.posts.add.get' , 'uses' => 'backend\posts\PostsController@add_get']);
          Route::post('add',['as' => 'backend.posts.posts.add.post' , 'uses' => 'backend\posts\PostsController@add_post']);
          Route::get('edit/{id}/{lang?}',['as' => 'backend.posts.posts.edit.get' , 'uses' => 'backend\posts\PostsController@edit_get']);
          Route::post('edit/{id}/{lang?}',['as' => 'backend.posts.posts.edit.post' , 'uses' => 'backend\posts\PostsController@edit_post']);
          Route::get('user/{key?}',['as' => 'backend.posts.posts.list_user.get' , 'uses' => 'backend\posts\PostsController@list_user_get']);
          Route::get('{key?}',['as' => 'backend.posts.posts.list.get' , 'uses' => 'backend\posts\PostsController@list_get']);
          Route::post('/',['as' => 'backend.posts.posts.list.post' , 'uses' => 'backend\posts\PostsController@list_post']);
          Route::get('delete/{id}/{lang?}',['as' => 'backend.posts.posts.delete' , 'uses' => 'backend\posts\PostsController@delete']);
        });
      });

      Route::group(['prefix' => 'media'],function(){
        Route::get('add',['as' => 'backend.media.add.get' , 'uses' => 'backend\MediaController@add_get']);
        Route::post('add',['as' => 'backend.media.add.post' , 'uses' => 'backend\MediaController@add_post']);
        Route::get('edit/{id}/{lang?}',['as' => 'backend.media.edit.get' , 'uses' => 'backend\MediaController@edit_get']);
        Route::post('edit/{id}/{lang?}',['as' => 'backend.media.edit.post' , 'uses' => 'backend\MediaController@edit_post']);
        Route::get('user/{key?}',['as' => 'backend.media.list_user.get' , 'uses' => 'backend\MediaController@list_user_get']);
        Route::get('{key?}',['as' => 'backend.media.list.get' , 'uses' => 'backend\MediaController@list_get']);
        Route::post('/',['as' => 'backend.media.list.post' , 'uses' => 'backend\MediaController@list_post']);
        Route::get('delete/{id}/{lang?}',['as' => 'backend.media.delete' , 'uses' => 'backend\MediaController@delete']);
      });

      Route::group(['prefix' => 'document'],function(){
        Route::get('add',['as' => 'backend.document.add.get' , 'uses' => 'backend\DocumentController@add_get']);
        Route::post('add',['as' => 'backend.document.add.post' , 'uses' => 'backend\DocumentController@add_post']);
        Route::get('edit/{id}/{lang?}',['as' => 'backend.document.edit.get' , 'uses' => 'backend\DocumentController@edit_get']);
        Route::post('edit/{id}/{lang?}',['as' => 'backend.document.edit.post' , 'uses' => 'backend\DocumentController@edit_post']);
        Route::get('user/{key?}',['as' => 'backend.document.list_user.get' , 'uses' => 'backend\DocumentController@list_user_get']);
        Route::get('{key?}',['as' => 'backend.document.list.get' , 'uses' => 'backend\DocumentController@list_get']);
        Route::post('/',['as' => 'backend.document.list.post' , 'uses' => 'backend\DocumentController@list_post']);
        Route::get('delete/{id}/{lang?}',['as' => 'backend.document.delete' , 'uses' => 'backend\DocumentController@delete']);
        Route::get('delete_details/{id}',['as' => 'backend.document.delete_details' , 'uses' => 'backend\DocumentController@delete_details']);
      });

    Route::group(['prefix' => 'product'],function(){
      Route::group(['prefix' => 'category'],function(){
        Route::get('add',['as' => 'backend.product.category.add.get' , 'uses' => 'backend\product\CategoryController@add_get']);
        Route::post('add',['as' => 'backend.product.category.add.post' , 'uses' => 'backend\product\CategoryController@add_post']);
        Route::get('edit/{id}',['as' => 'backend.product.category.edit.get' , 'uses' => 'backend\product\CategoryController@edit_get']);
        Route::post('edit/{id}',['as' => 'backend.product.category.edit.post' , 'uses' => 'backend\product\CategoryController@edit_post']);
        Route::get('{key?}',['as' => 'backend.product.category.list.get' , 'uses' => 'backend\product\CategoryController@list_get']);
        Route::post('/',['as' => 'backend.product.category.list.post' , 'uses' => 'backend\product\CategoryController@list_post']);
        Route::get('delete/{id}',['as' => 'backend.product.category.delete' , 'uses' => 'backend\product\CategoryController@delete']);
      });

      Route::group(['prefix' => 'product'],function(){
        Route::get('add',['as' => 'backend.product.product.add.get' , 'uses' => 'backend\product\ProductController@add_get']);
        Route::post('add',['as' => 'backend.product.product.add.post' , 'uses' => 'backend\product\ProductController@add_post']);
        Route::get('edit/{id}',['as' => 'backend.product.product.edit.get' , 'uses' => 'backend\product\ProductController@edit_get']);
        Route::post('edit/{id}',['as' => 'backend.product.product.edit.post' , 'uses' => 'backend\product\ProductController@edit_post']);
        Route::get('user/{key?}',['as' => 'backend.product.product.list_user.get' , 'uses' => 'backend\product\ProductController@list_user_get']);
        Route::get('{key?}',['as' => 'backend.product.product.list.get' , 'uses' => 'backend\product\ProductController@list_get']);
        Route::post('/',['as' => 'backend.product.product.list.post' , 'uses' => 'backend\product\ProductController@list_post']);
        Route::get('delete/{id}',['as' => 'backend.product.product.delete' , 'uses' => 'backend\product\ProductController@delete']);
        Route::get('delete_img/{id}',['as' => 'backend.product.product.delete_img' , 'uses' => 'backend\product\ProductController@delete_img']);
        Route::get('pk_img/{id}',['as' => 'backend.product.product.pk_img' , 'uses' => 'backend\product\ProductController@pk_img']);
      });
    });

     

      Route::group(['prefix' => 'profile'],function(){
      Route::get('/',['as' => 'backend.profile' , 'uses' => 'backend\ProfileController@index']);
      Route::post('edit',['as' => 'backend.profile.edit' , 'uses' => 'backend\ProfileController@edit']);
      Route::post('change_pw',['as' => 'backend.profile.change_pw' , 'uses' => 'backend\ProfileController@change_pw']);
      Route::post('change_img',['as' => 'backend.profile.change_img' , 'uses' => 'backend\ProfileController@change_img']);
      
      });


      

      

      Route::group(['prefix' => 'ajax'],function(){
        Route::get('get_data_cursor',['as' => 'get_data_cursor' , 'uses' => 'backend\AjaxController@get_data_cursor']);
        Route::post('add_lang',['as' => 'add_lang' , 'uses' => 'backend\AjaxController@add_lang']);
        Route::post('add_attr_product',['as' => 'add_attr_product' , 'uses' => 'backend\AjaxController@add_attr_product']);
        Route::post('get_attr_product',['as' => 'get_attr_product' , 'uses' => 'backend\AjaxController@get_attr_product']);
        Route::post('check_code_product',['as' => 'check_code_product' , 'uses' => 'backend\AjaxController@check_code_product']);
        Route::post('change_order',['as' => 'change_order' , 'uses' => 'backend\AjaxController@change_order']);
        
      });
    });
  });

Route::get('{alias}.html',['as' => 'posts' , 'uses' => 'frontend\PageController@posts']);
Route::get('cat/{alias?}.html',['as' => 'posts_category' , 'uses' => 'frontend\PageController@posts_category']);

