<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * Test delete user account admin functionality.
 *
 * @author Alexandru Bugairn <alexandru.bugarin@gmail.com>
 */
class DeleteUserAccountTest extends TestCase {

    use DatabaseTransactions;
    use WithoutMiddleware;

    /**
     * @var null
     */
    private $admin = null;

    /**
     * Called first.
     */
    public function setUp() {
        parent::setUp();
        $this->admin = factory(App\User::class, 'admin')->create();
    }

    /**
     * Admin delete user account.
     */
    public function test_admin_delete_user_account() {

        $user = factory(App\User::class)->create();

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $user->id . '/delete-account')
            ->seeJson([
                'success' => true,
                'message' => trans('users_manager.account_deleted'),
            ])
            ->notSeeInDatabase('users', [
                'email' => $user->email
            ]);
    }

    /**
     * Admin tries to delete not existent user account.
     */
    public function test_admin_delete_not_existent_user_account() {
        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . rand(1000, 9999) . '/delete-account')
            ->seeJson([
                'success' => false,
                'message' => trans('users_manager.user_not_found')
            ]);
    }

    /**
     * Not logged in user tries to delete user account.
     */
    public function test_not_logged_in_user_delete_user_account() {

        $user = factory(App\User::class)->create();
        $this->post('/admin-center/users-manager/user/' . $user->id . '/delete-account')
            ->seeInDatabase('users', [
                'email' => $user->email
            ]);
    }

    /**
     * Normal user tries to delete user account.
     */
    public function test_normal_user_delete_user_account() {

        $user = factory(App\User::class)->create();
        $this->actingAs(factory(App\User::class)->create())
            ->post('/admin-center/users-manager/user/' . $user->id . '/delete-account')
            ->seeInDatabase('users', [
                'email' => $user->email
            ]);
    }

}