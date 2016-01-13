<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * Test enable user account admin feature.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class EnableUserAccountTest extends TestCase {

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
     * Admin enable disabled user account.
     */
    public function test_admin_enable_user_account() {

        $disabledUser = factory(App\User::class)->create(['active' => 0]);

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $disabledUser->id . '/enable-account')
            ->seeJson([
                'success' => true,
                'message' => trans('users_manager.account_enabled')
            ])
            ->seeInDatabase('users', [
                'email' => $disabledUser->email,
                'active' => 1
            ]);
    }

    /**
     * Admin enable already enabled user account.
     */
    public function test_admin_enable_already_enabled_user_account() {

        $user = factory(App\User::class)->create();

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $user->id . '/enable-account')
            ->seeJson([
                'success' => true,
                'message' => trans('users_manager.account_enabled')
            ])
            ->seeInDatabase('users', [
                'email' => $user->email,
                'active' => 1
            ]);
    }

    /**
     * Admin tries to edit not existent user account.
     */
    public function test_admin_enable_not_existent_user_account() {

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . rand(9999, 10000) . '/enable-account')
            ->seeJson([
                'success' => false,
                'message' => trans('users_manager.user_not_found')
            ]);
    }

    /**
     * Not logged in user tries to enable user account.
     */
    public function test_not_logged_in_user_tries_to_enable_user_account() {

        $user = factory(App\User::class)->create(['active' => 0]);

        $this->post('/admin-center/users-manager/user/' . $user->id . '/enable-account')
            ->seeInDatabase('users', [
                'email' => $user->email,
                'active' => 0
            ]);
    }

    /**
     * Normal user tries to enable user account.
     */
    public function test_normal_user_tries_to_enable_user_account() {

        $user = factory(App\User::class)->create(['active' => 0]);
        $userWhoMakeRequest = factory(App\User::class)->create();

        $this->actingAs($userWhoMakeRequest)
            ->post('/admin-center/users-manager/user/' . $user->id . '/enable-account')
            ->seeInDatabase('users', [
                'email' => $user->email,
                'active' => 0
            ]);
    }

}