<?php namespace App\Http\Controllers;

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