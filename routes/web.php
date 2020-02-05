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

// Index
Route::get('/', 'TableCategoriesController@index');

// Table categories
Route::get('/category/{category}-{id}', 'TableCategoriesController@show')->name('tablecategory_show');

// Table subcategories
Route::get('/subcategory/{subcategory}-{id}', 'TableSubcategoriesController@show')->name('tablesubcategory_show');

// Threads
Route::post('/subcategory/{subcategory}-{id}/create', 'ThreadsController@store')->name('thread_store');
Route::get('/subcategory/{subcategory}-{id}/new', 'ThreadsController@create')->name('thread_create');
Route::get('/thread/{title}-{id}', 'ThreadsController@show')->name('thread_show');

// Posts
Route::post('/thread/{title}-{id}/create', 'PostsController@store')->name('post_store');
Route::get('/thread/{title}-{id}/new', 'PostsController@create')->name('post_create');
Route::get('/post/{id}', 'PostsController@show')->name('post_show');

// Users
Route::get('/user/{id}', 'UsersController@show')->name('user_show');