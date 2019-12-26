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

Route::get('/', function () {
    return view('welcome');
});

Route::get('call/{callMethod}', function ($callMethod) {
    return Artisan::call($callMethod);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {
    //Admin login infos
    Route::get('/', 'AdminController@index');
    Route::get('home', 'AdminController@index');
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
});
