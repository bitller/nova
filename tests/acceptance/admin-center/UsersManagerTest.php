<?php
use App\User;

/**
 * Acceptance tests for users manager section.
 *
 * @author Alexandru Bugairn <alexandru.bugarin@gmail.com>
 */
class UsersManagerTest extends TestCase {

    use \Illuminate\Foundation\Testing\DatabaseTransactions;
    use \Illuminate\Foundation\Testing\WithoutMiddleware;

    /**
     * @var null
     */
    private $admin = null;

    public function setUp() {
        parent::setUp();
        $this->admin = factory(App\User::class, 'admin')->create();
    }

    /**
     * Admin create new user form users manager section.
     */
    public function test_admin_create_new_user() {

        // Generate normal user
        $user = factory(App\User::class)->make();

        // Build post data
        $data = [
            'new_user_email' => $user->email,
            'new_user_password' => '123456',
            'new_user_password_confirmation' => '123456',
            'make_special_user' => false,
            'user_password' => '123456'
        ];

        // Make post request and check response
        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/create-new-user', $data)
            ->seeJson([
                'success' => true,
                'message' => trans('users_manager.user_created_successfully')
            ]);

        // Check if user exists in database
        $this->seeInDatabase('users', [
            'email' => $user->email,
            'special_user' => false
        ]);
    }

    /**
     * Admin create new special user from users manager section.
     */
    public function test_admin_create_new_special_user() {

        $user = factory(App\User::class)->make();

        // Build post data
        $data = [
            'new_user_email' => $user->email,
            'new_user_password' => '123456',
            'new_user_password_confirmation' => '123456',
            'make_special_user' => true,
            'user_password' => '123456'
        ];

        // Post
        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/create-new-user', $data)
            ->seeJson([
                'success' => true,
                'message' => trans('users_manager.user_created_successfully')
            ]);

        // Check if user exists in database
        $this->seeInDatabase('users', [
            'email' => $user->email,
            'special_user' => true
        ]);
    }

    /**
     * Admin create new user with empty data.
     */
    public function test_admin_create_new_user_with_empty_data() {

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/create-new-user')
            ->seeJson([
                'success' => false
            ]);
    }

    /**
     * Admin create new user with empty email field.
     */
    public function test_admin_create_new_user_without_email() {

        $data = [
            'new_user_password' => '123456',
            'new_user_password_confirmation' => '123456',
            'make_special_user' => false,
            'user_password' => '123456'
        ];

        // Post
        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/create-new-user', $data)
            ->seeJson([
                'success' => false,
                'errors' => ['new_user_email' => trans('validation.required', ['attribute' => trans('validation.attributes.new_user_email')])]
            ]);
    }

    /**
     * Test admin create new user with already used email.
     */
    public function test_admin_create_new_user_with_already_used_email() {

        $user = factory(App\User::class)->create();

        $data = [
            'new_user_email' => $user->email,
            'new_user_password' => '123456',
            'new_user_password_confirmation' => '123456',
            'make_special_user' => false,
            'user_password' => '123456'
        ];

        // Post
        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/create-new-user', $data)
            ->seeJson([
                'success' => false,
                'errors' => ['new_user_email' => trans('validation.not_exists', ['attribute' => trans('validation.attributes.new_user_email')])]
            ]);

        // Make sure new user was not inserted in database
        $this->assertEquals(1, User::where('email', $user->email)->count());
    }

    /**
     * Admin create new user without password field.
     */
    public function test_admin_create_new_user_without_password() {

        $user = factory(App\User::class)->make();

        $data = [
            'new_user_email' => $user->email,
            'new_user_password_confirmation' => '123456',
            'make_special_user' => false,
            'user_password' => '123456'
        ];

        // Post request
        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/create-new-user', $data)
            ->seeJson([
                'success' => false,
                'errors' => ['new_user_password' => trans('validation.required', ['attribute' => trans('validation.attributes.new_user_password')])]
            ]);
    }

    /**
     * Admin create new user without password confirmation field.
     */
    public function test_admin_create_new_user_without_password_confirmation() {

        $user = factory(App\User::class)->make();

        $data = [
            'new_user_email' => $user->email,
            'new_user_password' => '123456',
            'make_special_user' => false,
            'user_password' => '123456'
        ];

        // Make post request
        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/create-new-user', $data)
            ->seeJson([
                'success' => false
            ]);

        // Make sure user was not inserted in database
        $this->notSeeInDatabase('users', [
            'email' => $user->email
        ]);
    }

    /**
     * Admin create new user with empty admin password then with wrong admin password.
     */
    public function test_admin_create_new_user_with_empty_and_then_wrong_admin_password() {

        $user = factory(App\User::class)->make();

        $data = [
            'new_user_email' => $user->email,
            'new_user_password' => '123456',
            'new_user_password_confirmation' => '123456',
            'make_special_user' => false,
        ];

        // Make post request without admin password
        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/create-new-user', $data)
            ->seeJson([
                'success' => false,
                'errors' => ['user_password' => trans('validation.required', ['attribute' => trans('validation.attributes.user_password')])]
            ]);

        // Make sure user was not inserted in database
        $this->notSeeInDatabase('users', [
            'email' => $user->email
        ]);

        $data['user_password'] = 'random wrong password';

        // Make post request with wrong admin password
        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/create-new-user', $data)
            ->seeJson([
                'success' => false,
                'errors' => ['user_password' => trans('validation.check_auth_user_password')]
            ]);

        // Make sure user was not inserted in database
        $this->notSeeInDatabase('users', [
            'email' => $user->email
        ]);
    }

}