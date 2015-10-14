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
    el: '#bills',

    data: {
        rows: 0
    },

    ready: function() {
        this.getBills('/bills/get');
    },

    methods: {

        /**
         * Make request to delete bill.
         *
         * @param bill_id
         * @param current_page
         * @param rows_on_page
         * @param loading
         */
        deleteBill: function(bill_id, current_page, rows_on_page) {

            var thisInstance = this;

            Alert.confirmDeleteBill(function() {

                Alert.loader();

                // Make request to delete bill
                thisInstance.$http.get(UrlBuilder.deleteBill(bill_id)).success(function(response) {

                    // Make request to get bills
                    thisInstance.$http.get(UrlBuilder.getBill(rows_on_page, current_page)).success(function(data) {
                        Alert.success(response.title, response.message);
                        this.$set('bills', data);
                    });

                }).error(function(response) {

                    if (response.message) {
                        Alert.error(response.title, response.message);
                        return;
                    }

                    Alert.generalError();

                });
            });
        },

        createBill: function(title, placeholder, empty_input_error, message, loading, success) {

            var before = this;

            // Show prompt
            swal({
                    title: title,
                    type: "input",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    animation: "slide-from-top",
                    inputPlaceholder: placeholder
                },
                function(inputValue) {
                    if (inputValue === false) return false;

                    if (inputValue === "") {
                        swal.showInputError(empty_input_error);
                        return false
                    }

                    swal({
                        title: loading,
                        type: "info",
                        showConfirmButton: false
                    });

                    before.$http.post('/bills/create', {client:inputValue, _token:$('#token').attr('content')}).success(function() {
                        this.paginate('/bills/get');
                        swal({
                            title: success,
                            text: message,
                            type: "success",
                            timer: 1750,
                            showConfirmButton: false
                        });
                    });
            });

        },

        /**
         * This method is called by pagination links
         *
         * @param page_url
         */
        paginate: function(page_url) {
            if (page_url) {
                this.getBills(page_url);
            }
        },

        /**
         * Make ajax request to get bills
         *
         * @param url
         */
        getBills: function(url) {

            this.$set('loaded', false);

            swal({
                title: Nova.getCommonTranslation('loading'),
                type: "info",
                showConfirmButton: false
            });

            this.$http.get(url).success(function(data) {
                this.$set('bills', data);
                this.$set('loaded', true);
                swal.close();
            });
        },

        /**
         * Return url to paginate bills
         *
         * @param rows_on_page
         * @param current_page
         * @returns {string}
         */
        buildBillUrl: function(rows_on_page, current_page) {

            if (rows_on_page < 1) {
                current_page = current_page - 1;
            }

            return '/bills/get?page=' + current_page;
        }

    }
});
//# sourceMappingURL=bills.js.map