<?php
use App\User;
use Illuminate\Support\Facades\Hash;

/**
 * Acceptance test for user section of users manager.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class UserSectionTest extends TestCase {

    use \Illuminate\Foundation\Testing\DatabaseTransactions;

    use \Illuminate\Foundation\Testing\WithoutMiddleware;

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

        // Generate admin
        $this->admin = factory(App\User::class, 'admin')->create();

        // Generate user
        $this->user = factory(App\User::class)->create();
    }

    /**
     * Admin edit user email.
     */
    public function test_admin_edit_user_email() {

        // Generate new user to get their email
        $newUser = factory(App\User::class)->make();

        $data = [
            'email' => $newUser->email
        ];

        // Make post request to edit user email
        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/'.$this->user->id.'/edit-email', $data)
            // Check json response
            ->seeJson([
                'success' => true,
                'message' => trans('users_manager.user_email_updated')
            ])
            // Make sure new email exists in database
            ->seeInDatabase('users', [
                'email' => $newUser->email
            ])
            // Check if old one is still in database
            ->notSeeInDatabase('users', [
                'email' => $this->user->email
            ]);
    }

    /**
     * Make post request to edit user email with empty data, already used email, invalid email format and as normal user instead of admin.
     */
    public function test_admin_edit_email_with_error() {

        $requestUrl = '/admin-center/users-manager/user/' . $this->user->id . '/edit-email';

        // Make post request with empty data
        $this->actingAs($this->admin)
            ->post($requestUrl)
            // Check json response
            ->seeJson([
                'success' => false,
                'message' => trans('validation.required', ['attribute' => trans('validation.attributes.email')])
            ])
            // Make sure email was not updated in database
            ->seeInDatabase('users',[
                'email' => $this->user->email
            ]);

        $data = [
            'email' => 'random string' . rand()
        ];

        // Make post request with invalid email format
        $this->actingAs($this->admin)
            ->post($requestUrl, $data)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.email', ['attribute' => trans('validation.attributes.email')])
            ])
            // Make sure email was not updated in database
            ->notSeeInDatabase('users', [
                'email' => $data['email']
            ])->seeInDatabase('users', [
                'email' => $this->user->email
            ]);

        // Make post request with already used email
        $anotherUser = factory(App\User::class)->create();

        $data = [
            'email' => $anotherUser->email
        ];

        $this->actingAs($this->admin)
            ->post($requestUrl, $data)
            ->seeJson([
                'success' => false,
                'message' => trans('users_manager.email_already_used')
            ])
            ->seeInDatabase('users', [
                'email' => $anotherUser->email
            ]);

        // Make post request as normal user
        $data = [
            'email' => factory(App\User::class)->make()->email
        ];
        $this->actingAs($anotherUser)
            ->post($requestUrl, $data)
            ->notSeeInDatabase('users', [
                'email' => $data['email']
            ]);
    }

    public function test_admin_edit_user_password() {

        $requestUrl = '/admin-center/users-manager/user/' . $this->user->id . '/change-password';

        $data = [
            'new_password' => 'random_pass',
            'new_password_confirmation' => 'random_pass'
        ];

        // Edit user password as normal user
        $this->actingAs(factory(App\User::class)->create())
            ->post($requestUrl, $data);
        $this->assertEquals($this->user->password, User::where('id', $this->user->id)->first()->password);

        // Edit user password as admin
        $this->actingAs($this->admin)
            ->post($requestUrl, $data)
            ->seeJson([
                'success' => true,
                'message' => trans('users_manager.user_password_changed')
            ])
            ->assertTrue(Hash::check($data['new_password'], User::where('id', $this->user->id)->first()->password));

        // Edit user password with empty data
        $this->actingAs($this->admin)
            ->post($requestUrl, $data)
            ->seeJson([
                'success' => false,
                'message' => trans('validation.required', ['attribute' => trans('validation.new_password')])
            ])
            ->assertEquals($this->user->password, User::where('id', $this->user->id)->first()->password);

        // Edit user password with missing new_password
        // Edit user password with missing new_password_confirmation
        // Edit user password with different new_password_confirmation
        // Edit user password with too short password
        // Edit user password with too long password
    }

    /**
     * Test enable user account admin functionality.
     */
    public function test_admin_enable_user_account() {

        // Enable a disabled account
        $anotherUser = factory(App\User::class)->create(['active' => 0]);

        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $anotherUser->id . '/enable-account')
            ->seeJson([
                'success' => true,
                'message' => trans('users_manager.account_enabled')
            ])
            ->seeInDatabase('users', [
                'email' => $anotherUser->email,
                'active' => 1
            ]);

        // Enable an already enabled account
        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $anotherUser->id . '/enable-account')
            ->seeJson([
                'success' => true,
                'message' => trans('users_manager.account_enabled')
            ])
            ->seeInDatabase('users', [
                'email' => $anotherUser->email,
                'active' => 1
            ]);

        // Enable a non existent account
        $randomId = rand(1000,9999);
        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $randomId . '/enable-account')
            ->notSeeInDatabase('users', [
                'id' => $randomId
            ]);
    }

    /**
     * Test disable user account admin feature.
     */
    public function test_admin_disable_user_account() {

        // Disable account as normal user
        $this->actingAs(factory(App\User::class)->create())
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/enable-account')
            ->seeInDatabase('users', [
                'email' => $this->user->email,
                'active' => 1
            ]);

        // Disable an enabled account
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

        // Disable an already disabled account
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

        // Enable a non existent account
        $randomId = rand(1000,9999);
        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $randomId . '/disable-account')
            ->notSeeInDatabase('users',[
                'id' => $randomId
            ]);
    }

    /**
     * Test delete user account admin functionality.
     */
    public function test_admin_delete_user_account() {

        // Make success request
        $this->actingAs($this->admin)
            ->post('/admin-center/users-manager/user/' . $this->user->id . '/delete-account')
            ->seeJson([
                'success' => true
            ])
            ->notSeeInDatabase('users', [
                'email' => $this->user->email
            ]);

        // Make request with not existent user id
        $this->actingAs($this->admin)
            ->post('admin-center/users-manager/user/' . rand(1000, 9999) . '/delete-account')
            ->seeJson([
                'success' => false,
                'message' => trans('users_manager.user_not_found')
            ]);

        // Make request as normal user
        $firstUser = factory(App\User::class)->create();
        $secondUser = factory(App\User::class)->create();

        $this->actingAs($firstUser)
            ->post('admin-center/users-manager/user/' . $secondUser->id . '/delete-account')
            ->seeInDatabase('users', [
                'email' => $secondUser->email
            ]);
    }

}