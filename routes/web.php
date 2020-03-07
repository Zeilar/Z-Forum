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

// Index
Route::get('/', 'TableCategoriesController@index')->name('index');

// Table categories
Route::get('/category/{id}-{slug}', 'TableCategoriesController@show')->name('tablecategory_show');
Route::post('/category/store', 'TableCategoriesController@store')->name('tablecategory_store');
Route::get('/category/new', 'TableCategoriesController@create')->name('tablecategory_create');

// Table subcategories
Route::delete('/subcategory/{id}-{slug}/destroy', 'TableSubcategoriesController@destroy')->name('tablesubcategory_delete');
Route::put('/subcategory/{id}-{slug}/update', 'TableSubcategoriesController@update')->name('tablesubcategory_update');
Route::post('/subcategory/{id}-{slug}/store', 'TableSubcategoriesController@store')->name('tablesubcategory_store');
Route::get('/subcategory/{id}-{slug}/new', 'TableSubcategoriesController@create')->name('tablesubcategory_create');
Route::get('/subcategory/{id}-{slug}/edit', 'TableSubcategoriesController@edit')->name('tablesubcategory_edit');
Route::get('/subcategory/{id}-{slug}', 'TableSubcategoriesController@show')->name('tablesubcategory_show');

// Threads
Route::post('/subcategory/{id}-{slug}/thread/store', 'ThreadsController@store')->name('thread_store');
Route::get('/subcategory/{id}-{slug}/thread/new', 'ThreadsController@create')->name('thread_create');
Route::delete('/thread/{id}-{slug}/delete', 'ThreadsController@destroy')->name('thread_delete');
Route::put('/thread/{id}-{slug}/update', 'ThreadsController@update')->name('thread_update');
Route::put('/thread/{id}-{slug}/unlock', 'ThreadsController@unlock')->name('thread_unlock');
Route::put('/thread/{id}-{slug}/lock', 'ThreadsController@lock')->name('thread_lock');
Route::get('/thread/{id}-{slug}/edit', 'ThreadsController@edit')->name('thread_edit');
Route::get('/thread/{id}-{slug}', 'ThreadsController@show')->name('thread_show');

// Posts
Route::get('/thread/{id}-{slug}#{post-id}', 'PostsController@show')->name('post_show'); // TODO: fixa så det funkar med pagination
Route::post('/thread/{id}-{slug}/store', 'PostsController@store')->name('post_store');
Route::get('/thread/{id}-{slug}/new', 'PostsController@create')->name('post_create');
Route::delete('/post/{id}/delete', 'PostsController@destroy')->name('post_delete');
Route::put('/post/{id}/update', 'PostsController@update')->name('post_update');
Route::get('/post/{id}', 'PostsController@index')->name('post_permalink');
Route::get('/post/{id}/edit', 'PostsController@edit')->name('post_edit');

// Users
Route::get('/user/{id}', 'UsersController@show')->name('user_show');

// Search
Route::get('/search', 'SearchController@search')->name('search');

// Dashboard
Route::put('/dashboard/account/update', 'AccountController@update')->name('dashboard_account_update');
Route::get('/dashboard/superadmin', 'DashboardController@superadmin')->name('dashboard_superadmin');
Route::get('/dashboard/account', 'DashboardController@account')->name('dashboard_account');
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

// Auth
Route::post('/register', 'AuthController@register')->name('register');
Route::get('/logout', 'AuthController@logout')->name('logout');
Route::post('/login', 'AuthController@login')->name('login');