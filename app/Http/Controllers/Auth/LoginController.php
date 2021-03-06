<?php namespace App\Http\Controllers\Auth;

use App\Events\Event;
use App\Events\FailedLogIn;
use App\Events\UserLoggedIn;
use App\Events\UserLoggedOut;
use App\Helpers\AjaxResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Listeners\LogLoginAttempt;
use App\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Lang;

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

        $this->middleware('auth', ['except' => ['index', 'login']]);
        $this->auth = $auth;

    }

    /**
     * Show login page
     * @return \Illuminate\View\View
     */
    public function index() {
        return view('auth.login');
    }

    /**
     * Log user in
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function login(LoginRequest $request) {

        $response = new AjaxResponse();

        // Get inputs
        $email = $request->get('email');
        $password = $request->get('password');

        $userId = User::where('email', $email)->value('id');

        // todo check for login attempts

        // Check if credentials are ok
        if ($this->auth->attempt(['email' => $email, 'password' => $password, 'active' => 1])) {

            event(new UserLoggedIn($this->auth->user()->id));

            $response->setSuccessMessage(trans('common.success'));

            return response($response->get())->header('Content-Type', 'application/json');
        }

        // If email exists in database log the login attempt
        if ($userId) {
            event(new FailedLogIn($userId));
        }

        $response->setFailMessage(trans('login.login_failed'));
        return response($response->get(), $response->getDefaultErrorResponseCode())->header('Content-Type', 'application/json');

    }

    /**
     * Log user out.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout() {

        // Save user id to use later
        $userId = $this->auth->user()->id;

        // Log user out and fire event
        $this->auth->logout();
        event(new UserLoggedOut($userId));

        return redirect(\URL::previous());
    }

}