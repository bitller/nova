<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * Test delete all unpaid user bills admin functionality.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class DeleteAllUnpaidUserBillsTest extends TestCase {

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
     * Called first.
     */
    public function setUp() {
        parent::setUp();
        $this->admin = factory(App\User::class, 'admin')->create();
        $this->user = factory(App\User::class)->create();
        $this->client = factory(\App\Client::class)->create(['user_id' => $this->user->id]);
    }

    /**
     * Test admin delete all user unpaid bills.
     */
    public function test_admin_delete_all_user_unpaid_bills() {

        // Generate unpaid bills
        factory(\App\Bill::class, 4)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id
        ]);

        // Also generate paid bills
        factory(\App\Bill::class, 'paid')->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id
        ]);

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/delete-unpaid-bills')
            ->seeJson([
                'success' => true,
                'message' => trans('users_manager.user_unpaid_bills_deleted')
            ])
            ->notSeeInDatabase('bills', [
                'paid' => 0,
                'user_id' => $this->user->id
            ]);
    }

    /**
     * Not logged in user tries to delete user unpaid bills.
     */
    public function test_not_logged_in_user_delete_all_user_unpaid_bills() {

        // Generate unpaid bills
        factory(\App\Bill::class)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id
        ]);

        $this->post('/admin-center/users-manager/user/' . $this->user->id . '/delete-unpaid-bills')
            ->seeInDatabase('bills', [
                'paid' => 0,
                'user_id' => $this->user->id
            ]);
    }

    /**
     * Normal user tries to delete user unpaid bills.
     */
    public function test_normal_user_delete_all_user_unpaid_bills() {

        // Generate unpaid bills
        factory(App\Bill::class)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id
        ]);

        $this->actingAs(factory(\App\User::class)->create())
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/delete-unpaid-bills')
            ->seeInDatabase('bills', [
                'paid' => 0,
                'user_id' => $this->user->id
            ]);
    }

    /**
     * Admin tries to delete not existent user unpaid bills.
     */
    public function test_admin_delete_not_existent_user_unpaid_bills() {

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . rand(1000, 9999) . '/delete-unpaid-bills')
            ->seeJson([
                'success' => false,
                'message' => trans('users_manager.user_not_found')
            ]);
    }
}