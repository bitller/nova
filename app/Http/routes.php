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

// Bills page
Route::group(['prefix' => 'bills'], function() {
    Route::get('/', 'BillsController@index');
    Route::get('/get', 'BillsController@getBills');
    Route::get('/{billId}', 'BillsController@bill');
    Route::get('/{billId}/get', 'BillsController@getBill');
    Route::get('/{billId}/delete', 'BillsController@delete');
    Route::get('/{billId}/delete/{productId}/{code}/{billProductId}', 'BillsController@deleteProduct');
    Route::get('/{billId}/suggest-products', 'BillsController@suggestProducts');
    Route::get('/{billId}/delete-bill', 'BillsController@deleteBill');
    Route::get('/{billId}/mark-as-paid', 'BillsController@markAsPaid');
    Route::get('/{billId}/mark-as-unpaid', 'BillsController@markAsUnpaid');
    Route::post('/create', 'BillsController@create');
    Route::post('/{billId}/edit-page', 'BillsController@editPage');
    Route::post('/{billId}/edit-quantity', 'BillsController@editQuantity');
    Route::post('/{billId}/edit-price', 'BillsController@editPrice');
    Route::post('/{billId}/edit-discount', 'BillsController@editDiscount');
    Route::post('/{billId}/add', 'BillsController@addProduct');
    Route::post('/{billId}/edit-other-details', 'BillsController@editOtherDetails');
    Route::post('/{billId}/edit-payment-term', 'BillsController@editPaymentTerm');
});

// Clients page
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

// Products page
Route::group(['prefix' => 'products'], function() {
    Route::get('/', 'ProductsController@index');
    Route::get('/get', 'ProductsController@getProducts');
    Route::get('/create', 'ProductsController@create');
    Route::post('/{productId}/edit-name', 'ProductsController@editName');
});

// My products page
Route::group(['prefix' => 'my-products'], function() {
    Route::get('/', 'MyProductsController@index');
    Route::get('/get', 'MyProductsController@getProducts');
    Route::get('/{productId}/delete', 'MyProductsController@deleteProduct');
    Route::get('/check/{code}', 'MyProductsController@checkProductCode');
    Route::post('/add', 'MyProductsController@addProduct');
});

// Statistics page
Route::group(['prefix' => 'statistics'], function() {
    Route::get('/', 'StatisticsController@index');
    Route::get('/get', 'StatisticsController@get');
});

// Settings page
Route::group(['prefix' => 'settings'], function() {
    Route::get('/', 'SettingsController@index');
    Route::get('/get', 'SettingsController@get');
    Route::get('/get-languages', 'SettingsController@getLanguages');
    Route::get('/reset-to-default-values', 'SettingsController@resetToDefaultValues');
    Route::post('/edit-email', 'SettingsController@editEmail');
    Route::post('/edit-password', 'SettingsController@editPassword');
    Route::post('/edit-number-of-displayed-bills', 'SettingsController@editNumberOfDisplayedBills');
    Route::post('/edit-number-of-displayed-clients', 'SettingsController@editNumberOfDisplayedClients');
    Route::post('/edit-number-of-displayed-products', 'SettingsController@editNumberOfDisplayedProducts');
    Route::post('/edit-number-of-displayed-custom-products', 'SettingsController@editNumberOfDisplayedCustomProducts');
    Route::post('/change-language', 'SettingsController@changeLanguage');
});

// Search results
Route::group(['prefix' => 'search'], function() {
    Route::get('/header', 'SearchController@headerSearch');
});

// Product details
Route::group(['prefix' => 'product-details'], function() {
    Route::get('/{productCode}', 'ProductDetailsController@index');
    Route::get('/{productCode}/get', 'ProductDetailsController@get');
    Route::post('/{productCode}/edit-name', 'ProductDetailsController@editName');
    Route::post('/{productCode}/edit-code', 'ProductDetailsController@editCode');
    Route::post('/{productCode}/delete', 'ProductDetailsController@delete');
});

// Paid bills
Route::group(['prefix' => 'paid-bills'], function() {
    Route::get('/', 'PaidBillsController@index');
    Route::get('/get', 'PaidBillsController@get');
});

// About page
Route::group(['prefix' => 'about'], function() {
    Route::get('/', 'AboutController@index');
});