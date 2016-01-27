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
                this.$set('email', response.data.email);
                this.$set('phone_number', response.data.phone_number);
                this.$set('oldName', this.$get('name'));
                this.$set('oldPhone', this.$get('phone'));
                this.$set('statistics', response.data.statistics);
                this.$set('money_user_has_to_receive', response.data.money_user_has_to_receive);
                this.$set('money_owed_due_passed_payment_term', response.data.money_owed_due_passed_payment_term);
                this.$set('last_paid_bills', response.data.last_paid_bills);
                this.$set('last_unpaid_bills', response.data.last_unpaid_bills);

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
        editClientName: function() {

            this.$set('loading', true);

            // Build post data
            var data = {
                _token: Token.get(),
                client_name: this.$get('client_name')
            };

            // Make post request
            this.$http.post('/clients/' + $('#client').attr('client-id') + '/edit-name', data, function(response) {

                // Update client name, stop loading, close modal and show success alert
                this.$set('name', data.client_name);
                $('#edit-client-name-modal').modal('hide');
                this.$set('loading', false);
                Alert.success(response.message);

            }).error(function(response) {

                // Handle error response
                this.$set('loading', false);

                // Set corresponded error
                if (!response.message) {
                    this.$set('error', Translation.common('general-error'));
                    return;
                }

                this.$set('errors', response.errors);
            });
        },

        /**
         * Reset edit client email modal data.
         */
        resetEditClientEmailModal: function() {
            this.$set('loading', false);
            Reset.vueData(this, ['errors', 'error', 'client_email']);
        },

        /**
         * Edit client email.
         */
        editClientEmail: function() {

            this.$set('loading', true);

            // Build post data
            var data = {
                _token: Token.get(),
                client_email: this.$get('client_email')
            };

            // Make post request
            this.$http.post('/clients/' + $('#client').attr('client-id') + '/edit-email', data, function(response) {

                // Handle success response
                this.$set('loading', false);
                this.$set('email', data.client_email);
                $('#edit-client-email-modal').modal('hide');
                Alert.success(response.message);

            }).error(function(response) {

                this.$set('loading', false);

                // Handle error response
                if (!response.message) {
                    this.$set('error', Translation.common('general-error'));
                    return;
                }

                this.$set('errors', response.errors);
            });

        },

        /**
         * Reset edit client name modal data.
         */
        resetEditClientNameModal: function() {
            this.$set('loading', false);
            Reset.vueData(this, ['errors', 'error', 'client_name']);
        },

        /**
         * Allow user to edit clients phone number
         */
        editClientPhoneNumber: function() {

            this.$set('loading', true);

            // Post data
            var data = {
                _token: Token.get(),
                client_phone_number: this.$get('client_phone_number')
            };

            // Make post request
            this.$http.post('/clients/' + $('#client').attr('client-id') + '/edit-phone', data, function(response) {

                // Stop loading and set new phone number
                this.$set('loading', false);
                this.$set('phone_number', data.client_phone_number);

                // Hide modal and show success alert
                $('#edit-client-phone-number-modal').modal('hide');
                Alert.success(response.message);

            }).error(function(response) {

                // Stop loading and set proper error message
                this.$set('loading', false);

                if (!response.message) {
                    this.$set('error', Translation.common('general-error'));
                    return;
                }

                this.$set('errors', response.errors);
            });
        },

        /**
         * Reset edit client phone number modal data.
         */
        resetEditClientPhoneNumberModal: function() {
            this.$set('loading', false);
            Reset.vueData(this, ['errors', 'error', 'client_phone_number'])
        }
    }
});
//# sourceMappingURL=client.js.map