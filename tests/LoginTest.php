<?php

/**
 * LoginTest
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class LoginTest extends TestCase {

    /**
     * Login button text
     *
     * @var string
     */
    private $loginButton = 'Conecteaza-te';

    private $errors = [
        'empty_form' => 'The email field is required.',
        'empty_email' => 'The email field is required.',
        'empty_password' => 'The password field is required.',
    ];

    /**
     * Submit login form with valid credentials
     */
    public function testLoginWithValidCredentials() {

        $validEmail = 'alexandru.bugarin@gmail.com';
        $validPassword = '123456';

        $this->visit('/login')
            ->type($validEmail, 'email')
            ->type($validPassword, 'password')
            ->press($this->loginButton)
            ->seePageIs('/bills');
    }

    /**
     * Submit login form with all inputs empty
     */
    public function testLoginWithEmptyForm() {

        $this->visit('/login')
            ->press($this->loginButton)
            ->see($this->errors['empty_form']);

    }

    /**
     * Submit login form with email input empty
     */
    public function testLoginWithoutEmail() {

        $this->visit('/login')
            ->type(str_random(10), 'password')
            ->press($this->loginButton)
            ->see($this->errors['empty_email']);

    }

    /**
     * Submit login form without password input
     */
    public function testLoginWithoutPassword() {

        $user = factory(App\User::class)->make();

        $this->visit('/login')
            ->type($user->email, 'email')
            ->press($this->loginButton)
            ->see($this->errors['empty_password']);

    }

    /**
     * Check if create account button on login page works
     */
    public function testCreateAccountButton() {

        $this->visit('/login')
            ->click('Creaza cont')
            ->seePageIs('/register');

    }

    /**
     * Check if forgot password link on login page works
     */
    public function testRecoverPasswordLink() {

        $this->visit('/login')
            ->click('Ai uitat parola?')
            ->seePageIs('/recover');

    }

}