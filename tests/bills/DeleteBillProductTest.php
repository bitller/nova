<?php
use App\Helpers\TestUrlBuilder;

/**
 * Tests for delete bill product functionality
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class DeleteBillProductTest extends BaseTest {

    /**
     * Delete bill product.
     *
     * @group success
     * @group deleteBillProduct
     */
    public function deleteBillProduct() {

        $data = $this->generateData();

        $this->actingAs($data['user'])
            ->get(TestUrlBuilder::deleteBillProduct($data['bill']->id, $data['product']->id, $data['product']->code, $data['billProduct']->id))
            ->seeJson([
                'success' => true,
                'message' => trans('bill.product_deleted')
            ]);

    }

}