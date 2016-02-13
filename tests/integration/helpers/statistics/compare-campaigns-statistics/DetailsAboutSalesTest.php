<?php
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Integration tests for detailsAboutSales method.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class DetailsAboutSalesTest extends TestCase {

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
     * @var array
     */
    private $baseExpected = [];

    /**
     * Called before each test.
     */
    public function setUp() {

        parent::setUp();

        $this->user = factory(\App\User::class)->create();
        $this->client = factory(\App\Client::class)->create(['user_id' => $this->user->id]);

        $this->translationData = [
            'campaign_number' => $this->firstCampaign['number'],
            'campaign_year' => $this->firstCampaign['year'],
            'other_campaign_number' => $this->secondCampaign['number'],
            'other_campaign_year' => $this->secondCampaign['year']
        ];

        $this->baseExpected = [
            'sales_label' => trans('statistics.details_about_sales_label', ['campaign_number' => $this->firstCampaign['number'], 'campaign_year' => $this->firstCampaign['year']]),
            'sales_in_campaign_to_compare_label' => trans('statistics.details_about_sales_label', ['campaign_number' => $this->secondCampaign['number'], 'campaign_year' => $this->secondCampaign['year']])
        ];
    }

    /**
     * Make sure detailsAboutSales works as expected when both campaigns have no sales.
     */
    public function test_details_about_sales_when_both_campaigns_does_not_have_sales() {

        $this->translationData['sales'] = 0;

        $expected = [
            'message' => trans('statistics.details_about_sales_equal_trend', $this->translationData),
            'title' => trans('statistics.details_about_sales_equal_trend_title'),
            'sales' => 0,
            'sales_in_campaign_to_compare' => 0
        ];

        $expected = array_merge($expected, $this->baseExpected);

        $this->actingAs($this->user)
            ->assertEquals($expected, \App\Helpers\Statistics\CompareCampaignsStatistics::detailsAboutSales($this->firstCampaign, $this->secondCampaign));
    }

    /**
     * Make sure details about sales works as expected when only first campaign have sales.
     */
    public function test_details_about_sales_when_only_first_campaign_have_sales() {

        $bill = factory(\App\Bill::class)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id,
            'campaign_id' => \App\Campaign::where('number', $this->firstCampaign['number'])->where('year', $this->firstCampaign['year'])->first()->id
        ]);

        $product = factory(\App\Product::class)->create(['user_id' => $this->user->id]);
        $billProduct = factory(\App\BillProduct::class)->create([
            'bill_id' => $bill->id,
            'product_id' => $product->id
        ]);

        $this->translationData['sales'] = number_format($billProduct->final_price, 2);
        $this->translationData['plus'] = number_format($billProduct->final_price, 2);

        $expected = [
            'message' => trans('statistics.details_about_sales_up_trend', $this->translationData),
            'title' => trans('statistics.details_about_sales_up_trend_title', ['percent' => 100]),
            'sales' => $this->translationData['sales'],
            'sales_in_campaign_to_compare' => 0
        ];

        $expected = array_merge($expected, $this->baseExpected);

        $this->actingAs($this->user)
            ->assertEquals($expected, \App\Helpers\Statistics\CompareCampaignsStatistics::detailsAboutSales($this->firstCampaign, $this->secondCampaign));
    }

    /**
     * Test detailsAboutSales works as expected when only campaign to compare have sales.
     */
    public function test_details_about_sales_when_only_campaign_to_compare_have_sales() {

        $bill = factory(\App\Bill::class)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id,
            'campaign_id' => \App\Campaign::where('number', $this->secondCampaign['number'])->where('year', $this->secondCampaign['year'])->first()->id
        ]);

        $product = factory(\App\Product::class)->create(['user_id' => $this->user->id]);
        $billProduct = factory(\App\BillProduct::class)->create([
            'bill_id' => $bill->id,
            'product_id' => $product->id
        ]);

        $this->translationData['sales'] = 0;
        $this->translationData['minus'] = number_format($billProduct->final_price, 2);

        $expected = [
            'message' => trans('statistics.details_about_sales_down_trend', $this->translationData),
            'title' => trans('statistics.details_about_sales_down_trend_title', ['percent' => 100]),
            'sales' => 0,
            'sales_in_campaign_to_compare' => number_format($billProduct->final_price, 2)
        ];

        $expected = array_merge($expected, $this->baseExpected);

        $this->actingAs($this->user)
            ->assertEquals($expected, \App\Helpers\Statistics\CompareCampaignsStatistics::detailsAboutSales($this->firstCampaign, $this->secondCampaign));
    }

    /**
     * Make sure detailsAboutSales works as expected when first campaign have more sales.
     */
    public function test_details_about_sales_when_first_campaign_have_more_sales() {

        $bill = factory(\App\Bill::class)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id,
            'campaign_id' => \App\Campaign::where('number', $this->firstCampaign['number'])->where('year', $this->firstCampaign['year'])->first()->id,
        ]);

        $secondBill = factory(\App\Bill::class)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id,
            'campaign_id' => \App\Campaign::where('number', $this->secondCampaign['number'])->where('year', $this->secondCampaign['year'])->first()->id
        ]);

        $product = factory(\App\Product::class)->create(['user_id' => $this->user->id]);

        $billProduct = factory(\App\BillProduct::class)->create([
            'bill_id' => $bill->id,
            'product_id' => $product->id,
            'price' => 100,
            'quantity' => 1,
            'final_price' => 100,
            'discount' => 0,
            'calculated_discount' => 0
        ]);

        $secondBillProduct = factory(\App\BillProduct::class)->create([
            'bill_id' => $secondBill->id,
            'product_id' => $product->id,
            'price' => 50,
            'quantity' => 1,
            'final_price' => 50,
            'discount' => 0,
            'calculated_discount' => 0
        ]);

        $this->translationData['plus'] = number_format(50, 2);
        $this->translationData['sales'] = number_format(100, 2);

        $expected = [
            'message' => trans('statistics.details_about_sales_up_trend', $this->translationData),
            'title' => trans('statistics.details_about_sales_up_trend_title', ['percent' => 50]),
            'sales' => $this->translationData['sales'],
            'sales_in_campaign_to_compare' => number_format(50, 2)
        ];

        $expected = array_merge($expected, $this->baseExpected);

        $this->actingAs($this->user)
            ->assertEquals($expected, \App\Helpers\Statistics\CompareCampaignsStatistics::detailsAboutSales($this->firstCampaign, $this->secondCampaign));
    }

    /**
     * Make sure detailsAboutSales works as expected when campaign to compare have more sales.
     */
    public function test_details_about_sales_when_campaign_to_compare_have_more_sales() {

        $bill = factory(\App\Bill::class)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id,
            'campaign_id' => \App\Campaign::where('number', $this->firstCampaign['number'])->where('year', $this->firstCampaign['year'])->first()->id
        ]);

        $secondBill = factory(\App\Bill::class)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id,
            'campaign_id' => \App\Campaign::where('number', $this->secondCampaign['number'])->where('year', $this->secondCampaign['year'])->first()->id
        ]);

        $product = factory(\App\Product::class)->create(['user_id' => $this->user->id]);

        factory(\App\BillProduct::class)->create([
            'bill_id' => $bill->id,
            'product_id' => $product->id,
            'price' => 50,
            'quantity' => 1,
            'final_price' => 50,
            'discount' => 0,
            'calculated_discount' => 0
        ]);

        factory(\App\BillProduct::class)->create([
            'bill_id' => $secondBill->id,
            'product_id' => $product->id,
            'price' => 100,
            'quantity' => 1,
            'final_price' => 100,
            'discount' => 0,
            'calculated_discount' => 0
        ]);

        $this->translationData['minus'] = number_format(50, 2);
        $this->translationData['sales'] = number_format(50, 2);

        $expected = [
            'message' => trans('statistics.details_about_sales_down_trend', $this->translationData),
            'title' => trans('statistics.details_about_sales_down_trend_title', ['percent' => 50]),
            'sales' => $this->translationData['sales'],
            'sales_in_campaign_to_compare' => number_format(100, 2)
        ];

        $expected = array_merge($expected, $this->baseExpected);

        $this->actingAs($this->user)
            ->assertEquals($expected, \App\Helpers\Statistics\CompareCampaignsStatistics::detailsAboutSales($this->firstCampaign, $this->secondCampaign));
    }

    /**
     * Make sure detailsAboutSales works as expected when both campaigns have same sales.
     */
    public function test_details_about_sales_when_both_campaigns_have_the_same_sales() {

        $bill = factory(\App\Bill::class)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id,
            'campaign_id' => \App\Campaign::where('number', $this->firstCampaign['number'])->where('year', $this->firstCampaign['year'])->first()->id
        ]);

        $secondBill = factory(\App\Bill::class)->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id,
            'campaign_id' => \App\Campaign::where('number', $this->secondCampaign['number'])->where('year', $this->secondCampaign['year'])->first()->id
        ]);

        $product = factory(\App\Product::class)->create(['user_id' => $this->user->id]);

        factory(\App\BillProduct::class)->create([
            'bill_id' => $bill->id,
            'product_id' => $product->id,
            'price' => 100,
            'quantity' => 1,
            'final_price' => 100,
            'discount' => 0,
            'calculated_discount' => 0
        ]);

        factory(\App\BillProduct::class)->create([
            'bill_id' => $secondBill->id,
            'product_id' => $product->id,
            'price' => 100,
            'quantity' => 1,
            'final_price' => 100,
            'discount' => 0,
            'calculated_discount' => 0
        ]);

        $this->translationData['sales'] = number_format(100, 2);

        $expected = [
            'message' => trans('statistics.details_about_sales_equal_trend', $this->translationData),
            'title' => trans('statistics.details_about_sales_equal_trend_title'),
            'sales' => $this->translationData['sales'],
            'sales_in_campaign_to_compare' => number_format(100, 2)
        ];

        $expected = array_merge($expected, $this->baseExpected);

        $this->actingAs($this->user)
            ->assertEquals($expected, \App\Helpers\Statistics\CompareCampaignsStatistics::detailsAboutSales($this->firstCampaign, $this->secondCampaign));
    }
}