<?php

/**
 * Contain base methods used for bills page tests
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class BaseTest extends Testcase {

    /**
     * Generate user, client, bill, product and bill product.
     *
     * @return array
     */
    protected function generateData() {

        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());
        $bill = $user->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));
        $product = $user->products()->save(factory(App\Product::class)->make());
        $billProduct = $bill->products()->save(factory(App\BillProduct::class)->make(['product_id' => $product->id]));

        return [
            'user' => $user,
            'client' => $client,
            'bill' => $bill,
            'product' => $product,
            'billProduct' => $billProduct
        ];

    }

}