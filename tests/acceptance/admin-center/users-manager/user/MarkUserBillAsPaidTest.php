<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * Test mark user bill as paid admin feature.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class MarkUserBillAsPaidTest extends TestCase {

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
     * Admin mark user bills as paid.
     */
    public function test_admin_mark_user_bill_as_paid() {

        $bill = factory(\App\Bill::class)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id
        ]);

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/make-bill-paid', ['bill_id' => $bill->id])
            ->seeJson([
                'success' => true,
                'message' => trans('users_manager.user_bill_is_paid')
            ])
            ->seeInDatabase('bills', [
                'user_id' => $this->user->id,
                'client_id' => $this->client->id,
                'id' => $bill->id,
                'paid' => 1
            ]);
    }

    /**
     * Admin tries to mark user bill as paid with empty data.
     */
    public function test_admin_mark_user_bill_as_paid_with_empty_data() {

        $bill = factory(\App\Bill::class)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id
        ]);

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/make-bill-paid')
            ->seeJson([
                'success' => false,
                'message' => trans('validation.required', ['attribute' => trans('validation.attributes.bill_id')])
            ])
            ->seeInDatabase('bills', [
                'user_id' => $this->user->id,
                'id' => $bill->id,
                'paid' => 0
            ]);
    }

    /**
     * Admin tries to mark already paid bill as paid.
     */
    public function test_admin_mark_already_paid_bill_as_paid() {

        // Create paid bill
        $bill = factory(\App\Bill::class, 'paid')->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id
        ]);

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/make-bill-paid', ['bill_id' => $bill->id])
            ->seeJson([
                'success' => true,
                'message' => trans('users_manager.user_bill_is_paid')
            ])
            ->seeInDatabase('bills', [
                'user_id' => $this->user->id,
                'id' => $bill->id,
                'paid' => 1
            ]);
    }

    /**
     * Admin tries to make user bill as paid with not existent user id.
     */
    public function test_admin_mark_user_bill_as_paid_with_not_existent_user_id() {

        // Create bill
        $bill = factory(\App\Bill::class)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id
        ]);

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . rand(1000, 9999) . '/make-bill-paid', ['bill_id' => $bill->id])
            ->seeJson([
                'success' => false,
                'message' => trans('users_manager.user_not_found')
            ]);
    }

    /**
     * Admin tries to mark user bill as paid using user id of another user.
     */
    public function test_admin_mark_user_bill_as_paid_with_id_of_another_user() {

        // Create bill
        $bill = factory(\App\Bill::class)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id
        ]);

        // Create another user
        $user = factory(\App\User::class)->create();

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $user->id . '/make-bill-paid', ['bill_id' => $bill->id])
            ->seeJson([
                'success' => false,
                'message' => trans('users_manager.bill_not_found')
            ])
            ->seeInDatabase('bills', [
                'user_id' => $this->user->id,
                'id' => $bill->id,
                'paid' => 0
            ]);
    }

    /**
     * Admin mark user bill as paid with not existent bill id.
     */
    public function test_admin_mark_user_bill_as_paid_with_not_existent_bill_id() {

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/make-bill-paid', ['bill_id' => rand(1000, 9999)])
            ->seeJson([
                'success' => false,
                'message' => trans('validation.exists', ['attribute' => trans('validation.attributes.bill_id')])
            ]);
    }

    /**
     * Admin mark user bill as paid with a invalid string bill id.
     */
    public function test_admin_mark_user_bill_as_paid_with_string_bill_id() {

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/make-bill-paid', ['bill_id' => 'string'.rand()])
            ->seeJson([
                'success' => false,
                'message' => trans('users_manager.bill_not_found')
            ]);
    }

    /**
     * Not logged in user tries to mark user bill as paid.
     */
    public function test_not_logged_in_user_mark_user_bill_as_paid() {

        $bill = factory(\App\Bill::class)->create();

        $this->post('/admin-center/users-manager/user/' . $this->user->id . '/make-bill-paid', ['bill_id' => $bill->id])
            ->seeInDatabase('bills', [
                'user_id' => $this->user->id,
                'id' => $bill->id,
                'paid' => 0
            ]);
    }

    /**
     * Normal user tries to mark user bill as paid.
     */
    public function test_normal_user_mark_user_bill_as_paid() {

        $bill = factory(\App\Bill::class)->create();

        $this->actingAs(factory(\App\User::class)->create())
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/make-bill-paid', ['bill_id' => $bill->id])
            ->seeInDatabase('bills', [
                'user_id' => $this->user->id,
                'id' => $bill->id,
                'paid' => 0
            ]);
    }
}