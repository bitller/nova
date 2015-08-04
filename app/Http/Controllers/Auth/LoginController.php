<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

/**
 * Handle user login
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class LoginController extends Controller {

    public function __construct() {
        $this->middleware('guest');
    }

    /**
     * Show login page
     * @return \Illuminate\View\View
     */
    public function index() {
        return view('auth.login');
    }

}