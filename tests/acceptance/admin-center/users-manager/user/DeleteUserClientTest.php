<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * Test delete user client admin feature.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class DeleteUserClientTest extends TestCase {

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
     * Admin delete user client.
     */
    public function test_admin_delete_user_client() {

        $client = factory(\App\Client::class)->create([
            'user_id' => $this->user->id
        ]);

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/delete-client', ['client_id' => $client->id])
            ->seeJson([
                'success' => true,
                'message' => trans('users_manager.user_client_deleted')
            ])
            ->notSeeInDatabase('clients', [
                'user_id' => $this->user->id,
                'id' => $client->id
            ]);
    }

    /**
     * Admin tries to delete user client with not existent client id.
     */
    public function test_admin_delete_user_client_with_not_existent_client_id() {

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/delete-client', ['client_id' => rand(1000, 9999)])
            ->seeJson([
                'success' => false,
                'message' => trans('validation.exists', ['attribute' => trans('validation.attributes.client_id')])
            ]);
    }

    /**
     * Admin tries to delete user client with empty post data.
     */
    public function test_admin_delete_user_client_with_empty_data() {

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/delete-client')
            ->seeJson([
                'success' => false,
                'message' => trans('validation.required', ['attribute' => trans('validation.attributes.client_id')])
            ]);
    }

    /**
     * Admin tries to delete user client using id of another user.
     */
    public function test_admin_delete_user_client_with_user_id_of_another_user() {

        $client = factory(\App\Client::class)->create([
            'user_id' => $this->user->id
        ]);

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . factory(\App\User::class)->create()->id . '/delete-client', ['client_id' => $client->id])
            ->seeJson([
                'success' => false,
                'message' => trans('users_manager.client_not_found')
            ])
            ->seeInDatabase('clients', [
                'user_id' => $this->user->id,
                'id' => $client->id
            ]);
    }

    /**
     * Admin tries to delete user client using not existent user id.
     */
    public function test_admin_delete_user_client_with_not_existent_user_id() {

        $client = factory(\App\Client::class)->create([
            'user_id' => $this->user->id
        ]);

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . rand(1000, 9999) . '/delete-client', ['client_id' => $client->id])
            ->seeJson([
                'success' => false,
                'message' => trans('users_manager.user_not_found')
            ])
            ->seeInDatabase('clients', [
                'user_id' => $this->user->id,
                'id' => $client->id
            ]);
    }

    /**
     * Admin tries to delete user client using not existent user id in string format.
     */
    public function test_admin_delete_user_client_with_not_existent_user_id_in_string_format() {

        $client = factory(\App\Client::class)->create([
            'user_id' => $this->user->id
        ]);

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . 'string' . rand(1000, 9999) . '/delete-client', ['client_id' => $client->id])
            ->seeJson([
                'success' => false,
                'message' => trans('users_manager.user_not_found')
            ])
            ->seeInDatabase('clients', [
                'user_id' => $this->user->id,
                'id' => $client->id
            ]);
    }

    /**
     * Normal user tries to delete user client.
     */
    public function test_normal_user_delete_user_client() {

        $client = factory(\App\Client::class)->create([
            'user_id' => $this->user->id
        ]);

        $this->actingAs(factory(\App\User::class)->create())
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/delete-client', ['client_id' => $client->id])
            ->seeInDatabase('clients', [
                'user_id' => $this->user->id,
                'id' => $client->id
            ]);
    }

    /**
     * Not logged in user tries to delete user client.
     */
    public function test_not_logged_in_user_delete_user_client() {

        $client = factory(\App\Client::class)->create([
            'user_id' => $this->user->id
        ]);

        $this->post('/admin-center/users-manager/user/' . $this->user->id . '/delete-client', ['client_id' => $client->id])
            ->seeInDatabase('clients', [
                'user_id' => $this->user->id,
                'id' => $client->id
            ]);
    }
}