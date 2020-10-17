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
// frontend route
Route::get('/','IndexController@index')->name('front.index');
Route::get('/products/{url}','ProductsController@products')->name('productsByCategory');
Route::get('/404','IndexController@show404Page')->name('front.404');
Route::get('product/{productId}','ProductsController@product')->name('front.productDetails');

//getproduct price using ajax
Route::get('/get-product-price/{productId?}/{attributeId?}','ProductsController@getProductPrice');

//cart routes
Route::match(['get', 'post'], '/product/{productId?}/add-to-art','ProductsController@addToCart')->name('front.addToCart');
Route::match(['get', 'post'], '/cart','ProductsController@cart')->name('front.cart');
Route::get('/cart/delete-product/{cartId}','ProductsController@deleteCartProduct')->name('front.deleteCartItem');
Route::get('/cart/update-quantity/{cartId}/{quantity}','ProductsController@updateCartQuantity')->name('front.updateQuantity');

//coupon apply
Route::post('/cart/apply-coupon','ProductsController@applyCoupon')->name('front.applyCoupon');


Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');




//all admin Routes
Route::match(['get', 'post'], '/admin','AdminController@login')->name('admin')->middleware('guest');

Route::group(['middleware' => ['auth']],function(){
	Route::get('/admin/dashboard','AdminController@dashboard')->name('admin.dashboard');
    Route::get('/admin/settings','AdminController@settings')->name('admin.settings');

    //check password using ajax
    Route::get('/admin/check-pwd','AdminController@chkPassword');
    //then update admin user password
	Route::match(['get','post'],'/admin/update-pwd','AdminController@updatePassword')->name('admin.updatepassword');

	// Categories Routes (Admin)
	Route::match(['get','post'],'/admin/add-category','CategoryController@addCategory')->name('admin.addCategory');
	Route::match(['get','post'],'/admin/edit-category/{categoryId?}','CategoryController@editCategory')->name('admin.editCategory');
	Route::match(['get','post'],'/admin/delete-category/{categoryId?}','CategoryController@deleteCategory')->name('admin.deleteCategory');
	Route::get('/admin/view-categories','CategoryController@viewCategories')->name('admin.viewCategories');

	// Products Routes(admin)
    Route::match(['get','post'],'/admin/add-product','ProductsController@addProduct')->name('admin.addProduct');
    Route::match(['get','post'],'/admin/edit-product/{productId?}','ProductsController@editProduct')->name('admin.editProduct');
	Route::match(['get','post'],'/admin/delete-product/{productId?}','ProductsController@deleteProduct')->name('admin.deleteProduct');
    Route::get('/admin/view-products','ProductsController@viewProducts')->name('admin.viewProducts');



    //admin logout
    Route::get('/logout','AdminController@logout');

    //product Attributes
    Route::match(['get','post'],'admin/add-attributes/{productId?}','ProductsController@addAttributes')->name('admin.addProductAttribute');
    Route::get('/admin/delete-attribute/{attributeId?}','ProductsController@deleteAttribute')->name('admin.deleteAttribute');
    Route::post('/admin/update-attribute/{attributeId?}','ProductsController@updateAttribute')->name('admin.updateAttribute');


    //product alt image route
    Route::get('/admin/delete-altimage/{altImageId?}','ProductsController@deleteAltImage')->name('admin.deleteAltImage');
    Route::match(['get','post'],'/admin/addAlt-image/{productId?}','ProductsController@addProductAltImage')->name('admin.addProductImage');


    //coupons code route
    Route::match(['get','post'],'/admin/add-coupon','CouponController@addCoupon')->name('admin.addCoupon');
    Route::match(['get','post'],'/admin/edit-coupon/{couponId?}','CouponController@editCoupon')->name('admin.editCoupon');
    Route::get('/admin/view-coupons','CouponController@viewCoupons')->name('admin.viewCoupons');
    Route::match(['get','post'],'/admin/delete-coupon/{couponId?}','CouponController@deleteCoupon')->name('admin.deleteCoupon');


    //banners route
    Route::match(['get','post'],'/admin/add-banner','BannersController@addBanner')->name('admin.addBanner');
    Route::match(['get','post'],'/admin/edit-banner/{bannerId?}','BannersController@editBanner')->name('admin.editBanner');
    Route::get('/admin/view-banners','BannersController@viewCoupons')->name('admin.viewBanners');
    Route::match(['get','post'],'/admin/delete-banner/{bannerId?}','BannersController@deleteCoupon')->name('admin.deleteBanner');
});


