/**
 * Handle work with translations.
 *
 * @type {{get: Function}}
 */
var Translation = {

    /**
     * Get common translations.
     *
     * @param attribute
     * @returns {*|jQuery}
     */
    common: function(attribute) {
        return this.get('#common-trans', attribute);
    },

    /**
     * Get client page translations.
     *
     * @param attribute
     * @returns {*|jQuery}
     */
    client: function(attribute) {
        return this.get('#client-trans', attribute);
    },

    /**
     * Get products page translations.
     *
     * @param attribute
     * @returns {*|jQuery}
     */
    products: function(attribute) {
        return this.get('#product-trans', attribute);
    },

    /**
     * Get my products page translations.
     *
     * @param attribute
     * @returns {*|jQuery}
     */
    myProducts: function(attribute) {
        return this.get('#my-products-trans', attribute);
    },

    /**
     * Get bill page translations.
     *
     * @param attribute
     * @returns {*|jQuery}
     */
    bill: function(attribute) {
        return this.get('#bill-trans', attribute);
    },

    /**
     * @param pageSelector
     * @param attribute
     * @returns {*|jQuery}
     */
    get: function(pageSelector, attribute) {
        return $(pageSelector).attr(attribute);
    }
};