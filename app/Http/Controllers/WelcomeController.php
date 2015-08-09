<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/**
 * WelcomeController
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class WelcomeController extends Controller {

    /**
     * @return \Illuminate\View\View
     */
    public function index() {

        $this->middleware('guest');
        return view('welcome');

    }

}
