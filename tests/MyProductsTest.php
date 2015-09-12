<?php

/**
 * Tests for my products page.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class MyProductsTest extends TestCase {

    /**
     * Visit my products page.
     */
    public function testMyProductsPage() {

        $user = factory(App\User::class)->create();

        $this->actingAs($user)
            ->visit('/my-products')
            ->see($user->email);

    }

    /**
     * Visit my products page as visitor.
     */
    public function testMyProductsPageAsVisitor() {

        $this->visit('/my-products')
            ->seePageIs('/login');

    }

    /**
     * Paginate my products.
     */
    public function testMyProductsPagination() {

        $numberOfProducts = 45;

        // Generate user and products
        $user = factory(App\User::class)->create();
        for ($i = 0; $i < $numberOfProducts; $i++) {
            $user->products()->save(factory(App\Product::class)->make());
        }

        $paginate = App\Product::where('user_id', $user->id)->orderBy('code', 'asc')->paginate(10);

        $this->actingAs($user)
            ->get('/my-products/get')
            ->seeJson([
                'total' => $paginate->total(),
                'per_page' => $paginate->perPage()
            ]);
    }

    /**
     * Make request to see if a product code is available.
     */
    public function testIsProductCodeAvailable() {

        $user = factory(App\User::class)->create();
        $product = $user->products()->save(factory(App\Product::class)->make());

        $this->actingAs($user)
            ->get('/my-products/check/' . $product->code)
            ->seeJson(['success' => false]);

    }

    /**
     * Add new product.
     */
    public function testAddProduct() {

        $this->withoutMiddleware();

        $user = factory(App\User::class)->create();
        $product = factory(App\Product::class)->make();

        $this->actingAs($user)
            ->post('/my-products/add', ['name' => $product->name, 'code' => '04044'])
            ->seeJson(['success' => true]);

    }

    /**
     * Try to add a product that already exists.
     */
    public function testAddProductThatExists() {

        $this->withoutMiddleware();

        // Generate user and product
        $user = factory(App\User::class)->create();
        $product = $user->products()->save(factory(App\Product::class)->make());

        $this->actingAs($user)
            ->post('/my-products/add', ['name' => $product->name, 'code' => $product->code])
            ->seeJson(['success' => false]);

    }

    /**
     * Add product with empty fields.
     */
    public function testAddProductWithEmptyFields() {

        $this->withoutMiddleware();

        // Generate user
        $user = factory(App\User::class)->create();

        $this->actingAs($user)
            ->post('/my-products/add')
            ->seeJson(['success' => false]);

    }

    /**
     * Add product without code.
     */
    public function testAddProductWithoutCode() {

        $this->withoutMiddleware();

        // Generate user and product
        $user = factory(App\User::class)->create();
        $product = factory(App\Product::class)->make();

        $this->actingAs($user)
            ->post('/my-products/add', ['name' => $product->name])
            ->seeJson(['success' => false]);

    }

    /**
     * Add product without name.
     */
    public function testAddProductWithoutName() {

        $this->withoutMiddleware();

        // Generate user and product
        $user = factory(App\User::class)->create();

        $this->actingAs($user)
            ->post('/my-products/add', ['code' => '04101'])
            ->seeJson(['success' => false]);

    }

    /**
     * Add product with too short code.
     */
    public function testAddProductWithTooShortCode() {

        $this->withoutMiddleware();

        // Generate user and product
        $user = factory(App\User::class)->create();
        $product = factory(App\Product::class)->make();

        $this->actingAs($user)
            ->post('/my-products/add', ['name' => $product->name, 'code' => '0091'])
            ->seeJson(['success' => false]);

    }

    /**
     * Add product with too long code.
     */
    public function testAddProductWithTooLongCode() {

        $this->withoutMiddleware();

        // Generate user and product
        $user = factory(App\User::class)->create();
        $product = factory(App\Product::class)->make();

        $this->actingAs($user)
            ->post('/my-products/add', ['name' => $product->name, 'code' => '021337'])
            ->seeJson(['success' => false]);

    }

    /**
     * Add product with invalid code.
     */
    public function testAddProductWithInvalidCode() {

        $this->withoutMiddleware();

        // Generate user and product
        $user = factory(App\User::class)->create();
        $product = factory(App\Product::class)->make();

        $this->actingAs($user)
            ->post('/my-products/add', ['name' => $product->name, 'code' => 'dasd2'])
            ->seeJson(['success' => false]);

    }

    /**
     * Delete product.
     */
    public function testDeleteProduct() {

        // Generate user and product
        $user = factory(App\User::class)->create();
        $product = $user->products()->save(factory(App\Product::class)->make());

        $this->actingAs($user)
            ->get('/my-products/' . $product->id . '/delete')
            ->seeJson(['success' => true]);

    }

    /**
     * Delete product with invalid id.
     */
    public function testDeleteProductWithInvalidId() {

        // Generate user
        $user = factory(App\User::class)->create();

        $this->actingAs($user)
            ->get('/my-products/da04/delete')
            ->seeJson(['success' => false]);

    }

    /**
     * Try to delete a product with a not existent id.
     */
    public function testDeleteProductWithNotExistentId() {

        // Generate user
        $user = factory(App\User::class)->create();

        $this->actingAs($user)
            ->get('/my-products/4/delete')
            ->seeJson(['success' => false]);

    }

}