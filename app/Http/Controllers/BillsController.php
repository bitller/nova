<?php

namespace App\Http\Controllers;

use App\Bill;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Handle the work with bills
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class BillsController extends Controller {

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
        return view('bills');
    }

    /**
     * @return mixed
     */
    public function getBills() {

        $bills = Bill::where('bills.user_id', Auth::user()->id)->join('clients', function($join) {
            $join->on('client_id', '=', 'clients.id');
        })->paginate(10);

        return $bills;
    }

    /**
     * Delete bill that match given $billId
     *
     * @param int $billId
     * @return array
     */
    public function delete($billId) {

        DB::table('bills')->where('id', $billId)->where('user_id', Auth::user()->id)->delete();

        return [
            'success' => true,
            'title' => trans('common.success'),
            'message' => trans('bills.bill_deleted'),
            's' => $billId
        ];

    }

}
