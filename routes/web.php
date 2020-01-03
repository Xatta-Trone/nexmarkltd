<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/old', function () {
    return view('welcome');
});

Route::get('/', 'PagesController@home')->name('index');
Route::get('/register', 'PagesController@register')->name('register');
Route::get('/submitstatus', 'PagesController@submitstatus')->name('submitstatus');

Route::group(['namespace' => 'User'], function () {
    Route::post('/storeshopdata', 'ShopController@storeShopInfo')->name('shop.submit');
    Route::post('/validatetradelicense', 'ShopController@validatetradelicense')->name('shop.validatetradelicense');
});




Route::get('call/{callMethod}', function ($callMethod) {
    return Artisan::call($callMethod);
});

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {
    //Admin login infos
    Route::get('/', 'HomeController@index')->name('admin.home');
    Route::get('home', 'HomeController@index')->name('admin.home');
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('admin.login');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout')->name('admin.logout');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('admin.password.update');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('admin.password.reset');

    //category
    Route::resource('categories', 'CategoriesController');
    Route::get('categoriesajax', 'CategoriesController@ajaxDataTable')->name('categories.ajax');

    //shops
    Route::resource('shops', 'ShopsController');
    Route::get('shopsajax', 'ShopsController@ajaxDataTable')->name('shops.ajax');
    Route::get('shop/tlc/{id}', 'ShopsController@previewFile')->name('shops.previewfile');
    Route::get('shop/approve/{id}', 'ShopsController@approve')->name('shops.approve');

    //admins
    Route::resource('admins', 'AdminController');
    Route::get('adminsajax', 'AdminController@ajaxDataTable')->name('admins.ajax');
    Route::post('admins/checkemail', 'AdminController@checkEmail')->name('admins.checkemail');

    //permissions
    Route::resource('permissions', 'PermissionController');
    Route::get('permissionsajax', 'PermissionController@ajaxDataTable')->name('permissions.ajax');

    //roles
    Route::resource('roles', 'RolesController');
    Route::get('rolesajax', 'RolesController@ajaxDataTable')->name('roles.ajax');

    //products
    Route::resource('products', 'ProductsController');
    Route::get('productsajax', 'ProductsController@ajaxDataTable')->name('products.ajax');
    Route::post('checkproduct', 'ProductsController@checkproduct')->name('products.check');
    Route::post('getSingleProduct', 'ProductsController@getSingleProduct')->name('products.getSingleProduct');

    //orders
    Route::resource('orders', 'OrderController');
    Route::get('ordersajax', 'OrderController@ajaxDataTable')->name('orders.ajax');
});
