<?php

namespace App\Http\Controllers\AdminCenter\ProductsManager;

use App\ApplicationProduct;
use App\Http\Controllers\BaseController;
use App\Http\Requests\AdminCenter\ProductsManager\GetProductsRequest;

/**
 * Handle management of application products.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class IndexController extends BaseController {

    /**
     * Run middleware and initialize stuff.
     */
    public function __construct() {
        parent::__construct();
        $this->middleware('auth');
    }

    /**
     * Render products manager index page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        return view('admin-center.products-manager.index');
    }

    public function get(GetProductsRequest $request) {
        return ApplicationProduct::orderBy('created_at', 'desc')->paginate(10);
    }
}