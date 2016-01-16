<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * Test paginate user custom products admin feature.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class PaginateUserCustomProductsTest extends TestCase {

    use DatabaseTransactions;
    use WithoutMiddleware;

    /**
     * @var null
     */
    private $admin = null;

    /**
     * @var null
     */
    private $user = null;

    /**
     * Called before each test.
     */
    public function setUp() {
        parent::setUp();
        $this->admin = factory(\App\User::class, 'admin')->create();
        $this->user = factory(\App\User::class)->create();
    }

    /**
     * Test admin paginate user custom products.
     */
    public function test_admin_paginate_user_custom_products() {

        factory(\App\Product::class, 4)->create([
            'user_id' => $this->user->id
        ]);

        $this->actingAs($this->admin)
            ->get('/admin-center/users-manager/user/' . $this->user->id . '/get-custom-products')
            ->seeJson([
                'total' => 4
            ]);
    }

    /**
     * Admin tries to paginate custom products of not existent user.
     */
    public function test_admin_paginate_user_custom_products_with_not_existent_user_id() {

        factory(\App\Product::class, 4)->create([
            'user_id' => $this->user->id
        ]);

        $this->actingAs($this->admin)
            ->get('/admin-center/users-manager/user/' . rand(1000, 9999) . '/get-custom-products')
            ->seeJson([
                'success' => false,
                'message' => trans('users_manager.user_not_found')
            ]);
    }
}