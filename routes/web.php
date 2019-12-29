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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::match(['get', 'post'], '/products_list', 'ProductController@index')->middleware('auth');
Route::match(['get', 'post'], '/products_list/search', 'ProductController@search')->middleware('auth');
Route::match(['get', 'post'], '/products_list/edit/{id}', 'ProductController@edit')->middleware('auth');
Route::match(['get', 'post'], '/products_list/save', 'ProductController@save')->middleware('auth');
Route::match(['get', 'post', 'delete'], '/products_list/delete/{id}', 'ProductController@delete')->middleware('auth');

Route::match(['get', 'post'], '/order', 'OrderController@index')->middleware('auth');
Route::match(['get', 'post'], '/order/order', 'OrderController@order')->middleware('auth');

Route::match(['get', 'post'], '/order_details', 'OrderFormController@index')->middleware('auth');
Route::match(['get', 'post'], '/order_details/edit/{id}', 'OrderFormController@edit')->middleware('auth');
Route::match(['get', 'post'], '/order_details/save', 'OrderFormController@save')->middleware('auth');
Route::match(['get', 'post', 'delete'], '/order_details/delete/{id}', 'OrderFormController@delete')->middleware('auth');
Route::match(['get', 'post'], '/order_details/search', 'OrderFormController@search')->middleware('auth');

Route::match(['get', 'post'], '/delivery', 'DeliveryController@index')->middleware('auth');
Route::match(['get', 'post'], '/delivery/edit/{id}', 'DeliveryController@edit')->middleware('auth');
Route::match(['get', 'post'], '/delivery/save', 'DeliveryController@save')->middleware('auth');
Route::match(['get', 'post'], '/delivery/search', 'DeliveryController@search')->middleware('auth');


Route::match(['get', 'post'], '/contact', 'ContactController@index');
Route::match(['get', 'post'], '/contact/contact', 'ContactController@contact');


Route::match(['get', 'post'], '/checkcontact', 'CheckContactController@index');
Route::match(['get', 'post'], '/checkcontact/more/{id}', 'CheckContactController@more');
Route::match(['get', 'post'], '/checkcontact/contact', 'CheckContactController@contact');
Route::match(['get', 'post'], '/checkcontact/solve', 'CheckContactController@solve');
// Route::middleware(['auth'])->group(function () {
//     Route::get('/approval', 'HomeController@approval')->name('approval');
//     Route::get('/home', 'HomeController@index')->name('home');
// });