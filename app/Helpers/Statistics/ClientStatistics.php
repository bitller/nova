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
     * Return all client statistics.
     *
     * @param int $clientId
     * @return array
     */
    public static function all($clientId) {
        return [
            'earnings' => self::earnings($clientId),
            'earnings_in_current_campaign' => self::earningsInCurrentCampaign($clientId),
            'money_user_has_to_receive' => self::moneyUserHasToReceive($clientId),
            'money_owed_due_passed_payment_term' => self::moneyOwedDuePassedPaymentTerm($clientId),
            'number_of_products_ordered' => self::totalNumberOfProductsOrdered($clientId),
            'total_discount_received' => self::totalDiscountReceived($clientId)
        ];
    }

    /**
     * Return earnings made by given client.
     *
     * @param int $clientId
     * @return mixed
     */
    public static function earnings($clientId) {

        // Make first query. I used two separate queries because only one query returns the earnings doubled and I don't have time to solve this by grouping the results
        $billProductsQuery = self::_earningsProductsQuery($clientId);

        // Do the second query
        $billApplicationProductsQuery = self::_earningsApplicationProductsQuery($clientId);

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

    /**
     * @param int $clientId
     * @return int
     */
    public static function earningsInCurrentCampaign($clientId) {

        $earningsInCurrentCampaign = 0;

        // Query the two tables
        $billProductsQuery = self::_earningsProductsQuery($clientId, ['bills.campaign_number' => 1, 'bills.campaign_year' => date('Y')]);
        $billApplicationsQuery = self::_earningsApplicationProductsQuery($clientId, ['bills.campaign_number' => 1, 'bills.campaign_year' => date('Y')]);

        // Check if first query returned something and add to existent value
        if (isset($billProductsQuery[0]->earnings)) {
            $earningsInCurrentCampaign += $billProductsQuery[0]->earnings;
        }

        // Same here for the other table
        if (isset($billApplicationsQuery[0]->earnings)) {
            $earningsInCurrentCampaign += $billApplicationsQuery[0]->earnings;
        }

        return $earningsInCurrentCampaign;
    }

    /**
     * Return money a user has to receive from given client.
     *
     * @param int $clientId
     * @return int
     */
    public static function moneyUserHasToReceive($clientId) {

        $moneyToReceive = 0;

        // Get only not paid bills
        $paid = 0;

        $query = DB::table('clients')
            ->select(DB::raw('SUM(bill_products.final_price * bill_products.quantity) as earnings'))
            ->leftJoin('users', 'clients.user_id', '=', 'users.id')
            ->leftJoin('products', 'products.user_id', '=', 'users.id')
            ->leftJoin('bills', 'bills.client_id', '=', 'clients.id')
            ->leftJoin('bill_products', 'bill_products.bill_id', '=', 'bills.id')
            ->where('bills.paid', $paid)
            ->where('bills.payment_term', '>', date('Y-m-d'))
            ->where('clients.id', $clientId)
            ->groupBy('products.id')
            ->get();

        $secondQuery = DB::table('application_products')
            ->select(DB::raw('SUM(bill_application_products.final_price * bill_application_products.quantity) as earnings'))
            ->leftJoin('bill_application_products', function($join) {
                $join->on('application_products.id', '=', 'bill_application_products.product_id');
            })
            ->leftJoin('bills', 'bills.id', '=', 'bill_application_products.bill_id')
            ->leftJoin('clients', 'clients.id', '=', 'bills.client_id')
            ->where('bills.paid', $paid)
            ->where('bills.payment_term', '>', date('Y-m-d'))
            ->where('clients.id', $clientId)
            ->groupBy('clients.id')
            ->get();

        if (isset($query[0]->earnings)) {
            $moneyToReceive += $query[0]->earnings;
        }
        if (isset($secondQuery[0]->earnings)) {
            $moneyToReceive += $secondQuery[0]->earnings;
        }

        return $moneyToReceive;
    }

    /**
     * Money that client owes to the user because payment term was passed.
     *
     * @param int $clientId
     * @return int
     */
    public static function moneyOwedDuePassedPaymentTerm($clientId) {

        $money = 0;

        // Get only not paid bills
        $paid = 0;

        $query = DB::table('clients')
            ->select(DB::raw('SUM(bill_products.final_price * bill_products.quantity) as earnings'))
            ->leftJoin('users', 'clients.user_id', '=', 'users.id')
            ->leftJoin('products', 'products.user_id', '=', 'users.id')
            ->leftJoin('bills', 'bills.client_id', '=', 'clients.id')
            ->leftJoin('bill_products', 'bill_products.bill_id', '=', 'bills.id')
            ->where('bills.paid', $paid)
            ->where('bills.payment_term', '<', date('Y-m-d'))
            ->where('clients.id', $clientId)
            ->groupBy('products.id')
            ->get();

        $secondQuery = DB::table('application_products')
            ->select(DB::raw('SUM(bill_application_products.final_price * bill_application_products.quantity) as earnings'))
            ->leftJoin('bill_application_products', function($join) {
                $join->on('application_products.id', '=', 'bill_application_products.product_id');
            })
            ->leftJoin('bills', 'bills.id', '=', 'bill_application_products.bill_id')
            ->leftJoin('clients', 'clients.id', '=', 'bills.client_id')
            ->where('bills.paid', $paid)
            ->where('bills.payment_term', '<', date('Y-m-d'))
            ->where('clients.id', $clientId)
            ->groupBy('clients.id')
            ->get();

        if (isset($query[0]->earnings)) {
            $money += $query[0]->earnings;
        }
        if (isset($secondQuery[0]->earnings)) {
            $money += $secondQuery[0]->earnings;
        }

        return $money;
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

    /**
     * Return total discount received by given client.
     *
     * @param int $clientId
     * @return int
     */
    public static function totalDiscountReceived($clientId) {

        $totalDiscount = 0;

        // Build query to return total discount received by this client
        $firstQuery = DB::table('clients')
            ->select(DB::raw('SUM((bill_products.price - bill_products.final_price) * bill_products.quantity) as total_discount'))
            ->leftJoin('users', 'clients.user_id', '=', 'users.id')
            ->leftJoin('products', 'products.user_id', '=', 'users.id')
            ->leftJoin('bills', 'bills.client_id', '=', 'clients.id')
            ->leftJoin('bill_products', 'bill_products.bill_id', '=', 'bills.id')
            ->where('bills.paid', 1)
            ->where('clients.id', $clientId)
            ->groupBy('products.id')
            ->get();

        $secondQuery = DB::table('application_products')
            ->select(DB::raw('SUM((bill_application_products.price - bill_application_products.final_price) * bill_application_products.quantity) as total_discount'))
            ->leftJoin('bill_application_products', function($join) {
                $join->on('application_products.id', '=', 'bill_application_products.product_id');
            })
            ->leftJoin('bills', 'bills.id', '=', 'bill_application_products.bill_id')
            ->leftJoin('clients', 'clients.id', '=', 'bills.client_id')
            ->where('bills.paid', 1)
            ->where('clients.id', $clientId)
            ->groupBy('clients.id')
            ->get();

        if (isset($firstQuery[0]->total_discount)) {
            $totalDiscount += $firstQuery[0]->total_discount;
        }
        if (isset($secondQuery[0]->total_discount)) {
            $totalDiscount += $secondQuery[0]->total_discount;
        }

        return $totalDiscount;
    }

    /**
     * @param int $clientId
     * @param array $otherWheres
     * @param bool $paid
     * @return mixed
     */
    private static function _earningsProductsQuery($clientId, $otherWheres = [], $paid = true) {

        if (!$paid) {
            $paid = 0;
        } else {
            $paid = 1;
        }

        $query = DB::table('clients')
            ->select(DB::raw('SUM(bill_products.final_price * bill_products.quantity) as earnings'))
            ->leftJoin('users', 'clients.user_id', '=', 'users.id')
            ->leftJoin('products', 'products.user_id', '=', 'users.id')
            ->leftJoin('bills', 'bills.client_id', '=', 'clients.id')
            ->leftJoin('bill_products', 'bill_products.bill_id', '=', 'bills.id')
            ->where('bills.paid', $paid)
            ->where('clients.id', $clientId);

        if (count($otherWheres)) {
            foreach ($otherWheres as $column => $value) {
                $query->where($column, $value);
            }
        }

        return $query->groupBy('products.id')->get();
    }

    /**
     * @param int $clientId
     * @param array $otherWheres
     * @param bool $paid
     * @return
     */
    private static function _earningsApplicationProductsQuery($clientId, $otherWheres = [], $paid = true) {

        if (!$paid) {
            $paid = 0;
        } else {
            $paid = 1;
        }

        $query = DB::table('application_products')
            ->select(DB::raw('SUM(bill_application_products.final_price * bill_application_products.quantity) as earnings'))
            ->leftJoin('bill_application_products', function($join) {
                $join->on('application_products.id', '=', 'bill_application_products.product_id');
            })
            ->leftJoin('bills', 'bills.id', '=', 'bill_application_products.bill_id')
            ->leftJoin('clients', 'clients.id', '=', 'bills.client_id')
            ->where('bills.paid', $paid)
            ->where('clients.id', $clientId);

        // Add extra where conditions, if given
        if ($otherWheres) {
            foreach ($otherWheres as $column => $value) {
                $query->where($column, $value);
            }
        }

        return $query->groupBy('clients.id')->get();
    }
}