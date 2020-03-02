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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'TransferController@index');

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware('auth')->group(function () {
    Route::resource('/admin/categories', 'AdminCategoryController', ['as' => 'admin']);
    Route::resource('/admin/items', 'AdminItemController', ['as' => 'admin']);
});

Route::get('/items', 'ItemController@index')->name('items.index');
Route::get('/items/filter/{categoryId?}/{materialId?}', 'ItemController@filter')->name('items.filter');

Route::get('/transfer/{startItem?}/{finalItem?}', 'TransferController@index')->name('transfer.index');
Route::post('/transfer', 'TransferController@find')->name('transfer.find');

Route::get('/test', function () {
    return view('test');
});
