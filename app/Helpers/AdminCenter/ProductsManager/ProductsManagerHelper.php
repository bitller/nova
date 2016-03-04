<?php

namespace App\Helpers\AdminCenter\ProductsManager;
use App\ApplicationProduct;
use App\BillApplicationProduct;

/**
 * Helper methods for products manager section.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class ProductsManagerHelper extends ProtectedHelpers {

    /**
     * Return pagination of searched bills.
     *
     * @param string $searchTerm
     * @param int $page
     * @return mixed
     */
    public static function searchedBillsPagination($searchTerm, $page) {
        return self::paginateSearchedProducts($searchTerm, $page);
    }

    /**
     * Return details about given application product.
     *
     * @param string $productCode
     * @param string $productId
     * @return array
     */
    public static function productDetails($productCode, $productId) {

        $product = ApplicationProduct::select('id', 'code', 'name', 'created_at')
            ->where('code', $productCode)
            ->where('id', $productId)
            ->first();

        $numberOfUsersThatUseThisProduct = BillApplicationProduct::where('product_id', $productId)
            ->join('bills', 'bills.id', '=', 'bill_application_products.bill_id')
            ->join('users', 'users.id', '=', 'bills.user_id')
            ->groupBy('users.id')->distinct()->count();

        $numberOfBillsThatUseThisProduct = BillApplicationProduct::where('product_id', $productId)
            ->distinct('bill_id')->count();

        $soldPiecesOfThisProduct = BillApplicationProduct::where('product_id', $productId)->sum('quantity');

        $generatedMoneyByThisProduct = BillApplicationProduct::where('product_id', $productId)->sum('final_price');

        return [
            'id' => $product->id,
            'code' => $product->code,
            'name' => $product->name,
            'created_at' => $product->created_at,
            'number_of_users_that_use_this_product' => trans('products_manager.number_of_users_that_use_this_product', [
                'number' => $numberOfUsersThatUseThisProduct
            ]),
            'number_of_bills_that_use_this_product' => trans('products_manager.number_of_bills_that_use_this_product', [
                'number' => $numberOfBillsThatUseThisProduct
            ]),
            'sold_pieces' => trans('products_manager.sold_pieces_of_this_product', [
                'number' => $soldPiecesOfThisProduct
            ]),
            'generated_money' => trans('products_manager.generated_money_by_this_product', [
                'money' => $generatedMoneyByThisProduct
            ])
        ];
    }
}