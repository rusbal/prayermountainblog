<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'BlogController@index');

Auth::routes();

Route::get('/home', 'HomeController@index');

/**
 * Names
 */
Route::get('/names',     'NameController@index')->name('names');
Route::get('/names/new', 'NameController@create');
Route::post('/names',    'NameController@store');

// Sort
Route::post('ajax/names/status/{name}', 'NameController@setStatus');
Route::post('ajax/names/sort', 'NameSortController');

/**
 * Revision
 */
Route::get('/names/{name}/revisions', 'RevisionController@index');
Route::get('/names/{name}/revisions/{revision}', 'RevisionController@edit')->name('revision');
Route::patch('/names/{name}/revisions/{revision}', 'RevisionController@update');
Route::delete('/names/{name}/revisions/{revision}', 'RevisionController@destroy');

Route::get('/names/{name}/author/{author}', 'RevisionController@editAuthorRevision')->name('latest-author-revision');

/**
 * Comment
 */
Route::post('ajax/{name}/comments', 'CommentController@create');
Route::delete('ajax/comments/{comment}', 'CommentController@destroy');

/**
 * MS Word Download
 */
Route::get('docs', 'WordController@index');
Route::post('docs/create', 'WordDocGenerator');

/**
 * Admin
 */
Route::group(['namespace' => 'Auth'], function() {
    Route::get('password/change', 'ChangePasswordController@edit');
    Route::post('password/change', 'ChangePasswordController@store');
});

/**
 * Admin
 */
Route::group(['namespace' => 'Admin'], function() {
    Route::get('admin/{admin}', 'AdminController@index')->name('admin-profile');
    Route::patch('admin/{admin}', 'AdminController@update');
});

/**
 * Test Email
 */
Route::get('/raymond/mail', 'RaymondMailController@mail');

// Route::get('/raymond/notify', function() {
//     Event::listen(Illuminate\Notifications\Events\NotificationSent::class, function($event) { info($event->notifiable->email); });
//     $user = \App\User::find(1);
//     $user->notify(new \App\Notifications\RayNotification());
// });

