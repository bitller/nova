<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Integration tests for detailsAboutNumberClients method.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class DetailsAboutNumberOfClientsTest extends TestCase {

    use DatabaseTransactions;

    /**
     * @var null
     */
    private $user = null;

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

        $this->user = factory(\App\User::class)->create();

        $this->translationData = [
            'campaign_number' => $this->firstCampaign['number'],
            'campaign_year' => $this->firstCampaign['year'],
            'other_campaign_number' => $this->secondCampaign['number'],
            'other_campaign_year' => $this->secondCampaign['year']
        ];
    }

    /**
     * Make sure detailsAboutNumberOfClients works as expected when both campaigns does not have clients.
     */
    public function test_details_about_number_of_clients_when_both_campaigns_does_not_have_clients() {

        $this->translationData['clients'] = 0;

        $expected = [
            'message' => trans('statistics.details_about_number_of_clients_equal_trend', $this->translationData),
            'title' => trans('statistics.details_about_number_of_clients_equal_trend_title'),
            'number_of_clients' => 0,
            'number_of_clients_in_campaign_to_compare' => 0
        ];

        $this->actingAs($this->user)
            ->assertEquals($expected, \App\Helpers\Statistics\CompareCampaignsStatistics::detailsAboutNumberOfClients($this->firstCampaign, $this->secondCampaign));
    }

    /**
     * Test detailsAboutNumberOfClients when only first campaign have clients.
     */
    public function test_details_about_number_of_clients_when_only_first_campaign_have_clients() {

        $clients = factory(\App\Client::class, 4)->create(['user_id' => $this->user->id]);

        foreach ($clients as $client) {
            factory(\App\Bill::class)->create([
                'client_id' => $client->id,
                'user_id' => $this->user->id,
                'campaign_id' => \App\Campaign::where('number', $this->firstCampaign['number'])->where('year', $this->firstCampaign['year'])->first()->id
            ]);
        }

        $this->translationData['clients'] = 4;
        $this->translationData['plus'] = 4;

        $expected = [
            'message' => trans('statistics.details_about_number_of_clients_up_trend', $this->translationData),
            'title' => trans('statistics.details_about_number_of_clients_up_trend_title', ['percent' => 100]),
            'number_of_clients' => 4,
            'number_of_clients_in_campaign_to_compare' => 0
        ];

        $this->actingAs($this->user)
            ->assertEquals($expected, \App\Helpers\Statistics\CompareCampaignsStatistics::detailsAboutNumberOfClients($this->firstCampaign, $this->secondCampaign));
    }

    /**
     * Make sure detailsAboutNumberOfClients works as expected when only campaign to compare have clients.
     */
    public function test_details_about_number_of_clients_when_only_campaign_to_compare_have_clients() {

        $clients = factory(\App\Client::class, 5)->create(['user_id' => $this->user->id]);

        foreach ($clients as $client) {
            factory(\App\Bill::class)->create([
                'client_id' => $client->id,
                'user_id' => $this->user->id,
                'campaign_id' => \App\Campaign::where('number', $this->secondCampaign['number'])->where('year', $this->secondCampaign['year'])->first()->id
            ]);
        }

        $this->translationData['clients'] = 0;
        $this->translationData['minus'] = 5;

        $expected = [
            'message' => trans('statistics.details_about_number_of_clients_down_trend', $this->translationData),
            'title' => trans('statistics.details_about_number_of_clients_down_trend_title', ['percent' => 100]),
            'number_of_clients' => 0,
            'number_of_clients_in_campaign_to_compare' => 5
        ];

        $this->actingAs($this->user)
            ->assertEquals($expected, \App\Helpers\Statistics\CompareCampaignsStatistics::detailsAboutNumberOfClients($this->firstCampaign, $this->secondCampaign));
    }

    /**
     * Test detailsAboutNumberOfClients works as expected when first campaign have more clients.
     */
    public function test_details_about_number_of_clients_when_first_campaign_have_more_clients() {

        $clients = factory(\App\Client::class, 5)->create(['user_id' => $this->user->id]);

        foreach ($clients as $client) {
            factory(\App\Bill::class)->create([
                'client_id' => $client->id,
                'user_id' => $this->user->id,
                'campaign_id' => \App\Campaign::where('number', $this->firstCampaign['number'])->where('year', $this->firstCampaign['year'])->first()->id
            ]);
        }

        foreach ($clients as $client) {
            factory(\App\Bill::class)->create([
                'client_id' => $client->id,
                'user_id' => $this->user->id,
                'campaign_id' => \App\Campaign::where('number', $this->secondCampaign['number'])->where('year', $this->secondCampaign['year'])->first()->id
            ]);
            break;
        }

        $this->translationData['clients'] = 5;
        $this->translationData['plus'] = 4;

        $expected = [
            'message' => trans('statistics.details_about_number_of_clients_up_trend', $this->translationData),
            'title' => trans('statistics.details_about_number_of_clients_up_trend_title', ['percent' => 80]),
            'number_of_clients' => 5,
            'number_of_clients_in_campaign_to_compare' => 1
        ];

        $this->actingAs($this->user)
            ->assertEquals($expected, \App\Helpers\Statistics\CompareCampaignsStatistics::detailsAboutNumberOfClients($this->firstCampaign, $this->secondCampaign));
    }

    /**
     * Make sure detailsAboutNumberOfClients works as expected when campaign to compare have more clients.
     */
    public function test_details_about_number_of_clients_when_campaign_to_compare_have_more_clients() {

        $clients = factory(\App\Client::class, 5)->create(['user_id' => $this->user->id]);

        foreach ($clients as $client) {
            factory(\App\Bill::class)->create([
                'client_id' => $client->id,
                'user_id' => $this->user->id,
                'campaign_id' => \App\Campaign::where('number', $this->firstCampaign['number'])->where('year', $this->firstCampaign['year'])->first()->id
            ]);
            break;
        }

        foreach ($clients as $client) {
            factory(\App\Bill::class)->create([
                'client_id' => $client->id,
                'user_id' => $this->user->id,
                'campaign_id' => \App\Campaign::where('number', $this->secondCampaign['number'])->where('year', $this->secondCampaign['year'])->first()->id
            ]);
        }

        $this->translationData['clients'] = 1;
        $this->translationData['minus'] = 4;

        $expected = [
            'message' => trans('statistics.details_about_number_of_clients_down_trend', $this->translationData),
            'title' => trans('statistics.details_about_number_of_clients_down_trend_title', ['percent' => 80]),
            'number_of_clients' => 1,
            'number_of_clients_in_campaign_to_compare' => 5
        ];

        $this->actingAs($this->user)
            ->assertEquals($expected, \App\Helpers\Statistics\CompareCampaignsStatistics::detailsAboutNumberOfClients($this->firstCampaign, $this->secondCampaign));
    }

    /**
     * Make sure detailsAboutNumberOfClients works as expected when both campaigns have same number of clients.
     */
    public function test_details_about_number_of_clients_when_both_campaigns_have_same_number_of_clients() {

        $clients = factory(\App\Client::class, 4)->create(['user_id' => $this->user->id]);

        foreach ($clients as $client) {
            factory(\App\Bill::class)->create([
                'client_id' => $client->id,
                'user_id' => $this->user->id,
                'campaign_id' => \App\Campaign::where('number', $this->firstCampaign['number'])->where('year', $this->firstCampaign['year'])->first()->id
            ]);

            factory(\App\Bill::class)->create([
                'client_id' => $client->id,
                'user_id' => $this->user->id,
                'campaign_id' => \App\Campaign::where('number', $this->secondCampaign['number'])->where('year', $this->secondCampaign['year'])->first()->id
            ]);
        }

        $this->translationData['clients'] = 4;

        $expected = [
            'message' => trans('statistics.details_about_number_of_clients_equal_trend', $this->translationData),
            'title' => trans('statistics.details_about_number_of_clients_equal_trend_title'),
            'number_of_clients' => 4,
            'number_of_clients_in_campaign_to_compare' => 4
        ];

        $this->actingAs($this->user)
            ->assertEquals($expected, \App\Helpers\Statistics\CompareCampaignsStatistics::detailsAboutNumberOfClients($this->firstCampaign, $this->secondCampaign));
    }
}