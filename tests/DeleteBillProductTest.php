<?php
use App\Helpers\TestUrlBuilder;

/**
 * Tests for delete bill product functionality
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class DeleteBillProductTest extends TestCase {

    /**
     * Delete bill product.
     *
     * @group success
     * @group deleteBillProduct
     */
    public function testDeleteBillProduct() {

        $data = $this->generateData();

        $this->actingAs($data['user'])
            ->get(TestUrlBuilder::deleteBillProduct($data['bill']->id, $data['product']->id, $data['product']->code, $data['billProduct']->id))
            ->seeJson([
                'success' => true,
                'message' => trans('common.product_deleted')
            ]);

    }

    /**
     * Delete bill application product.
     *
     * @group success
     * @group deleteBillProduct
     */
    public function testDeleteBillApplicationProduct() {

        $data = $this->generateData(true);

        $this->actingAs($data['user'])
            ->get(TestUrlBuilder::deleteBillProduct($data['bill']->id, $data['product']->id, $data['product']->code, $data['billProduct']->id))
            ->seeJson([
                'success' => true,
                'message' => trans('common.product_deleted')
            ]);

    }

    /**
     * Delete bill application product with invalid bill id.
     *
     * @group fail
     * @group deleteBillProduct
     */
    public function testDeleteBillProductWithInvalidBillId() {

        $data = $this->generateData();

        $this->actingAs($data['user'])
            ->get(TestUrlBuilder::deleteBillProduct('btl1', $data['product']->id, $data['product']->code, $data['billProduct']->id))
            ->seeJson([
                'success' => false,
                'message' => trans('common.general_error')
            ]);

    }

    /**
     * Delete bill application product with invalid product id.
     *
     * @group fail
     * @group deleteBillProduct
     */
    public function testDeleteBillProductWithInvalidProductId() {

        $data = $this->generateData();

        $this->actingAs($data['user'])
            ->get(TestUrlBuilder::deleteBillProduct($data['bill']->id, 'btl4', $data['product']->code, $data['billProduct']->id))
            ->seeJson([
                'success' => false,
                'message' => trans('common.general_error')
            ]);
    }

    /**
     * Delete bill application product with invalid product code.
     *
     * @group fail
     * @group deleteBillProduct
     */
    public function testDeleteBillProductWithInvalidProductCode() {

        $data = $this->generateData();

        $this->actingAs($data['user'])
            ->get(TestUrlBuilder::deleteBillProduct($data['bill']->id, $data['product']->id, '<script>', $data['billProduct']->id))
            ->seeJson([
                'success' => false,
                'message' => trans('common.general_error')
            ]);
    }

    /**
     * Delete bill application product of another user.
     *
     * @group fail
     * @group deleteBillProduct
     */
    public function testDeleteBillProductOfAnotherUser() {

        $firstData = $this->generateData();
        $secondData = $this->generateData();

        $this->actingAs($secondData['user'])
            ->get(TestUrlBuilder::deleteBillProduct($firstData['bill']->id, $firstData['product']->id, $firstData['product']->code, $firstData['billProduct']->id))
            ->seeJson([
                'success' => false,
                'message' => trans('common.general_error')
            ]);

    }

}