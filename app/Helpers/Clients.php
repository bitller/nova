<?php

namespace App\Helpers;

use App\Bill;
use App\Client;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Include helper methods for clients
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class Clients {

    /**
     * Return last client unpaid bills.
     *
     * @param int $clientId
     * @param int $limit
     * @return object|int
     */
    public static function lastUnpaidBills($clientId, $limit = 5) {
        return self::lastBills($clientId, $limit, 0);
    }

    /**
     * Return last client paid bills.
     * @param int $clientId
     * @param int $limit
     * @return object|int
     */
    public static function lastPaidBills($clientId, $limit = 5) {
        return self::lastBills($clientId, $limit, 1);
    }

    /**
     * Paginate paid bills of given client.
     *
     * @param int $clientId
     * @param int $page
     * @return LengthAwarePaginator
     */
    public static function paginatePaidBills($clientId, $page = 1) {
        return self::paginateBills($clientId, $page, 1);
    }

    /**
     * Paginate unpaid bills of given client.
     *
     * @param int $clientId
     * @param int $page
     * @return LengthAwarePaginator
     */
    public static function paginateUnpaidBills($clientId, $page = 1) {
        return self::paginateBills($clientId, $page);
    }

    /**
     * Paginate bills of given client.
     *
     * @param int $clientId
     * @param int $page
     * @param int $paid
     * @return LengthAwarePaginator
     */
    public static function paginateBills($clientId, $page = 1, $paid = 0) {

        $bills = self::lastBills($clientId, 'all', $paid);

        // Make sure page is positive
        if ($page < 1) {
            $page = 1;
        }

        $perPage = Settings::displayedBills();

        // Calculate start from
        $start = ($perPage * ($page - 1));

        // Slice results
        $sliced = array_slice($bills, $start, $perPage);

        // Build paginator
        $paginate = new LengthAwarePaginator($sliced, count($bills), $perPage);

        // Set path in function of wanted bills
        $path = '/clients/' .$clientId . '/bills/';
        if ($paid) {
            $path .= 'paid/get';
        } else {
            $path .= 'unpaid/get';
        }

        $paginate->setPath($path);

        return $paginate;
    }

    public static function lastBills($clientId, $limit = 5, $paid = false) {

        if ($paid) {
            $paid = 1;
        } else {
            $paid = 0;
        }

        // Do a first query to get bill ids
        $billIdsQuery = Bill::where('client_id', $clientId)->where('paid', $paid)->get();
        if (!count($billIdsQuery)) {
            return 0;
        }

        // Build string with question marks
        $billIdsQuestionMarks = '';
        foreach($billIdsQuery as $result) {
            $billIdsQuestionMarks .= "?,";
        }

        // Remove last comma from generated string
        $billIdsQuestionMarks = substr($billIdsQuestionMarks, 0, -1);

        // Build array with values
        $stop = 2;
        $billIds = [];
        for ($i = 1; $i <= $stop; $i++) {
            foreach ($billIdsQuery as $result) {
                $billIds[] = $result->id;
            }
        }

        // Select total price, number of products and bill id to be used in group statement
        $query = "SELECT SUM(bill_products.final_price) as total, SUM(bill_products.quantity) as number_of_products, bill_products.bill_id as bill_id, ";
        $query .= "bill_products.payment_term as payment_term, bill_products.campaign_order as campaign_order, ";
        $query .= "bill_products.campaign_year as campaign_year, bill_products.campaign_number as campaign_number FROM ";

        // Select other required columns
        $query .= "(SELECT final_price, bill_id, quantity, bills.created_at as created_at, bills.payment_term as payment_term, campaigns.year as campaign_year, ";
        $query .= "campaigns.number as campaign_number, bills.campaign_order as campaign_order ";
        $query .= "FROM bill_products LEFT JOIN bills ON bills.id = bill_id LEFT JOIN campaigns ON bills.campaign_id = campaigns.id WHERE bill_id IN ($billIdsQuestionMarks) ";

        // Do the same for other table
        $query .= "UNION ALL SELECT final_price, bill_id, quantity, bills.created_at as created_at, bills.payment_term as payment_term, campaigns.year as campaign_year, ";
        $query .= "campaigns.number as campaign_number, bills.campaign_order as campaign_order ";
        $query .= "FROM bill_application_products LEFT JOIN bills ON bills.id = bill_id LEFT JOIN campaigns ON bills.campaign_id = campaigns.id WHERE bill_id IN ($billIdsQuestionMarks)) bill_products ";
        $query .= "GROUP BY bill_products.bill_id ORDER BY bill_products.created_at DESC";

        if ($limit !== 'all') {
            $query .= " LIMIT $limit";
        }

        $results = DB::select($query, $billIds);

        // Loop trough results and set an appropriate message when a bill has no payment term set
        if (!count($results)) {
            return 0;
        }

        foreach ($results as $result) {
            if ($result->payment_term === '0000-00-00') {
                $result->payment_term = trans('bill.not_set');
            }
        }

        return $results;
    }

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

    /**
     * @param $clientBills
     * @return mixed
     */
    public static function getTotalSellsWithoutDiscountByBillIds($clientBills) {

        $billIds = [];
        foreach ($clientBills as $bill) {
            $billIds[]= $bill->id;
        }

        $billProductsPrice = DB::table('bill_products')->whereIn('bill_id', $billIds)->sum('price');
        $billApplicationProductsFinalPrice = DB::table('bill_application_products')->whereIn('bill_id', $billIds)->sum('price');

        return $billProductsPrice + $billApplicationProductsFinalPrice;

    }

    /**
     * Return suggestions based on client name.
     *
     * @param string $clientName
     * @return mixed
     */
    public static function suggestClients($clientName) {
        return Client::where('user_id', Auth::user()->id)->where('name', 'LIKE', "$clientName%")->get();
    }

}