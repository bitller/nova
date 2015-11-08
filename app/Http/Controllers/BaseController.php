<?php

namespace App\Http\Controllers;
use App\Helpers\Roles;
use Illuminate\Support\Facades\App;
use App\Helpers\Settings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

/**
 * Base controller to be extended by rest of controllers
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class BaseController extends Controller {

    /**
     * Initialize required stuff.
     */
    public function __construct() {

        if (Auth::check()) {

            // Check if admin center should be displayed
            $roles = new Roles();
            $showAdminCenter = false;
            if ($roles->getAdminRoleId() === Auth::user()->role_id || $roles->getModeratorRoleId() === Auth::user()->role_id) {
                $showAdminCenter = true;
            }

            View::share([
                'showAdminCenter' => $showAdminCenter
            ]);

            App::setLocale(Settings::language());
        }
    }

}