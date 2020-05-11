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

// Categories
Route::post('/category/{id}/restore', 'CategoriesController@restore')->name('category_restore');
Route::post('/category/{id}/delete', 'CategoriesController@destroy')->name('category_delete');
Route::get('/category/{id}/{slug}', 'CategoriesController@show')->name('category_show');
Route::post('/category/update', 'CategoriesController@update')->name('category_update');
Route::post('/category/store', 'CategoriesController@store')->name('category_store');

// Subcategories
Route::post('/subcategory/{id}/{slug}/store', 'SubcategoriesController@store')->name('subcategory_store');
Route::post('/subcategory/{id}/restore', 'SubcategoriesController@restore')->name('subcategory_restore');
Route::post('/category/{id}/{slug}/new', 'SubcategoriesController@create')->name('subcategory_create');
Route::post('/subcategory/{id}/delete', 'SubcategoriesController@destroy')->name('subcategory_delete');
Route::post('/subcategory/{id}/update', 'SubcategoriesController@update')->name('subcategory_update');
Route::get('/subcategory/{id}/{slug}', 'SubcategoriesController@show')->name('subcategory_show');

// Threads
Route::post('/subcategory/{id}/{slug}/thread/store', 'ThreadsController@store')->name('thread_store');
Route::get('/subcategory/{id}/{slug}/thread/new', 'ThreadsController@create')->name('thread_create');
Route::post('/thread/{id}/restore', 'ThreadsController@restore')->name('thread_restore');
Route::post('/thread/{id}/delete', 'ThreadsController@destroy')->name('thread_delete');
Route::get('/thread/{id}/{slug}', 'ThreadsController@show')->name('thread_show');
Route::post('/thread/update', 'ThreadsController@update')->name('thread_update');
Route::post('/thread/toggle', 'ThreadsController@toggle')->name('thread_toggle');

// Posts
Route::get('/thread/{id}/{slug}?page={page}#{post-id}', 'PostsController@show')->name('post_show');
Route::post('/thread/{id}/{slug}/store', 'PostsController@store')->name('post_store');
Route::post('/post/delete', 'PostsController@destroy_ajax')->name('post_delete_ajax');
Route::get('/thread/{id}/{slug}/new', 'PostsController@create')->name('post_create');
Route::post('/post/update', 'PostsController@update_ajax')->name('post_update_ajax');
Route::get('/post/{id}', 'PostsController@index')->name('post_permalink');

// Users
Route::get('/user/{id}/activity', 'UsersController@show_activity')->name('user_activity');
Route::post('/user/push-status', 'UsersController@push_status')->name('user_push_status');
Route::get('/user/{id}/messages', 'UsersController@show_messages')->name('user_messages');
Route::get('/user/{id}/threads', 'UsersController@show_threads')->name('user_threads');
Route::get('/user/{id}/posts', 'UsersController@show_posts')->name('user_posts');
Route::get('/user/{id}/likes', 'UsersController@show_likes')->name('user_likes');
Route::post('/user/{id}/update', 'UsersController@update')->name('user_update');
Route::post('/user/store', 'UsersController@store')->name('user_store');
Route::get('/user/{id}', 'UsersController@show')->name('user_show');

// Search
Route::get('/search', 'SearchController@search')->name('search');

// Dashboard
Route::post('/messages/{id}/restore', 'DashboardController@message_restore')->name('message_restore');
Route::post('/messages/{id}/delete', 'DashboardController@message_delete')->name('message_delete');
Route::put('/dashboard/update', 'AccountController@update')->name('dashboard_account_update');
Route::post('/messages/send', 'DashboardController@message_send')->name('message_send');
Route::get('/messages/new', 'DashboardController@message_create')->name('message_new');
Route::get('/messages/{id}', 'DashboardController@message')->name('dashboard_message');
Route::get('/messages', 'DashboardController@messages')->name('dashboard_messages');
Route::get('/dashboard', 'DashboardController@account')->name('dashboard_account');

// Tools
Route::post('/mark-as-read/{collection}/{id}', 'UserVisitedThreadsController@mark_as_read')->name('mark_as_read');
Route::post('/post/like', 'PostsController@like')->name('post_like');

// Chat messages
Route::post('/chat/{id}/restore', 'ChatMessagesController@restore')->name('chat_restore');
Route::post('/chat/update', 'ChatMessagesController@update')->name('chat_update');
Route::post('/chat/remove', 'ChatMessagesController@remove')->name('chat_remove');
Route::post('/chat/send', 'ChatMessagesController@send')->name('chat_send');

// Password reset
Route::post('/password-reset-request', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('/password-reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('/password-reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// Auth
Route::get('/admin-login', 'AuthController@admin_login_page')->name('admin_login_page');
Route::post('/admin-login', 'AuthController@admin_login')->name('admin_login');
Route::post('/register', 'AuthController@register')->name('register');
Route::get('/logout', 'AuthController@logout')->name('logout');
Route::post('/login', 'AuthController@login')->name('login');

// OAuth2 Github
Route::get('/login/github/callback', 'AuthController@handleProviderCallback')->name('login_github_callback');
Route::get('/login/github', 'AuthController@redirectToProvider')->name('login_github');

// Toolbar
Route::post('/toggle-maintenance-mode', 'ToolbarController@toggle_maintenance_mode')->name('toggle_maintenance_mode');
Route::post('/spoof-login', 'ToolbarController@spoof_login')->name('spoof_login');
Route::post('/user/{id}/suspend', 'UsersController@suspend')->name('user_suspend');
Route::post('/user/{id}/pardon', 'UsersController@pardon')->name('user_pardon');

// Garbage & Restores
Route::post('/post/{id}/restore', 'PostsController@restore')->name('post_restore');
Route::get('/garbage', 'GarbageController@show');