<?php

namespace App\Providers;

use App\ApplicationProduct;
use App\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        Validator::extend('check_auth_user_password', function($attribute, $value, $parameters, $validator) {
            return Hash::check($value, Auth::user()->password);
        });

        // Make sure client email is not used by another client of current user
        Validator::extend('email_not_used_by_another_user_client', function($attribute, $value, $parameters, $validator) {
            if (Client::where('user_id', Auth::user()->id)->where('email', $value)->count()) {
                return false;
            }
            return true;
        });

        // Make sure client phone number is not user by another client of current user
        Validator::extend('phone_number_not_used_by_another_user_client', function($attribute, $value, $parameters, $validator) {
            if (Client::where('user_id', Auth::user()->id)->where('phone_number', $value)->count()) {
                return false;
            }
            return true;
        });

        Validator::extend('not_exists', function($attribute, $value, $parameters, $validator) {
            return !DB::table($parameters[0])->where($parameters[1], $value)->count();
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }
}
