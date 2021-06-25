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


//Home Page
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index')->name('home');

Route::resource('productType', 'ProductTypeController');
Route::resource('product', 'ProductController');
// Route::resource('cartItem', 'CartItemController');

Route::get('/product/filtered/{productType_id}', 'productController@indexFiltered');

Route::get('/cartItem', 'CartItemController@index');
Route::post('/cartItem', 'CartItemController@store');
Route::post('/cartItem/update-cart', 'CartItemController@update');
Route::post('/cartItem/destroy', 'CartItemController@destroy');

Route::get('/transaction', 'TransactionController@index');
Route::post('/transaction/checkout', 'TransactionController@checkout');

Route::get('/edit-profile', 'ProfileController@edit');
Route::post('/edit-profile', 'ProfileController@update');

Auth::routes();
