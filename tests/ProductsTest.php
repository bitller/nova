<?php

/**
 * Test products page
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class ProductsTest extends TestCase {

    /**
     * Access products page.
     */
    public function testProductsPage() {

        // Generate user
        $user = factory(App\User::class)->create();

        $this->actingAs($user)
            ->visit('/products')
            ->see($user->email);

    }

    /**
     * Access products page as visitor.
     */
    public function testProductsPageAsVisitor() {

        $this->visit('/products')
            ->seePageIs('/login');

    }

    /**
     * Test products pagination.
     */
    public function testProductsPagination() {

        $numberOfProducts = 45;

        // Generate user
        $user = factory(App\User::class)->create();

        // Generate products
        for ($i = 0; $i < $numberOfProducts; $i++) {
            factory(App\ApplicationProduct::class)->create();
        }

        $pagination = App\ApplicationProduct::orderBy('code', 'asc')->paginate(10);

        $this->actingAs($user)
            ->get('/products/get')
            ->seeJson([
                'total' => $pagination->total(),
                'per_page' => $pagination->perPage()
            ]);

    }

}