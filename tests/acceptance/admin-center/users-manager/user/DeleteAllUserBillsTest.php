<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * Test delete all user bills admin feature.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class DeleteAllUserBillsTest extends TestCase {

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
        $this->admin = factory(\App\User::class, 'admin')->create();
        $this->user = factory(\App\User::class)->create();
        $this->client = factory(\App\Client::class)->create(['user_id' => $this->user->id]);
    }

    /**
     * Admin delete all user bills.
     */
    public function test_admin_delete_all_user_bills() {

        $billIds = [
            'client_id' => $this->client->id,
            'user_id' => $this->user->id
        ];

        // Generate paid bills
        factory(\App\Bill::class, 'paid', 4)->create($billIds);

        // Generate unpaid bills
        factory(\App\Bill::class, 4)->create($billIds);

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/delete-all-bills')
            ->seeJson([
                'success' => true,
                'message' => trans('users_manager.all_user_bills_deleted')
            ])
            ->notSeeInDatabase('bills', [
                'user_id' => $this->user->id
            ]);
    }

    /**
     * Admin tries to delete bills of not existent user.
     */
    public function test_admin_delete_not_existent_user_bills() {

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . rand(1000, 9999) . '/delete-all-bills')
            ->seeJson([
                'success' => false,
                'message' => trans('users_manager.user_not_found')
            ]);
    }

    /**
     * Admin tries to delete bills of a user that does not have bills.
     */
    public function test_admin_delete_all_user_bills_when_user_has_no_bill() {

        $this->assertEquals(0, \App\Bill::where('user_id', $this->user->id)->count());

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/delete-all-bills')
            ->seeJson([
                'success' => true,
                'message' => trans('users_manager.all_user_bills_deleted')
            ])
            ->notSeeInDatabase('bills', [
                'user_id' => $this->user->id
            ]);
    }

    /**
     * Not logged in user tries to delete all user bills.
     */
    public function test_not_logged_in_user_delete_all_user_bills() {

        $billIds = [
            'user_id' => $this->user->id,
            'client_id' => $this->client->id
        ];

        // Generate paid bills
        factory(\App\Bill::class, 'paid', 4)->create($billIds);

        // Generate unpaid bills
        factory(\App\Bill::class, 4)->create($billIds);

        $this->post('/admin-center/users-manager/user/' . $this->user->id . '/delete-all-bills')
            ->assertEquals(8, \App\Bill::where('user_id', $this->user->id)->where('client_id', $this->client->id)->count());
    }

    /**
     * Normal user tries to delete all user bills.
     */
    public function test_normal_user_delete_all_user_bills() {

        $billIds = [
            'user_id' => $this->user->id,
            'client_id' => $this->client->id
        ];

        // Generate paid bills
        factory(\App\Bill::class, 'paid', 4)->create($billIds);

        // Generate unpaid bills
        factory(\App\Bill::class, 4)->create($billIds);

        $this->actingAs(factory(\App\User::class)->create())
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/delete-all-bills')
            ->assertEquals(8, \App\Bill::where('user_id', $this->user->id)->where('client_id', $this->client->id)->count());
    }
}