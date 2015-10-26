<?php

namespace App\Helpers;

use App\ApplicationProduct;
use App\Product;
use Illuminate\Support\Facades\DB;

/**
 * Helper methods to handle application search features
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class Searches {

    public static function headerSearch($query) {

        $firstQuery = DB::table('products')->where('code', 'LIKE', $query.'%')->orWhere('name', 'LIKE', $query.'%')->select('id', 'code', 'name');
        $secondQuery = DB::table('application_products')->where('code', 'LIKE', "$query%")
            ->orWhere('name', 'LIKE', "$query%")
            ->select('id', 'code', 'name')
            ->union($firstQuery)
            ->limit(5)
            ->get();

        return $secondQuery;

    }

}