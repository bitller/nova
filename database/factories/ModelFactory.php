<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

// Generate a normal user
use App\Helpers\Products;

$factory->define(App\User::class, function ($faker) {

    $roleHelper = new \App\Helpers\Roles();

    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'password' => bcrypt('123456'),
        'remember_token' => str_random(10),
        'role_id' => $roleHelper->getUserRoleId()
    ];
});

// Generate an administrator user
$factory->defineAs(App\User::class, 'admin', function($faker) use ($factory) {

    $roleHelper = new \App\Helpers\Roles();
    $user = $factory->raw(App\User::class);

    return array_merge($user, ['role_id' => $roleHelper->getAdminRoleId()]);

});

// Generate an moderator user
$factory->defineAs(App\User::class, 'moderator', function($faker) use ($factory) {

    $roleHelper = new \App\Helpers\Roles();
    $user = $factory->raw(App\User::class);

    return array_merge($user, ['role_id' => $roleHelper->getModeratorRoleId()]);

});

// Generate a client
$factory->define(App\Client::class, function($faker) {

    return [
        'name' => $faker->name,
        'phone_number' => $faker->phoneNumber
    ];

});

// Generate a bill
$factory->define(App\Bill::class, function($faker) {
    return [
        'campaign_order' => rand(1, 6),
        'campaign_number' => rand(1, 13),
        'campaign_year' => date('Y'),
        'payment_term' => date('Y-m-d'),
        'other_details' => $faker->paragraph()
    ];
});

// Generate paid bill
$factory->defineAs(App\Bill::class, 'paid', function($faker) use ($factory) {
    $bill = $factory->raw(App\Bill::class);
    return array_merge($bill, ['paid' => 1]);
});

// Generate product
$factory->define(App\Product::class, function($faker) {

    return [
        'name' => $faker->name,
        'code' => (string) $faker->numberBetween(10000, 99999)
    ];

});

// Generate application product
$factory->define(App\ApplicationProduct::class, function() use ($factory) {

    return $factory->raw(App\Product::class);

});

// Generate bill product
$factory->define(App\BillProduct::class, function() use ($factory) {

    $page = rand(1, 999);
    $quantity = rand(1, 99);
    $price = rand(1, 200) * $quantity;
    $discount = rand(0, 100);
    $calculatedDiscount = Products::discount($price, $discount);
    $finalPrice = $price - $calculatedDiscount;

    return [
        'page' => $page,
        'quantity' => $quantity,
        'price' => $price,
        'discount' => $discount,
        'calculated_discount' =>$calculatedDiscount,
        'final_price' =>$finalPrice
    ];

});

$factory->define(App\BillApplicationProduct::class, function() use ($factory) {

    return $factory->raw(App\BillProduct::class);

});

$factory->define(App\UserSetting::class, function() {

    return [
        'displayed_bills' => rand(1, 20),
        'displayed_clients' => rand(1, 20),
        'displayed_products' => rand(1, 20),
        'displayed_custom_products' => rand(1, 20),
    ];

});

$factory->define(App\Language::class, function() {

    return [
        'key' => 'ro',
        'language' => 'Romana'
    ];

});

$factory->define(App\UserDefaultSetting::class, function() {
    return [
        'displayed_bills' => 10,
        'displayed_clients' => 10,
        'displayed_products' => 10,
        'displayed_custom_products' => 10,
    ];
});

$factory->define(App\SecuritySetting::class, function() {
    return [];
});

$factory->define(App\QuestionCategory::class, function() {
    return [];
});

// Empty action
$factory->define(App\Action::class, function() {
    return [];
});

// Allowed user action
$factory->define(App\UserAction::class, function($faker) {
    return [
        'message' => $faker->sentence(),
        'action_id' => \App\Action::where('type', 'allowed')->first()->id
    ];
});

// Info user action
$factory->defineAs(App\UserAction::class, 'info', function($faker) use ($factory) {
    $userAction = $factory->raw(\App\UserAction::class);
    $userAction['action_id'] = \App\Action::where('type', 'info')->first()->id;
    return $userAction;
});

// Wrong format user action
$factory->defineAs(\App\UserAction::class, 'wrong_format', function($faker) use ($factory) {
    $userAction = $factory->raw(\App\UserAction::class);
    $userAction['action_id'] = \App\Action::where('type', 'wrong_format')->first()->id;
    return $userAction;
});

// Not allowed user action
$factory->defineAs(\App\UserAction::class, 'not_allowed', function($faker) use ($factory) {
    $userAction = $factory->raw(\App\UserAction::class);
    $userAction['action_id'] = \App\Action::where('type', 'not_allowed')->first()->id;
    return $userAction;
});

/**
 * Generate new offer.
 */
$factory->define(App\Offer::class, function($faker) {

    $paymillOfferId = 'offer_' . substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 20);

    return [
        'paymill_offer_id' => $paymillOfferId,
        'name' => $faker->word(),
        'amount' => rand(2,9999),
        'interval' => '1 MONTH',
        'currency' => 'EUR'
    ];
});