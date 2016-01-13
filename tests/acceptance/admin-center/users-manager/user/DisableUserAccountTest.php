<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * Test disable account admin feature.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class DisableUserAccountTest extends TestCase {

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
     * Called first.
     */
    public function setUp() {
        parent::setUp();
        $this->admin = factory(App\User::class, 'admin')->create();
        $this->user = factory(App\User::class)->create();
    }

    /**
     * Admin disable enabled account.
     */
    public function test_admin_disable_user_account() {

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/disable-account')
            ->seeJson([
                'success' => true,
                'message' => trans('users_manager.account_disabled')
            ])
            ->seeInDatabase('users', [
                'email' => $this->user->email,
                'active' => 0
            ]);
    }

    /**
     * Admin disable disabled account.
     */
    public function test_admin_disable_already_disabled_user_account() {

        $user = factory(App\User::class)->create(['active' => 0]);

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $user->id . '/disable-account')
            ->seeJson([
                'success' => true,
                'message' => trans('users_manager.account_disabled')
            ])
            ->seeInDatabase('users', [
                'email' => $user->email,
                'active' => 0
            ]);
    }

    /**
     * Not logged in user tries to disable user account.
     */
    public function test_not_logged_in_user_disable_user_account() {

        $user = factory(App\User::class)->create();

        $this->post('/admin-center/users-manager/user/' . $user->id . '/disable-account')
            ->seeInDatabase('users', [
                'email' => $user->email,
                'active' => 1
            ]);
    }

    /**
     * Normal user tries to disable user account.
     */
    public function test_normal_user_disable_user_account() {

        $user = factory(App\User::class)->create();
        $userThatMakeRequest = factory(App\User::class)->create();

        $this->actingAs($userThatMakeRequest)
            ->post('/admin-center/users-manager/user/' . $user->id . '/disable-account')
            ->seeInDatabase('users', [
                'email' => $user->email,
                'active' => 1
            ]);
    }

    public function test_admin_disable_not_existent_user_account() {
        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . rand(1000,9999) . '/disable-account')
            ->seeJson([
                'success' => false,
                'message' => trans('users_manager.user_not_found')
            ]);
    }

}