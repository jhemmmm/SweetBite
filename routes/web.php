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

Route::get('/', 'HomeController@index')->name('home');
Route::get('/about', 'HomeController@about')->name('about');
Route::get('/product', 'HomeController@product')->name('prudct');
Route::get('/product/{id}', 'HomeController@productDetail')->name('product.view');
Route::post('/product/{id}/review', 'UserController@createReview')->name('product.review')->middleware('auth');

Route::get('/cart', 'CartController@index')->name('cart');
Route::get('/cart/{id}/delete', 'CartController@cartDelete')->name('cart.delete')->middleware('auth');
Route::get('/cart/AddItem', 'CartController@addItem')->name('AddItem');

Route::post('/cart/OrderItem', 'CartController@orderItem')->name('OrderItem');

Route::get('/order/{id}/success', 'CartController@orderSuccess')->name('order.success');

Route::get('/provinces/cities', 'HomeController@cities');

Auth::routes();
Route::group(['prefix' => 'user', 'middleware' => 'auth'], function () {
    Route::get('/setting', 'UserController@setting')->name('user.setting');
    Route::post('/setting', 'UserController@settingPost')->name('user.setting');
    Route::group(['prefix' => 'addresses'], function () {
        Route::get('/', 'UserController@addreses')->name('user.addresses');

        Route::get('/create', 'UserController@createAddress')->name('user.addresses.create');
        Route::post('/create', 'UserController@createAddressPost')->name('user.addresses.store');

        Route::get('/{id}', 'UserController@editAddress')->name('user.addresses.edit');
        Route::post('/{id}', 'UserController@editAddressPost')->name('user.addresses.update');

        Route::delete('/{id}', 'UserController@deleteAddress')->name('user.addresses.delete');

    });
    Route::group(['prefix' => 'orders'], function () {
        Route::get('/', 'UserController@orderHistory')->name('user.order.list');
        Route::get('/{id}', 'UserController@orderDetails')->name('user.order.view');
        Route::post('/{id}', 'UserController@orderCancel')->name('user.order.cancel');
    });
});
Route::group(['prefix' => 'admin', 'middleware' => ['processing', 'admin', 'inventory']], function () {
    Route::get('/', 'AdminController@index');
    Route::get('/reports/{type}', 'AdminController@report')->name('admin.report');

    Route::group(['prefix' => 'user', 'middleware' => ['admin']], function () {
        Route::get('/', 'AdminController@userLists')->name('admin.user.list');
        Route::get('/update/{id}', 'AdminController@userUpdate')->name('admin.user.update');
        Route::post('/update/{id}', 'AdminController@userPostUpdate')->name('admin.user.update.post');
        Route::delete('/delete/{id}', 'AdminController@userDelete')->name('admin.user.delete');
    });
    Route::group(['prefix' => 'product'], function () {
        Route::get('/', 'AdminController@productList')->name('admin.product.list');
        Route::get('/create', 'AdminController@productCreate')->name('admin.product.create');
        Route::post('/create', 'AdminController@productStore')->name('admin.product.store');
        Route::get('/update/{id}', 'AdminController@productUpdate')->name('admin.product.update');
        Route::post('/update/{id}', 'AdminController@productUpdatePost')->name('admin.product.update.post');
        Route::delete('/delete/{id}', 'AdminController@productDelete')->name('admin.product.delete');
        Route::get('/{id}', 'AdminController@productReport')->name('admin.product.report');
    });

    Route::group(['prefix' => 'order'], function () {
        Route::get('/', 'AdminController@orderLists')->name('admin.order.list');
        Route::get('/{id}', 'AdminController@orderView')->name('admin.order.view');
        Route::post('/{id}', 'AdminController@orderUpdateStatus')->name('admin.order.view');
    });

    Route::group(['prefix' => 'invoice'], function () {
       Route::get('/', 'AdminController@invoiceList')->name('admin.invoice.list');
       Route::get('/{id}', 'AdminController@invoiceView')->name('admin.invoice.view');
    });
});
