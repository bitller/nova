<?php

namespace App\Helpers;

use App\ApplicationProduct;
use App\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Helper methods to handle application search features
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class Searches {

    /**
     * Search products by code or name.
     *
     * @param $query
     * @return mixed
     */
    public static function headerSearch($query) {

        $firstQuery = DB::table('products')->where('code', 'LIKE', $query.'%')->orWhere('name', 'LIKE', $query.'%')->where('user_id', Auth::user()->id)->select('id', 'code', 'name');
        $secondQuery = DB::table('application_products')->where('code', 'LIKE', "$query%")
            ->orWhere('name', 'LIKE', "$query%")
            ->select('id', 'code', 'name')
            ->union($firstQuery)
            ->limit(5)
            ->get();

        return $secondQuery;

    }

    public static function searchUsers($query) {
        return DB::table('users')->where('email', 'LIKE', $query.'%')->select('id', 'email')->limit(5)->get();
    }

}