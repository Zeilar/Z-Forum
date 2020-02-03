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

Auth::routes();

Route::resource('post', 'PostsController');
Route::get('/', 'TableCategoriesController@index');
Route::get('/thread/{title}-{id}', 'ThreadsController@show');
Route::get('/category/{subcategory}-{id}', 'TableSubcategoriesController@show');