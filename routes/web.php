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
Route::get('/', 'CategoriesController@index')->name('index');

// Table categories
Route::get('/category/{id}-{slug}', 'CategoriesController@show')->name('category_show');
Route::post('/category/store', 'CategoriesController@store')->name('category_store');
Route::get('/category/new', 'CategoriesController@create')->name('category_create');

// Table subcategories
Route::delete('/subcategory/{id}-{slug}/destroy', 'SubcategoriesController@destroy')->name('subcategory_delete');
Route::put('/subcategory/{id}-{slug}/update', 'SubcategoriesController@update')->name('subcategory_update');
Route::post('/subcategory/{id}-{slug}/store', 'SubcategoriesController@store')->name('subcategory_store');
Route::post('/category/{id}-{slug}/new', 'SubcategoriesController@create')->name('subcategory_create');
Route::get('/subcategory/{id}-{slug}/edit', 'SubcategoriesController@edit')->name('subcategory_edit');
Route::get('/subcategory/{id}-{slug}', 'SubcategoriesController@show')->name('subcategory_show');

// Threads
Route::post('/subcategory/{id}-{slug}/thread/store', 'ThreadsController@store')->name('thread_store');
Route::get('/subcategory/{id}-{slug}/thread/new', 'ThreadsController@create')->name('thread_create');
Route::delete('/thread/{id}-{slug}/delete', 'ThreadsController@destroy')->name('thread_delete');
Route::put('/thread/{id}-{slug}/update', 'ThreadsController@update')->name('thread_update');
Route::get('/thread/{id}-{slug}/edit', 'ThreadsController@edit')->name('thread_edit');
Route::post('/thread/toggle', 'ThreadsController@toggle')->name('thread_toggle');
Route::get('/thread/{id}-{slug}', 'ThreadsController@show')->name('thread_show');

// Posts
Route::post('/post/update_ajax', 'PostsController@update_ajax')->name('post_update_ajax');
Route::get('/thread/{id}-{slug}#{post-id}', 'PostsController@show')->name('post_show'); // TODO: fixa så det funkar med pagination
Route::post('/post/delete', 'PostsController@destroy_ajax')->name('post_delete_ajax');
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