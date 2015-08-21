<?php
use Illuminate\Support\Facades\Lang;

/**
 * LoginTest
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class LoginTest extends TestCase {

    /**
     * Submit login form with valid credentials
     */
    public function testLoginWithValidCredentials() {

        $validEmail = 'alexandru.bugarin@gmail.com';
        $validPassword = '123456';

        $this->visit('/login')
            ->type($validEmail, 'email')
            ->type($validPassword, 'password')
            ->press(trans('common.login_button'))
            ->seePageIs('/bills');
    }

    /**
     * Submit login form with all inputs empty
     */
    public function testLoginWithEmptyForm() {

        $this->visit('/login')
            ->press(trans('common.login_button'))
            ->see(trans('validation.required', ['attribute' => 'email']));

    }

    /**
     * Submit login form with email input empty
     */
    public function testLoginWithoutEmail() {

        $this->visit('/login')
            ->type(str_random(10), 'password')
            ->press(trans('common.login_button'))
            ->see(trans('validation.required', ['attribute' => 'email']));

    }

    /**
     * Submit login form without password input
     */
    public function testLoginWithoutPassword() {

        $user = factory(App\User::class)->make();

        $this->visit('/login')
            ->type($user->email, 'email')
            ->press(trans('common.login_button'))
            ->see(trans('validation.required', ['attribute' => 'parolă']));

    }

    /**
     * Check if create account button on login page works
     */
    public function testCreateAccountButton() {

        $this->visit('/login')
            ->click(trans('login.register_button'))
            ->seePageIs('/register');

    }

    /**
     * Check if forgot password link on login page works
     */
    public function testRecoverPasswordLink() {

        $this->visit('/login')
            ->click(trans('login.forgot_password'))
            ->seePageIs('/recover');

    }

}