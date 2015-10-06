<?php
use App\Helpers\TestUrlBuilder;

/**
 * Tests for edit bill product quantity functionality
 *
 * @author Alexandru Bugairn <alexandru.bugarin@gmail.com>
 */
class EditBillQuantityTest extends TestCase {

    use \Illuminate\Foundation\Testing\DatabaseTransactions;

    /**
     * Edit bill product quantity.
     *
     * @group success
     * @group editBillProduct
     * @group editBillProductQuantity
     */
    public function testEditBillProductQuantity() {

        $data = $this->generateData();

        $post = [
            'product_id' => $data['product']->id,
            'bill_product_id' => $data['billProduct']->id,
            'product_code' => $data['product']->code,
            'product_quantity' =>  rand(1, 100)
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::editBillProductQuantity($data['bill']->id), $post)
            ->seeJson([
                'success' => true,
                'message' => trans('bill.quantity_updated')
            ])
            ->seeInDatabase('bill_products', [
                'id' => $data['billProduct']->id,
                'quantity' => $post['product_quantity']
            ]);

    }

    /**
     * Edit bill product quantity with empty data.
     *
     * @group fail
     * @group editBillProduct
     * @group editBillProductQuantity
     */
    public function testEditBillProductQuantityWithEmptyData() {

        $data = $this->generateData();

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::editBillProductQuantity($data['bill']->id))
            ->seeJson([
                'success' => false,
                'message' => trans('validation.required', ['attribute' => trans('validation.attributes.product_quantity')])
            ]);

    }

    /**
     * Edit bill product quantity with empty bill id.
     *
     * @group fail
     * @group editBillProduct
     * @group editBillProductQuantity
     */
    public function testEditBillProductQuantityWithEmptyProductId() {

        $data = $this->generateData();

        $post = [
            'bill_product_id' => $data['billProduct']->id,
            'product_code' => $data['product']->code,
            'product_quantity' => rand(1, 100)
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::editBillProductQuantity($data['bill']->id), $post)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.required', ['attribute' => trans('validation.attributes.product_id')])
            ]);

    }

    /**
     * Edit bill product quantity with invalid bill id.
     *
     * @group fail
     * @group editBillProduct
     * @group editBillProductQuantity
     */
    public function testEditBillProductQuantityWithInvalidProductId() {

        $data = $this->generateData();

        $post = [
            'product_id' => 'btl4',
            'bill_product_id' => $data['billProduct']->id,
            'product_code' => $data['product']->code,
            'product_quantity' => rand(1, 100)
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::editBillProductQuantity($data['bill']->id), $post)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.numeric', ['attribute' => trans('validation.attributes.product_id')])
            ]);

    }

    /**
     * Edit bill product quantity with product id of another product.
     *
     * @group fail
     * @group editBillProduct
     * @group editBillProductQuantity
     */
    public function testEditBillProductQuantityWithProductIdOfAnotherProduct() {

        $data = $this->generateData();

        // Generate another product
        $secondProduct = $data['user']->products()->save(factory(App\Product::class)->make());

        $post = [
            'product_id' => $secondProduct->id,
            'bill_product_id' => $data['product']->id,
            'product_code' => $data['product']->code,
            'product_quantity' => rand(1, 100)
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::editBillProductQuantity($data['bill']->id), $post)
            ->seeJson([
                'success' => false,
                'message' => trans('common.general_error')
            ]);

    }

    /**
     * Edit bill product quantity with empty bill product id.
     *
     * @group fail
     * @group editBillProduct
     * @group editBillProductQuantity
     */
    public function testEditBillProductQuantityWithEmptyBillProductId() {

        $data = $this->generateData();

        $post = [
            'product_id' => $data['product']->id,
            'product_code' => $data['product']->code,
            'product_quantity' => rand(1, 100)
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::editBillProductQuantity($data['bill']->id), $post)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.required', ['attribute' => trans('validation.attributes.bill_product_id')])
            ]);

    }

    /**
     * Edit bill product quantity with invalid bill product id.
     *
     * @group fail
     * @group editBillProduct
     * @group editBillProductQuantity
     */
    public function testEditBillProductQuantityWithInvalidBillProductId() {

        $data = $this->generateData();

        $post = [
            'product_id' => $data['product']->id,
            'bill_product_id' => 'btl4',
            'product_code' => $data['product']->code,
            'product_quantity' => rand(1, 100)
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::editBillProductQuantity($data['bill']->id), $post)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.numeric', ['attribute' => trans('validation.attributes.bill_product_id')])
            ]);

    }

    /**
     * Edit bill product quantity with empty product code.
     *
     * @group fail
     * @group editBillProduct
     * @group editBillProductQuantity
     */
    public function testEditBillProductQuantityWithEmptyProductCode() {

        $data = $this->generateData();

        $post = [
            'product_id' => $data['product']->id,
            'bill_product_id' => $data['billProduct']->id,
            'product_quantity' => rand(1, 100)
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::editBillProductQuantity($data['bill']->id), $post)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.required', ['attribute' => trans('validation.attributes.product_code')])
            ]);

    }

    /**
     * Test edit bill product quantity with invalid product code.
     *
     * @group fail
     * @group editBillProduct
     * @group editBillProductQuantity
     */
    public function testEditBillProductQuantityWithInvalidProductCode() {

        $data = $this->generateData();

        $post = [
            'product_id' => $data['product']->id,
            'bill_product_id' => $data['billProduct']->id,
            'product_code' => 'btl04',
            'product_quantity' => rand(1, 100)
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::editBillProductQuantity($data['bill']->id), $post)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.digits', ['attribute' => trans('validation.attributes.product_code'), 'digits' => '5'])
            ]);

    }

    /**
     * Edit bill product quantity with product code of another user.
     *
     * @group fail
     * @group editBillProduct
     * @group editBillProductQuantity
     */
    public function testEditBillProductQuantityWithProductCodeOfAnotherUser() {

        $firstData = $this->generateData();
        $secondData = $this->generateData();

        $post = [
            'product_id' => $firstData['product']->id,
            'bill_product_id' => $firstData['product']->id,
            'product_code' => $secondData['product']->code,
            'product_quantity' => rand(1, 100)
        ];

        $this->actingAs($firstData['user'])
            ->post(TestUrlBuilder::editBillProductQuantity($firstData['bill']->id), $post)
            ->seeJson([
                'success' => false,
                'message' => trans('common.general_error')
            ]);

    }

    /**
     * Edit bill product quantity with product code of another product.
     *
     * @group fail
     * @group editBillProduct
     * @group editBillProductQuantity
     */
    public function testEditBillProductQuantityWithProductCodeOfAnotherProduct() {

        $data = $this->generateData();

        // Generate another product
        $product = $data['user']->products()->save(factory(App\Product::class)->make());

        $post = [
            'product_id' => $data['product']->id,
            'bill_product_id' => $data['billProduct']->id,
            'product_code' => $product->code,
            'product_quantity' => rand(1, 100)
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::editBillProductQuantity($data['bill']->id), $post)
            ->seeJson([
                'success' => false,
                'message' => trans('common.general_error')
            ]);

    }

    /**
     * Edit bill product quantity using product id and bill product id of another product.
     *
     * @group fail
     * @group editBillProduct
     * @group editBillProductQuantity
     */
    public function testEditBillProductQuantityWithProductIdAndBillProductIdOfAnotherProduct() {

        $data = $this->generateData();

        // Generate another product and add to bill
        $product = $data['user']->products()->save(factory(App\Product::class)->make());
        $billProduct = $data['bill']->products()->save(factory(App\BillProduct::class)->make(['product_id' => $product->id]));

        $post = [
            'product_id' => $product->id,
            'bill_product_id' => $billProduct->id,
            'product_code' => $data['product']->code,
            'product_quantity' => rand(1, 100)
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::editBillProductQuantity($data['bill']->id), $post)
            ->seeJson([
                'success' => false,
                'message' => trans('common.general_error')
            ]);

    }
}