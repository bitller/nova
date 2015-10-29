var Data = {

    /**
     * Get bill id. Works only on bill page.
     *
     * @returns {*|jQuery}
     */
    getBillId: function() {
        return $('#bill').attr('bill-id')
    },

    /**
     * Get product code. Works only on product details page.
     *
     * @returns {*|jQuery}
     */
    getProductCode: function() {
        return $('#product-details').attr('product-code');
    }
};