<?php

namespace App\Helpers;

use App\BillApplicationProduct;
use App\BillProduct;

/**
 * Handle bill product and bill application product data.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class BillProductData {

    /**
     * Get price of given bill product.
     *
     * @param int $billProductId
     * @return mixed
     */
    public static function getPrice($billProductId) {
        $billProduct = self::setModel($billProductId);
        return $billProduct->first()->price;
    }

    /**
     * Get final price of given bill product.
     *
     * @param int $billProductId
     * @return mixed
     */
    public static function getFinalPrice($billProductId) {
        $billProduct = self::setModel($billProductId);
        return $billProduct->first()->final_price;
    }

    /**
     * Get bill product page.
     *
     * @param int $billProductId
     * @return mixed
     */
    public static function getPage($billProductId) {
        $billProduct = self::setModel($billProductId);
        return $billProduct->first()->page;
    }

    /**
     * Get bill product quantity.
     *
     * @param int $billProductId
     * @return mixed
     */
    public static function getQuantity($billProductId) {
        $billProduct = self::setModel($billProductId);
        return $billProduct->first()->quantity;
    }

    /**
     * Get bill product discount.
     *
     * @param int $billProductId
     * @return mixed
     */
    public static function getDiscount($billProductId) {
        $billProduct = self::setModel($billProductId);
        return $billProduct->first()->discount;
    }

    /**
     * Set right model for given bill product id.
     *
     * @param int $billProductId
     * @return mixed
     */
    private static function setModel($billProductId) {

        // Check if is a bill product
        if (BillProduct::where('id', $billProductId)->count()) {
            return BillProduct::where('id', $billProductId);
        }

        // Check if is bill application product
        if (BillApplicationProduct::where('id', $billProductId)->count()) {
            return BillApplicationProduct::where('id', $billProductId);
        }
    }
}