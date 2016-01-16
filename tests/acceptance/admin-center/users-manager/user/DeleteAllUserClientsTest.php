<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * Test delete all user clients admin feature.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class DeleteAllUserClientsTest extends TestCase {

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
     * Admin delete all user clients.
     */
    public function test_admin_delete_all_user_clients() {

        // Generate clients
        factory(\App\Client::class, 4)->create([
            'user_id' => $this->user->id
        ]);

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/delete-clients')
            ->seeJson([
                'success' => true,
                'message' => trans('users_manager.user_clients_deleted')
            ])
            ->notSeeInDatabase('clients', [
                'user_id' => $this->user->id
            ]);
    }

    /**
     * Admin delete all user clients when user has no clients.
     */
    public function test_admin_delete_all_user_clients_when_user_has_no_clients() {

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/delete-clients')
            ->seeJson([
                'success' => true,
                'message' => trans('users_manager.user_clients_deleted')
            ])
            ->notSeeInDatabase('clients', [
                'user_id' => $this->user->id
            ]);
    }

    /**
     * Admin tries to delete all user clients with not existent user id.
     */
    public function test_admin_delete_all_user_clients_with_not_existent_user_id() {

        factory(\App\Client::class, 4)->create([
            'user_id' => $this->user->id
        ]);

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . rand(1000, 9999) . '/delete-clients')
            ->seeJson([
                'success' => false,
                'message' => trans('users_manager.user_not_found')
            ])
            ->assertEquals(4, \App\Client::where('user_id', $this->user->id)->count());
    }

    /**
     * Admin tries to delete all user clients with not existent user id as string.
     */
    public function test_admin_delete_all_user_clients_with_not_existent_user_id_in_string_format() {

        factory(\App\Client::class, 4)->create([
            'user_id' => $this->user->id
        ]);

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . 'string' . rand(1000, 9999) . '/delete-clients')
            ->seeJson([
                'success' => false,
                'message' => trans('users_manager.user_not_found')
            ])
            ->assertEquals(4, \App\Client::where('user_id', $this->user->id)->count());
    }

    /**
     * Not logged in user tries to delete all user clients.
     */
    public function test_not_logged_in_user_delete_all_user_clients() {

        factory(\App\Client::class, 4)->create([
            'user_id' => $this->user->id
        ]);

        $this->post('/admin-center/users-manager/user/' . $this->user->id . '/delete-clients')
            ->assertEquals(4, \App\Client::where('user_id', $this->user->id)->count());
    }

    /**
     * Normal user tries to delete all user clients.
     */
    public function test_normal_user_delete_all_user_clients() {

        factory(\App\Client::class, 4)->create([
            'user_id' => $this->user->id
        ]);

        $this->actingAs(factory(\App\User::class)->create())
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/delete-clients')
            ->assertEquals(4, \App\Client::where('user_id', $this->user->id)->count());
    }
}