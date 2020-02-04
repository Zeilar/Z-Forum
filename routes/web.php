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

Route::get('/', 'TableCategoriesController@index');
Route::get('/post/{id}', 'PostsController@show');
Route::get('/thread/{title}-{id}/new', 'PostsController@create');
Route::get('/thread/{title}-{id}', 'ThreadsController@show');
Route::get('/category/{subcategory}-{id}/new', 'ThreadsController@create');
Route::get('/category/{subcategory}-{id}', 'TableSubcategoriesController@show');

Route::post('/post/create', 'PostsController@store');
Route::post('/thread/create', 'ThreadsController@store');