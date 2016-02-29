<?php

namespace App\Http\Controllers\AdminCenter\ProductsManager;

use App\Http\Controllers\BaseController;

/**
 * Handle management of application products.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class IndexController extends BaseController {

    /**
     * Run middlewares and initialize stuff.
     */
    public function __construct() {
        parent::__construct();
        $this->middleware('auth');
    }

    public function index() {
        return view('admin-center.products-manager.index');
    }
}