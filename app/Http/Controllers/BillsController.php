<?php

namespace App\Http\Controllers;

use App\Bill;
use App\Client;
use App\Http\Requests\CreateBillRequest;
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

        $bills = Bill::select('bills.id', 'bills.campaign_number', 'bills.campaign_year', 'bills.payment_term', 'bills.other_details', 'clients.name as client_name')
            ->where('bills.user_id', Auth::user()->id)
            ->orderBy('bills.created_at', 'desc')
            ->join('clients', function($join) {
                $join->on('bills.client_id', '=', 'clients.id');
            })
            ->paginate(10);

        return $bills;
    }

    /**
     * @param CreateBillRequest $request
     * @return array
     */
    public function create(CreateBillRequest $request) {

        // Create new client if not exists
        $client = DB::table('clients')->where('name', $request->get('client'))->first();
        if (!$client) {
            $client = new Client();
            $client->user_id = Auth::user()->id;
            $client->name = $request->get('client');
            $client->save();
        }

        $bill = new Bill();
        $bill->client_id = $client->id;
        $bill->user_id = Auth::user()->id;
        $bill->save();

        return [
            'success' => true,
            'message' => trans('bills.bill_created')
        ];
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
            'message' => trans('bills.bill_deleted')
        ];

    }

    public function bill($billId) {

    }

}
