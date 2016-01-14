<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * Test delete user bill admin feature.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class DeleteUserBillTest extends TestCase {

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
     * Admin delete one user paid bill and one user unpaid bill.
     */
    public function test_admin_delete_user_bill() {

        $billInfo = [
            'user_id' => $this->user->id,
            'client_id' => $this->client->id
        ];

        // Create one paid bill
        $paidBill = factory(\App\Bill::class, 'paid')->create($billInfo);

        // Also create one unpaid bill
        $unpaidBill = factory(\App\Bill::class)->create($billInfo);

        // Delete paid bill
        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/delete-bill', ['bill_id' => $paidBill->id])
            ->seeJson([
                'success' => true,
                'message' => trans('users_manager.user_bill_deleted')
            ])
            ->notSeeInDatabase('bills', [
                'id' => $paidBill->id,
                'user_id' => $this->user->id
            ]);

        // Delete unpaid bill
        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/delete-bill', ['bill_id' => $unpaidBill->id])
            ->seeJson([
                'success' => true,
                'message' => trans('users_manager.user_bill_deleted')
            ])
            ->notSeeInDatabase('bills', [
                'id' => $unpaidBill->id,
                'user_id' => $this->user->id
            ]);
    }

    /**
     * Not logged in user tries to delete user bill.
     */
    public function test_not_logged_in_user_delete_user_bill() {

        $bill = factory(\App\Bill::class)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id
        ]);

        $this->post('/admin-center/users-manager/user/' . $this->user->id . '/delete-bill', ['bill_id' => $bill->id])
            ->seeInDatabase('bills', [
                'id' => $bill->id,
                'user_id' => $this->user->id,
                'client_id' => $this->client->id
            ]);
    }

    /**
     * Normal user tries to delete user bill.
     */
    public function test_normal_user_delete_user_bill() {

        $bill = factory(\App\Bill::class)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id
        ]);

        $this->actingAs(factory(\App\User::class)->create())
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/delete-bill', ['bill_id' => $bill->id])
            ->seeInDatabase('bills', [
                'id' => $bill->id,
                'user_id' => $this->user->id,
                'client_id' => $this->client->id
            ]);
    }
}