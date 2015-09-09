<?php

namespace App\Http\Controllers;
use App\Http\Requests\EditProductNameRequest;
use App\Product;
use App\ApplicationProduct;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Add, edit and delete products
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class ProductsController extends Controller {

    /**
     * Initialize and run required methods
     */
    public function __construct() {
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

        $page = $request->get('page');
        if ($page < 1) {
            $page = 1;
        }

        $page--;

        $applicationProducts = DB::table('application_products')->select('id', 'code', 'name', 'default');
        $data = DB::table('products')->select('id', 'code', 'name', 'default')->where('user_id', Auth::user()->id)->orderBy('code', 'asc')->get();

        $perPage = 10;

        $paginator = new LengthAwarePaginator(array_slice($data, $page * $perPage, $perPage), count($data), $perPage);
        $paginator->setPath('/products/get');

        return response($paginator)->header('Content-Type', 'application/json');

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