<?php

namespace App\Helpers;

/**
 * Build urls used for get requests
 *
 * @author Alexandru Bugairn <alexandru.bugarin@gmail.com>
 */
class TestUrlBuilder {

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