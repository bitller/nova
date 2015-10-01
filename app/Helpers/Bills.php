<?php

namespace App\Helpers;
use App\Bill;
use Illuminate\Support\Facades\Auth;
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
            ->select(
                'products.id',
                'products.name',
                'products.code',
                'bill_products.id as bill_product_id',
                'bill_products.page',
                'bill_products.quantity',
                'bill_products.price',
                'bill_products.discount',
                'bill_products.calculated_discount',
                'bill_products.final_price'
            );

        $secondQuery = DB::table('application_products')->whereIn('application_products.id', $applicationProductIds)
            ->leftJoin('bill_application_products', 'bill_application_products.product_id', '=', 'application_products.id')
            ->select(
                'application_products.id',
                'application_products.name',
                'application_products.code',
                'bill_application_products.id as bill_product_id',
                'bill_application_products.page',
                'bill_application_products.quantity',
                'bill_application_products.price',
                'bill_application_products.discount',
                'bill_application_products.calculated_discount',
                'bill_application_products.final_price'
            )->union($firstQuery)->orderBy('page', 'asc')->get();

        return $secondQuery;

    }

    /**
     * Check if given bill belongs to currently authenticated user.
     *
     * @param int $billId
     * @return mixed
     */
    public static function belongsToAuthUser($billId) {
        return Bill::where('id', $billId)->where('user_id', Auth::user()->id)->count();
    }

    /**
     * Return an array with columns to update on bill product edit.
     *
     * @param string $columnToUpdate
     * @param string|int $newValue
     * @param Product $product
     * @return array
     */
    public static function getDataToUpdateOnEdit($columnToUpdate, $newValue, $product) {

        if ($columnToUpdate === 'page') {

            return [
                $columnToUpdate => $newValue
            ];
        }

        // When quantity is updated, update price, calculated discount and final price
        if ($columnToUpdate === 'quantity') {

            $toUpdate = [
                $columnToUpdate => $newValue
            ];

            $toUpdate['price'] = Products::newPrice($product->price, $product->quantity, $newValue);
            $toUpdate['calculated_discount'] = Products::discount($toUpdate['price'], $product->discount);
            $toUpdate['final_price'] = $toUpdate['price'] - $toUpdate['calculated_discount'];

            return $toUpdate;
        }

        // When price is updated, update calculated discount and final price
        if ($columnToUpdate === 'price') {

            $toUpdate = [
                $columnToUpdate => $newValue * $product->quantity
            ];

            $toUpdate['calculated_discount'] = Products::discount($newValue * $product->quantity, $product->discount);
            $toUpdate['final_price'] = ($newValue * $product->quantity) - $toUpdate['calculated_discount'];

            return $toUpdate;
        }

        // When discount is updated, update calculated discount and final price
        if ($columnToUpdate === 'discount') {

            $toUpdate = [
                $columnToUpdate => $newValue
            ];

            $toUpdate['calculated_discount'] = Products::discount($product->price, $newValue);
            $toUpdate['final_price'] = $product->price - $toUpdate['calculated_discount'];

            return $toUpdate;
        }

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