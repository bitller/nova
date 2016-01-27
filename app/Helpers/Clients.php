<?php

namespace App\Helpers;

use App\Bill;
use App\Client;
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

    public static function lastBills($clientId, $limit = 5, $paid = false) {

        $select = 'SUM(bill_products.final_price * bill_products.quantity) as bill_products_total_price, SUM(bill_application_products.final_price * bill_application_products.quantity) as bill_application_products_total_price';
        $select .= ', SUM(bill_products.quantity + bill_application_products.quantity) as number_of_products';
        $query = Bill::select('bills.*', DB::raw($select))
            ->where('client_id', $clientId)
            ->leftJoin('bill_products', 'bill_products.bill_id', '=', 'bills.id')
            ->leftJoin('bill_application_products', 'bill_application_products.bill_id', '=', 'bills.id')
            ->where('bills.paid', $paid)
            ->orderBy('bills.created_at', 'desc')
            ->groupBy('bills.id')
            ->take($limit)
            ->get();

        if (!count($query)) {
            return 0;
        }

        foreach ($query as $result) {
            $result->total_price = $result->bill_products_total_price + $result->bill_application_products_total_price;
            $result->total_price = number_format($result->total_price, 2);
        }

        return $query;
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