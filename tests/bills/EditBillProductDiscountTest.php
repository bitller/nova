<?php
use App\Helpers\Products;
use App\Helpers\TestUrlBuilder;

/**
 * Test edit bill product discount functionality
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class EditBillProductDiscount extends BaseTest {

    /**
     * Edit bill product discount.
     *
     * @group success
     * @group editBillProduct
     * @group editBillProductDiscount
     */
    public function testEditBillProductDiscount() {

        $data = $this->generateData();

        $post = [
            'product_id' => $data['product']->id,
            'bill_product_id' => $data['billProduct']->id,
            'product_code' => $data['product']->code,
            'product_discount' => rand(0, 100)
        ];

        $calculatedDiscount = Products::discount($data['product']->price * $data['product']->quantity, $post['product_discount']);
        $finalPrice = $data['product']->price - $calculatedDiscount;

        $this->actingAs($data['user'])
            ->post(\App\Helpers\TestUrlBuilder::editBillProductDiscount($data['bill']->id), $post)
            ->seeJson([
                'success' => true,
                'message' => trans('bill.discount_updated')
            ])
            ->seeInDatabase('bill_products', [
                'id' => $post['bill_product_id'],
                'discount' => $post['product_discount'],
                'calculated_discount' => $calculatedDiscount,
                'final_price' => $finalPrice
            ]);

    }

    /**
     * Edit bill product discount with empty data.
     *
     * @group fail
     * @group editBillProduct
     * @group editBillProductDiscount
     */
    public function testEditBillProductDiscountWithEmptyData() {

        $data = $this->generateData();

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::editBillProductDiscount($data['bill']->id))
            ->seeJson([
                'success' => false,
                'message' => trans('validation.required', ['attribute' => trans('validation.attributes.product_discount')])
            ]);

    }

    /**
     * Edit bill product discount with empty product id.
     *
     * @group fail
     * @group editBillProduct
     * @group editBillProductDiscount
     */
    public function testEditBillProductDiscountWithEmptyProductId() {

        $data = $this->generateData();

        $post = [
            'bill_product_id' => $data['billProduct']->id,
            'product_code' => $data['product']->code,
            'product_discount' => rand(0, 100)
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::editBillProductDiscount($data['bill']->id), $post)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.required', ['attribute' => trans('validation.attributes.product_id')])
            ]);

    }

    /**
     * Edit bill product discount with invalid product id.
     *
     * @group fail
     * @group editBillProduct
     * @group editBillProductDiscount
     */
    public function testEditBillProductDiscountWithInvalidProductId() {

        $data = $this->generateData();

        $post = [
            'product_id' => 'btl',
            'bill_product_id' => $data['billProduct']->id,
            'product_code' => $data['product']->code,
            'product_discount' => rand(0, 100)
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::editBillProductDiscount($data['bill']->id), $post)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.numeric', ['attribute' => trans('validation.attributes.product_id')])
            ]);

    }

    /**
     * Edit bill product discount using product id of another product.
     *
     * @group fail
     * @group editBillProduct
     * @group editBillProductDiscount
     */
    public function testEditBillProductDiscountWithProductIdOfAnotherProduct() {

        $data = $this->generateData();

        // Generate another product
        $secondProduct = $data['user']->products()->save(factory(App\Product::class)->make());

        $post = [
            'product_id' => $secondProduct->id,
            'bill_product_id' => $data['billProduct']->id,
            'product_code' => $data['product']->code,
            'product_discount' => rand(0, 100)
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::editBillProductDiscount($data['bill']->id), $post)
            ->seeJson([
                'success' => false,
                'message' => trans('common.general_error')
            ]);

    }

    /**
     * Edit bill product discount with empty bill product id.
     *
     * @group fail
     * @group editBillProduct
     * @group editBillProductDiscount
     */
    public function testEditBillProductDiscountWithEmptyBillProductId() {

        $data = $this->generateData();

        $post = [
            'product_id' => $data['product']->id,
            'product_code' => $data['product']->code,
            'product_discount' => rand(0, 100)
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::editBillProductDiscount($data['bill']->id), $post)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.required', ['attribute' => trans('validation.attributes.bill_product_id')])
            ]);

    }

    /**
     * Edit bill product discount with invalid bill product id.
     *
     * @group fail
     * @group editBillProduct
     * @group editBillProductDiscount
     */
    public function testEditBillProductDiscountWithInvalidBillProductId() {

        $data = $this->generateData();

        $post = [
            'product_id' => $data['product']->id,
            'bill_product_id' => 'btl2',
            'product_code' => $data['product']->code,
            'product_discount' => rand(0, 100)
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::editBillProductDiscount($data['bill']->id), $post)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.numeric', ['attribute' => trans('validation.attributes.bill_product_id')])
            ]);

    }

    /**
     * Edit bill product discount with empty product code.
     *
     * @group fail
     * @group editBillProduct
     * @group editBillProductDiscount
     */
    public function testEditBillProductDiscountWithEmptyProductCode() {

        $data = $this->generateData();

        $post = [
            'product_id' => $data['product']->id,
            'bill_product_id' => $data['billProduct']->id,
            'product_discount' => rand(0, 100)
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::editBillProductDiscount($data['bill']->id), $post)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.required', ['attribute' => trans('validation.attributes.product_code')])
            ]);

    }

    /**
     * Edit bill product discount with invalid product code.
     *
     * @group fail
     * @group editBillProduct
     * @group editBillProductDiscount
     */
    public function testEditBillProductDiscountWithInvalidProductCode() {

        $data = $this->generateData();

        $post = [
            'product_id' => $data['product']->id,
            'bill_product_id' => $data['billProduct']->id,
            'product_code' => 'btl04',
            'product_discount' => rand(0, 100)
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::editBillProductDiscount($data['bill']->id), $post)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.digits', ['attribute' => trans('validation.attributes.product_code'), 'digits' => '5'])
            ]);

    }

    /**
     * Edit bill product discount using product code of another user.
     *
     * @group fail
     * @group editBillProduct
     * @group editBillProductDiscount
     */
    public function testEditBillProductDiscountWithProductCodeOfAnotherUser() {

        $firstData = $this->generateData();
        $secondData = $this->generateData();

        $post = [
            'product_id' => $firstData['product']->id,
            'bill_product_id' => $firstData['billProduct']->id,
            'product_code' => $secondData['product']->code,
            'product_discount' => rand(0, 100)
        ];

        $this->actingAs($firstData['user'])
            ->post(TestUrlBuilder::editBillProductDiscount($firstData['bill']->id), $post)
            ->seeJson([
                'success' => false,
                'message' => trans('common.general_error')
            ]);

    }

    /**
     * Edit bill product discount using product code of another product.
     *
     * @group fail
     * @group editBillProduct
     * @group editBillProductDiscount
     */
    public function testEditBillProductDiscountWithProductCodeOfAnotherProduct() {

        $data = $this->generateData();

        // Generate another product
        $secondProduct = $data['user']->products()->save(factory(App\Product::class)->make());

        $post = [
            'product_id' => $data['product']->id,
            'bill_product_id' => $data['billProduct']->id,
            'product_code' => $secondProduct->code,
            'product_discount' => rand(0, 100)
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::editBillProductDiscount($data['bill']->id), $post)
            ->seeJson([
                'success' => false,
                'message' => trans('common.general_error')
            ]);

    }

    /**
     * Edit bill product discount using product id and bill product id of another product.
     *
     * @group fail
     * @group editBillProduct
     * @group editBillProductDiscount
     */
    public function testEditBillProductDiscountWithProductIdAndBillProductIdOfAnotherProduct() {

        $data = $this->generateData();

        // Generate another product and add to bill
        $secondProduct = $data['user']->products()->save(factory(App\Product::class)->make());
        $secondBillProduct = $data['bill']->products()->save(factory(App\BillProduct::class)->make(['product_id' => $secondProduct->id]));

        $post = [
            'product_id' => $secondProduct->id,
            'bill_product_id' => $secondBillProduct->id,
            'product_code' => $data['product']->code,
            'product_discount' => rand(0, 100)
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::editBillProductDiscount($data['bill']->id), $post)
            ->seeJson([
                'success' => false,
                'message' => trans('common.general_error')
            ]);

    }

}