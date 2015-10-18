<?php

namespace App\Helpers;
use Illuminate\Support\Facades\DB;

/**
 * Include helper methods for clients
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class Clients {

    /**
     * Return value of all purchased products by a client matching given bill ids.
     *
     * @param $clientBills
     * @return mixed
     */
    public static function getTotalSellsByBillIds($clientBills) {

        // Save all bill ids in an array
        $billIds = [];
        foreach ($clientBills as $bill) {
            $billIds[] = $bill->id;
        }

        $billProductsFinalPrice = DB::table('bill_products')->whereIn('bill_id', $billIds)->sum('final_price');
        $billApplicationProductsFinalPrice = DB::table('bill_application_products')->whereIn('bill_id', $billIds)->sum('final_price');

        return $billProductsFinalPrice + $billApplicationProductsFinalPrice;

    }

    public static function getTotalSellsWithoutDiscountByBillIds($clientBills) {

        $billIds = [];
        foreach ($clientBills as $bill) {
            $billIds[]= $bill->id;
        }

        $billProductsPrice = DB::table('bill_products')->whereIn('bill_id', $billIds)->sum('price');
        $billApplicationProductsFinalPrice = DB::table('bill_application_products')->whereIn('bill_id', $billIds)->sum('price');

        return $billProductsPrice + $billApplicationProductsFinalPrice;

    }

}