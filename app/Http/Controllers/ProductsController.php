<?php

namespace App\Http\Controllers;
use App\Helpers\Settings;
use App\Http\Requests\EditProductNameRequest;
use App\Product;
use App\ApplicationProduct;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Add, edit and delete products.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class ProductsController extends BaseController {

    /**
     * Initialize and run required methods
     */
    public function __construct() {
        parent::__construct();
        $this->middleware('auth');
    }

    /**
     * Render products index page
     *
     * @return \Illuminate\View\View
     */
    public function index() {
        return view('products');
    }

    /**
     * Paginate products in json
     *
     * @param Request $request
     * @return mixed
     */
    public function getProducts(Request $request) {
        return ApplicationProduct::orderBy('code', 'asc')->paginate(Settings::displayedProducts());
    }

    /**
     * @param int $productId
     * @param EditProductNameRequest $request
     * @return mixed
     */
    public function editName($productId, EditProductNameRequest $request) {

        $name = $request->get('name');
        DB::table('products')->where('id', $productId)->where('user_id', Auth::user()->id)->update(['name' => $name]);

        $response = [
            'success' => true,
            'title' => trans('common.success'),
            'message' => trans('products.product_name_edited')
        ];

        return response($response)->header('Content-Type', 'application/json');

    }

}