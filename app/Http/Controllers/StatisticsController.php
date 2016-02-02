<?php

namespace App\Http\Controllers;

use App\Helpers\AjaxResponse;
use App\Helpers\Statistics\CampaignStatistics;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers\Statistics;

/**
 * Handle user statistics
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class StatisticsController extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->middleware('auth');
    }

    public function index() {
        return view('statistics');
    }

    public function get() {

        $response = new AjaxResponse();
        $response->setSuccessMessage('success');
        $response->addExtraFields(Statistics::general());
        return response($response->get());

    }

    public function campaign($campaignNumber, $campaignYear) {
        return view('statistics.campaign')->with('campaignNumber', $campaignNumber)->with('campaignYear', $campaignYear);
    }

    public function getCampaignStatistics($campaignNumber, $campaignYear) {

        $response = new AjaxResponse();

        $response->setSuccessMessage(trans('common.success'));
        $statistics = CampaignStatistics::all($campaignNumber, $campaignYear);
        $response->addExtraFields(['statistics' => $statistics]);

        return response($response->get())->header('Content-Type', 'application/json');
    }
}
