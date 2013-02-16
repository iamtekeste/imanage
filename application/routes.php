<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Simply tell Laravel the HTTP verbs and URIs it should respond to. It is a
| breeze to setup your application using Laravel's RESTful routing and it
| is perfectly suited for building large applications and simple APIs.
|
| Let's respond to a simple GET request to http://example.com/hello:
|
|		Route::get('hello', function()
|		{
|			return 'Hello World!';
|		});
|
| You can even respond to more than one URI:
|
|		Route::post(array('hello', 'world'), function()
|		{
|			return 'Hello World!';
|		});
|
| It's easy to allow URI wildcards using (:num) or (:any):
|
|		Route::put('hello/(:any)', function($name)
|		{
|			return "Welcome, $name.";
|		});
|
*/// user Resource
Route::get('users', array('as' => 'users', 'before'=>'auth','uses' => 'users@index'));
Route::get('users/new/(:num)', array('as'=>'add_new_user', 'uses'=>'users@new'));
Route::get('users/new', array('as' => 'new_user', 'uses' => 'users@new'));
Route::get('users/(:any)', array('as' => 'user', 'uses' => 'users@show'));
Route::get('users/(:any)/edit', array('as' => 'edit_user', 'uses' => 'users@edit'));
Route::put('users/update', 'users@update');
Route::get('users/(:any)/delete', 'projects@destroy');

// job Resource
Route::get('jobs', array('as' => 'jobs', 'uses' => 'jobs@index'));
Route::get('jobs/new/(:num)', array('as'=>'new_job', 'uses'=>'jobs@new'));
Route::get('jobs/(:num)', array('as' => 'job', 'uses' => 'jobs@show'));
Route::get('jobs/(:any)/edit', array('as' => 'edit_job', 'uses' => 'jobs@edit'));
Route::post('jobs', 'jobs@create');
Route::put('jobs/update', 'jobs@update');
Route::delete('jobs/(:any)', 'jobs@destroy');


//Registering Routes
Route::get('register', array('as' => 'new_user', 'uses' => 'users@new'));
Route::post('register', array('before'=>'csrf', 'uses' => 'users@create'));

//Logining in Routes
Route::get('login', array('as' => 'login', 'uses' => 'users@login'));
Route::post('login', array('before'=>'csrf','uses'=>'users@login'));

//Logout
Route::get('logout', array('as' => 'logout', 'uses' => 'users@logout'));


// project Resource
Route::get('projects', array('as' => 'projects','before'=>'auth', 'uses' => 'projects@index'));
Route::get('projects/(:any)', array('as' => 'project', 'uses' => 'projects@show'));
Route::get('projects/new', array('as' => 'new_project', 'uses' => 'projects@new'));
Route::get('projects/(:any)/edit', array('as' => 'edit_project', 'uses' => 'projects@edit'));
Route::post('projects', 'projects@create');
Route::put('projects/update', 'projects@update');
Route::get('projects/(:any)/delete', 'projects@destroy');


//Home Routes
Route::get('/',array('as'=>'home', 'uses'=>'home@index'));


//Authenticate
Route::filter('pattern: users/*', 'auth');
Route::filter('pattern: projects/*', 'auth');
Route::filter('pattern: jobs/*', 'auth');
Route::filter('pattern: /*', 'auth');
/*
|--------------------------------------------------------------------------
| Application 404 & 500 Error Handlers
|--------------------------------------------------------------------------
|
| To centralize and simplify 404 handling, Laravel uses an awesome event
| system to retrieve the response. Feel free to modify this function to
| your tastes and the needs of your application.
|
| Similarly, we use an event to handle the display of 500 level errors
| within the application. These errors are fired when there is an
| uncaught exception thrown in the application.
|
*/

Event::listen('404', function()
{
	return Response::error('404');
});

Event::listen('500', function()
{
	return Response::error('500');
});

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
|
| Filters provide a convenient method for attaching functionality to your
| routes. The built-in before and after filters are called before and
| after every request to your application, and you may even create
| other filters that can be attached to individual routes.
|
| Let's walk through an example...
|
| First, define a filter:
|
|		Route::filter('filter', function()
|		{
|			return 'Filtered!';
|		});
|
| Next, attach the filter to a route:
|
|		Router::register('GET /', array('before' => 'filter', function()
|		{
|			return 'Hello World!';
|		}));
|
*/

Route::filter('before', function()
{
	// Do stuff before every request to your application...
});

Route::filter('after', function($response)
{
	// Do stuff after every request to your application...
});

Route::filter('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::to('login');
});