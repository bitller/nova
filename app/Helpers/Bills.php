<?php

namespace App\Helpers;
use App\Bill;
use Illuminate\Support\Facades\DB;

/**
 * Handle work with bills
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class Bills {

    /**
     * @param int $billId
     * @return mixed
     */
    public function getBillProducts($billId) {

        $productIds = $this->getProductIds($billId);
        $applicationProductIds = $this->getApplicationProductIds($billId);

        $firstQuery = DB::table('products')->whereIn('products.id', $productIds)
            ->leftJoin('bill_products', 'bill_products.product_id', '=', 'products.id')
            ->select('products.name', 'products.code', 'bill_products.id', 'bill_products.page');

        $secondQuery = DB::table('application_products')->whereIn('application_products.id', $applicationProductIds)
            ->leftJoin('bill_application_products', 'bill_application_products.product_id', '=', 'application_products.id')
            ->select('application_products.name', 'application_products.code', 'bill_application_products.id', 'bill_application_products.page')
            ->union($firstQuery)->get();

        return $secondQuery;

    }

    /**
     * @param int $billId
     * @return array
     */
    private function getProductIds($billId) {

        $bill = Bill::find($billId);

        if (!$bill) {
            return [];
        }

        $productIds = [];
        $products = $bill->products()->select('product_id as id')->get();

        foreach ($products as $product) {
            $productIds[] = $product->id;
        }

        return $productIds;

    }

    /**
     * @param int $billId
     * @return array
     */
    private function getApplicationProductIds($billId) {

        $bill = Bill::find($billId);

        if (!$bill) {
            return [];
        }

        $applicationProductIds = [];
        $applicationProducts = $bill->applicationProducts()->select('product_id as id')->get();

        foreach ($applicationProducts as $applicationProduct) {
            $applicationProductIds[] = $applicationProduct->id;
        }

        return $applicationProductIds;

    }

}