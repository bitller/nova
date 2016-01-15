<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * Test mark user bill as unpaid admin feature.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class MarkUserBillAsUnpaidTest extends TestCase {

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
     * Called before each test.
     */
    public function setUp() {
        parent::setUp();
        $this->admin = factory(\App\User::class, 'admin')->create();
        $this->user = factory(\App\User::class)->create();
        $this->client = factory(\App\Client::class)->create(['user_id' => $this->user->id]);
    }

    /**
     * Admin mark user bill as unpaid.
     */
    public function test_admin_mark_user_bill_as_unpaid() {

        $bill = factory(\App\Bill::class, 'paid')->create([
            'client_id' => $this->client->id,
            'user_id' => $this->user->id
        ]);

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/make-bill-unpaid', ['bill_id' => $bill->id])
            ->seeJson([
                'success' => true,
                'message' => trans('users_manager.user_bill_is_unpaid')
            ])
            ->seeInDatabase('bills', [
                'user_id' => $this->user->id,
                'id' => $bill->id,
                'paid' => 0
            ]);
    }

    /**
     * Admin tries to mark user bill as unpaid with empty post data.
     */
    public function test_admin_mark_user_bill_as_unpaid_with_empty_data() {

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/make-bill-unpaid')
            ->seeJson([
                'success' => false,
                'message' => trans('validation.required', ['attribute' => trans('validation.attributes.bill_id')])
            ]);
    }

    /**
     * Admin mark already unpaid bill as unpaid.
     */
    public function test_admin_mark_already_unpaid_bill_as_unpaid() {

        $bill = factory(\App\Bill::class)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id
        ]);

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/make-bill-unpaid', ['bill_id' => $bill->id])
            ->seeJson([
                'success' => true,
                'message' => trans('users_manager.user_bill_is_unpaid')
            ])
            ->seeInDatabase('bills', [
                'user_id' => $this->user->id,
                'id' => $bill->id,
                'paid' => 0
            ]);
    }

    /**
     * Admin tries to mark user bill as unpaid using id of not existent user.
     */
    public function test_admin_mark_user_bill_as_unpaid_without_existent_user_id() {

        $bill = factory(\App\Bill::class, 'paid')->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id
        ]);

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . rand(1000, 9999) . '/make-bill-unpaid', ['bill_id' => $bill->id])
            ->seeInDatabase('bills', [
                'user_id' => $this->user->id,
                'id' => $bill->id,
                'paid' => 1
            ]);
    }

    /**
     * Admin tries to mark user bill as unpaid with id of another user.
     */
    public function test_admin_mark_user_bill_as_unpaid_with_id_of_another_user() {

        $bill = factory(\App\Bill::class, 'paid')->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id
        ]);

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . factory(\App\User::class)->create()->id . '/make-bill-unpaid', ['bill_id' => $bill->id])
            ->seeInDatabase('bills', [
                'user_id' => $this->user->id,
                'id' => $bill->id,
                'paid' => 1
            ]);
    }

    /**
     * Admin tries to mark user bill as unpaid using not existent bill id.
     */
    public function test_admin_mark_user_bill_as_unpaid_with_not_existent_bill_id() {

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/make-bill-unpaid', ['bill_id' => rand(1000, 9999)])
            ->seeJson([
                'success' => false,
                'message' => trans('validation.exists', ['attribute' => trans('validation.attributes.bill_id')])
            ]);
    }

    /**
     * Admin tries to mark user bill as unpaid using string bill id.
     */
    public function test_admin_mark_user_bill_as_unpaid_with_string_bill_id() {

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/make-bill-unpaid', ['bill_id' => 'string'.rand()])
            ->seeJson([
                'success' => false,
                'message' => trans('validation.exists', ['attribute' => trans('validation.attributes.bill_id')])
            ]);
    }

    /**
     * Not logged in user tries to mark user bill as unpaid.
     */
    public function test_not_logged_in_user_mark_user_bill_as_unpaid() {

        $bill = factory(\App\Bill::class, 'paid')->create([
            'client_id' => $this->client->id,
            'user_id' => $this->user->id
        ]);

        $this->post('/admin-center/users-manager/user/' . $this->user->id . '/make-bill-unpaid', ['bill_id' => $bill->id])
            ->seeInDatabase('bills', [
                'user_id' => $this->user->id,
                'id' => $bill->id,
                'paid' => 1
            ]);
    }

    /**
     * Normal user tries to mark user bill as unpaid.
     */
    public function test_normal_user_mark_user_bill_as_unpaid() {

        $bill = factory(\App\Bill::class, 'paid')->create([
            'client_id' => $this->client->id,
            'user_id' => $this->user->id
        ]);

        $this->actingAs(factory(\App\User::class)->create())
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/make-bill-unpaid', ['bill_id' => $bill->id])
            ->seeInDatabase('bills', [
                'user_id' => $this->user->id,
                'id' => $bill->id,
                'paid' => 1
            ]);
    }
}