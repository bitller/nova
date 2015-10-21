<?php

namespace App\Helpers;

use App\ApplicationProduct;
use App\Bill;
use App\BillApplicationProduct;
use App\BillProduct;
use App\Client;
use App\Product;
use Illuminate\Support\Facades\Auth;

/**
 * Statistics methods
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class Statistics {

    /**
     * Build general statistics.
     *
     * @return array
     */
    public static function general() {

        $billData = self::billData();

        return [
            'number_of_clients' => self::numberOfClients(),
            'number_of_custom_products' => self::numberOfCustomProducts(),
            'number_of_sold_products' => $billData['sold_products'],
            'number_of_bills' => $billData['bills'],
            'total_price' => $billData['total_price'],
            'total_discount' => $billData['total_discount']
        ];
    }

    /**
     * Get number of user clients.
     *
     * @return int
     */
    public static function numberOfClients() {
        return Client::where('user_id', Auth::user()->id)->count();
    }

    /**
     * Get number of user products.
     *
     * @return int
     */
    public static function numberOfCustomProducts() {
        return Product::where('user_id', Auth::user()->id)->count();
    }

    /**
     * Return number of bills, number user sold products, total price and total discount.
     *
     * @return array
     */
    public static function billData() {

        // Build an array with all user bill ids
        $billIds = [];
        $bills = Bill::select('id')->where('user_id', Auth::user()->id)->get();
        foreach ($bills as $bill) {
            $billIds[] = $bill->id;
        }

        $data = [
            'sold_products' => BillApplicationProduct::whereIn('bill_id', $billIds)->count() + BillProduct::whereIn('bill_id', $billIds)->count(),
            'bills' => count($billIds),
            'total_price' => BillApplicationProduct::whereIn('bill_id', $billIds)->sum('final_price') + BillProduct::whereIn('bill_id', $billIds)->sum('final_price')
        ];
        $data['total_discount'] = (BillApplicationProduct::whereIn('bill_id', $billIds)->sum('price') + BillProduct::whereIn('bill_id', $billIds)->sum('price')) - $data['total_price'];

        return $data;
    }

    /**
     * Get number of user bills.
     *
     * @return int
     */
    public static function numberOfBills() {
        return Bill::where('user_id', Auth::user()->id)->count();
    }

}