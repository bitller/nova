<?php
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Hash;

/**
 * Test edit user password admin feature.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class EditUserPasswordTest extends TestCase {

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
        $this->admin = factory(User::class, 'admin')->create();
        $this->user = factory(User::class)->create();
    }

    /**
     * Edit user password as normal user.
     */
    public function test_normal_user_edit_user_password() {

        $data = [
            'new_password' => '123456',
            'new_password_confirmation' => '123456'
        ];

        $this->actingAs(factory(User::class)->create())
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/change-password', $data)
            ->assertEquals($this->user->password, User::where('id', $this->user->id)->first()->password);
    }

    /**
     * Edit user password with valid data.
     */
    public function test_admin_edit_user_password() {

        $data = [
            'new_password' => 'random_pass',
            'new_password_confirmation' => 'random_pass'
        ];

        // Edit user password as admin
        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/change-password', $data)
            ->seeJson([
                'success' => true,
                'message' => trans('users_manager.user_password_changed')
            ])
            ->assertTrue(Hash::check($data['new_password'], User::where('id', $this->user->id)->first()->password));
    }

    /**
     * Edit user password with empty data.
     */
    public function test_admin_edit_user_password_with_empty_data() {

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/change-password')
            ->seeJson([
                'success' => false,
                'message' => trans('validation.required', ['attribute' => trans('validation.attributes.new_password')])
            ])
            ->seeInDatabase('users', [
                'email' => $this->user->email,
                'password' => $this->user->password
            ]);
    }

    /**
     * Edit user password with empty password field.
     */
    public function test_admin_edit_user_password_with_empty_new_password_field() {

        $data = [
            'new_password_confirmation' => 'rand_pass'
        ];

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/change-password', $data)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.required', ['attribute' => trans('validation.attributes.new_password')])
            ])
            ->seeInDatabase('users', [
                'email' => $this->user->email,
                'password' => $this->user->password
            ]);
    }

    /**
     * Edit user password with empty password confirmation field.
     */
    public function test_admin_edit_user_password_with_empty_new_password_confirmation_field() {

        $data = [
            'new_password' => 'rand_pass'
        ];

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/change-password', $data)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.confirmed', ['attribute' => trans('validation.attributes.new_password')])
            ])
            ->seeInDatabase('users', [
                'email' => $this->user->email,
                'password' => $this->user->password
            ]);
    }

    /**
     * Edit user password with different password confirmation field.
     */
    public function test_admin_edit_user_password_with_different_password_confirmation_field() {

        $data = [
            'new_password' => 'rand_pass',
            'new_password_confirmation' => 'rand_pass_different'
        ];

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/change-password', $data)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.confirmed', ['attribute' => trans('validation.attributes.new_password')])
            ])
            ->seeInDatabase('users', [
                'email' => $this->user->email,
                'password' => $this->user->password
            ]);
    }

    /**
     * Edit user password with too short new password.
     */
    public function test_admin_edit_user_password_with_too_short_new_password_field() {

        $data = [
            'new_password' => 'short',
            'new_password_confirmation' => 'short'
        ];

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/change-password', $data)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.min.string', ['attribute' => trans('validation.attributes.new_password'), 'min' => 6])
            ])
            ->seeInDatabase('users', [
                'email' => $this->user->email,
                'password' => $this->user->password
            ]);
    }

    /**
     * Try to edit user password as not logged in user.
     */
    public function test_not_logged_in_user_edit_user_password() {

        $data = [
            'new_password' => 'rand_pass',
            'new_password_confirmation' => 'rand_pass'
        ];

        $this->post('/admin-center/users-manager/user/' . $this->user->id . '/change-password', $data)
            ->seeInDatabase('users', [
                'email' => $this->user->email,
                'password' => $this->user->password
            ]);
    }

}