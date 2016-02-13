<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Helpers\AjaxResponse;
use App\Helpers\Statistics\CompareCampaignsStatistics;
use App\Helpers\Statistics\CampaignStatistics;
use App\Http\Requests\Statistics\GetCampaignNumbersRequest;
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

    /**
     * Compare given campaigns.
     *
     * @param int $campaignNumber
     * @param int $campaignYear
     * @param int $otherCampaignNumber
     * @param int $otherCampaignYear
     * @return mixed
     */
    public function compareCampaigns($campaignNumber, $campaignYear, $otherCampaignNumber, $otherCampaignYear) {
        return view('statistics.compare-campaigns')->with('campaignNumber', $campaignNumber)->with('campaignYear', $campaignYear)
            ->with('otherCampaignNumber', $otherCampaignNumber)->with('otherCampaignYear', $otherCampaignYear);
    }

    public function getCompareCampaignsData($campaignNumber, $campaignYear, $otherCampaignNumber, $otherCampaignYear) {

        $firstCampaign = [
            'number' => $campaignNumber,
            'year' => $campaignYear
        ];

        $secondCampaign = [
            'number' => $otherCampaignNumber,
            'year' => $otherCampaignYear
        ];

        $response = new AjaxResponse();
        $response->setSuccessMessage(trans('common.success'));
        $response->addExtraFields(['statistics' => CompareCampaignsStatistics::all($firstCampaign, $secondCampaign)]);

        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Return all years used by campaigns.
     *
     * @return mixed
     */
    public function getCampaignsYears() {

        $response = new AjaxResponse();
        $response->setSuccessMessage(trans('common.success'));

        $response->addExtraFields(['years' => Campaign::select('year')->distinct()->get()]);

        return response($response->get())->header('Content-Type', 'application/json');
    }

    /**
     * Return all campaign numbers for given year.
     *
     * @param Requests\Statistics\GetCampaignNumbersRequest $request
     * @return mixed
     */
    public function getCampaignNumbers(GetCampaignNumbersRequest $request) {

        $response = new AjaxResponse();
        $response->setSuccessMessage(trans('common.success'));

        $response->addExtraFields(['numbers' => Campaign::select('number')->distinct()->where('year', $request->get('year'))->get()]);

        return response($response->get())->header('Content-Type', 'application/json');
    }
}
