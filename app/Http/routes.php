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
    Route::get('/get', 'BillsController@getBills');
    Route::get('/{billId}', 'BillsController@bill');
    Route::get('/{billId}/get', 'BillsController@getBill');
    Route::get('/{billId}/delete', 'BillsController@delete');
    Route::get('/{billId}/delete/{productId}/{code}/{billProductId}', 'BillsController@deleteProduct');
    Route::get('/{billId}/suggest-products', 'BillsController@suggestProducts');
    Route::post('/create', 'BillsController@create');
    Route::post('/{billId}/edit-page', 'BillsController@editPage');
    Route::post('/{billId}/edit-quantity', 'BillsController@editQuantity');
    Route::post('/{billId}/edit-price', 'BillsController@editPrice');
    Route::post('/{billId}/edit-discount', 'BillsController@editDiscount');
    Route::post('/{billId}/add', 'BillsController@addProduct');
});

Route::group(['prefix' => 'clients'], function() {
    Route::get('/', 'ClientsController@index');
    Route::get('/get', 'ClientsController@getClients');
    Route::post('/create', 'ClientsController@create');
    Route::get('/{clientId}', 'ClientsController@client');
    Route::get('/{clientId}/get', 'ClientsController@getClient');
    Route::get('/{clientId}/delete', 'ClientsController@delete');
    Route::post('/{clientId}/edit-name', 'ClientsController@editName');
    Route::post('/{clientId}/edit-phone', 'ClientsController@editPhone');
});

Route::group(['prefix' => 'products'], function() {
    Route::get('/', 'ProductsController@index');
    Route::get('/get', 'ProductsController@getProducts');
    Route::get('/create', 'ProductsController@create');
    Route::post('/{productId}/edit-name', 'ProductsController@editName');
});

Route::group(['prefix' => 'my-products'], function() {
    Route::get('/', 'MyProductsController@index');
    Route::get('/get', 'MyProductsController@getProducts');
    Route::get('/{productId}/delete', 'MyProductsController@deleteProduct');
    Route::get('/check/{code}', 'MyProductsController@checkProductCode');
    Route::post('/add', 'MyProductsController@addProduct');
});