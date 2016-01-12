<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * Test edit user email admin feature.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class EditUserEmailTest extends TestCase {

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
     * Not logged in user tries to edit user email.
     */
    public function test_not_logged_in_user_tries_to_edit_user_email() {

        $newUser = factory(App\User::class)->make();

        $data = [
            'email' => $newUser->email
        ];

        $this->post('/admin-center/users-manager/user/' . $this->user->id . '/edit-email', $data)
            ->notSeeInDatabase('users', [
                'email' => $newUser->email
            ]);
    }

    /**
     * Normal user tries to edit user email.
     */
    public function test_normal_user_tries_to_edit_user_email() {

        $newUser = factory(App\User::class)->make();

        $data = [
            'email' => $newUser->email
        ];

        $this->actingAs($newUser)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/edit-email', $data)
            ->notSeeInDatabase('users', [
                'email' => $newUser->email
            ]);
    }

    /**
     * Admin edit user email.
     */
    public function test_admin_edit_user_email() {

        $newUser = factory(App\User::class)->make();

        $data = [
            'email' => $newUser->email
        ];

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/edit-email', $data)
            ->seeJson([
                'success' => true,
                'message' => trans('users_manager.user_email_updated')
            ])
            ->seeInDatabase('users', [
                'email' => $newUser->email
            ]);
    }

    /**
     * Admin tries to edit user email with an invalid email.
     */
    public function test_admin_edit_user_email_with_invalid_email_format() {

        $data = [
            'email' => 'wrong@format'
        ];

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/edit-email', $data)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.email', ['attribute' => trans('validation.attributes.email')])
            ])
            ->notSeeInDatabase('users', [
                'email' => $data['email']
            ]);
    }

    /**
     * Admin tries to edit user email with already used email.
     */
    public function test_admin_edit_user_email_with_already_used_email() {

        $user = factory(App\User::class)->create();

        $data = [
            'email' => $user->email
        ];

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/edit-email', $data)
            ->seeJson([
                'success' => false,
                'message' => trans('users_manager.email_already_used')
            ]);
    }

}