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
     * @param bool $useApplicationProduct
     * @return array
     */
    protected function generateData($useApplicationProduct = false) {

        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());
        $bill = $user->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));

        if ($useApplicationProduct) {
            $product = factory(App\ApplicationProduct::class)->create();
            $billProduct = $bill->applicationProducts()->save(factory(App\BillApplicationProduct::class)->make(['product_id' => $product->id]));
        } else {
            $product = $user->products()->save(factory(App\Product::class)->make());
            $billProduct = $bill->products()->save(factory(App\BillProduct::class)->make(['product_id' => $product->id]));
        }

        return [
            'user' => $user,
            'client' => $client,
            'bill' => $bill,
            'product' => $product,
            'billProduct' => $billProduct
        ];

    }

}