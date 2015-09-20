<?php
use App\Helpers\TestUrlBuilder;

/**
 * Contains tests for bill page
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class BillTest extends TestCase {

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