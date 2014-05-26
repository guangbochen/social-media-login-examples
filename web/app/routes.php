<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/* Route::resource('/', 'HomeController'); */
Route::get('/', 'HomeController@index');
Route::get('logout', 'HomeController@logout');
Route::get('dashboard', 'HomeController@getDashboard');

// APIS controller
Route::group(array('prefix' => 'api'), function() {
  Route::post('signin/fb', 'api\FacebookApisController@signInWithFacebook');
});
