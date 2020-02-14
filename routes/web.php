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
Route::get('/', 'TableCategoriesController@index')->name('index');

// Table categories
Route::get('/category/{category}-{id}', 'TableCategoriesController@show')->name('tablecategory_show');
Route::post('/category/store', 'TableCategoriesController@store')->name('tablecategory_store');
Route::get('/category/new', 'TableCategoriesController@create')->name('tablecategory_create');

// Table subcategories
Route::post('/subcategory/{subcategory}-{id}/store', 'TableSubcategoriesController@store')->name('tablesubcategory_store');
Route::get('/category/{category}-{id}/new', 'TableSubcategoriesController@create')->name('tablesubcategory_create');
Route::get('/subcategory/{subcategory}-{id}', 'TableSubcategoriesController@show')->name('tablesubcategory_show');

// Threads
Route::post('/subcategory/{subcategory}-{id}/thread/store', 'ThreadsController@store')->name('thread_store');
Route::get('/subcategory/{subcategory}-{id}/new', 'ThreadsController@create')->name('thread_create');
Route::get('/thread/{title}-{id}', 'ThreadsController@show')->name('thread_show');

// Posts
Route::get('/thread/{title}-{thread-id}#post-{post-id}', 'PostsController@show')->name('post_show');
Route::post('/thread/{title}-{id}/store', 'PostsController@store')->name('post_store');
Route::get('/thread/{title}-{id}/new', 'PostsController@create')->name('post_create');
Route::delete('/post/{id}/delete', 'PostsController@destroy')->name('post_delete');
Route::put('/post/{id}/update', 'PostsController@update')->name('post_update');
Route::get('/post/{id}', 'PostsController@index')->name('post_permalink');
Route::get('/post/{id}/edit', 'PostsController@edit')->name('post_edit');

// Users
Route::get('/user/{id}', 'UsersController@show')->name('user_show');

// Search
Route::get('/search', 'SearchController@search')->name('search');

// Dashboard
Route::get('/dashboard/superadmin', 'DashboardController@superadmin')->name('dashboard_superadmin');
Route::get('/dashboard/account', 'DashboardController@account')->name('dashboard_account');
Route::get('/dashboard', 'UsersController@index')->name('dashboard');

// Custom logout path (also change LoginController)
//Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');