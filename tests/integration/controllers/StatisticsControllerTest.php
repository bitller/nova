<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * Integration tests for StatisticsController.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class StatisticsControllerTest extends TestCase {

    use DatabaseTransactions;
    use WithoutMiddleware;

    /**
     * Make sure getCampaignsYears method works.
     */
    public function test_get_campaigns_years() {

        $user = factory(\App\User::class)->create();

        $expected = [
            'success' => true,
            'years' => \App\Campaign::select('year')->distinct()->get()
        ];

        $this->actingAs($user)
            ->get('/statistics/campaign/get-all-years')
            ->seeJson($expected);
    }

    /**
     * Make sure getCampaignNumbers method works as expected.
     */
    public function test_get_campaign_numbers() {

        $user = factory(\App\User::class)->create();
        $year = 2016;

        $expected = [
            'success' => true,
            'numbers' => \App\Campaign::select('number')->distinct()->where('year', $year)->get()
        ];

        $this->actingAs($user)
            ->post('/statistics/campaign/get-numbers', ['year' => $year])
            ->seeJson($expected);
    }

}