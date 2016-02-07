<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Integration tests for CompareCampaignsStatistics helper.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class SoldProductsDetailsTest extends TestCase {

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
     * @var null
     */
    private $billInFirstCampaign = null;

    /**
     * @var null
     */
    private $billInComparedCampaign = null;

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
     * Called before each test.
     */
    public function setUp() {

        parent::setUp();

        // Generate user and client
        $this->user = factory(App\User::class)->create();
        $this->client = factory(\App\Client::class)->create(['user_id' => $this->user->id]);

        // Generate the two bills
        $this->billInFirstCampaign = factory(\App\Bill::class)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id,
            'campaign_id' => \App\Campaign::where('year', $this->firstCampaign['year'])->where('number', $this->firstCampaign['number'])->first()->id
        ]);

        $this->billInComparedCampaign = factory(\App\Bill::class)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id,
            'campaign_id' => \App\Campaign::where('year', $this->secondCampaign['year'])->where('number', $this->secondCampaign['number'])->first()->id
        ]);
    }

    /**
     * Test soldProductsDetails method works as expected when in first campaign are no products.
     */
    public function test_sold_products_details_with_no_sold_products_in_first_campaign() {

        // Add product to the second bill
        $product = factory(\App\Product::class)->create(['user_id' => $this->user->id]);
        factory(\App\BillProduct::class)->create([
            'bill_id' => $this->billInComparedCampaign->id,
            'product_id' => $product->id,
            'quantity' => 2
        ]);

        $expectedStatistics = [
            'message' => trans('statistics.sold_products_down_trend', [
                'campaign_number' => $this->firstCampaign['number'],
                'campaign_year' => $this->firstCampaign['year'],
                'minus' => 2,
                'number' => 0,
                'other_campaign_number' => $this->secondCampaign['number'],
                'other_campaign_year' => $this->secondCampaign['year']
            ]),
            'title' => trans('statistics.sold_products_down_trend_title', ['percent' => 100]),
            'products_sold_in_campaign' => 0,
            'products_in_campaign_to_compare' => '2'
        ];

        $this->actingAs($this->user)
            ->assertSame($expectedStatistics, \App\Helpers\Statistics\CompareCampaignsStatistics::soldProductsDetails($this->firstCampaign, $this->secondCampaign));
    }

    /**
     * Test soldProductsDetails method work as expected when in compared campaign are no products.
     */
    public function test_sold_products_details_with_no_sold_products_in_compared_campaign() {

        // Add one product to the first bill
        $product = factory(\App\Product::class)->create(['user_id' => $this->user->id]);
        $billProduct = factory(\App\BillProduct::class)->create([
            'bill_id' => $this->billInFirstCampaign->id,
            'product_id' => $product->id,
            'quantity' => 2
        ]);

        $expectedStatistics = [
            'message' => trans('statistics.sold_products_up_trend', [
                'campaign_number' => $this->firstCampaign['number'],
                'campaign_year' => $this->firstCampaign['year'],
                'plus' => 2,
                'number' => 2,
                'other_campaign_number' => $this->secondCampaign['number'],
                'other_campaign_year' => $this->secondCampaign['year']
            ]),
            'title' => trans('statistics.sold_products_up_trend_title', ['percent' => 100]),
            'products_sold_in_campaign' => '2',
            'products_in_campaign_to_compare' => 0
        ];

        $this->actingAs($this->user)
            ->assertSame($expectedStatistics, \App\Helpers\Statistics\CompareCampaignsStatistics::soldProductsDetails($this->firstCampaign, $this->secondCampaign));
    }

    /**
     * Test soldProductsDetails method wok as expected when both campaigns has no products.
     */
    public function test_sold_products_details_with_no_products_in_both_campaigns() {

        $expectedStatistics = [
            'message' => trans('statistics.sold_products_equal_trend', [
                'campaign_number' => $this->firstCampaign['number'],
                'campaign_year' => $this->firstCampaign['year'],
                'plus' => 0,
                'number' => 0,
                'other_campaign_number' => $this->secondCampaign['number'],
                'other_campaign_year' => $this->secondCampaign['year']
            ]),
            'title' => trans('statistics.sold_products_equal_trend_title'),
            'products_sold_in_campaign' => 0,
            'products_in_campaign_to_compare' => 0
        ];

        $this->actingAs($this->user)
            ->assertSame($expectedStatistics, \App\Helpers\Statistics\CompareCampaignsStatistics::soldProductsDetails($this->firstCampaign, $this->secondCampaign));
    }

    /**
     * Test soldProductsDetails when both campaigns has products.
     */
    public function test_sold_products_when_both_campaign_has_products() {

        $product = factory(\App\Product::class)->create(['user_id' => $this->user->id]);
        factory(\App\BillProduct::class)->create([
            'bill_id' => $this->billInFirstCampaign->id,
            'product_id' => $product->id,
            'quantity' => 2
        ]);

        factory(\App\BillProduct::class)->create([
            'bill_id' => $this->billInComparedCampaign->id,
            'product_id' => $product->id,
            'quantity' => 4
        ]);

        $expectedStatistics = [
            'message' => trans('statistics.sold_products_down_trend', [
                'campaign_number' => $this->firstCampaign['number'],
                'campaign_year' => $this->firstCampaign['year'],
                'minus' => 2,
                'number' => 2,
                'other_campaign_number' => $this->secondCampaign['number'],
                'other_campaign_year' => $this->secondCampaign['year']
            ]),
            'title' => trans('statistics.sold_products_down_trend_title', ['percent' => 50]),
            'products_sold_in_campaign' => '2',
            'products_in_campaign_to_compare' => '4'
        ];

        $this->actingAs($this->user)
            ->assertSame($expectedStatistics, \App\Helpers\Statistics\CompareCampaignsStatistics::soldProductsDetails($this->firstCampaign, $this->secondCampaign));
    }

    /**
     * Test soldProductsDetails works as expected when are more products in first campaign.
     */
    public function test_sold_products_with_more_products_in_first_campaign() {

        $product = factory(\App\Product::class)->create(['user_id' => $this->user->id]);

        factory(\App\BillProduct::class)->create([
            'bill_id' => $this->billInFirstCampaign->id,
            'product_id' => $product->id,
            'quantity' => 10
        ]);

        factory(\App\BillProduct::class)->create([
            'bill_id' => $this->billInComparedCampaign->id,
            'product_id' => $product->id,
            'quantity' => 8
        ]);

        $expectedStatistics = [
            'message' => trans('statistics.sold_products_up_trend', [
                'campaign_number' => $this->firstCampaign['number'],
                'campaign_year' => $this->firstCampaign['year'],
                'plus' => 2,
                'number' => 10,
                'other_campaign_number' => $this->secondCampaign['number'],
                'other_campaign_year' => $this->secondCampaign['year']
            ]),
            'title' => trans('statistics.sold_products_up_trend_title', ['percent' => 20]),
            'products_sold_in_campaign' => '10',
            'products_in_campaign_to_compare' => '8'
        ];

        $this->actingAs($this->user)
            ->assertEquals($expectedStatistics, \App\Helpers\Statistics\CompareCampaignsStatistics::soldProductsDetails($this->firstCampaign, $this->secondCampaign));
    }

    /**
     * Test soldProductsDetails works as expected then are more products in compared campaign.
     */
    public function test_sold_products_with_more_products_in_compared_campaign() {

        $product = factory(\App\Product::class)->create(['user_id' => $this->user->id]);

        factory(\App\BillProduct::class)->create([
            'bill_id' => $this->billInFirstCampaign->id,
            'product_id' => $product->id,
            'quantity' => 18
        ]);

        factory(\App\BillProduct::class)->create([
            'bill_id' => $this->billInComparedCampaign->id,
            'product_id' => $product->id,
            'quantity' => 20
        ]);

        $expectedStatistics = [
            'message' => trans('statistics.sold_products_down_trend', [
                'campaign_number' => $this->firstCampaign['number'],
                'campaign_year' => $this->firstCampaign['year'],
                'minus' => 2,
                'number' => 18,
                'other_campaign_number' => $this->secondCampaign['number'],
                'other_campaign_year' => $this->secondCampaign['year']
            ]),
            'title' => trans('statistics.sold_products_down_trend_title', ['percent' => 10]),
            'products_sold_in_campaign' => '18',
            'products_in_campaign_to_compare' => '20'
        ];

        $this->actingAs($this->user)
            ->assertEquals($expectedStatistics, \App\Helpers\Statistics\CompareCampaignsStatistics::soldProductsDetails($this->firstCampaign, $this->secondCampaign));
    }
}