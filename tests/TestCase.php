<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase {
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost:8888';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication() {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

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

    /**
     * Generate user, client, bill and product used for add bill tests.
     *
     * @param bool $useApplicationProduct
     * @return array
     */
    protected function generateAddBillData($useApplicationProduct = false) {

        $user = factory(App\User::class)->create();
        $client = $user->clients()->save(factory(App\Client::class)->make());
        $bill = $user->bills()->save(factory(App\Bill::class)->make(['client_id' => $client->id]));

        if ($useApplicationProduct) {
            $product = factory(App\ApplicationProduct::class)->create();
        } else {
            $product = $user->products()->save(factory(App\Product::class)->make());
        }

        return [
            'user' => $user,
            'client' => $client,
            'bill' => $bill,
            'product' => $product
        ];

    }

}
