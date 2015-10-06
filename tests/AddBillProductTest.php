<?php
use App\Helpers\TestUrlBuilder;


/**
 * Test add bill product functionality
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class AddBillProductTest extends TestCase {

    /**
     * Add a bill product.
     *
     * @group success
     * @group addBillProduct
     */
    public function testAddBillProduct() {

        $data = $this->generateAddBillData();

        $post = [
            'product_code' => $data['product']->code,
            'product_page' => rand(1, 999),
            'product_price' => rand(1, 999),
            'product_discount' => rand(0, 100),
            'product_quantity' => rand(1, 99)
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::addBillProduct($data['bill']->id), $post)
            ->seeJson([
                'success' => true,
                'message' => trans('bill.product_added_successfully')
            ]);

    }

    /**
     * Add bill application product.
     *
     * @group success
     * @group addBillProduct
     */
    public function testAddBillApplicationProduct() {

        $data = $this->generateAddBillData(true);

        $post = [
            'product_code' => $data['product']->code,
            'product_page' => rand(1, 999),
            'product_price' => rand(1, 999),
            'product_discount' => rand(0, 100),
            'product_quantity' => rand(1, 99)
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::addBillProduct($data['bill']->id), $post)
            ->seeJson([
                'success' => true,
                'message' => trans('bill.product_added_successfully')
            ]);

    }

    /**
     * Add bill product with empty post data.
     *
     * @group fail
     * @group addBillProduct
     */
    public function testAddBillProductWithEmptyData() {

        $data = $this->generateAddBillData();

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::addBillProduct($data['bill']->id))
            ->seeJson([
                'success' => false,
                'message' => trans('validation.required', ['attribute' => trans('validation.attributes.product_price')])
            ]);

    }

    /**
     * Add bill product with empty product code.
     *
     * @group fail
     * @group addBillProduct
     */
    public function testAddBillProductWithEmptyProductCode() {

        $data = $this->generateAddBillData();

        $post = [
            'product_page' => rand(1, 999),
            'product_price' => rand(1, 999),
            'product_discount' => rand(0, 100),
            'product_quantity' => rand(1, 99)
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::addBillProduct($data['bill']->id), $post)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.required', ['attribute' => trans('validation.attributes.product_code')])
            ]);

    }

    /**
     * Add bill product with invalid product code.
     *
     * @group fail
     * @group addBillProduct
     */
    public function testAddBillProductWithInvalidProductCode() {

        $data = $this->generateAddBillData();

        $post = [
            'product_code' => 'btl04',
            'product_page' => rand(1, 999),
            'product_price' => rand(1, 999),
            'product_discount' => rand(0, 100),
            'product_quantity' => rand(1, 99)
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::addBillProduct($data['bill']->id), $post)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.digits', ['attribute' => trans('validation.attributes.product_code'), 'digits' => '5'])
            ]);

    }

    /**
     * Add bill product with empty product page.
     *
     * @group fail
     * @group addBillProduct
     */
    public function testAddBillProductWithEmptyProductPage() {

        $data = $this->generateAddBillData();

        $post = [
            'product_code' => $data['product']->code,
            'product_page' => "",
            'product_price' => rand(1, 999),
            'product_discount' => rand(0, 100),
            'product_quantity' => rand(1, 99)
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::addBillProduct($data['bill']->id), $post)
            ->seeJson([
                'success' => true,
                'message' => trans('bill.product_added_successfully')
            ]);

    }

    /**
     * Add bill product with invalid product page.
     *
     * @group fail
     * @group addBillProduct
     */
    public function testAddBillProductWithInvalidProductPage() {

        $data = $this->generateAddBillData();

        $post = [
            'product_code' => $data['product']->code,
            'product_page' => 'btl4',
            'product_price' => rand(1, 999),
            'product_discount' => rand(0, 100),
            'product_quantity' => rand(1, 99)
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::addBillProduct($data['bill']->id), $post)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.numeric', ['attribute' => trans('validation.attributes.product_page')])
            ]);

    }

    /**
     * Add bill product with too small and too big product page.
     *
     * @group fail
     * @group addBillProduct
     */
    public function testAddBillProductWithTooSmallAndTooBigProductPage() {

        $data = $this->generateAddBillData();

        $post = [
            'product_code' => $data['product']->code,
            'product_page' => rand(-900, -1),
            'product_price' => rand(1, 999),
            'product_discount' => rand(0, 100),
            'product_quantity' => rand(1, 99)
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::addBillProduct($data['bill']->id), $post)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.between.numeric', ['attribute' => trans('validation.attributes.product_page'), 'min' => '1', 'max' => '2000'])
            ]);

    }

    /**
     * Add bill product with empty product price.
     *
     * @group fail
     * @group addBillProduct
     */
    public function testAddBillProductWithEmptyProductPrice() {

        $data = $this->generateAddBillData();

        $post = [
            'product_code' => $data['product']->code,
            'product_page' => rand(1, 999),
            'product_price' => '',
            'product_discount' => rand(0, 100),
            'product_quantity' => rand(1, 99)
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::addBillProduct($data['bill']->id), $post)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.required', ['attribute' => trans('validation.attributes.product_price')])
            ]);

    }

    /**
     * Add bill product with invalid product price.
     *
     * @group fail
     * @group addBillProduct
     */
    public function testAddBillProductWithInvalidProductPrice() {

        $data = $this->generateAddBillData();

        $post = [
            'product_code' => $data['product']->code,
            'product_page' => rand(1, 999),
            'product_price' => 'btl',
            'product_discount' => rand(0, 100),
            'product_quantity' => rand(1, 99)
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::addBillProduct($data['bill']->id), $post)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.numeric', ['attribute' => trans('validation.attributes.product_price')])
            ]);

    }

    /**
     * Add bill product with too small and too big product price
     *
     * @group fail
     * @group addBillProduct
     */
    public function testAddBillProductWithTooSmallAndTooBigProductPrice() {

        $data = $this->generateAddBillData();

        $post = [
            'product_code' => $data['product']->code,
            'product_page' => rand(1, 999),
            'product_price' => rand(10000, 100000),
            'product_discount' => rand(0, 100),
            'product_quantity' => rand(1, 99)
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::addBillProduct($data['bill']->id), $post)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.between.numeric', ['attribute' => trans('validation.attributes.product_price'), 'min' => 0, 'max' => 9999])
            ]);

    }

    /**
     * Add bill product with empty product discount.
     *
     * @group fail
     * @group addBillProduct
     */
    public function testAddBillProductWithEmptyProductDiscount() {

        $data = $this->generateAddBillData();

        $post = [
            'product_code' => $data['product']->code,
            'product_page' => rand(1, 999),
            'product_price' => rand(1, 999),
            'product_discount' => "",
            'product_quantity' => rand(0, 99)
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::addBillProduct($data['bill']->id), $post)
            ->seeJson([
                'success' => true,
                'message' => trans('bill.product_added_successfully')
            ]);

    }

    /**
     * Add bill product with invalid product discount.
     *
     * @group fail
     * @group addBillProduct
     */
    public function testAddBillProductWithInvalidProductDiscount() {

        $data = $this->generateAddBillData();

        $post = [
            'product_code' => $data['product']->code,
            'product_page' => rand(1, 999),
            'product_price' => rand(1, 999),
            'product_discount' => 'btl',
            'product_quantity' => rand(1, 99)
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::addBillProduct($data['bill']->id), $post)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.numeric', ['attribute' => trans('validation.attributes.product_discount')])
            ]);

    }

    /**
     * Add bill product with empty product quantity.
     *
     * @group fail
     * @group addBillProduct
     */
    public function testAddBillProductWithEmptyProductQuantity() {

        $data = $this->generateAddBillData();

        $post = [
            'product_code' => $data['product']->code,
            'product_page' => rand(1, 999),
            'product_price' => rand(1, 999),
            'product_discount' => rand(0, 100),
            'product_quantity' => ''
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::addBillProduct($data['bill']->id), $post)
            ->seeJson([
                'success' => true,
                'message' => trans('bill.product_added_successfully')
            ]);

    }

    /**
     * Add bill product with invalid product quantity.
     *
     * @group fail
     * @group addBillProduct
     */
    public function testAddBillProductWithInvalidProductQuantity() {

        $data = $this->generateAddBillData();

        $post = [
            'product_code' => $data['product']->code,
            'product_page' => rand(1, 999),
            'product_price' => rand(1, 999),
            'product_discount' => rand(0, 100),
            'product_quantity' => 'btl'
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::addBillProduct($data['bill']->id), $post)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.numeric', ['attribute' => trans('validation.attributes.product_quantity')])
            ]);

    }

    /**
     * Add bill product with too long and too short product quantity.
     *
     * @group fail
     * @group addBillProduct
     */
    public function testAddBillProductWithTooSmallAndTooBigProductQuantity() {

        $data = $this->generateAddBillData();

        $post = [
            'product_code' => $data['product']->code,
            'product_page' => rand(1, 999),
            'product_price' => rand(1, 999),
            'product_discount' => rand(0, 100),
            'product_quantity' => rand(1000, 9999)
        ];

        $this->actingAs($data['user'])
            ->post(TestUrlBuilder::addBillProduct($data['bill']->id), $post)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.between.numeric', ['attribute' => trans('validation.attributes.product_quantity'), 'min' => 1, 'max' => 999])
            ]);

    }

}