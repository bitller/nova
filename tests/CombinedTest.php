<?php
use App\Helpers\Products;
use App\Helpers\TestUrlBuilder;

/**
 * Test bills and bill pages functions combined
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class CombinedTest extends TestCase {

    /**
     * Edit product page, quantity, price and discount.
     *
     * @group success
     * @group billCombined
     */
    public function testEditProductPageProductQuantityProductPriceAndProductDiscount() {

        $data = $this->generateData();

        // Edit product page first
        $post = [
            'product_id' => $data['product']->id,
            'bill_product_id' => $data['billProduct']->id,
            'product_code' => $data['product']->code,
            'product_page' => rand(1, 999)
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::editBillProductPage($data['bill']->id), $post)
            ->seeJson([
                'success' => true,
                'message' => trans('bill.page_updated')
            ])
            ->seeInDatabase('bill_products', [
                'id' => $data['billProduct']->id,
                'page' => $post['product_page']
            ]);

        // Edit product quantity
        unset($post['product_page']);
        $post['product_quantity'] = rand(1, 99);

        $newPrice = Products::newPrice($data['billProduct']->price, $data['billProduct']->quantity, $post['product_quantity']);
        $newCalculatedDiscount = Products::discount($newPrice, $data['billProduct']->discount);
        $newFinalPrice = $newPrice - $newCalculatedDiscount;

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::editBillProductQuantity($data['bill']->id), $post)
            ->seeJson([
                'success' => true,
                'message' => trans('bill.quantity_updated')
            ])
            ->seeInDatabase('bill_products', [
                'id' => $data['billProduct']->id,
                'price' => $newPrice,
                'calculated_discount' => $newCalculatedDiscount,
                'final_price' => $newFinalPrice
            ]);

        $data['billProduct']->quantity = $post['product_quantity'];

        // Edit product price
        unset($post['product_quantity']);
        $post['product_price'] = rand(1, 200);

        $newCalculatedDiscount = Products::discount($post['product_price'] * $data['billProduct']->quantity, $data['billProduct']->discount);
        $newFinalPrice = $post['product_price'] * $data['billProduct']->quantity - $newCalculatedDiscount;

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::editBillProductPrice($data['bill']->id), $post)
            ->seeJson([
                'success' => true,
                'message' => trans('bill.price_updated')
            ])
            ->seeInDatabase('bill_products', [
                'id' => $data['billProduct']->id,
                'calculated_discount' => $newCalculatedDiscount,
                'final_price' => $newFinalPrice
            ]);

        $data['billProduct']->price = $post['product_price'] * $data['billProduct']->quantity;

        // And finally edit product discount
        unset($post['product_price']);
        $post['product_discount'] = rand(0, 100);

        $newCalculatedDiscount = Products::discount($data['billProduct']->price, $post['product_discount']);

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::editBillProductDiscount($data['bill']->id), $post)
            ->seeJson([
                'success' => true,
                'message' => trans('bill.discount_updated')
            ])
            ->seeInDatabase('bill_products', [
                'id' => $data['billProduct']->id,
                'calculated_discount' => $newCalculatedDiscount,
                'final_price' => $data['billProduct']->price - $newCalculatedDiscount
            ]);

    }

}