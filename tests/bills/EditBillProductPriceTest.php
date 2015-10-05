<?php
use App\Helpers\TestUrlBuilder;

/**
 * Test edit bill product price functionality
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class EditBillProductPriceTest extends BaseTest {

    /**
     * Edit bill product price.
     *
     * @group success
     * @group editBillProduct
     * @group editBillProductPrice
     */
    public function testEditBillProductPrice() {

        $data = $this->generateData();

        $post = [
            'product_id' => $data['product']->id,
            'bill_product_id' => $data['billProduct']->id,
            'product_code' => $data['product']->code,
            'product_price' => rand(1, 99)
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::editBillProductPrice($data['bill']->id), $post)
            ->seeJson([
                'success' => true,
                'message' => trans('bill.price_updated')
            ])
            ->seeInDatabase('bill_products', [
                'id' => $data['billProduct']->id,
                'price' => $post['product_price']
            ]);
    }

    /**
     * Edit bill product price with empty data.
     *
     * @group fail
     * @group editBillProduct
     * @group editBillProductPrice
     */
    public function testEditBillProductPriceWithEmptyData() {

        $data = $this->generateData();

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::editBillProductPrice($data['bill']->id))
            ->seeJson([
                'success' => false,
                'message' => trans('validation.required', ['attribute' => trans('validation.attributes.product_price')])
            ]);

    }

    /**
     * Edit bill product price with empty product id.
     *
     * @group fail
     * @group editBillProduct
     * @group editBillProductPrice
     */
    public function testEditBillProductPriceWithEmptyProductId() {

        $data = $this->generateData();

        $post = [
            'bill_product_id' => $data['billProduct']->id,
            'product_code' => $data['product']->code,
            'product_price' => rand(1, 999)
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::editBillProductPrice($data['bill']->id), $post)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.required', ['attribute' => trans('validation.attributes.product_id')])
            ]);

    }

    /**
     * Edit bill product price with invalid product id.
     *
     * @group fail
     * @group editBillProduct
     * @group editBillProductPrice
     */
    public function testEditBillProductPriceWithInvalidProductId() {

        $data = $this->generateData();

        $post = [
            'product_id' => 'btl4',
            'bill_product_id' => $data['billProduct']->id,
            'product_code' => $data['product']->code,
            'product_price' => rand(1, 999)
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::editBillProductPrice($data['bill']->id), $post)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.numeric', ['attribute' => trans('validation.attributes.product_id')])
            ]);

    }

    /**
     * Edit bill product price with product id of another product.
     *
     * @group fail
     * @group editBillProduct
     * @group editBillProductPrice
     */
    public function testEditBillProductPriceWithProductIdOfAnotherProduct() {

        $data = $this->generateData();

        $anotherProduct = $data['user']->products()->save(factory(App\Product::class)->make());

        $post = [
            'product_id' => $anotherProduct->id,
            'bill_product_id' => $data['billProduct']->id,
            'product_code' => $data['product']->code,
            'product_price' => rand(1, 999)
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::editBillProductPrice($data['bill']->id), $post)
            ->seeJson([
                'success' => false,
                'message' => trans('common.general_error')
            ]);

    }

    /**
     * Edit bill product price with empty bill product id.
     *
     * @group fail
     * @group editBillProduct
     * @group editBillProductPrice
     */
    public function testEditBillProductPriceWithEmptyBillProductId() {

        $data = $this->generateData();

        $post = [
            'product_id' => $data['product']->id,
            'product_code' => $data['product']->code,
            'product_price' => rand(1, 999)
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::editBillProductPrice($data['bill']->id), $post)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.required', ['attribute' => trans('validation.attributes.bill_product_id')])
            ]);

    }

    /**
     * Edit bill product price with invalid bill product id.
     *
     * @group fail
     * @group editBillProduct
     * @group editBillProductPrice
     */
    public function testEditBillProductPriceWithInvalidBillProductId() {

        $data = $this->generateData();

        $post = [
            'product_id' => $data['product']->id,
            'bill_product_id' => 'btl4',
            'product_code' => $data['product']->code,
            'product_price' => rand(1, 999)
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::editBillProductPrice($data['bill']->id), $post)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.numeric', ['attribute' => trans('validation.attributes.bill_product_id')])
            ]);

    }

    /**
     * Edit bill product price with empty product code.
     *
     * @group fail
     * @group editBillProduct
     * @group editBillProductPrice
     */
    public function testEditBillProductPriceWithEmptyProductCode() {

        $data = $this->generateData();

        $post = [
            'product_id' => $data['product']->id,
            'bill_product_id' => $data['billProduct']->id,
            'product_price' => rand(1, 999)
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::editBillProductPrice($data['bill']->id), $post)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.required', ['attribute' => trans('validation.attributes.product_code')])
            ]);

    }

    /**
     * Edit bill product price with invalid product code.
     *
     * @group fail
     * @group editBillProduct
     * @group editBillProductPrice
     */
    public function testEditBillProductPriceWithInvalidProductCode() {

        $data = $this->generateData();

        $post = [
            'product_id' => $data['product']->id,
            'bill_product_id' => $data['billProduct']->id,
            'product_code' => 'btl04',
            'product_price' => rand(1, 999)
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::editBillProductPrice($data['bill']->id), $post)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.digits', ['attribute' => trans('validation.attributes.product_code'), 'digits' => '5'])
            ]);

    }

    /**
     * Edit bill product price with product code that belongs to another user.
     *
     * @group fail
     * @group editBillProduct
     * @group editBillProductPrice
     */
    public function testEditBillProductPriceWithProductCodeOfAnotherUser() {

        $firstData = $this->generateData();
        $secondData = $this->generateData();

        $post = [
            'product_id' => $firstData['product']->id,
            'bill_product_id' => $firstData['billProduct']->id,
            'product_code' => $secondData['product']->code,
            'product_price' => rand(1, 999)
        ];

        $this->actingAs($firstData['user'])
            ->post(TestUrlBuilder::editBillProductPrice($firstData['bill']->id), $post)
            ->seeJson([
                'success' => false,
                'message' => trans('common.general_error')
            ]);

    }

    /**
     * Edit bill product price with product code of another product.
     *
     * @group fail
     * @group editBillProduct
     * @group editBillProductPrice
     */
    public function testEditBillProductPriceWithProductCodeOfAnotherProduct() {

        $data = $this->generateData();

        // Generate another product
        $secondProduct = $data['user']->products()->save(factory(App\Product::class)->make());

        $post = [
            'product_id' => $data['product']->id,
            'bill_product_id' => $data['billProduct']->id,
            'product_code' => $secondProduct->code,
            'product_price' => rand(1, 999)
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::editBillProductPrice($data['bill']->id), $post)
            ->seeJson([
                'success' => false,
                'message' => trans('common.general_error')
            ]);
    }

    /**
     * Edit bill product price using product id and bill product id of another product.
     *
     * @group fail
     * @group editBillProduct
     * @group editBillProductPrice
     */
    public function testEditBillProductPriceWithProductIdAndBillProductIdOfAnotherProduct() {

        $data = $this->generateData();

        // Generate another product and add to bill
        $secondProduct = $data['user']->products()->save(factory(App\Product::class)->make());
        $secondBillProduct = $data['bill']->products()->save(factory(App\BillProduct::class)->make(['product_id' => $secondProduct->id]));

        $post = [
            'product_id' => $secondProduct->id,
            'bill_product_id' => $secondBillProduct->id,
            'product_code' => $data['product']->code,
            'product_price' => rand(1, 999)
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::editBillProductPrice($data['bill']->id), $post)
            ->seeJson([
                'success' => false,
                'message' => trans('common.general_error')
            ]);

    }

}