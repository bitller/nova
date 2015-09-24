<?php

use App\Helpers\TestUrlBuilder;

/**
 * Contains tests for bill page
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class BillTest extends TestCase {

    use \Illuminate\Foundation\Testing\DatabaseTransactions;

    /**
     * Access bill page as logged in user. Bill page should be displayed.
     */
    public function testBillPage() {

        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());
        $bill = $user->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));

        $this->actingAs($user)
            ->visit('/bills/' . $bill->id)
            ->see($user->email);

    }

    /**
     * Access bill page as visitor. Redirect to login is expected.
     */
    public function testBillPageAsVisitor() {

        $this->visit('/bills/4')
            ->seePageIs('/login');

    }

    public function testBillProducts() {
        //
    }

    /*
     * --------------------------------------------------------------------------------------
     *      Edit product page tests
     * --------------------------------------------------------------------------------------
     */

    /**
     * Edit custom product page. Success message is expected.
     */
    public function testEditCustomProductPage() {

        // Generate user, client and bill
        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());
        $bill = $user->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));

        // Generate one product and add to bill
        $product = $user->products()->save(factory(App\Product::class)->make());
        $bill->products()->save(factory(App\BillProduct::class)->make(['product_id' => $product->id]));

        $data = [
            'product_id' => $product->id,
            'product_code' => $product->code,
            'product_page' => rand(1, 99)
        ];

        // Edit product page
        $this->actingAs($user)
            ->post(TestUrlBuilder::editBillProductPage($bill->id), $data)
            ->seeJson([
                'success' => true,
                'message' => trans('bill.page_updated')
            ]);

    }

    /**
     * Edit application product page. Success response is expected.
     */
    public function testEditApplicationProductPage() {

        // Generate user, client and bill
        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());
        $bill = $user->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));

        // Generate application product and add to bill
        $applicationProduct = factory(App\ApplicationProduct::class)->create();
        $bill->applicationProducts()->save(factory(App\BillApplicationProduct::class)->make(['product_id' => $applicationProduct->id]));

        $data = [
            'product_id' => $applicationProduct->id,
            'product_code' => $applicationProduct->code,
            'product_page' => rand(1, 99)
        ];

        // Edit application product page
        $this->actingAs($user)
            ->post(TestUrlBuilder::editBillProductPage($bill->id), $data)
            ->seeJson([
                'success' => true,
                'message' => trans('bill.page_updated')
            ]);

    }

    /**
     * Edit product page without posting any data.
     */
    public function editProductPageWithEmptyPostData() {

        // Generate user, client and bill
        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());
        $bill = $user->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));

        // Generate application product and add to bill
        $product = $user->products()->save(factory(App\Product::class)->make());
        $bill->products()->save(factory(App\BillProduct::class)->make(['product_id' => $product->id]));

        $this->actingAs($user)
            ->post(TestUrlBuilder::editBillProductPage($bill->id))
            ->seeJson([
                'success' => false
            ]);

    }

    /**
     * Try to edit product page without product id field. Fail response is expected.
     */
    public function editProductPageWithEmptyProductId() {

        // Generate user, client and bill
        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());
        $bill = $user->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));

        // Generate product and add to bill
        $product = $user->products()->save(factory(App\Product::class)->make());
        $bill->products()->save(factory(App\BillProduct::class)->make(['product_id' => $product->id]));

        $data = [
            'product_code' => $product->code,
            'product_page' => rand(1, 99)
        ];

        // Try to edit product page
        $this->actingAs($user)
            ->post(TestUrlBuilder::editBillProductPage($bill->id))
            ->seeJson([
                'success' => false
            ]);

    }

    /**
     * Edit product page without product code field. Fail response is expected.
     */
    public function editProductPageWithEmptyProductCode() {

        // Generate user, client and bill
        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());
        $bill = $user->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));

        // Generate product and add to bill
        $product = $user->products()->save(factory(App\Product::class)->make());
        $bill->products()->save(factory(App\BillProduct::class)->make(['product_id' => $product->id]));

        $data = [
            'product_id' => $product->id,
            'product_page' => rand(1, 99)
        ];

        // Edit product page
        $this->actingAs($user)
            ->post(TestUrlBuilder::editBillProductPage($bill->id))
            ->seeJson([
                'success' => false
            ]);

    }

    /**
     * Edit product page without page field. Fail response is expected.
     */
    public function testEditProductPageWithEmptyProductPage() {

        // Generate user, client, bill
        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());
        $bill = $user->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));

        // Generate product and add to bill
        $product = $user->products()->save(factory(App\Product::class)->make());
        $bill->products()->save(factory(App\BillProduct::class)->make(['product_id' => $product->id]));

        $data = [
            'product_id' => $product->id,
            'product_code' => $product->code
        ];

        // Try to edit product page
        $this->actingAs($user)
            ->post(TestUrlBuilder::editBillProductPage($bill->id), $data)
            ->seeJson([
                'success' => false
            ]);

    }

    /**
     * Edit product page with an invalid page. Fail response is expected.
     */
    public function testEditProductPageWithInvalidProductPage() {

        // Generate user, client, bill
        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());
        $bill = $user->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));

        // Generate product and add to bill
        $product = $user->products()->save(factory(App\Product::class)->make());
        $bill->products()->save(factory(App\BillProduct::class)->make(['product_id' => $product->id]));

        $data = [
            'product_id' => $product->id,
            'product_code' => $product->code,
            'product_page' => 'btl04'
        ];

        // Try to edit product page
        $this->actingAs($user)
            ->post(TestUrlBuilder::editBillProductPage($bill->id), $data)
            ->seeJson([
                'success' => false
            ]);

    }

    /**
     * Edit product page with too small and too big page. Fail response is expected.
     */
    public function testEditProductPageWithTooSmallAndTooBigProductPage() {

        // Generate user, client, bill
        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());
        $bill = $user->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));

        // Generate product and add to bill
        $product = $user->products()->save(factory(App\Product::class)->make());
        $bill->products()->save(factory(App\BillProduct::class)->make(['product_id' => $product->id]));

        $data = [
            'product_id' => $product->id,
            'product_code' => $product->code,
            'product_page' => rand(-99, -1)
        ];

        // Edit product page request with too small page
        $this->actingAs($user)
            ->post(TestUrlBuilder::editBillProductPage($bill->id), $data)
            ->seeJson([
                'success' => false
            ]);

        $data['product_page'] = rand(2001, 99999);

        // Edit product page with too big page
        $this->actingAs($user)
            ->post(TestUrlBuilder::editBillProductPage($bill->id), $data)
            ->seeJson([
                'success' => false
            ]);

    }

    /**
     * Try to edit product page with an invalid product id format. Fail response is expected.
     */
    public function testEditProductPageWithInvalidProductId() {

        // Generate user, client and bill
        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());
        $bill = $user->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));

        // Generate product and add to bill
        $product  = $user->products()->save(factory(App\Product::class)->make());
        $bill->products()->save(factory(App\BillProduct::class)->make(['product_id' => $product->id]));

        $data = [
            'product_id' => 'btl04',
            'product_code' => $product->code,
            'product_page' => rand(1, 99)
        ];

        // Try to edit product page
        $this->actingAs($user)
            ->post(TestUrlBuilder::editBillProductPage($bill->id), $data)
            ->seeJson([
                'success' => false
            ]);

    }

    /**
     * Edit product page with invalid product code. Fail response is expected.
     */
    public function testEditProductPageWithInvalidProductCode() {

        // Generate user, client and bill
        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());
        $bill = $user->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));

        // Generate product and add to bill
        $product = $user->products()->save(factory(App\Product::class)->make());
        $bill->products()->save(factory(App\BillProduct::class)->make(['product_id' => $product->id]));

        $data = [
            'product_id' => $product->id,
            'product_code' => 'abcd4',
            'product_page' => rand(1, 99)
        ];

        $this->actingAs($user)
            ->post(TestUrlBuilder::editBillProductPage($bill->id), $data)
            ->seeJson([
                'success' => false
            ]);

    }

    /**
     * Edit product page with an too short, then too long code. Fail response is expected.
     */
    public function testEditProductPageWithTooShortAndTooLongProductCode() {

        // Generate user, client and bill
        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());
        $bill = $user->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));

        // Generate product and add to bill
        $product = $user->products()->save(factory(App\Product::class)->make());
        $bill->products()->save(factory(App\BillProduct::class)->make(['product_id' => $product->id]));

        $data = [
            'product_id' => $product->id,
            'product_code' => '1234',
            'product_page' => rand(1, 99)
        ];

        // Try to edit with too short product code
        $this->actingAs($user)
            ->post(TestUrlBuilder::editBillProductPage($bill->id), $data)
            ->seeJson([
                'success' => false
            ]);

        $data['product_code'] = str_repeat($product->code, 10);

        // Try to edit with too long product code
        $this->actingAs($user)
            ->post(TestUrlBuilder::editBillProductPage($bill->id), $data)
            ->seeJson([
                'success' => false
            ]);

    }

    /**
     * Edit product page using code of another product. Fail response is expected.
     */
    public function testEditProductPageWithProductCodeOfAnotherProduct() {

        // Generate user, client and bill
        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());
        $bill = $user->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));

        // Generate two products and add to bill
        $firstProduct = $user->products()->save(factory(App\Product::class)->make());
        $bill->products()->save(factory(App\BillProduct::class)->make(['product_id' => $firstProduct->id]));
        $secondProduct = $user->products()->save(factory(App\Product::class)->make());
        $bill->products()->save(factory(App\BillProduct::class)->make(['product_id' => $secondProduct->id]));

        $data = [
            'product_id' => $firstProduct->id,
            'product_code' => $secondProduct->code,
            'product_page' => rand(1, 99)
        ];

        // Edit page with code of another product
        $this->actingAs($user)
            ->post(TestUrlBuilder::editBillProductPage($bill->id), $data)
            ->seeJson([
                'success' => false
            ]);

    }

    /**
     * Try to edit product page from bill of another user. Fail response is expected.
     */
    public function testEditProductPageFromBillOfAnotherUser() {

        // Generate first user, client and bill
        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());
        $bill = $user->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));


        // Generate first product and add to bill
        $product = $user->products()->save(factory(App\Product::class)->make());
        $bill->products()->save(factory(App\BillProduct::class)->make(['product_id' => $product->id]));

        $data = [
            'product_id' => $product->id,
            'product_code' => $product->code,
            'product_page' => rand(1, 99)
        ];

        // Generate another user
        $secondUser = factory(App\User::class)->create();

        // Try to edit product page of another user
        $this->actingAs($secondUser)
            ->post(TestUrlBuilder::editBillProductPage($bill->id), $data)
            ->seeJson([
                'success' => false
            ]);

    }

    /**
     * Edit product page with not existent product id. Fail response is expected.
     */
    public function testEditProductPageWithNotExistentProductId() {

        // Generate user, client and bill
        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());
        $bill = $user->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));

        // Generate product and add to bill
        $product = $user->products()->save(factory(App\Product::class)->make());
        $bill->products()->save(factory(App\BillProduct::class)->make(['product_id' => $product->id]));

        $data = [
            'product_id' => $product->id * 44 + $product->id,
            'product_code' => $product->code,
            'product_page' => rand(1, 99)
        ];

        // Edit product page
        $this->actingAs($user)
            ->post(TestUrlBuilder::editBillProductPage($bill->id), $data)
            ->seeJson([
                'success' => false
            ]);

    }

    /*
     * --------------------------------------------------------------------------------------
     *      Edit product quantity tests
     * --------------------------------------------------------------------------------------
     */

    /**
     * Edit custom product quantity. Success response is expected.
     */
    public function testEditCustomProductQuantity() {

        // Generate user, client and bill
        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());
        $bill = $user->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));

        // Generate product and add to bill
        $product = $user->products()->save(factory(App\Product::class)->make());
        $bill->products()->save(factory(App\BillProduct::class)->make(['product_id' => $product->id]));

        // Build post data and edit product quantity
        $data = [
            'product_id' => $product->id,
            'product_code' => $product->code,
            'product_quantity' => rand(2, 99)
        ];

        $this->actingAs($user)
            ->post(TestUrlBuilder::editBillProductQuantity($bill->id), $data)
            ->seeJson([
                'success' => true,
                'message' => trans('bill.quantity_updated')
            ]);

    }

    /**
     * Edit application product quantity. Success response is expected.
     */
    public function testEditApplicationProductQuantity() {

        // Generate user, client, bill
        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());
        $bill = $user->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));

        // Generate application product and add to bill
        $applicationProduct = factory(App\ApplicationProduct::class)->create();
        $bill->applicationProducts()->save(factory(App\BillApplicationProduct::class)->make(['product_id' => $applicationProduct->id]));

        // Build post data and edit product quantity
        $data = [
            'product_id' => $applicationProduct->id,
            'product_code' => $applicationProduct->code,
            'product_quantity' => rand(2, 99)
        ];

        $this->actingAs($user)
            ->post(TestUrlBuilder::editBillProductQuantity($bill->id), $data)
            ->seeJson([
                'success' => true,
                'message' => trans('bill.quantity_updated')
            ]);

    }

    /**
     * Make edit product quantity request with empty post data. Fail response is expected.
     */
    public function testEditProductQuantityWithEmptyPostData() {

        // Generate user, client and bill
        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());
        $bill = $user->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));

        // Make request without data
        $this->actingAs($user)
            ->post(TestUrlBuilder::editBillProductQuantity($bill->id))
            ->seeJson([
                'success' => false,
                'message' => trans('validation.required', ['attribute' => trans('validation.attributes.product_quantity')])
            ]);

    }

    /**
     * Edit product quantity with empty product id. Fail response is expected.
     */
    public function testEditProductQuantityWithEmptyProductId() {

        // Generate user, client and bill
        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());
        $bill = $user->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));

        // Generate product and add to bill
        $product = $user->products()->save(factory(App\Product::class)->make());
        $bill->products()->save(factory(App\BillProduct::class)->make(['product_id' => $product->id]));

        // Make request with empty product id
        $data = [
            'product_code' => $product->code,
            'product_quantity' => rand(2, 99)
        ];

        $this->actingAs($user)
            ->post(TestUrlBuilder::editBillProductQuantity($bill->id), $data)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.required', ['attribute' => trans('validation.attributes.product_id')])
            ]);

    }

    /**
     * Edit product quantity with invalid product id. Fail response is expected.
     */
    public function testEditProductQuantityWithInvalidProductId() {

        // Generate user, client and bill
        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());
        $bill = $user->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));

        // Generate product
        $product = $user->products()->save(factory(App\Product::class)->make());
        $bill->products()->save(factory(App\BillProduct::class)->make(['product_id' => $product->id]));

        // Post data
        $data = [
            'product_id' => 'btl04',
            'product_code' => $product->code,
            'product_quantity' => rand(2, 99)
        ];

        $this->actingAs($user)
            ->post(TestUrlBuilder::editBillProductQuantity($bill->id), $data)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.numeric', ['attribute' => trans('validation.attributes.product_id')])
            ]);

    }

    /**
     * Edit product quantity with empty product code. Fail response is expected.
     */
    public function testEditProductQuantityWithEmptyProductCode() {

        // Generate user, client, bill
        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());
        $bill = $user->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));

        // Generate product and add to bill
        $product = $user->products()->save(factory(App\Product::class)->make());
        $bill->products()->save(factory(App\BillProduct::class)->make(['product_id' => $product->id]));

        $data = [
            'product_id' => $product->id,
            'product_quantity' => rand(2, 99)
        ];

        $this->actingAs($user)
            ->post(TestUrlBuilder::editBillProductQuantity($bill->id), $data)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.required', ['attribute' => trans('validation.attributes.product_code')])
            ]);

    }

    /**
     * Edit product quantity with invalid product code. Fail response is expected.
     */
    public function testEditProductQuantityWithInvalidProductCode() {

        // Generate user, client, bill
        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());
        $bill = $user->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));

        // Generate product
        $product = $user->products()->save(factory(App\Product::class)->make());
        $bill->products()->save(factory(App\BillProduct::class)->make(['product_id' => $product->id]));

        $data = [
            'product_id' => $product->id,
            'product_code' => 'abc04',
            'product_quantity' => rand(2, 99)
        ];

        $this->actingAs($user)
            ->post(TestUrlBuilder::editBillProductQuantity($bill->id))
            ->seeJson([
                'success' => false
            ]);

    }

    /**
     * Edit product quantity with too long and too short product code. Fail response is expected.
     */
    public function testEditProductQuantityWithTooShortAndTooLongProductCode() {

        // Generate user, client and bill
        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());
        $bill = $user->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));

        // Generate product and add to bill
        $product = $user->products()->save(factory(App\Product::class)->make());
        $bill->products()->save(factory(App\BillProduct::class)->make(['product_id' => $product->id]));

        $data = [
            'product_id' => $product->id,
            'product_code' => '0404',
            'product_quantity' => rand(2, 99)
        ];

        // Edit with too short code
        $this->actingAs($user)
            ->post(TestUrlBuilder::editBillProductQuantity($bill->id), $data)
            ->seeJson([
                'success' => false
            ]);

        $data['product_code'] = str_repeat($product->code, 10);

        // Edit with too long code
        $this->actingAs($user)
            ->post(TestUrlBuilder::editBillProductQuantity($bill->id), $data)
            ->seeJson([
                'success' => false
            ]);

    }

    /**
     * Edit product quantity with empty product quantity. Fail response is expected.
     */
    public function testEditProductQuantityWithEmptyProductQuantity() {

        // Create user, client and bill
        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());
        $bill = $user->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));

        // Generate product and add to bill
        $product = $user->products()->save(factory(App\Product::class)->make());
        $bill->products()->save(factory(App\BillProduct::class)->make(['product_id' => $product->id]));

        $data = [
            'product_id' => $product->id,
            'product_code' => $product->code
        ];

        $this->actingAs($user)
            ->post(TestUrlBuilder::editBillProductQuantity($bill->id), $data)
            ->seeJson([
                'success' => false
            ]);

    }

    /**
     * Edit product quantity with invalid product quantity. Failure is expected.
     */
    public function testEditProductQuantityWithInvalidProductQuantity() {

        // Create user, client and bill
        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());
        $bill = $user->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));

        // Generate product and add to bill
        $product = $user->products()->save(factory(App\Product::class)->make());
        $bill->products()->save(factory(App\BillProduct::class)->make(['product_id' => $product->id]));

        $data = [
            'product_id' => $product->id,
            'product_code' => $product->code,
            'product_quantity' => 'ab'
        ];

        $this->actingAs($user)
            ->post(TestUrlBuilder::editBillProductQuantity($bill->id), $data)
            ->seeJson([
                'success' => false
            ]);
    }

    /**
     * Edit product quantity with too small and too big quantity. Fail response is expected.
     */
    public function testEditProductQuantityWithTooSmallAndTooBigProductQuantity() {

        // Create user, client and bill
        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());
        $bill = $user->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));

        // Generate product and add to bill
        $product = $user->products()->save(factory(App\Product::class)->make());
        $bill->products()->save(factory(App\BillProduct::class)->make(['product_id' => $product->id]));

        $data = [
            'product_id' => $product->id,
            'product_code' => $product->code,
            'product_quantity' => rand(-99, -1)
        ];

        // Try with too small quantity
        $this->actingAs($user)
            ->post(TestUrlBuilder::editBillProductQuantity($bill->id), $data)
            ->seeJson([
                'success' => false
            ]);

        $data['product_quantity'] = rand(1000, 9999);

        // Try with too big quantity
        $this->actingAs($user)
            ->post(TestUrlBuilder::editBillProductQuantity($bill->id), $data)
            ->seeJson([
                'success' => false
            ]);

    }

    /*
     * --------------------------------------------------------------------------------------
     *      Edit product price tests
     * --------------------------------------------------------------------------------------
     */

    /**
     * Edit custom product price. Success response is expected.
     */
    public function testEditCustomProductPrice() {

        // Create user, client and bill
        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());
        $bill = $user->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));

        // Generate product and add to bill
        $product = $user->products()->save(factory(App\Product::class)->make());
        $bill->products()->save(factory(App\BillProduct::class)->make(['product_id' => $product->id]));

        // Edit product price
        $data = [
            'product_id' => $product->id,
            'product_code' => $product->code,
            'product_price' => rand(0, 9999)
        ];

        $this->actingAs($user)
            ->post(TestUrlBuilder::editBillProductPrice($bill->id), $data)
            ->seeJson([
                'success' => true
            ]);

    }

    /**
     * Edit application product price. Success response is expected.
     */
    public function testEditApplicationProductPrice() {

        // Create user, client and bill
        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());
        $bill = $user->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));

        // Create application product
        $applicationProduct = factory(App\ApplicationProduct::class)->create();
        $bill->applicationProducts()->save(factory(App\BillApplicationProduct::class)->make(['product_id' => $applicationProduct->id]));

        // Edit product price
        $data = [
            'product_id' => $applicationProduct->id,
            'product_code' => $applicationProduct->code,
            'product_price' => rand(0, 9999)
        ];

        $this->actingAs($user)
            ->post(TestUrlBuilder::editBillProductPrice($bill->id), $data)
            ->seeJson([
                'success' => true
            ]);

    }

    /**
     * Try to edit product price with empty post data. Fail response is expected.
     */
    public function testEditProductPriceWithEmptyData() {

        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());
        $bill = $user->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));

        $this->actingAs($user)
            ->post(TestUrlBuilder::editBillProductPrice($bill->id))
            ->seeJson([
                'success' => false
            ]);

    }

    /**
     * Edit product price with empty product id field. Fail response is expected.
     */
    public function testEditProductPriceWithEmptyProductId() {

        // Create user, client and bill
        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());
        $bill = $user->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));

        // Create product
        $product = $user->products()->save(factory(App\Product::class)->make());
        $bill->products()->save(factory(App\BillProduct::class)->make(['product_id' => $product->id]));

        $data = [
            'product_code' => $product->code,
            'product_price' => rand(0, 9999)
        ];

        $this->actingAs($user)
            ->post(TestUrlBuilder::editBillProductPrice($bill->id), $data)
            ->seeJson([
                'success' => false
            ]);

    }

    /**
     * Edit product price with invalid product id. Fail response is expected.
     */
    public function testEditProductPriceWithInvalidProductId() {

        // Create user, client and bill
        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());
        $bill = $user->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));

        // Generate product
        $product = $user->products()->save(factory(App\Product::class)->make());
        $bill->products()->save(factory(App\BillProduct::class)->make(['product_id' => $product->id]));

        $data = [
            'product_id' => 'b04',
            'product_code' => $product->code,
            'product_price' => rand(0, 9999)
        ];

        $this->actingAs($user)
            ->post(TestUrlBuilder::editBillProductPrice($bill->id), $data)
            ->seeJson([
                'success' => false
            ]);

    }

    /**
     * Edit product price with empty product code. Fail response is expected.
     */
    public function testEditProductPriceWithEmptyProductCode() {

        // Generate user, client and bill
        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());
        $bill = $user->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));

        // Generate product
        $product = $user->products()->save(factory(App\Product::class)->make());
        $bill->products()->save(factory(App\BillProduct::class)->make(['product_id' => $product->id]));

        $data = [
            'product_id' => $product->id,
            'product_price' => rand(0, 9999)
        ];

        $this->actingAs($user)
            ->post(TestUrlBuilder::editBillProductPrice($bill->id), $data)
            ->seeJson([
                'success' => false
            ]);

    }

    /**
     * Edit product price with invalid product code. Fail response is expected.
     */
    public function testEditProductPriceWithInvalidProductCode() {

        // Generate user, client and bill
        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());
        $bill = $user->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));

        // Create product
        $product = $user->products()->save(factory(App\Product::class)->make());
        $bill->products()->save(factory(App\BillProduct::class)->make(['product_id' => $product->id]));

        $data = [
            'product_id' => $product->id,
            'product_code' => 'btl10',
            'product_price' => rand(0, 9999)
        ];

        $this->actingAs($user)
            ->post(TestUrlBuilder::editBillProductPrice($bill->id), $data)
            ->seeJson([
                'success' => false
            ]);

    }

    /**
     * Edit product page with too short and too long code. Fail response is expected.
     */
    public function testEditProductPriceWithTooShortAndTooLongProductCode() {

        // Generate user, client and bill
        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());
        $bill = $user->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));

        // Create product
        $product = $user->products()->save(factory(App\Product::class)->make());
        $bill->products()->save(factory(App\BillProduct::class)->make(['product_id' => $product->id]));

        $data = [
            'product_id' => $product->id,
            'product_code' => '0404',
            'product_price' => rand(0, 9999)
        ];

        // Edit with too short code
        $this->actingAs($user)
            ->post(TestUrlBuilder::editBillProductPrice($bill->id), $data)
            ->seeJson([
                'success' => false
            ]);

        $data['product_code'] = str_repeat($product->code, 3);

        // Edit with too long code
        $this->actingAs($user)
            ->post(TestUrlBuilder::editBillProductPrice($bill->id), $data)
            ->seeJson([
                'success' => false
            ]);

    }

    /**
     * Edit product price with empty product price. Fail response is expected.
     */
    public function testEditProductPriceWithEmptyProductPrice() {

        // Create user, client and bill
        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());
        $bill = $user->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));

        // Generate product
        $product = $user->products()->save(factory(App\Product::class)->make());
        $bill->products()->save(factory(App\BillProduct::class)->make(['product_id' => $product->id]));

        $data = [
            'product_id' => $product->id,
            'product_code' => $product->code,
        ];

        $this->actingAs($user)
            ->post(TestUrlBuilder::editBillProductPrice($bill->id), $data)
            ->seeJson([
                'success' => false
            ]);

    }

    /**
     * Edit product price with invalid product price. Fail response is expected.
     */
    public function testEditProductPriceWithInvalidProductPrice() {

        // Create user, client and bill
        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());
        $bill = $user->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));

        // Generate product
        $product = $user->products()->save(factory(App\Product::class)->make());
        $bill->products()->save(factory(App\BillProduct::class)->make(['product_id' => $product->id]));

        $data = [
            'product_id' => $product->id,
            'product_code' => $product->code,
            'product_price' => 'btl1'
        ];

        $this->actingAs($user)
            ->post(TestUrlBuilder::editBillProductPrice($bill->id), $data)
            ->seeJson([
                'success' => false
            ]);
    }

    /**
     * Edit product price from bill of another user. Fail response is expected.
     */
    public function testEditProductPriceFromBillOfAnotherUser() {

        // Create user, client and bill
        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());
        $bill = $user->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));

        // Generate product
        $product = $user->products()->save(factory(App\Product::class)->make());
        $bill->products()->save(factory(App\BillProduct::class)->make(['product_id' => $product->id]));

        $data = [
            'product_id' => $product->id,
            'product_code' => $product->code,
            'product_price' => rand(0, 9999)
        ];

        $secondUser = factory(App\User::class)->create();

        $this->actingAs($secondUser)
            ->post(TestUrlBuilder::editBillProductPrice($bill->id), $data)
            ->seeJson([
                'success' => false
            ]);

    }

    /**
     * Edit product price with too small and too big price. Fail response is expected.
     */
    public function testEditProductPriceWithTooSmallAndTooBigProductPrice() {

        // Create user, client and bill
        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());
        $bill = $user->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));

        // Generate product
        $product = $user->products()->save(factory(App\Product::class)->make());
        $bill->products()->save(factory(App\BillProduct::class)->make(['product_id' => $product->id]));

        $data = [
            'product_id' => $product->id,
            'product_code' => $product->code,
            'product_price' => rand(-99, -1)
        ];

        // Try with to small price
        $this->actingAs($user)
            ->post(TestUrlBuilder::editBillProductPrice($bill->id), $data)
            ->seeJson([
                'success' => false
            ]);

        $data['product_price'] = rand(10000, 99999);

        // Try with o big price
        $this->actingAs($user)
            ->post(TestUrlBuilder::editBillProductPrice($bill->id), $data)
            ->seeJson([
                'success' => false
            ]);

    }

    /*
     * --------------------------------------------------------------------------------------
     *      Delete product from bill tests
     * --------------------------------------------------------------------------------------
     */

    /**
     * Delete bill product. Success response is expected.
     */
    public function testDeleteBillCustomProduct() {

        // Generate user, client and bill
        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());
        $bill = $user->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));

        // Generate one product and add to bill
        $product = $user->products()->save(factory(App\Product::class)->make());
        $bill->products()->save(factory(App\BillProduct::class)->make(['product_id' => $product->id]));

        // Delete product from bill
        $this->actingAs($user)
            ->get('/bills/' . $bill->id . '/delete/' . $product->id . '/' . $product->code)
            ->seeJson([
                'success' => true,
                'message' => trans('common.product_deleted')
            ]);
    }

    /**
     * Delete bill application product. Success response is expected.
     */
    public function testDeleteBillApplicationProduct() {

        // Generate user, client and bill
        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());
        $bill = $user->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));

        // Generate application product and add to bill
        $applicationProduct = factory(App\ApplicationProduct::class)->create();
        $bill->applicationProducts()->save(factory(App\BillApplicationProduct::class)->make(['product_id' => $applicationProduct->id]));

        // Delete application product from bill
        $this->actingAs($user)
            ->get(TestUrlBuilder::deleteBillProduct($bill->id, $applicationProduct->id, $applicationProduct->code))
            ->seeJson([
                'success' => true,
                'message' => trans('common.product_deleted')
            ]);

    }

    /**
     * Delete bill product of another user. Fail response is expected.
     */
    public function testDeleteBillCustomProductOfAnotherUser() {

        // Generate user, client, bill
        $firstUser = factory(App\User::class)->create();
        $client = $firstUser->clients()->save(factory(App\Client::class)->make());
        $bill = $firstUser->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));

        // Generate product and add to bill
        $product = $firstUser->products()->save(factory(App\Product::class)->make());
        $bill->products()->save(factory(App\BillProduct::class)->make(['product_id' => $product->id]));

        // Create new user
        $secondUser = factory(App\User::class)->create();
        $requestUrl = '/bills/' . $bill->id . '/delete/' . $product->id . '/' . $product->code;

        // Delete product from first user bill acting as second user
        $this->actingAs($secondUser)
            ->get($requestUrl)
            ->seeJson([
                'success' => false,
                'message' => trans('common.general_error')
            ]);
    }

    /**
     * Delete bill application product of another user. Fail response is expected.
     */
    public function testDeleteBillApplicationProductOfAnotherUser() {

        // Generate user, client and bill
        $firstUser = factory(App\User::class)->create();
        $client = $firstUser->clients()->save(factory(App\Client::class)->make());
        $bill = $firstUser->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));

        // Generate application product and add to bill
        $applicationProduct = factory(App\ApplicationProduct::class)->create();
        $bill->applicationProducts()->save(factory(App\BillApplicationProduct::class)->make(['product_id' => $applicationProduct->id]));

        // Create another user
        $secondUser = factory(App\User::class)->create();

        // Delete application product form bill acting as second user
        $this->actingAs($secondUser)
            ->get(TestUrlBuilder::deleteBillProduct($bill->id, $applicationProduct->id, $applicationProduct->code))
            ->seeJson([
                'success' => false,
                'message' => trans('common.general_error')
            ]);

    }

    /**
     * Delete one custom product and one application product from bill. Success response is expected.
     */
    public function testDeleteBillCustomProductAndBillApplicationProduct() {

        // Generate user, client, bill
        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());
        $bill = $user->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));

        // Generate custom product
        $product = $user->products()->save(factory(App\Product::class)->make());
        $bill->products()->save(factory(App\BillProduct::class)->make(['product_id' => $product->id]));

        // Generate application product
        $applicationProduct = factory(App\ApplicationProduct::class)->create();
        $bill->applicationProducts()->save(factory(App\BillApplicationProduct::class)->make(['product_id' => $applicationProduct->id]));

        $successResponse = [
            'success' => true,
            'message' => trans('common.product_deleted')
        ];

        // Delete custom product from bill
        $this->actingAs($user)
            ->get(TestUrlBuilder::deleteBillProduct($bill->id, $product->id, $product->code))
            ->seeJson($successResponse);

        // Delete application product from bill
        $this->actingAs($user)
            ->get(TestUrlBuilder::deleteBillProduct($bill->id, $applicationProduct->id, $applicationProduct->code))
            ->seeJson($successResponse);

    }

    /**
     * Delete a product from bill with an invalid product id. Fail response is expected.
     */
    public function testDeleteBillProductWithInvalidId() {

        // Generate user, client and bill
        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());
        $bill = $user->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));

        // Try to delete a product from bill with an invalid product id
        $this->actingAs($user)
            ->get(TestUrlBuilder::deleteBillProduct($bill->id, 'b04', '10004'))
            ->seeJson([
                'success' => false,
                'message' => trans('common.general_error')
            ]);

    }

    /**
     * Delete a product form bill using the code of another. Fail response is expected.
     */
    public function testDeleteBillCustomProductWithCodeOfAnotherProduct() {

        // Generate user, client and bill
        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());
        $bill = $user->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));

        // Generate 2 custom products
        $firstProduct = $user->products()->save(factory(App\Product::class)->make());
        $secondProduct = $user->products()->save(factory(App\Product::class)->make());

        // Add to bill products table
        $bill->products()->save(factory(App\BillProduct::class)->make(['product_id' => $firstProduct->id]));
        $bill->products()->save(factory(App\BillProduct::class)->make(['product_id' => $secondProduct->id]));

        // Try to delete first product using code of the second product
        $this->actingAs($user)
            ->get(TestUrlBuilder::deleteBillProduct($bill->id, $firstProduct->id, $secondProduct->code))
            ->seeJson([
                'success' => false,
                'message' => trans('common.general_error')
            ]);

    }

    /**
     * Delete an application product from bill using the code of another. Fail response is expected.
     */
    public function testDeleteBillApplicationProductWithCodeOfAnotherProduct() {

        // Generate user, client and bill
        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());
        $bill = $user->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));

        // Generate 2 application products
        $firstApplicationProduct = factory(App\ApplicationProduct::class)->create();
        $secondApplicationProduct = factory(App\ApplicationProduct::class)->create();

        // Add to bill application products table
        $bill->applicationProducts()->save(factory(App\BillApplicationProduct::class)->make(['product_id' => $firstApplicationProduct->id]));
        $bill->applicationProducts()->save(factory(App\BillApplicationProduct::class)->make(['product_id' => $secondApplicationProduct->id]));

        // Try to delete first application product from bill using code of the second
        $this->actingAs($user)
            ->get(TestUrlBuilder::deleteBillProduct($bill->id, $firstApplicationProduct->id, $secondApplicationProduct->code))
            ->seeJson([
                'success' => false,
                'message' => trans('common.general_error')
            ]);
    }

}