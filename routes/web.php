<?php

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

Route::get('/', 'MainController@index')->name('main');
Route::get('shop', 'ShopController@index')->name('shop');
Route::get('shop/{product}', 'ShopController@show')->name('shop.show');
Route::get('cart', 'CartController@index')->name('cart.index');
Route::post('cart', 'CartController@store')->name('cart.store');
Route::delete('cart/{product}', 'CartController@destroy')->name('cart.destroy');
Route::get('checkout', 'CheckoutController@index')->name('checkout')->middleware('auth');
Route::post('checkout', 'CheckoutController@store')->name('checkout.store');
Route::get('confirmation', 'ConfirmationController@index')->name('confirmation');
Route::get('empty', 'CartController@empty')->name('empty');
Route::get('order', 'OrderController@index')->name('order.index');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
