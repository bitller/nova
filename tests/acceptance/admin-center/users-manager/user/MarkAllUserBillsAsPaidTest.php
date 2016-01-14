<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * Test mark all user bills as paid admin feature.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class MarkAllBillsAsPaidTest extends TestCase {

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
     * Admin mark all user bills to paid.
     */
    public function test_admin_mark_all_users_bills_as_paid() {

        // Generate bills
        factory(\App\Bill::class, 4)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id
        ]);

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/make-all-bills-paid')
            ->seeJson([
                'success' => true,
                'message' => trans('users_manager.all_user_bills_are_paid')
            ])
            ->notSeeInDatabase('bills', [
                'user_id' => $this->user->id,
                'paid' => 0
            ]);
    }

    /**
     * Admin mark all user bills to paid even if all user bills already are.
     */
    public function test_admin_mark_all_user_bills_as_paid_when_user_has_no_unpaid_bills() {

        // Generate paid bills
        factory(\App\Bill::class, 'paid', 4)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id
        ]);

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/make-all-bills-paid')
            ->seeJson([
                'success' => true,
                'message' => trans('users_manager.all_user_bills_are_paid')
            ])
            ->notSeeInDatabase('bills', [
                'user_id' => $this->user->id,
                'paid' => 0
            ]);
    }

    /**
     * Admin mark all user bills to paid even if user has no bills.
     */
    public function test_admin_mark_all_user_bills_as_paid_when_user_has_no_bills() {

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/make-all-bills-paid')
            ->seeJson([
                'success' => true,
                'message' => trans('users_manager.all_user_bills_are_paid')
            ])
            ->notSeeInDatabase('bills', [
                'user_id' => $this->user->id
            ]);
    }

    /**
     * Not logged in user tries to mark all user bills to paid.
     */
    public function test_not_logged_in_user_mark_all_user_bills_as_paid() {

        // Generate bills
        factory(\App\Bill::class, 4)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id
        ]);

        $this->post('/admin-center/users-manager/user/' . $this->user->id . '/make-all-bills-paid')
            ->seeInDatabase('bills', [
                'user_id' => $this->user->id,
                'paid' => 0
            ]);
    }

    /**
     * Normal user tries to mark all user bills to paid.
     */
    public function test_normal_user_mark_all_user_bills_as_paid() {

        // Generate bills
        factory(\App\Bill::class, 4)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id
        ]);

        $this->actingAs(factory(App\User::class)->create())
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/make-all-bills-paid')
            ->seeInDatabase('bills', [
                'user_id' => $this->user->id,
                'paid' => 0
            ]);
    }
}