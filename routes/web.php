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

Route::middleware('auth')->group(function () {
    Route::resource('/admin/categories', 'AdminCategoryController', ['as' => 'admin']);
    Route::resource('/admin/items', 'AdminItemController', ['as' => 'admin']);
});

Route::get('/items', 'ItemController@index')->name('items.index');
Route::get('/items/{item}', 'ItemController@show')->name('items.show');
Route::get('/items/category/{category}', 'ItemController@indexCategory')->name('items.index.category');
Route::get('/items/material/{material}', 'ItemController@indexMaterial')->name('items.index.material');
