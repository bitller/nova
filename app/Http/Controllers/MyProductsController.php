<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteMyProductRequest;
use App\Product;
use Illuminate\Support\Facades\Auth;

/**
 * Handle work with products added by users
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class MyProductsController extends Controller {

    /**
     * Initialize required stuff
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index() {
        return view('my-products');
    }

    public function getProducts() {

        return Product::where('user_id', Auth::user()->id)->paginate(10);

    }

    public function addProduct() {
        //
    }

    public function editName() {
        //
    }

    public function editCode() {
        //
    }

    public function deleteProduct($productId) {

        $records = Product::where('user_id', Auth::user()->id)->count();

        Product::where('id', $productId)->where('user_id', Auth::user()->id)->delete();

        $response = [
            'success' => true,
            'title' => trans('common.success'),
            'message' => trans('common.product_deleted')
        ];

        // Return success response if product was deleted
        if (Product::where('user_id', Auth::user()->id)->count() < $records) {
            return response($response)->header('Content-Type', 'application/json');
        }

        $response = [
            'success' => false,
            'title' => trans('common.fail'),
            'message' => trans('common.product_delete_error'),
        ];

        return response($response, 422)->header('Content-Type', 'application/json');

    }

}