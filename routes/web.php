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




Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

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


});







Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
