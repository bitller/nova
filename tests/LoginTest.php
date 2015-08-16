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
            ->see('The email field is required.');

    }

    public function testLoginWithoutEmail() {

        $this->visit('/login')
            ->type(str_random(10), 'password')
            ->press($this->loginButton)
            ->see('The email field is required.');

    }

    /**
     * Submit login form without password input
     */
    public function testLoginWithoutPassword() {

        $user = factory(App\User::class)->make();

        $this->visit('/login')
            ->type($user->email, 'email')
            ->press($this->loginButton)
            ->see('The password field is required.');

    }

    public function testCreateAccountButton() {

        $this->visit('/login')
            ->click('Creaza cont')
            ->seePageIs('/register');

    }

}