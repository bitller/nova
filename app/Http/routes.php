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

// Register page
Route::group(['namespace' => 'Auth', 'prefix' => 'register'], function() {
    Route::get('/', 'RegisterController@index');
    Route::post('/', 'RegisterController@register');
});

// Recover page
Route::group(['namespace' => 'Auth', 'prefix' => 'recover'], function() {
    Route::get('/', 'RecoverController@index');
    Route::get('/{userId}/{code}', 'RecoverController@check');
    Route::post('/', 'RecoverController@recover');
    Route::post('/{userId}/{code}', 'RecoverController@setNewPassword');
});

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

// Suggestions
Route::group(['prefix' => 'suggest'], function() {
    Route::get('clients', 'BillsController@suggestClients');
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

// Next page
Route::group(['prefix' => 'next'], function() {
    Route::get('/', 'NextController@index');
});

// Help center
Route::group(['prefix' => 'help-center'], function() {
    Route::get('/', 'HelpCenterController@index');
    Route::get('/get', 'HelpCenterController@get');
    Route::get('/get-question-categories', 'HelpCenterController@getQuestionCategories');
    Route::get('/category/{categoryId}', 'HelpCenterController@category');
    Route::get('/category/{categoryId}/get', 'HelpCenterController@getCategory');
    Route::post('/ask-question', 'HelpCenterController@askQuestion');
});

// Admin center
Route::group(['prefix' => 'admin-center', 'namespace' => 'AdminCenter'], function() {
    Route::get('/', 'UsersManagerController@index');
    Route::get('/users-manager', 'UsersManagerController@index');
    Route::get('/users-manager/get', 'UsersManagerController@get');
    Route::get('/users-manager/browse', 'UsersManagerController@browse');
    Route::get('/users-manager/get-users', 'UsersManagerController@getUsers');
    Route::get('/application-settings', 'ApplicationSettingsController@index');
    Route::get('/application-settings/get', 'ApplicationSettingsController@get');
    Route::get('/application-settings/allow-new-accounts', 'ApplicationSettingsController@allowCreationOfNewAccounts');
    Route::get('/application-settings/deny-new-accounts', 'ApplicationSettingsController@denyCreationOfNewAccounts');
    Route::post('/application-settings/edit-displayed-bills', 'ApplicationSettingsController@editNumberOfDisplayedBills');
    Route::post('/application-settings/edit-displayed-clients', 'ApplicationSettingsController@editNumberOfDisplayedClients');
    Route::post('/application-settings/edit-displayed-products', 'ApplicationSettingsController@editNumberOfDisplayedProducts');
    Route::post('/application-settings/edit-displayed-custom-products', 'ApplicationSettingsController@editNumberOfDisplayedCustomProducts');
    Route::post('/application-settings/edit-recover-code-valid-time', 'ApplicationSettingsController@editRecoverCodeValidTime');
    Route::post('/application-settings/edit-number-of-login-attempts-allowed', 'ApplicationSettingsController@editNumberOfLoginAttemptsAllowed');

    // Help center manager
    Route::group(['prefix' => 'help-center-manager'], function() {
        Route::get('/', 'HelpCenterManagerController@index');
        Route::get('/get', 'HelpCenterManagerController@get');
        Route::get('/category/{categoryId}', 'HelpCenterManagerController@category');
        Route::get('/category/{categoryId}/get', 'HelpCenterManagerController@getCategory');
        Route::post('/add-category', 'HelpCenterManagerController@addCategory');
        Route::post('/delete-category', 'HelpCenterManagerController@deleteCategory');
        Route::post('/edit-category', 'HelpCenterManagerController@editCategory');
        Route::post('/category/{categoryId}/add-article', 'HelpCenterManagerController@addArticle');
        Route::post('/category/{categoryId}/delete-article', 'HelpCenterManagerController@deleteArticle');
        Route::post('/category/{categoryId}/edit-article', 'HelpCenterManagerController@editArticle');
    });

    // Support center manager
    Route::group(['prefix' => 'support-center'], function() {
        Route::get('/', 'SupportCenterController@index');
        Route::get('/get', 'SupportCenterController@get');
    });

});

// Subscribe page
Route::group(['prefix' => 'subscribe'], function() {
    Route::get('/', 'SubscribeController@index');
    Route::post('/process', 'SubscribeController@process');
});