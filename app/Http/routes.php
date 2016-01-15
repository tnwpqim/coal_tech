<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/
// AJAX routes do not work inside the web middleware
	Route::post('/ct_form', 'CTTestController@post_form');
	Route::post('/ct_reset', 'CTTestController@post_reset');
		
Route::group(['middleware' => ['web']], function () {
	
	Route::get('/ct_form', 'CTTestController@index');
	Route::get('/edit/{line_id}', 'CTTestController@getEdit');

});





