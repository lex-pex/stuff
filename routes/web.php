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

Route::get('/', 'GuestController@index')->name('items_index');

Route::get('/category/{id}', 'GuestController@category')->name('category_index');

Route::get('/item/{id}', 'GuestController@show')->name('item_show');

Route::get('/item/{id}/edit', 'GuestController@edit')->name('item_edit');

Route::get('/home', 'HomeController@index')->middleware('moderator')->name('home');

Route::resource('items', 'ItemController')->except(['index', 'show']);

Route::middleware('admin')->resource('categories', 'CategoryController')->except(['show']);

Route::get('users/cabinet', 'UserController@cabinet')->name('cabinet');

Route::middleware('admin')->resource('users', 'UserController');

Route::get('error_page', function() { return view('error'); })->name('error_page');

/* - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
Route::get('/', function () { return view('welcome'); });
Route::get('/home', 'HomeController@index')->name('home');
*/

Auth::routes();





