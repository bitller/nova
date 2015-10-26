<?php

namespace App\Http\Controllers;

use App\Helpers\Searches;
use Illuminate\Http\Request;

/**
 * Handle application header search
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class SearchController extends BaseController {

    public function headerSearch(Request $request) {
        return Searches::headerSearch($request->get('query'));
    }

}