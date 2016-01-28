<?php

namespace App\Helpers;

use App\ApplicationProduct;
use App\Bill;
use App\BillApplicationProduct;
use App\BillProduct;

/**
 * Get all types of bill data.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class BillData {

    /**
     * @var int
     */
    private $price = 'not_calculated';

    /**
     * @var int
     */
    private $finalPrice = 'not_calculated';

    /**
     * Return price of given bill.
     *
     * @param int $billId
     * @return mixed
     */
    public static function getBillPrice($billId) {

        $price = 0;
        $billProducts = BillProduct::where('bill_id', $billId)->get();
        $billApplicationProducts = BillApplicationProduct::where('bill_id', $billId)->get();

        // Loop trough bill products
        foreach ($billProducts as $billProduct) {
            $price += $billProduct->price * $billProduct->quantity;
        }

        // Loop bill application products
        foreach ($billApplicationProducts as $billApplicationProduct) {
            $price += $billApplicationProduct->price * $billApplicationProduct->quantity;
        }

        return $price;
    }

    /**
     * Return number of products of given bill.
     *
     * @param int $billId
     * @return mixed
     */
    public static function getNumberOfProducts($billId) {

        $numberOfProducts = 0;
        $billProducts = BillProduct::where('bill_id', $billId)->get();
        $billApplicationProducts = BillApplicationProduct::where('bill_id', $billId)->get();

        foreach ($billProducts as $billProduct) {
            $numberOfProducts += $billProduct->quantity;
        }

        foreach ($billApplicationProducts as $billApplicationProduct) {
            $numberOfProducts += $billApplicationProduct->quantity;
        }

        return $numberOfProducts;
    }

    /**
     * Return bill to pay price.
     *
     * @param int $billId
     * @return mixed
     */
    public static function getBillToPay($billId) {

        $finalPrice = 0;
        $billProducts = BillProduct::where('bill_id', $billId)->get();
        $billApplicationProducts = BillApplicationProduct::where('bill_id', $billId)->get();

        foreach($billProducts as $billProduct) {
            $finalPrice += $billProduct->final_price;
        }

        foreach ($billApplicationProducts as $billApplicationProduct) {
            $finalPrice += $billApplicationProduct->final_price;
        }

        return $finalPrice;
    }

    /**
     * Return bill saved money.
     *
     * @param int $billId
     * @return int
     */
    public static function getBillSavedMoney($billId) {

        $price = 0;
        $billProducts = BillProduct::where('bill_id', $billId)->get();
        $billApplicationProducts = BillApplicationProduct::where('bill_id', $billId)->get();

        foreach ($billProducts as $billProduct) {
            $price += $billProduct->price * $billProduct->quantity;
        }

        foreach ($billApplicationProducts as $billApplicationProduct) {
            $price += $billApplicationProduct->price * $billApplicationProduct->quantity;
        }

        return $price - self::getBillToPay($billId);
    }

    /**
     * Return bill price, final price, to pay, saved money and number of products.
     *
     * @param int $billId
     * @return array
     */
    public static function getBillPriceFinalPriceToPaySavedMoneyAndNumberOfProducts($billId) {

        $data = [
            'final_price' => 0,
            'price' => 0,
            'to_pay' => self::getBillToPay($billId),
            'number_of_products' => 0,
            'saved_money' => 0
        ];

        $billProducts = BillProduct::where('bill_id', $billId)->get();
        $billApplicationProducts = BillApplicationProduct::where('bill_id', $billId)->get();

        // Loop trough bill products
        foreach ($billProducts as $billProduct) {
            $data['price'] += $billProduct->price;
            $data['final_price'] += $billProduct->final_price;
            $data['number_of_products'] += $billProduct->quantity;
        }

        // Loop trough bill application products
        foreach ($billApplicationProducts as $billApplicationProduct) {
            $data['price'] += $billApplicationProduct->price;
            $data['final_price'] += $billApplicationProduct->final_price;
            $data['number_of_products'] += $billApplicationProduct->quantity;
        }

        $data['saved_money'] = $data['price'] - $data['final_price'];
        return $data;
    }

    /**
     * Get bill payment term.
     *
     * @param int $billId
     * @return bool
     */
    public static function getPaymentTerm($billId) {

        $paymentTerm = Bill::where('id', $billId)->first()->payment_term;
        if ($paymentTerm === '0000-00-00') {
            return false;
        }

        return date('d-m-Y', strtotime($paymentTerm));
    }
}