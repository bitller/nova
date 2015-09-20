<?php

namespace App\Helpers;

class TestUrlBuilder {

    public static function deleteBillProduct($billId, $productId, $productCode) {
        return '/bills/' . $billId . '/delete/' . $productId . '/' . $productCode;
    }

}