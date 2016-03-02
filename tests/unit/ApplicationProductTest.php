<?php

/**
 * Unit tests for ApplicationProduct model.
 */
class ApplicationProductTest extends TestCase {

    /**
     * Test if returned product code and name are valid.
     */
    public function testGetProductCodeAndName() {

        $product = factory(\App\ApplicationProduct::class)->create();
        $productQuery = \App\ApplicationProduct::find($product->id);

        $this->assertEquals($product->code, $productQuery->code);
        $this->assertEquals($product->name, $productQuery->name);
    }
}