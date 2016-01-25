<?php

namespace App\Helpers\Statistics;

use Illuminate\Support\Facades\DB;

/**
 * Handle client statistics.
 *
 * @author Alexandru Bugairin <alexandru.bugarin@gmail.com>
 */
class ClientStatistics {

    /**
     * Return earnings made by given client.
     *
     * @param int $clientId
     * @return mixed
     */
    public static function earnings($clientId) {

        // Make first query. I used two separate queries because only one query returns the earnings doubled and I don't have time to solve this by grouping the results
        $billProductsQuery = DB::table('clients')
            ->select(DB::raw('SUM(bill_products.final_price * bill_products.quantity) as earnings'))
            ->leftJoin('users', 'clients.user_id', '=', 'users.id')
            ->leftJoin('products', 'products.user_id', '=', 'users.id')
            ->leftJoin('bills', 'bills.client_id', '=', 'clients.id')
            ->leftJoin('bill_products', 'bill_products.bill_id', '=', 'bills.id')
            ->where('clients.id', $clientId)
            ->groupBy('products.id')
            ->get();

        // Do the second query
        $billApplicationProductsQuery = DB::table('application_products')
            ->select(DB::raw('SUM(bill_application_products.final_price * bill_application_products.quantity) as earnings'))
            ->leftJoin('bill_application_products', function($join) {
                $join->on('application_products.id', '=', 'bill_application_products.product_id');
            })
            ->leftJoin('bills', 'bills.id', '=', 'bill_application_products.bill_id')
            ->leftJoin('clients', 'clients.id', '=', 'bills.client_id')
            ->where('clients.id', $clientId)
            ->groupBy('clients.id')
            ->get();

        $earnings = 0;

        // Sum earnings of the two queries
        if (isset($billProductsQuery[0]->earnings)) {
            $earnings += $billProductsQuery[0]->earnings;
        }

        if (isset($billApplicationProductsQuery[0]->earnings)) {
            $earnings += $billApplicationProductsQuery[0]->earnings;
        }

        return $earnings;
    }

    public static function earningsInCurrentCampaign($clientId) {
        //
    }

    public static function moneyUserHasToReceive($clientId) {
        //
    }

    /**
     * Return number of total products ordered by given client.
     *
     * @param int $clientId
     * @return mixed
     */
    public static function totalNumberOfProductsOrdered($clientId) {

        // Count number of bill products
        $billProducts = DB::table('bill_products')
            ->leftJoin('bills', 'bill_products.bill_id', '=', 'bills.id')
            ->where('bills.client_id', $clientId)
            ->where('bills.paid', 1)
            ->sum('bill_products.quantity');

        // Count number of bill application products
        $billApplicationProducts = DB::table('bill_application_products')
            ->leftJoin('bills', 'bill_application_products.bill_id', '=', 'bills.id')
            ->where('bills.client_id', $clientId)
            ->where('bills.paid', 1)
            ->sum('bill_application_products.quantity');

        return $billProducts + $billApplicationProducts;
    }

    public static function numberOfUniqueProductsOrdered($clientId) {
        //
    }

    public static function totalDiscountReceived($clientId) {
        //
    }
}