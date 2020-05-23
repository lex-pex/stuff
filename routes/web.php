<?php

Route::get('/', 'GuestController@index')->name('items_index');

Route::get('/category/{alias}', 'GuestController@category')->name('category');

Route::get('/item/{id}', 'GuestController@show')->name('item_show');

Route::get('/item/{id}/edit', 'GuestController@edit')->name('item_edit');

Route::get('/home', 'HomeController@index')->middleware('moderator')->name('home');

Route::resource('items', 'ItemController')->except(['show']);

Route::post('itemsSortFilter', 'ItemController@sortFilter')->name('sortFilter');

Route::get('users/cabinet', 'UserController@cabinet')->name('cabinet');

Route::middleware('admin')->resource('categories', 'CategoryController')->except(['show']);

Route::middleware('moderator')->resource('users', 'UserController');

Route::get('error_page', function() { return view('error'); })->name('error_page');

Auth::routes();





