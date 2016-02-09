<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Integration tests for numberOfBillsDetails method.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class DetailsAboutNumberOfBillsTest extends TestCase {

    use DatabaseTransactions;

    /**
     * @var null
     */
    private $user = null;

    /**
     * @var null
     */
    private $client = null;

    /**
     * @var array
     */
    private $firstCampaign = [
        'number' => 1,
        'year' => 2016
    ];

    /**
     * @var array
     */
    private $secondCampaign = [
        'number' => 2,
        'year' => 2016
    ];

    /**
     * @var array
     */
    private $translationData = [];

    /**
     * Called before each test.
     */
    public function setUp() {

        parent::setUp();

        // Generate user and client
        $this->user = factory(\App\User::class)->create();
        $this->client = factory(\App\Client::class)->create(['user_id' => $this->user->id]);

        // Build basic translation data
        $this->translationData = [
            'campaign_number' => $this->firstCampaign['number'],
            'campaign_year' => $this->firstCampaign['year'],
            'other_campaign_number' => $this->secondCampaign['number'],
            'other_campaign_year' => $this->secondCampaign['year']
        ];
    }

    /**
     * Test detailsAboutNumberOfBills method works as expected when both campaign have no bills.
     */
    public function test_details_about_number_of_bills_when_both_campaigns_have_no_bills() {

        $this->translationData['bills'] = 0;

        $expected = [
            'message' => trans('statistics.details_about_number_of_bills_equal_trend', $this->translationData),
            'title' => trans('statistics.details_about_number_of_bills_equal_trend_title'),
            'number_of_bills' => 0,
            'number_of_bills_in_campaign_to_compare' => 0
        ];

        $this->actingAs($this->user)
            ->assertEquals($expected, \App\Helpers\Statistics\CompareCampaignsStatistics::detailsAboutNumberOfBills($this->firstCampaign, $this->secondCampaign));
    }

    /**
     * Make sure detailsAboutNumberOfBills works as expected only when first campaign contains bills.
     */
    public function test_details_about_number_of_bills_when_only_first_campaign_contains_bills() {

        factory(\App\Bill::class, 3)->create([
            'client_id' => $this->client->id,
            'user_id' => $this->user->id,
            'campaign_id' => \App\Campaign::where('number', $this->firstCampaign['number'])->where('year', $this->firstCampaign['year'])->first()->id
        ]);

        $this->translationData['bills'] = 3;
        $this->translationData['plus'] = 3;

        $expected = [
            'message' => trans('statistics.details_about_number_of_bills_up_trend', $this->translationData),
            'title' => trans('statistics.details_about_number_of_bills_up_trend_title', ['percent' => 100]),
            'number_of_bills' => 3,
            'number_of_bills_in_campaign_to_compare' => 0
        ];

        $this->actingAs($this->user)
            ->assertEquals($expected, \App\Helpers\Statistics\CompareCampaignsStatistics::detailsAboutNumberOfBills($this->firstCampaign, $this->secondCampaign));
    }

    /**
     * Make sure detailsAboutNumberOfBills works as expected when only campaign to compare contains bills.
     */
    public function test_details_about_number_of_bills_when_only_campaign_to_compare_contains_bills() {

        factory(\App\Bill::class, 4)->create([
            'client_id' => $this->client->id,
            'user_id' => $this->user->id,
            'campaign_id' => \App\Campaign::where('number', $this->secondCampaign['number'])->where('year', $this->secondCampaign['year'])->first()->id
        ]);

        $this->translationData['bills'] = 0;
        $this->translationData['minus'] = 4;

        $expected = [
            'message' => trans('statistics.details_about_number_of_bills_down_trend', $this->translationData),
            'title' => trans('statistics.details_about_number_of_bills_down_trend_title', ['percent' => 100]),
            'number_of_bills' => 0,
            'number_of_bills_in_campaign_to_compare' => 4
        ];

        $this->actingAs($this->user)
            ->assertEquals($expected, \App\Helpers\Statistics\CompareCampaignsStatistics::detailsAboutNumberOfBills($this->firstCampaign, $this->secondCampaign));
    }

    /**
     * Test detailsAboutNumberOfBills works when first campaign have more bills.
     */
    public function test_details_about_number_of_bills_when_first_campaign_have_more_bills() {

        factory(\App\Bill::class, 10)->create([
            'client_id' => $this->client->id,
            'user_id' => $this->user->id,
            'campaign_id' => \App\Campaign::where('number', $this->firstCampaign['number'])->where('year', $this->firstCampaign['year'])->first()->id
        ]);

        factory(\App\Bill::class, 8)->create([
            'client_id' => $this->client->id,
            'user_id' => $this->user->id,
            'campaign_id' => \App\Campaign::where('number', $this->secondCampaign['number'])->where('year', $this->secondCampaign['year'])->first()->id
        ]);

        $this->translationData['bills'] = 10;
        $this->translationData['plus'] = 2;

        $expected = [
            'message' => trans('statistics.details_about_number_of_bills_up_trend', $this->translationData),
            'title' => trans('statistics.details_about_number_of_bills_up_trend_title', ['percent' => '20.00']),
            'number_of_bills' => 10,
            'number_of_bills_in_campaign_to_compare' => 8
        ];

        $this->actingAs($this->user)
            ->assertEquals($expected, \App\Helpers\Statistics\CompareCampaignsStatistics::detailsAboutNumberOfBills($this->firstCampaign, $this->secondCampaign));
    }

    /**
     * Test detailsAboutNumberOfBills works when campaign to compare have more bills.
     */
    public function test_details_about_number_of_bills_when_campaign_to_compare_have_more_bills() {

        factory(\App\Bill::class, 90)->create([
            'client_id' => $this->client->id,
            'user_id' => $this->user->id,
            'campaign_id' => \App\Campaign::where('number', $this->firstCampaign['number'])->where('year', $this->firstCampaign['year'])->first()->id
        ]);

        factory(\App\Bill::class, 100)->create([
            'client_id' => $this->client->id,
            'user_id' => $this->user->id,
            'campaign_id' => \App\Campaign::where('number', $this->secondCampaign['number'])->where('year', $this->secondCampaign['year'])->first()->id
        ]);

        $this->translationData['bills'] = 90;
        $this->translationData['minus'] = 10;

        $expected = [
            'message' => trans('statistics.details_about_number_of_bills_down_trend', $this->translationData),
            'title' => trans('statistics.details_about_number_of_bills_down_trend_title', ['percent' => '10.00']),
            'number_of_bills' => 90,
            'number_of_bills_in_campaign_to_compare' => 100
        ];

        $this->actingAs($this->user)
            ->assertEquals($expected, \App\Helpers\Statistics\CompareCampaignsStatistics::detailsAboutNumberOfBills($this->firstCampaign, $this->secondCampaign));
    }

    /**
     * Make sure detailsAboutNumberOfBills works as expected when both campaigns have the same number of bills.
     */
    public function test_details_about_number_of_bills_when_both_campaigns_have_the_same_number_of_bills() {

        factory(\App\Bill::class, 4)->create([
            'client_id' => $this->client->id,
            'user_id' => $this->user->id,
            'campaign_id' => \App\Campaign::where('number', $this->firstCampaign['number'])->where('year', $this->firstCampaign['year'])->first()->id
        ]);

        factory(\App\Bill::class, 4)->create([
            'client_id' => $this->client->id,
            'user_id' => $this->user->id,
            'campaign_id' => \App\Campaign::where('number', $this->secondCampaign['number'])->where('year', $this->secondCampaign['year'])->first()->id
        ]);

        $this->translationData['bills'] = 4;

        $expected = [
            'message' => trans('statistics.details_about_number_of_bills_equal_trend', $this->translationData),
            'title' => trans('statistics.details_about_number_of_bills_equal_trend_title'),
            'number_of_bills' => 4,
            'number_of_bills_in_campaign_to_compare' => 4
        ];

        $this->actingAs($this->user)
            ->assertEquals($expected, \App\Helpers\Statistics\CompareCampaignsStatistics::detailsAboutNumberOfBills($this->firstCampaign, $this->secondCampaign));
    }
}