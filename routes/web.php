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

// Subcategories
Route::get('/category/{subcategory}-{id}', 'TableSubcategoriesController@show');

// Posts
Route::post('/thread/{title}-{id}/create', 'PostsController@store');
Route::get('/thread/{title}-{id}/new', 'PostsController@create');
Route::get('/post/{id}', 'PostsController@show');

// Threads
Route::post('/category/{subcategory}-{id}/create', 'ThreadsController@store');
Route::get('/category/{subcategory}-{id}/new', 'ThreadsController@create');
Route::get('/thread/{title}-{id}', 'ThreadsController@show');

// Users
Route::get('/user/{id}', 'UsersController@show');