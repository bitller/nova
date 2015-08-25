<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

Route::get('/login', 'Auth\LoginController@index');
Route::post('/login', 'Auth\LoginController@login');

Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/register', 'Auth\RegisterController@index');

Route::get('/recover', 'Auth\RecoverController@index');

Route::group(['prefix' => 'bills'], function() {
    Route::get('/', 'BillsController@index');
    Route::get('/delete/{billId}', 'BillsController@delete');
    Route::post('/create', 'BillsController@create');
});

Route::group(['prefix' => 'ajax'], function() {
    Route::get('get-bills',  'BillsController@getBills');
});