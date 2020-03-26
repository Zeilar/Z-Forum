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

// Table subcategories
Route::post('/subcategory/{id}-{slug}/store', 'SubcategoriesController@store')->name('subcategory_store');
Route::post('/category/{id}-{slug}/new', 'SubcategoriesController@create')->name('subcategory_create');
Route::get('/subcategory/{id}-{slug}', 'SubcategoriesController@show')->name('subcategory_show');

// Threads
Route::post('/subcategory/{id}-{slug}/thread/store', 'ThreadsController@store')->name('thread_store');
Route::get('/subcategory/{id}-{slug}/thread/new', 'ThreadsController@create')->name('thread_create');
Route::post('/thread/delete', 'ThreadsController@destroy_ajax')->name('thread_delete_ajax');
Route::post('/thread/update', 'ThreadsController@update_ajax')->name('thread_update_ajax');
Route::get('/thread/{id}-{slug}', 'ThreadsController@show')->name('thread_show');
Route::post('/thread/toggle', 'ThreadsController@toggle')->name('thread_toggle');

// Posts
Route::get('/thread/{id}-{slug}?page={page}#{post-id}', 'PostsController@show')->name('post_show');
Route::post('/post/delete', 'PostsController@destroy_ajax')->name('post_delete_ajax');
Route::post('/thread/{id}-{slug}/store', 'PostsController@store')->name('post_store');
Route::get('/thread/{id}-{slug}/new', 'PostsController@create')->name('post_create');
Route::post('/post/update', 'PostsController@update_ajax')->name('post_update_ajax');
Route::get('/post/{id}', 'PostsController@index')->name('post_permalink');

// Users
Route::post('/user/push_status', 'UsersController@push_status')->name('user_push_status');
Route::get('/user/{id}', 'UsersController@show')->name('user_show');

// Search
Route::get('/search', 'SearchController@search')->name('search');

// Dashboard
Route::put('/dashboard/account/update', 'AccountController@update')->name('dashboard_account_update');
Route::get('/dashboard/superadmin', 'DashboardController@superadmin')->name('dashboard_superadmin');
Route::get('/dashboard/account', 'DashboardController@account')->name('dashboard_account');

// Auth
Route::get('/login', 'AuthController@backup_login')->name('backup_login');
Route::post('/register', 'AuthController@register')->name('register');
Route::get('/logout', 'AuthController@logout')->name('logout');
Route::post('/login', 'AuthController@login')->name('login');

// Toolbar
Route::post('/toggle_maintenance_mode', 'ToolbarController@toggle_maintenance_mode')->name('toggle_maintenance_mode');
Route::post('/spoof_login', 'ToolbarController@spoof_login')->name('spoof_login');