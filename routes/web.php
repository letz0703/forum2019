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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/register/confirm', 'Auth\RegistrationConfirmationController@index')->name('register.confirm');

Route::get('/threads/', 'ThreadController@index')->name('threads')->name('threads');
Route::get('/threads/create', 'ThreadController@create')->middleware('email-confirmation');
Route::patch('/threads/{channel}/{thread}', 'ThreadController@update')->name('threads.update');
Route::post('/threads', 'ThreadController@store')->middleware('email-confirmation');
Route::post('/locked-threads/{thread}', 'LockedThreadController@store')
     ->name('locked-thread.store')->middleware('admin');
Route::delete('/locked-threads/{thread}', 'LockedThreadController@destroy')
     ->name('locked-thread.destroy')->middleware('admin');
Route::post('/pinned-threads/{thread}', 'PinnedThreadController@store')
     ->name('pinned-thread.store')->middleware('admin');
Route::delete('/pinned-threads/{thread}', 'PinnedThreadController@destroy')
     ->name('pinned-thread.destroy')->middleware('admin');
Route::get('/threads/{channel}', 'ThreadController@index');
Route::get('/threads/{channel}/{thread}', 'ThreadController@show');
//Route::patch('/threads/{channel}/{thread}', 'ThreadController@update')
//     ->name('thread.update');

Route::post('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionController@store');
Route::delete('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionController@destroy');

Route::get('/threads/{channel}/{thread}/replies', 'ReplyController@index');
Route::delete('/threads/{channel}/{thread}', 'ThreadController@destroy');
Route::post('/threads/{channel}/{thread}/replies', 'ReplyController@store');

Route::post('/replies/{reply}/favorites', 'FavoriteController@store');
Route::delete('/replies/{reply}/favorites', 'FavoriteController@destroy');
Route::delete('/replies/{reply}', 'ReplyController@destroy')->name('reply.destroy');
Route::patch('/replies/{reply}', 'ReplyController@update');
Route::post('/replies/{reply}/best', 'BestReplyController@store')
     ->name('best-replies.store');

Route::get('/profiles/{user}', 'ProfileController@show')->name('profile');
Route::get('/profiles/{user}/notifications', 'NotificationController@index');
Route::delete('/profiles/{user}/notifications/{notification}', 'NotificationController@destroy');

Route::get('/api/users', 'Api\UserController@index');
Route::get('/api/channels', 'Api\ChannelController@index')->name('api.channels.index');
Route::post('/api/users/{user}/avatar', 'Api\UserAvatarController@store')
     ->middleware('auth')
     ->name('avatar');

Route::group([
    'prefix'     => 'admin',
    'middleware' => 'admin',
    'namespace'  => 'Admin',
], function () {
    Route::get('/', 'DashboardController@index')
         ->name('admin.dashboard.index');
    Route::post('/channels', 'ChannelController@store')
         ->name('admin.channels.store');
    Route::get('/channels', 'ChannelController@index')
         ->name('admin.channels.index');
    Route::get('/channels/create', 'ChannelController@create')
         ->name('admin.channels.create');
    Route::get('/channels/{channel}/edit', 'ChannelController@edit')
         ->name('admin.channels.edit');
    Route::patch('/channels/{channel}', 'ChannelController@update')
         ->name('admin.channels.update');
});
