<?php

namespace App\Http\Controllers\Bills;

use App\Bill;
use App\Campaign;
use App\Client;
use App\Events\HomepageAccessed;
use App\Events\UserCreatedNewBill;
use App\Helpers\AjaxResponse;
use App\Helpers\Bills;
use App\Helpers\Campaigns;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Bill\CreateBillRequest;
use App\Http\Requests\Bill\SearchBillsRequest;
use DB;
use Illuminate\Http\Request;
use Auth;

/**
 * Bills page controller.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class IndexController extends BaseController {

    /**
     * Initialize required stuff.
     */
    public function __construct() {
        parent::__construct();
        $this->middleware('auth');
    }

    /**
     * Render bills index page.
     *
     * @return \Illuminate\View\View
     */
    public function index() {
        return view('bills.index');
    }

    /**
     * Return paginated bills in json format.
     *
     * @param Request $request
     * @return mixed
     * @internal param bool $first_time
     */
    public function get(Request $request) {

        // Fire event
        event(new HomepageAccessed(Auth::user()->id));

        $config = ['page' => $request->get('page')];

        return Bills::get($config);
    }

    /**
     * Handle creation of new bill.
     *
     * @param CreateBillRequest $request
     * @return array
     */
    public function create(CreateBillRequest $request) {

        // Save request data
        $clientName = $request->get('client');
        $useCurrentCampaign = $request->get('use_current_campaign');
        $campaignYear = $request->get('campaign_year');
        $campaignNumber = $request->get('campaign_number');

        $client = DB::table('clients')->where('name', $clientName)->where('user_id', Auth::user()->id)->first();

        // Create new client if not exists
        if (!$client) {
            $client = new Client();
            $client->user_id = Auth::user()->id;
            $client->name = $clientName;
            $client->save();
        }

        // Create new bill
        $bill = new Bill();
        $bill->client_id = $client->id;
        $bill->user_id = Auth::user()->id;

        $campaign = Campaigns::current();

        // Check if current campaign should be used
        if (!$useCurrentCampaign) {
            $campaign = Campaign::where('year', $campaignYear)->where('number', $campaignNumber)->first();
        }

        $bill->campaign_id = $campaign->id;
        $bill->campaign_order = Campaigns::autoDetermineOrderNumber($campaign, $client->id);
        $bill->save();

        event(new UserCreatedNewBill(Auth::user()->id, $bill->id));

        // Return response
        $response = new AjaxResponse();
        $response->setSuccessMessage(trans('bills.bill_created'));

        return response($response->get());
    }

    public function search(SearchBillsRequest $request) {

        $config = [
            'searchTerm' => $request->get('term'),
            'page' => $request->get('page')
        ];

        return Bills::get($config);
    }
}