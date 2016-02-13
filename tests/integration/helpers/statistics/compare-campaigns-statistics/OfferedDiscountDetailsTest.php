<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Integration tests for offeredDiscountDetails helper method.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class OfferedDiscountDetailsTest extends TestCase {

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
    private $billInCampaignToCompare = null;

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
     * @var array
     */
    private $baseExpected = [];

    /**
     * Called before each test.
     */
    public function setUp() {

        parent::setUp();

        // Generate user and client
        $this->user = factory(\App\User::class)->create();
        $this->client = factory(\App\Client::class)->create(['user_id' => $this->user->id]);

        // Create bill in first campaign
        $this->billInFirstCampaign = factory(\App\Bill::class)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id,
            'campaign_id' => \App\Campaign::where('number', $this->firstCampaign['number'])->where('year', $this->firstCampaign['year'])->first()->id
        ]);

        // Create bill in campaign to compare
        $this->billInCampaignToCompare = factory(\App\Bill::class)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id,
            'campaign_id' => \App\Campaign::where('number', $this->secondCampaign['number'])->where('year', $this->secondCampaign['year'])->first()->id
        ]);

        $this->translationData = [
            'campaign_number' => $this->firstCampaign['number'],
            'campaign_year' => $this->firstCampaign['year'],
            'other_campaign_number' => $this->secondCampaign['number'],
            'other_campaign_year' => $this->secondCampaign['year']
        ];

        $this->baseExpected = [
            'discount_offered_label' => trans('statistics.offered_discount_label', [
                'campaign_number' => $this->firstCampaign['number'],
                'campaign_year' => $this->firstCampaign['year']
            ]),
            'discount_offered_in_campaign_to_compare_label' => trans('statistics.offered_discount_label', [
                'campaign_number' => $this->secondCampaign['number'],
                'campaign_year' => $this->secondCampaign['year']
            ])
        ];
    }

    /**
     * Test offeredDiscountDetails works as expected when both campaigns have no discount.
     */
    public function test_offered_discount_details_with_no_discount_in_both_campaigns() {

        $product = factory(\App\Product::class)->create(['user_id' => $this->user->id]);

        factory(\App\BillProduct::class)->create([
            'bill_id' => $this->billInFirstCampaign->id,
            'product_id' => $product->id,
            'price' => 10,
            'final_price' => 10,
            'discount' => 0,
            'calculated_discount' => 0
        ]);

        factory(\App\BillProduct::class)->create([
            'bill_id' => $this->billInCampaignToCompare->id,
            'product_id' => $product->id,
            'price' => 10,
            'final_price' => 10,
            'discount' => 0,
            'calculated_discount' => 0
        ]);

        $this->translationData['money'] = '0.00';

        $expected = [
            'message' => trans('statistics.offered_discount_equal_trend', $this->translationData),
            'title' => trans('statistics.offered_discount_equal_trend_title'),
            'discount_offered' => '0.00',
            'discount_offered_in_campaign_to_compare' => '0.00'
        ];

        $expected = array_merge($expected, $this->baseExpected);

        $this->actingAs($this->user)
            ->assertEquals($expected, \App\Helpers\Statistics\CompareCampaignsStatistics::offeredDiscountDetails($this->firstCampaign, $this->secondCampaign));
    }

    /**
     * Make sure offeredDiscountDetails works as expected when is no discount in first campaign.
     */
    public function test_offered_discount_when_is_no_discount_in_first_campaign() {

        $product = factory(\App\Product::class)->create(['user_id' => $this->user->id]);

        factory(\App\BillProduct::class)->create([
            'bill_id' => $this->billInFirstCampaign->id,
            'product_id' => $product->id,
            'price' => 10,
            'final_price' => 10,
            'discount' => 0,
            'calculated_discount' => 0
        ]);

        $secondBillProduct = factory(\App\BillProduct::class)->create([
            'bill_id' => $this->billInCampaignToCompare->id,
            'product_id' => $product->id
        ]);

        $this->translationData['money'] = '0.00';
        $this->translationData['minus'] = number_format($secondBillProduct->calculated_discount, 2);

        $expected = [
            'message' => trans('statistics.offered_discount_down_trend', $this->translationData),
            'title' => trans('statistics.offered_discount_down_trend_title', ['percent' => 100]),
            'discount_offered' => '0.00',
            'discount_offered_in_campaign_to_compare' => number_format($secondBillProduct->calculated_discount, 2)
        ];

        $expected = array_merge($expected, $this->baseExpected);

        $this->actingAs($this->user)
            ->assertEquals($expected, \App\Helpers\Statistics\CompareCampaignsStatistics::offeredDiscountDetails($this->firstCampaign, $this->secondCampaign));
    }

    /**
     * Make sure offeredDiscountDetails works as expected when is no offered discount in campaign to compare.
     */
    public function test_offered_discount_when_is_not_discount_in_campaign_to_compare() {

        $product = factory(\App\Product::class)->create(['user_id' => $this->user->id]);

        $billProduct = factory(\App\BillProduct::class)->create([
            'bill_id' => $this->billInFirstCampaign->id,
            'product_id' => $product->id
        ]);

        factory(\App\BillProduct::class)->create([
            'bill_id' => $this->billInCampaignToCompare->id,
            'product_id' => $product->id,
            'price' => 10,
            'final_price' => 10,
            'discount' => 0,
            'calculated_discount' => 0
        ]);

        $this->translationData['money'] = number_format($billProduct->calculated_discount, 2);
        $this->translationData['plus'] = number_format($billProduct->calculated_discount, 2);

        $expected = [
            'message' => trans('statistics.offered_discount_up_trend', $this->translationData),
            'title' => trans('statistics.offered_discount_up_trend_title', ['percent' => 100]),
            'discount_offered' => number_format($billProduct->calculated_discount, 2),
            'discount_offered_in_campaign_to_compare' => '0.00'
        ];

        $expected = array_merge($expected, $this->baseExpected);

        $this->actingAs($this->user)
            ->assertEquals($expected, \App\Helpers\Statistics\CompareCampaignsStatistics::offeredDiscountDetails($this->firstCampaign, $this->secondCampaign));
    }

    /**
     * Make sure offeredDiscountDetails works as expected when first campaign has more offered discount.
     */
    public function test_offered_discount_when_first_campaign_has_more_discount() {

        $product = factory(\App\Product::class)->create(['user_id' => $this->user->id]);

        $billProduct = factory(\App\BillProduct::class)->create([
            'bill_id' => $this->billInFirstCampaign->id,
            'product_id' => $product->id,
            'price' => 100,
            'discount' => 10,
            'calculated_discount' => 10,
            'final_price' => 90,
            'quantity' => 1
        ]);

        $secondBillProduct = factory(\App\BillProduct::class)->create([
            'bill_id' => $this->billInCampaignToCompare->id,
            'product_id' => $product->id,
            'price' => 100,
            'discount' => 5,
            'calculated_discount' => 5,
            'final_price' => 95,
            'quantity' => 1
        ]);

        $this->translationData['money'] = '10.00';
        $this->translationData['plus'] = '5.00';

        $expected = [
            'message' => trans('statistics.offered_discount_up_trend', $this->translationData),
            'title' => trans('statistics.offered_discount_up_trend_title', ['percent' => 50]),
            'discount_offered' => $this->translationData['money'],
            'discount_offered_in_campaign_to_compare' => '5.00'
        ];

        $expected = array_merge($expected, $this->baseExpected);

        $this->actingAs($this->user)
            ->assertEquals($expected, \App\Helpers\Statistics\CompareCampaignsStatistics::offeredDiscountDetails($this->firstCampaign, $this->secondCampaign));
    }

    /**
     * Make sure offeredDiscountDetails works as expected when campaign to compare has more offered discount.
     */
    public function test_offered_discount_when_campaign_to_compare_has_more_discount() {

        $product = factory(\App\Product::class)->create(['user_id' => $this->user->id]);

        factory(\App\BillProduct::class)->create([
            'bill_id' => $this->billInFirstCampaign->id,
            'product_id' => $product->id,
            'price' => 100,
            'discount' => 10,
            'calculated_discount' => 10,
            'final_price' => 90,
            'quantity' => 1
        ]);

        factory(\App\BillProduct::class)->create([
            'bill_id' => $this->billInCampaignToCompare->id,
            'product_id' => $product->id,
            'price' => 200,
            'discount' => 50,
            'calculated_discount' => 100,
            'final_price' => 100,
            'quantity' => 1
        ]);

        $this->translationData['money'] = '10.00';
        $this->translationData['minus'] = '90.00';

        $expected = [
            'message' => trans('statistics.offered_discount_down_trend', $this->translationData),
            'title' => trans('statistics.offered_discount_down_trend_title', ['percent' => 90]),
            'discount_offered' => '10.00',
            'discount_offered_in_campaign_to_compare' => '100.00'
        ];

        $expected = array_merge($expected, $this->baseExpected);

        $this->actingAs($this->user)
            ->assertEquals($expected, \App\Helpers\Statistics\CompareCampaignsStatistics::offeredDiscountDetails($this->firstCampaign, $this->secondCampaign));
    }

    /**
     * Test offeredDiscountDetails works as expected when both campaigns have the same discount.
     */
    public function test_offered_discount_when_both_campaigns_have_same_discount() {

        $product = factory(\App\Product::class)->create(['user_id' => $this->user->id]);

        factory(\App\BillProduct::class)->create([
            'bill_id' => $this->billInFirstCampaign->id,
            'product_id' => $product->id,
            'price' => 100,
            'discount' => 50,
            'calculated_discount' => 50,
            'final_price' => 50,
            'quantity' => 1
        ]);

        factory(\App\BillProduct::class)->create([
            'bill_id' => $this->billInCampaignToCompare->id,
            'product_id' => $product->id,
            'price' => 100,
            'discount' => 50,
            'calculated_discount' => 50,
            'final_price' => 50,
            'quantity' => 1
        ]);

        $this->translationData['money'] = '50.00';

        $expected = [
            'message' => trans('statistics.offered_discount_equal_trend', $this->translationData),
            'title' => trans('statistics.offered_discount_equal_trend_title'),
            'discount_offered' => '50.00',
            'discount_offered_in_campaign_to_compare' => '50.00'
        ];

        $expected = array_merge($expected, $this->baseExpected);

        $this->actingAs($this->user)
            ->assertEquals($expected, \App\Helpers\Statistics\CompareCampaignsStatistics::offeredDiscountDetails($this->firstCampaign, $this->secondCampaign));
    }
}