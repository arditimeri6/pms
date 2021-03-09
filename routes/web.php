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

Route::get('login/facebook', 'Auth\LoginController@redirectToProvider');
Route::get('login/facebook/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('/', 'HomeController@index')->name('home');

Route::middleware(['auth'])->group(function(){

	Route::resource('companies', 'CompaniesController');

	Route::resource('projects', 'ProjectsController');
	Route::post('projects/adduser', 'ProjectsController@adduser')->name('projects.adduser');

	Route::resource('tasks', 'TasksController');
	Route::post('tasks/adduser', 'TasksController@adduser')->name('tasks.adduser');

	// Route::resource('roles', 'RolesController');

	Route::get('getUsers', 'UsersController@getUsers')->name('get.users');
	Route::resource('users', 'UsersController');

	Route::post('comments', 'CommentsController@store')->name('comments.store');

});
