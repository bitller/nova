<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * Test delete all user custom products admin feature.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class DeleteAllUserCustomProductsTest extends TestCase {

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
     * @var null
     */
    private $client = null;

    /**
     * @var null
     */
    private $bill = null;

    /**
     * Called before each test.
     */
    public function setUp() {
        parent::setUp();
        $this->admin = factory(\App\User::class, 'admin')->create();
        $this->user = factory(\App\User::class)->create();
        $this->client = factory(\App\Client::class)->create(['user_id' => $this->user->id]);
        $this->bill = factory(\App\Bill::class)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id
        ]);
    }

    /**
     * Admin delete all user custom products.
     */
    public function test_admin_delete_all_user_custom_products() {

        // Generate some custom products
        factory(\App\BillProduct::class, 10)->create([
            'bill_id' => $this->bill->id,
            'product_id' => factory(\App\Product::class)->create(['user_id' => $this->user->id])->id
        ]);

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/delete-custom-products')
            ->seeJson([
                'success' => true,
                'message' => trans('users_manager.user_custom_products_deleted')
            ])
            ->notSeeInDatabase('bill_products', [
                'bill_id' => $this->bill->id
            ]);
    }

    /**
     * Admin delete all user custom products when user has no custom products.
     */
    public function test_admin_delete_all_user_custom_products_when_user_has_no_custom_products() {

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/delete-custom-products')
            ->seeJson([
                'success' => true,
                'message' => trans('users_manager.user_custom_products_deleted')
            ]);
    }

    /**
     * Admin tries to delete custom products of non existent user.
     */
    public function test_admin_delete_all_user_custom_products_with_not_existent_user_id() {

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . rand(1000, 9999) . '/delete-custom-products')
            ->seeJson([
                'success' => false,
                'message' => trans('users_manager.user_not_found')
            ]);
    }

    /**
     * Admin tries to delete custom products of non existent user with user id in string format.
     */
    public function test_admin_delete_all_user_custom_products_with_not_existent_user_id_in_string_format() {

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/string' . rand() . '/delete-custom-products')
            ->seeJson([
                'success' => false,
                'message' => trans('users_manager.user_not_found')
            ]);
    }

    /**
     * Normal user tries to delete all user custom products.
     */
    public function test_normal_user_delete_all_user_custom_products() {

        factory(\App\BillProduct::class, 10)->create([
            'bill_id' => $this->bill->id,
            'product_id' => factory(\App\Product::class)->create(['user_id' => $this->user->id])->id
        ]);

        $this->actingAs(factory(\App\User::class)->create())
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/delete-custom-products')
            ->seeInDatabase('bill_products', [
                'bill_id' => $this->bill->id
            ]);
    }

    /**
     * Not logged in user tries to delete all user custom products.
     */
    public function test_not_logged_in_user_delete_all_user_custom_products() {

        factory(\App\BillProduct::class, 10)->create([
            'bill_id' => $this->bill->id,
            'product_id' => factory(\App\Product::class)->create(['user_id' => $this->user->id])->id
        ]);

        $this->post('/admin-center/users-manager/user/' . $this->user->id . '/delete-custom-products')
            ->seeInDatabase('bill_products', [
                'bill_id' => $this->bill->id
            ]);
    }
}