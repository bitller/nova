<?php

namespace App\Helpers;
use App\ApplicationProduct;
use App\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Helper functions to make easier the work with products
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class Products {

    /**
     * Calculate new price of a product when quantity is updated.
     *
     * @param float $currentPrice
     * @param int $currentQuantity
     * @param int $newQuantity
     * @return float
     */
    public static function newPrice($currentPrice, $currentQuantity, $newQuantity) {
        return ($currentPrice / $currentQuantity) * $newQuantity;
    }

    /**
     * Calculate product price with given quantity.
     *
     * @param float $pricePerProduct
     * @param int $quantity
     * @return mixed
     */
    public static function price($pricePerProduct, $quantity) {
        return $pricePerProduct * $quantity;
    }

    /**
     * Calculate discount.
     *
     * @param float $totalPrice
     * @param int $discount
     * @return float
     */
    public static function discount($totalPrice, $discount) {
        return ($discount/100) * $totalPrice;
    }

    /**
     * Return product suggestions in function of given product code.
     *
     * @param string $code
     * @return mixed
     */
    public static function suggestProducts($code) {

        $firstQuery = DB::table('application_products')->where('code', 'like', $code . '%')
            ->select('code', 'name')
            ->take(5);

        return DB::table('products')->where('user_id', Auth::user()->id)
            ->where('code', 'like', $code . '%')
            ->select('code', 'name')
            ->union($firstQuery)
            ->take(5)
            ->get();
    }

    /**
     * Add new product to given bill.
     *
     * @param int $billId
     * @param array $inputs
     * @return mixed
     */
    public static function insertProduct($billId, $inputs) {

        // Create ajax response instance
        $response = new AjaxResponse();

        // Check if bill belongs to current user
        if (!Bills::belongsToAuthUser($billId)) {
            $response->setFailMessage('');
            return response($response->get(), $response->getDefaultErrorResponseCode())->header('Content-Type', 'application/json');
        }

        $applicationProduct = ApplicationProduct::where('code', $inputs['product_code'])->first();
        $customProduct = Product::where('code', $inputs['product_code'])->where('user_id', Auth::user()->id)->first();

        // Check if products exists and if is an application product or custom product
        if ($applicationProduct) {

            // Get application product and create db table instance
            $product = $applicationProduct;
            $query = DB::table('bill_application_products');

        } else if ($customProduct) {

            // Query for custom product and create db table instance
            $product = $customProduct;
            $query = DB::table('bill_products');

        } else {
            // Product does not exists
            $response->setFailMessage(trans('bill.product_not_found'));
            return response($response->get(), $response->getDefaultErrorResponseCode())->header('Content-Type', 'application/json');
        }

        $inputs['bill_id'] = $billId;
        self::handleProductInsert($product, $inputs, $query);

        $response->setSuccessMessage(trans('bill.product_added_successfully'));
        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Return true if given product is an application product, false otherwise.
     *
     * @param int $productId
     * @param string $productCode
     * @return mixed
     */
    public static function isApplicationProduct($productId, $productCode) {
        return ApplicationProduct::where('id', $productId)->where('code', $productCode)->count();
    }

    /**
     * Return true if given product is a custom product, false otherwise.
     *
     * @param int $productId
     * @param string $productCode
     * @return mixed
     */
    public static function isCustomProduct($productId, $productCode) {
        return Product::where('id', $productId)->where('code', $productCode)->where('user_id', Auth::user()->id)->count();
    }

    /**
     * Add new product to bill.
     *
     * @param $productQuery
     * @param $inputs
     * @param $insertQuery
     */
    private static function handleProductInsert($productQuery, $inputs, $insertQuery) {

        $insertData = [
            'bill_id' => $inputs['bill_id'],
            'product_id' => $productQuery->id,
        ];

        // If page input is empty, set a default value
        if (!isset($inputs['product_page'])) {
            $insertData['page'] = 0;
        } else {
            $insertData['page'] = $inputs['product_page'];
        }

        // If quantity input is empty, set a default value
        if (!isset($inputs['product_quantity'])) {
            $insertData['quantity'] = 1;
        } else {
            $insertData['quantity'] = $inputs['product_quantity'];
        }

        // Set default value for price
        if (!isset($inputs['product_price'])) {
            $insertData['price'] = 0;
        } else {
            $insertData['price'] = $inputs['product_price'] * $insertData['quantity'];
        }

        if (!isset($inputs['product_discount'])) {
            $insertData['discount'] = 0;
        } else {
            $insertData['discount'] = $inputs['product_discount'];
        }

        // Check if discount exists
        if (isset($inputs['product_discount'])) {
            $insertData['discount'] = $inputs['product_discount'];
            $insertData['calculated_discount'] = self::discount($insertData['price'], $insertData['discount']);
        }

        // Calculate final price
        if (isset($insertData['calculated_discount'])) {
            $insertData['final_price'] = $insertData['price'] - $insertData['calculated_discount'];
        } else {
            $insertData['final_price'] = $insertData['price'];
        }

        $insertQuery->insert($insertData);

    }

}