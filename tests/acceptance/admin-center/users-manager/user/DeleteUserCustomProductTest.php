<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * Test delete user custom product admin feature.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class DeleteUserCustomProductTest extends TestCase {

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
     * @var null
     */
    private $custom_product = null;

    /**
     * @var null
     */
    private $bill_product = null;

    /**
     * Called before each test.
     */
    public function setUp() {
        parent::setUp();

        // Generate admin, user and client
        $this->admin = factory(\App\User::class, 'admin')->create();
        $this->user = factory(\App\User::class)->create();
        $this->client = factory(\App\Client::class)->create(['user_id' => $this->user->id]);

        // Generate bill
        $this->bill = factory(\App\Bill::class)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id
        ]);

        // Generate custom product
        $this->custom_product = factory(\App\Product::class)->create(['user_id' => $this->user->id]);

        // Generate bill product
        $this->bill_product = factory(\App\BillProduct::class)->create([
            'bill_id' => $this->bill->id,
            'product_id' => $this->custom_product->id
        ]);
    }

    /**
     * Admin delete user custom product.
     */
    public function test_admin_delete_user_custom_product() {

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/delete-custom-product', ['custom_product_id' => $this->custom_product->id])
            ->seeJson([
                'success' => true,
                'message' => trans('users_manager.user_custom_product_deleted')
            ])
            ->notSeeInDatabase('products', [
                'id' => $this->custom_product->id,
                'user_id' => $this->user->id
            ]);
    }

    /**
     * Admin tries to delete user custom product with not existent custom product id.
     */
    public function test_admin_delete_user_custom_product_with_not_existent_custom_product_id() {

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/delete-custom-product', ['custom_product_id' => rand(1000, 9999)])
            ->seeJson([
                'success' => false,
                'message' => trans('validation.exists', ['attribute' => trans('validation.attributes.custom_product_id')])
            ])
            ->seeInDatabase('products', [
                'id' => $this->custom_product->id,
                'user_id' => $this->user->id
            ]);
    }

    /**
     * Admin tries to delete user custom product with empty post data.
     */
    public function test_admin_delete_user_custom_product_id_with_empty_data() {

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/delete-custom-product')
            ->seeJson([
                'success' => false,
                'message' => trans('validation.required', ['attribute' => trans('validation.attributes.custom_product_id')])
            ])
            ->seeInDatabase('products', [
                'id' => $this->custom_product->id,
                'user_id' => $this->user->id
            ]);
    }

    /**
     * Admin tries to delete user custom product with user id of another user.
     */
    public function test_admin_delete_user_custom_product_with_user_id_of_another_user() {

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . factory(\App\User::class)->create()->id . '/delete-custom-product', ['custom_product_id' => $this->custom_product->id])
            ->seeJson([
                'success' => false,
                'message' => trans('users_manager.product_not_found')
            ])
            ->seeInDatabase('products', [
                'user_id' => $this->user->id,
                'id' => $this->custom_product->id
            ]);
    }

    /**
     * Admin tries to delete user custom product with not existent user id.
     */
    public function test_admin_delete_user_custom_product_with_not_existent_user_id() {

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . rand(1000, 9999) . '/delete-custom-product', ['custom_product_id' => $this->custom_product->id])
            ->seeJson([
                'success' => false,
                'message' => trans('users_manager.user_not_found')
            ])
            ->seeInDatabase('products', [
                'id' => $this->custom_product->id,
                'user_id' => $this->user->id
            ]);
    }

    /**
     * Admin tries to delete user custom product with not existent id in string format.
     */
    public function test_admin_delete_user_custom_product_with_not_existent_user_id_in_string_format() {

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/string' . rand(1000, 9999) . '/delete-custom-product', ['custom_product_id' => $this->custom_product->id])
            ->seeJson([
                'success' => false,
                'message' => trans('users_manager.user_not_found')
            ])
            ->seeInDatabase('products', [
                'id' => $this->custom_product->id,
                'user_id' => $this->user->id
            ]);
    }

    /**
     * Normal user tries to delete user custom product.
     */
    public function test_normal_user_delete_user_custom_product() {

        $this->actingAs(factory(\App\User::class)->create())
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/delete-custom-product', ['custom_product_id' => $this->custom_product->id])
            ->seeInDatabase('products', [
                'id' => $this->custom_product->id,
                'user_id' => $this->user->id
            ]);
    }

    /**
     * Not logged in user tries to delete user custom product.
     */
    public function test_not_logged_in_user_delete_user_custom_product() {

        $this->post('/admin-center/users-manager/user/' . $this->user->id . '/delete-custom-product', ['custom_product_id' => $this->custom_product->id])
            ->seeInDatabase('products', [
                'id' => $this->custom_product->id,
                'user_id' => $this->user->id
            ]);
    }
}