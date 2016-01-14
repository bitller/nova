<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * Testing delete all paid user bill admin feature.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class DeleteAllPaidUserBillsTest extends TestCase {

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
        $this->client = factory(App\Client::class)->create(['user_id' => $this->user->id]);
    }

    /**
     * Test admin delete all user paid bills.
     */
    public function test_admin_delete_all_user_paid_bills() {

        // Generate paid bills
        factory(App\Bill::class, 'paid', 4)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id
        ]);

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/delete-paid-bills')
            ->seeJson([
                'success' => true,
                'message' => trans('users_manager.user_paid_bills_deleted')
            ])
            ->notSeeInDatabase('bills', [
                'paid' => 1,
                'user_id' => $this->user->id
            ]);
    }

    /**
     * Not logged in user delete all user paid bills.
     */
    public function test_not_logged_in_user_delete_all_user_paid_bills() {

        // Generate paid bills
        factory(App\Bill::class, 'paid', 4)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id
        ]);

        $this->post('/admin-center/users-manager/user/' . $this->user->id . '/delete-paid-bills')
            ->seeInDatabase('bills', [
                'user_id' => $this->user->id,
                'paid' => 1
            ])
            ->assertEquals(4, \App\Bill::where('user_id', $this->user->id)->where('paid', 1)->count());
    }

    /**
     * Normal user tries to delete all user paid bills.
     */
    public function test_normal_user_delete_all_user_paid_bills() {

        // Generate paid bills
        factory(App\Bill::class, 'paid', 4)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id
        ]);

        $this->actingAs(factory(App\User::class)->create())
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/delete-paid-bills')
            ->seeInDatabase('bills', [
                'user_id' => $this->user->id,
                'paid' => 1
            ])
            ->assertEquals(4, \App\Bill::where('user_id', $this->user->id)->where('paid', 1)->count());
    }

    /**
     * Admin tries to delete not existent user paid bills.
     */
    public function test_admin_delete_not_existent_user_paid_bills() {

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . rand(1000, 9999) . '/delete-paid-bills')
            ->seeJson([
                'success' => false,
                'message' => trans('users_manager.user_not_found')
            ]);
    }

}