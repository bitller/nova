<?php
use App\Helpers\TestUrlBuilder;

/**
 * Tests for edit bill product page functionality
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class EditBillProductPageTest extends TestCase {

    use \Illuminate\Foundation\Testing\DatabaseTransactions;

    /**
     * Edit bill product page.
     *
     * @group success
     * @group editBillProduct
     * @group editBillProductPage
     */
    public function testEditBillProductPage() {

        $data = $this->generateData();

        $post = [
            'product_id' => $data['product']->id,
            'bill_product_id' => $data['billProduct']->id,
            'product_code' => $data['product']->code,
            'product_page' => rand(1, 999)
        ];

        // Check json response and make sure page was updated in database
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

    }

    /**
     * Edit bill product page with empty post data.
     *
     * @group fail
     * @group editBillProduct
     * @group editBillProductPage
     */
    public function testEditBillProductPageWithEmptyData() {

        $data = $this->generateData();

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::editBillProductPage($data['bill']->id))
            ->seeJson([
                'success' => false,
                'message' => trans('validation.required', ['attribute' => trans('validation.attributes.product_page')])
            ]);

    }

    /**
     * Edit bill product page with empty product id.
     *
     * @group fail
     * @group editBillProduct
     * @group editBillProductPage
     */
    public function testEditBillProductPageWithEmptyProductId() {

        $data = $this->generateData();

        $post = [
            'bill_product_id' => $data['billProduct']->id,
            'product_code' => $data['product']->code,
            'product_page' => rand(1, 999)
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::editBillProductPage($data['bill']->id), $post)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.required', ['attribute' => trans('validation.attributes.product_id')])
            ]);

    }

    /**
     * Edit bill product page with invalid product id.
     *
     * @group fail
     * @group editBillProduct
     * @group editBillProductPage
     */
    public function testEditBillProductPageWithInvalidProductId() {

        $data = $this->generateData();

        $post = [
            'product_id' => 'btl4',
            'bill_product_id' => $data['billProduct']->id,
            'product_code' => $data['product']->code,
            'product_page' => rand(1, 999)
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::editBillProductPage($data['bill']->id), $post)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.numeric', ['attribute' => trans('validation.attributes.product_id')])
            ]);

    }

    /**
     * Edit bill product page with product id of another product.
     *
     * @group fail
     * @group editBillProduct
     * @group editBillProductPage
     */
    public function testEditBillProductPageWithProductIdOfAnotherProduct() {

        $data = $this->generateData();

        // Generate another product for current user
        $secondProduct = $data['user']->products()->save(factory(App\Product::class)->make());

        $post = [
            'product_id' => $secondProduct['id'],
            'bill_product_id' => $data['billProduct']->id,
            'product_code' => $data['product']->code,
            'product_page' => rand(1, 999)
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::editBillProductPage($data['bill']->id), $post)
            ->seeJson([
                'success' => false,
                'message' => trans('common.general_error')
            ]);

    }

    /**
     * Edit bill product page with empty bill product id.
     *
     * @group fail
     * @group editBillProduct
     * @group editBillProductPage
     */
    public function testEditBillProductPageWithEmptyBillProductId() {

        $data = $this->generateData();

        $post = [
            'product_id' => $data['product']->id,
            'product_code' => $data['product']->code,
            'product_page' => rand(1, 999)
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::editBillProductPage($data['bill']->id), $post)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.required', ['attribute' => trans('validation.attributes.bill_product_id')])
            ]);

    }

    /**
     * Edit bill product page with invalid bill product id.
     *
     * @group fail
     * @group editBillProduct
     * @group editBillProductPage
     */
    public function testEditBillProductPageWithInvalidBillProductId() {

        $data = $this->generateData();

        $post = [
            'product_id' => $data['product']->id,
            'bill_product_id' => 'btl4',
            'product_code' => $data['product']->code,
            'product_page' => rand(1, 999)
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::editBillProductPage($data['bill']->id), $post)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.numeric', ['attribute' => trans('validation.attributes.bill_product_id')])
            ]);

    }

    /**
     * Edit bill product page with empty product code.
     *
     * @group fail
     * @group editBillProduct
     * @group editBillProductPage
     */
    public function testEditBillProductPageWithEmptyProductCode() {

        $data = $this->generateData();

        $post = [
            'product_id' => $data['product']->id,
            'bill_product_id' => $data['billProduct']->id,
            'product_page' => rand(1, 999)
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::editBillProductPage($data['bill']->id), $post)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.required', ['attribute' => trans('validation.attributes.product_code')])
            ]);

    }

    /**
     * Edit bill product page with invalid product code.
     *
     * @group fail
     * @group editBillProduct
     * @group editBillProductPage
     */
    public function testEditBillProductPageWithInvalidProductCode() {

        $data = $this->generateData();

        $post = [
            'product_id' => $data['product']->id,
            'bill_product_id' => $data['billProduct']->id,
            'product_code' => 'btl04',
            'product_page' => rand(1, 999)
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::editBillProductPage($data['bill']->id), $post)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.digits', ['attribute' => trans('validation.attributes.product_code'), 'digits' => '5'])
            ]);

    }

    /**
     * Edit bill product page with product code of another user.
     *
     * @group fail
     * @group editBillProduct
     * @group editBillProductPage
     */
    public function testEditBillProductPageWithProductCodeOfAnotherUser() {

        $firstData = $this->generateData();
        $secondData = $this->generateData();

        $post = [
            'product_id' => $firstData['product']->id,
            'bill_product_id' => $firstData['billProduct']->id,
            'product_code' => $secondData['product']->code,
            'product_page' => rand(1, 999)
        ];

        $this->actingAs($firstData['user'])
            ->post(TestUrlBuilder::editBillProductPage($firstData['bill']->id), $post)
            ->seeJson([
                'success' => false,
                'message' => trans('common.general_error')
            ]);

    }

    /**
     * Edit bill product page with code of another product of the same user.
     *
     * @group fail
     * @group editBillProduct
     * @group editBillProductPage
     */
    public function testEditBillProductPageWithProductCodeOfAnotherProduct() {

        $data = $this->generateData();

        // Generate another product for current user
        $secondProduct = $data['user']->products()->save(factory(App\Product::class)->make());

        $post = [
            'product_id' => $data['product']->id,
            'bill_product_id' => $data['billProduct']->id,
            'product_code' => $secondProduct->code,
            'product_page' => rand(1, 999)
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::editBillProductPage($data['bill']->id), $post)
            ->seeJson([
                'success' => false,
                'message' => trans('common.general_error')
            ]);

    }

    /**
     * Edit bill product page with product id and bill product id of another product.
     *
     * @group fail
     * @group editBillProduct
     * @group editBillProductPage
     */
    public function testEditBillProductPageWithProductIdAndBillProductIdOfAnotherProduct() {

        $data = $this->generateData();

        // Generate another product and add to bill
        $secondProduct = $data['user']->products()->save(factory(App\Product::class)->make());
        $secondBillProduct = $data['bill']->products()->save(factory(App\BillProduct::class)->make(['product_id' => $secondProduct->id]));

        $post = [
            'product_id' => $secondProduct->id,
            'bill_product_id' => $secondBillProduct->id,
            'product_code' => $data['product']->code,
            'product_page' => rand(1, 999)
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::editBillProductPage($data['bill']->id), $post)
            ->seeJson([
                'success' => false,
                'message' => trans('common.general_error')
            ]);

    }

}