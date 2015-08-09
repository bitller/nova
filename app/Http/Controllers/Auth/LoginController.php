<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Contracts\Auth\Guard;

/**
 * Handle user login
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class LoginController extends Controller {

    /**
     * @var Guard|null
     */
    private $auth = null;

    /**
     * @param Guard $auth
     */
    public function __construct(Guard $auth) {

        $this->middleware('guest', ['except' => 'logout']);
        $this->auth = $auth;

    }

    /**
     * Show login page
     * @return \Illuminate\View\View
     */
    public function index() {
        return view('auth.login');
    }

    public function login(LoginRequest $request) {

        $email = $request->input('email');
        $password = $request->input('password');

        // Fire TriedToLogIn event (check for login attempts)

        if ($this->auth->attempt(['email' => $email, 'password' => $password, 'active' => 1])) {
            // User logged in
            // Fire LoggedIn event
            echo 'logged in';
        }

        // Fire FailedLogIn event (with email as parameter)

    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout() {

        $this->auth->logout();
        return redirect('/');

    }

}