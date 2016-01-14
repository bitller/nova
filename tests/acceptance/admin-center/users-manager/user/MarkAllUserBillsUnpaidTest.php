<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * Test make all user bills unpaid admin feature.
 *
 * @author Alexandru Bugairn <alexandru.bugarin@gmail.com>
 */
class MarkAllUserBillsUnpaidTest extends TestCase {

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
     * Admin mark all user bills as unpaid.
     */
    public function test_admin_mark_all_user_bills_as_unpaid() {

        // Generate paid bills
        factory(\App\Bill::class, 'paid', 4)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id
        ]);

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/make-all-bills-unpaid')
            ->seeJson([
                'success' => true,
                'message' => trans('users_manager.all_user_bills_are_unpaid')
            ])
            ->notSeeInDatabase('bills', [
                'user_id' => $this->user->id,
                'paid' => 1
            ]);
    }

    /**
     * Admin mark all user bills as unpaid when user has no paid bills.
     */
    public function test_admin_mark_all_user_bills_as_unpaid_when_user_has_no_paid_bills() {

        // Generate unpaid bills
        factory(\App\Bill::class, 4)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id
        ]);

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/make-all-bills-unpaid')
            ->seeJson([
                'success' => true,
                'message' => trans('users_manager.all_user_bills_are_unpaid')
            ])
            ->notSeeInDatabase('bills', [
                'user_id' => $this->user->id,
                'paid' => 1
            ]);
    }

    /**
     * Admin mark all user bills as unpaid when user has no bills.
     */
    public function test_admin_mark_all_user_bills_as_unpaid_when_user_has_no_bills() {

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/make-all-bills-unpaid')
            ->seeJson([
                'success' => true,
                'message' => trans('users_manager.all_user_bills_are_unpaid')
            ])
            ->notSeeInDatabase('bills', [
                'user_id' => $this->user->id
            ]);
    }

    /**
     * Not logged in user tries to mark all user bills as unpaid.
     */
    public function test_not_logged_in_user_mark_all_user_bills_as_unpaid() {

        // Generate paid bills
        factory(\App\Bill::class, 'paid', 4)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id
        ]);

        $this->post('/admin-center/users-manager/user/' . $this->user->id . '/make-all-bills-unpaid')
            ->seeInDatabase('bills', [
                'user_id' => $this->user->id,
                'paid' => 1
            ]);
    }

    /**
     * Normal user tries to mark all user bills as unpaid.
     */
    public function test_normal_user_mark_all_user_bills_as_unpaid() {

        // Generate paid bills
        factory(\App\Bill::class, 'paid', 4)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id
        ]);

        $this->actingAs(factory(\App\User::class)->create())
            ->post('/admin-center/users-manager/user/' . $this->user . '/make-all-bills-unpaid')
            ->seeInDatabase('bills', [
                'user_id' => $this->user->id,
                'paid' => 1
            ]);
    }
}