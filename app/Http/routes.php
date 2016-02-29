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
Route::group(['prefix' => 'bills', 'namespace' => 'Bills'], function() {

    // Bills page
    get('/', 'IndexController@index');
    get('/get', 'IndexController@get');
    get('/get/search', 'IndexController@search');
    post('/create', 'IndexController@create');

    // Bill page
    get('/{billId}', 'BillController@index');
    get('/{billId}/get', 'BillController@get');
    get('/{billId}/delete', 'BillController@delete');
    get('/{billId}/delete/{productId}/{code}/{billProductId}', 'BillController@deleteProduct');
    get('/{billId}/suggest-products', 'BillController@suggestProducts');
    get('/{billId}/mark-as-paid', 'BillController@markAsPaid');
    get('/{billId}/mark-as-unpaid', 'BillController@markAsUnpaid');
    post('/{billId}/edit-page', 'BillController@editPage');
    post('/{billId}/edit-quantity', 'BillController@editQuantity');
    post('/{billId}/edit-price', 'BillController@editPrice');
    post('/{billId}/edit-discount', 'BillController@editDiscount');
    post('/{billId}/add', 'BillController@addProduct');
    post('/{billId}/add-not-existent-product', 'BillController@addNotExistentProduct');
    post('/{billId}/edit-other-details', 'BillController@editOtherDetails');
    post('/{billId}/edit-payment-term', 'BillController@editPaymentTerm');

//    Route::get('/{billId}/delete-bill', 'BillsController@deleteBill');

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
    Route::post('/{clientId}/edit-email', 'ClientsController@editEmail');

    // Paginate paid bills of given client
    Route::get('/{clientId}/bills/paid', 'ClientsController@paidBillsOfThisClient');
    Route::get('/{clientId}/bills/paid/get', 'ClientsController@getPaidBillsOfThisClient');

    // Paginate unpaid bills of give client
    Route::get('/{clientId}/bills/unpaid', 'ClientsController@unpaidBillsOfThisClient');
    Route::get('/{clientId}/bills/unpaid/get', 'ClientsController@getUnpaidBillsOfThisClient');
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

    // Campaign statistics
    Route::get('/campaign/{campaignNumber}/{campaignYear}', 'StatisticsController@campaign');
    Route::get('/campaign/{campaignNumber}/{campaignYear}/get', 'StatisticsController@getCampaignStatistics');
    Route::get('/campaign/{campaignNumber}/{campaignYear}/compare-with/{otherCampaignNumber}/{otherCampaignYear}', 'StatisticsController@compareCampaigns');
    Route::get('/campaign/{campaignNumber}/{campaignYear}/compare-with/{otherCampaignNumber}/{otherCampaignYear}/get', 'StatisticsController@getCompareCampaignsData');

    Route::get('/campaign/get-all-years', 'StatisticsController@getCampaignsYears');
    Route::post('/campaign/get-numbers', 'StatisticsController@getCampaignNumbers');
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

// Subscription events listener
Route::post('/subscription-events', 'SubscriptionEventsController@index');

// Admin center
Route::group(['prefix' => 'admin-center', 'namespace' => 'AdminCenter'], function() {

    Route::get('/', 'UsersManagerController@index');

    // Users manager
    Route::group(['prefix' => 'users-manager'], function() {
        Route::get('/', 'UsersManagerController@index');
        Route::get('/get', 'UsersManagerController@get');
        Route::get('/browse', 'UsersManagerController@browse');
        Route::get('/get-users', 'UsersManagerController@getUsers');
        Route::get('/search', 'UsersManagerController@search');
        Route::post('/create-new-user', 'UsersManagerController@createNewUser');

        // Manage user
        Route::group(['prefix' => 'user'], function() {
            Route::get('/{userId}', 'UsersManagerController@user');
            Route::get('/{userId}/get', 'UsersManagerController@getUserBills');
            Route::get('/{userId}/get-user-data', 'UsersManagerController@getUserData');
            Route::get('/{userId}/get-paid-bills', 'UsersManagerController@getUserPaidBills');
            Route::post('{userId}/delete-bill', 'UsersManagerController@deleteUserBill');
            Route::post('/{userId}/delete-all-bills', 'UsersManagerController@deleteAllUserBills');
            Route::post('/{userId}/delete-unpaid-bills', 'UsersManagerController@deleteUserUnpaidBills');
            Route::post('/{userId}/delete-paid-bills', 'UsersManagerController@deleteUserPaidBills');
            Route::post('/{userId}/make-bill-paid', 'UsersManagerController@makeUserBillPaid');
            Route::post('/{userId}/make-bill-unpaid', 'UsersManagerController@makeUserBillUnpaid');
            Route::post('/{userId}/make-all-bills-paid', 'UsersManagerController@makeAllUserBillsPaid');
            Route::post('/{userId}/make-all-bills-unpaid', 'UsersManagerController@makeAllUserBillsUnpaid');
            Route::post('/{userId}/disable-account', 'UsersManagerController@disableUserAccount');
            Route::post('/{userId}/enable-account', 'UsersManagerController@enableUserAccount');
            Route::post('/{userId}/delete-account', 'UsersManagerController@deleteUserAccount');
            Route::post('/{userId}/edit-email', 'UsersManagerController@editUserEmail');
            Route::post('/{userId}/change-password', 'UsersManagerController@changeUserPassword');

            // User clients
            Route::get('/{userId}/get-clients', 'UsersManagerController@getUserClients');
            Route::post('/{userId}/delete-clients', 'UsersManagerController@deleteUserClients');
            Route::post('/{userId}/delete-client', 'UsersManagerController@deleteUserClient');

            // User custom products
            Route::get('/{userId}/get-custom-products', 'UsersManagerController@getUserCustomProducts');
            Route::post('/{userId}/delete-custom-product', 'UsersManagerController@deleteUserCustomProduct');
            Route::post('/{userId}/delete-custom-products', 'UsersManagerController@deleteUserCustomProducts');

            // User actions
            Route::get('/{userId}/get-actions/{type}', 'UsersManagerController@getUserActions');
            Route::post('/{userId}/delete-actions/{type}', 'UsersManagerController@deleteUserActions');
        });
    });

    // Notifications manager
    Route::group(['namespace' => 'Notifications', 'prefix' => 'notifications'], function() {

        Route::get('/', 'NotificationsController@index');
        Route::get('/types', 'NotificationsController@types');
        Route::get('/last', 'NotificationsController@getLast');
        Route::get('/all', 'NotificationsController@getAll');
        Route::get('/targeted-users', 'NotificationsController@getTargetedUsers');

        Route::post('/new', 'NotificationsController@create');
        Route::post('/edit-title', 'NotificationsController@editTitle');
        Route::post('/edit-message', 'NotificationsController@editMessage');
        Route::post('/delete', 'NotificationsController@delete');
        Route::post('/delete-all', 'NotificationsController@deleteAll');
        Route::post('/set-targeted-users', 'NotificationsController@setTargetedUsers');
    });

    // Subscriptions section
    Route::group(['prefix' => 'subscriptions', 'namespace' => 'Subscriptions'], function() {

        // Subscriptions
        Route::get('/', 'SubscriptionsController@index');
        Route::get('/index', 'SubscriptionController@index');
        Route::get('/get/{status}', 'SubscriptionsController@get');

        // Offers
        Route::group(['prefix' => 'offers'], function() {
            Route::get('/', 'OffersController@index');
            Route::get('/get', 'OffersController@get');
            Route::post('/create', 'OffersController@create');

            Route::get('/{offerId}', 'OffersController@offer');
            Route::get('/{offerId}/get', 'OffersController@getOne');
            Route::post('/{offerId}/edit-name', 'OffersController@editOfferName');
            Route::post('/{offerId}/edit-amount', 'OffersController@editOfferAmount');
            Route::post('/{offerId}/edit-promo-code', 'OffersController@editOfferPromoCode');
            Route::post('/{offerId}/use-on-sign-up', 'OffersController@useOfferOnSignUp');
            Route::post('/{offerId}/enable', 'OffersController@enableOffer');
            Route::post('/{offerId}/disable', 'OffersController@disableOffer');
        });

    });

    // Application settings
    Route::group(['prefix' => 'application-settings'], function() {
        Route::get('/', 'ApplicationSettingsController@index');
        Route::get('/get', 'ApplicationSettingsController@get');
        Route::get('/allow-new-accounts', 'ApplicationSettingsController@allowCreationOfNewAccounts');
        Route::get('/deny-new-accounts', 'ApplicationSettingsController@denyCreationOfNewAccounts');
        Route::get('/edit-displayed-bills', 'ApplicationSettingsController@editNumberOfDisplayedBills');
        Route::get('/edit-displayed-clients', 'ApplicationSettingsController@editNumberOfDisplayedClients');
        Route::get('/edit-displayed-products', 'ApplicationSettingsController@editNumberOfDisplayedProducts');
        Route::get('/edit-displayed-custom-products', 'ApplicationSettingsController@editNumberOfDisplayedCustomProducts');
        Route::get('/edit-recover-code-valid-time', 'ApplicationSettingsController@editRecoverCodeValidTime');
        Route::get('/edit-number-of-login-attempts-allowed', 'ApplicationSettingsController@editNumberOfLoginAttemptsAllowed');
        Route::get('/allow-users-to-change-language', 'ApplicationSettingsController@allowUsersToChangeLanguage');
        Route::get('/deny-users-to-change-language', 'ApplicationSettingsController@denyUsersToChangeLanguage');
    });

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

    // Products manager
    Route::group(['prefix' => 'products-manager', 'namespace' => 'ProductsManager'], function() {
        get('/', 'IndexController@index');
        get('/get', 'IndexController@get');
    });

});

// Subscribe page
Route::group(['prefix' => 'subscribe'], function() {
    Route::get('/', 'SubscribeController@index');
    Route::post('/process', 'SubscribeController@process');
});

// Notifications page
Route::group(['prefix' => 'notifications'], function() {
    Route::get('/', 'NotificationsController@getUnreadNotifications');
    Route::get('/mark-notifications-as-read', 'NotificationsController@markNotificationsAsRead');
});