var Nova = {

    /**
     * Show sweet alert loader
     *
     * @param title
     */
    showLoader: function(title) {
        swal({
            title: title,
            type: "info",
            showConfirmButton: false
        });
    },

    /**
     * Hide sweet alert loader
     */
    hideLoader: function() {
        swal.close();
    },

    /**
     * Show success alert
     *
     * @param title
     * @param message
     */
    showSuccessAlert: function(title, message) {
        this.showAlert('success', title, message);
    },

    /**
     * Show general error alert
     */
    showGeneralErrorAlert: function() {
        this.showErrorAlert(this.getCommonTranslation('fail'), this.getCommonTranslation('general-error'));
    },

    /**
     * Show error alert
     *
     * @param title
     * @param message
     */
    showErrorAlert: function(title, message) {
        this.showAlert('error', title, message);
    },

    /**
     * Show sweet alert box
     *
     * @param type
     * @param title
     * @param message
     */
    showAlert: function(type, title, message) {
        swal({
            title: title,
            text: message,
            type: type,
            timer: 1750,
            showConfirmButton: false
        });
    },

    /**
     * Get common translation that match given attribute
     *
     * @param attribute
     * @returns {*|jQuery}
     */
    getCommonTranslation: function(attribute) {
        return this.getTranslation('#common-trans', attribute);
    },

    /**
     * Get client page translation that match given attribute
     *
     * @param attribute
     * @returns {*|jQuery}
     */
    getClientTranslation: function(attribute) {
        return this.getTranslation('#client-trans', attribute);
    },

    /**
     * Get product page translation that match given attribute
     *
     * @param attribute
     * @returns {*|jQuery}
     */
    getProductTranslation: function(attribute) {
        return this.getTranslation('#product-trans', attribute);
    },

    /**
     * Get my products page translation that match given attribute
     *
     * @param attribute
     * @returns {*|jQuery}
     */
    getMyProductTranslation: function(attribute) {
        return this.getTranslation('#my-products-trans', attribute);
    },

    /**
     * Get page translation
     *
     * @param pageSelector
     * @param attribute
     * @returns {*|jQuery}
     */
    getTranslation: function(pageSelector, attribute) {
        return $(pageSelector).attr(attribute);
    },

    /**
     * Return application token
     *
     * @returns {*|jQuery}
     */
    getToken: function() {
        return $('#token').attr('content');
    },

    /**
     * Return url used to get products data
     *
     * @param rows_on_page
     * @param current_page
     * @returns {string}
     */
    buildProductsRequestUrl: function(rows_on_page, current_page) {
        return this.buildPaginationRequestUrl('/products/get', rows_on_page, current_page);
    },

    /**
     *
     * Return url used to edit product name
     *
     * @param product_id
     * @param rows_on_page
     * @param current_page
     * @returns {string}
     */
    buildEditProductNameRequestUrl: function(product_id, rows_on_page, current_page) {
        return '/products/' + product_id + '/edit-name';
        //return this.buildPaginationRequestUrl('/products/' + product_id + '/edit-name', rows_on_page, current_page);
    },

    /**
     * Return url for pagination with given route
     *
     * @param route
     * @param rows_on_page
     * @param current_page
     * @returns {string}
     */
    buildPaginationRequestUrl: function(route, rows_on_page, current_page) {

        if (rows_on_page < 1) {
            current_page = current_page - 1;
        }

        return route + '?page=' + current_page;
    }
};
new Vue({

    el: "#client",

    /**
     * Called when page is loaded
     */
    ready: function() {
        this.getPageData();
    },

    methods: {

        /**
         * Make ajax request to load initial page data
         */
        getPageData: function() {

            Alert.loader();

            var url = '/clients/' + Nova.getClientTranslation('client-id') + '/get';

            // Make request to get page data
            this.$http.get(url, function(response) {

                // Update models
                this.$set('name', response.data.name);
                this.$set('phone', response.data.phone_number);
                this.$set('oldName', this.$get('name'));
                this.$set('oldPhone', this.$get('phone'));

                this.$set('client', response.data);

                // Hide loader
                this.$set('loaded', true);
                swal.close();
            }).error(function(response) {

                if (response.message) {
                    Alert.error(response.title, response.message);
                    window.location.replace(response.redirect_to);
                    return;
                }

                Alert.generalError();
            });
        },

        /**
         * Allow user to edit clients name
         */
        saveName: function() {

            Nova.showLoader(Nova.getClientTranslation('loading'));

            // Build url and data to post
            var url = '/clients/' + Nova.getClientTranslation('client-id') + '/edit-name';
            var data = {
                name: this.$get('name'),
                _token: Nova.getToken()
            };

            var thisInstance = this;

            // Make request
            this.$http.post(url, data).success(function(response) {

                Nova.showSuccessAlert(response.title, response.message);

            }).error(function(response) {

                Nova.showErrorAlert(response.title, response.message);

                // Typed name is not valid so display the old one
                thisInstance.$set('name', thisInstance.$get('oldName'));

            });

        },

        /**
         * Allow user to edit clients phone number
         */
        savePhone: function() {

            Nova.showLoader(Nova.getClientTranslation('loading'));

            // Build url and data object to post
            var url = '/clients/' + Nova.getClientTranslation('client-id') + '/edit-phone';
            var data = {
                phone: this.$get('phone'),
                _token: Nova.getToken()
            };

            var thisInstance = this;

            // Make request
            this.$http.post(url, data, function(response) {

                Nova.showSuccessAlert(response.title, response.message);

            }).error(function(response) {

                Nova.showErrorAlert(response.title, response.message);

                // Typed phone is not valid so display the old one
                thisInstance.$set('phone', thisInstance.$get('oldPhone'));

            });

        }
    }
});
//# sourceMappingURL=client.js.map