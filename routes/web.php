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
Route::get('/category/{category-{id}}', 'TableCategoriesController@show');

// Table subcategories
Route::get('/subcategory/{subcategory}-{id}', 'TableSubcategoriesController@show');

// Threads
Route::post('/subcategory/{subcategory}-{id}/create', 'ThreadsController@store');
Route::get('/subcategory/{subcategory}-{id}/new', 'ThreadsController@create');
Route::get('/thread/{title}-{id}', 'ThreadsController@show');

// Posts
Route::post('/thread/{title}-{id}/create', 'PostsController@store');
Route::get('/thread/{title}-{id}/new', 'PostsController@create');
Route::get('/post/{id}', 'PostsController@show');

// Users
Route::get('/user/{id}', 'UsersController@show');