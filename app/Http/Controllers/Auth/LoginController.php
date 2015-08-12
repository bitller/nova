<?php namespace App\Http\Controllers\Auth;

use App\Events\Event;
use App\Events\FailedLogIn;
use App\Events\UserLoggedIn;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Listeners\LogLoginAttempt;
use App\User;
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

        $userId = User::where('email', $email)->value('id');

        // Check if credentials are ok
        if ($this->auth->attempt(['email' => $email, 'password' => $password, 'active' => 1])) {

            event(new UserLoggedIn($this->auth->user()->id));
            return redirect('/bills');

        }

        // If email exists in database log the login attempt
        if ($userId) {
            event(new FailedLogIn($userId));
        }

    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout() {

        $this->auth->logout();
        return redirect('/');

    }

}