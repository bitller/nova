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
     * Get register page translations.
     *
     * @param attribute
     * @returns {*|jQuery}
     */
    register: function(attribute) {
        return this.get('#register-trans', attribute);
    },

    /**
     * Get help center manager translations.
     *
     * @param attribute
     * @returns {*|jQuery}
     */
    helpCenterManager: function(attribute) {
        return this.get('#help-center-manager-trans', attribute);
    },

    /**
     * Get subscribe page translations.
     *
     * @param attribute
     * @returns {*|jQuery}
     */
    subscribe: function(attribute) {
        return this.get('#subscribe-trans', attribute);
    },

    /**
     * Get application settings page translations.
     *
     * @param attribute
     * @returns {*|jQuery}
     */
    applicationSettings: function(attribute) {
        return this.get('#application-settings-trans', attribute);
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
     * Get clients page translations.
     *
     * @param attribute
     * @returns {*|jQuery}
     */
    clients: function(attribute) {
        return this.get('#clients-trans', attribute);
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
     * Get bills page translations.
     *
     * @param attribute
     * @returns {*|jQuery}
     */
    bills: function(attribute) {
        return this.get('#bills-trans', attribute);
    },

    /**
     * Get settings page translations.
     *
     * @param attribute
     * @returns {*|jQuery}
     */
    settings: function(attribute) {
        return this.get('#settings-trans', attribute);
    },

    /**
     * Get product details page translations.
     *
     * @param attribute
     * @returns {*|jQuery}
     */
    productDetails: function(attribute) {
        return this.get('#product-details-trans', attribute);
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