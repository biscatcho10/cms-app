<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', 'WelcomeController@index' );

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index')->name('home');

    Route::resource('/categories', 'CategoriesController');
    Route::resource('/posts', 'PostsController');
    Route::resource('/tags', 'TagController');

    // Trashed
    Route::get('trashed-posts','PostsController@trashed')->name('trashed.posts');
    Route::get('trashed-categories','CategoriesController@trashed')->name('trashed.categories');
    Route::get('trashed-tags','TagController@trashed')->name('trashed.tags');

    // Restore
    Route::get('restore-posts/{id}','PostsController@restore')->name('restore.posts');
    Route::get('restore-categories/{id}','CategoriesController@restore')->name('restore.categories');
    Route::get('restore-tags/{id}','TagController@restore')->name('restore.tags');
});


// For Admin only
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard.index');
    Route::resource('/users', 'UsersController');

    Route::post('/users/{user}/make-admin' , 'UsersController@makeAdmin')->name('users.make-admin');

    // Trashed
    Route::get('trashed-users','UsersController@trashed')->name('trashed.users');

    // Restore
    Route::get('restore-tags/{id}','UsersController@restore')->name('restore.users');
});


//
Route::group(['middleware' => ['auth']], function () {
    Route::get('users/{user}/profile', 'UsersController@edit' )->name('users.edit-profile');
    Route::post('users/{user}/profile', 'UsersController@update' )->name('users.update-profile');

});
