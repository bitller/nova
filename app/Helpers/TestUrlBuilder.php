<?php

namespace App\Helpers;

/**
 * Build urls used for get requests
 *
 * @author Alexandru Bugairn <alexandru.bugarin@gmail.com>
 */
class TestUrlBuilder {

    /**
     * Build url used to edit product page.
     *
     * @param int $billId
     * @return string
     */
    public static function editBillProductPage($billId) {
        return '/bills/' . $billId . '/edit-page';
    }

    /**
     * Build url used to edit product quantity.
     *
     * @param int $billId
     * @return string
     */
    public static function editBillProductQuantity($billId) {
        return '/bills/' . $billId . '/edit-quantity';
    }

    /**
     * Build url used to edit product price.
     *
     * @param int $billId
     * @return string
     */
    public static function editBillProductPrice($billId) {
        return '/bills/' . $billId . '/edit-price';
    }

    /**
     * Build url used to delete a product from a bill.
     *
     * @param int $billId
     * @param int $productId
     * @param string $productCode
     * @return string
     */
    public static function deleteBillProduct($billId, $productId, $productCode) {
        return '/bills/' . $billId . '/delete/' . $productId . '/' . $productCode;
    }

}