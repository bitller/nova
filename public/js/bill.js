new Vue({

    el: '#bill',

    data: {
        pageHover: false,
        counter: 0
    },

    ready: function() {
        this.getBill();
    },

    methods: {

        /**
         * @param showSuccess callback when get bills request is finished
         * @param hideLoader If set to true, loading alert will not be displayed
         */
        getBill: function(showSuccess, hideLoader) {

            if (typeof hideLoader === 'undefined') {
                Alert.loader();
            }

            this.$http.get('/bills/' + $('#bill').attr('bill-id') + '/get', function(response) {

                this.$set('bill', response);
                this.$set('loaded', true);

                if (typeof showSuccess === 'undefined') {
                    Alert.close();
                    return;
                }
                showSuccess();
            });

        },

        /**
         * Edit product page from bill.
         *
         * @param productPage
         * @param productId
         * @param productCode
         */
        editPage: function(productPage, productId, productCode) {

            var thisInstance = this;

            Alert.editPage(productPage, function(inputValue) {

                var data = {
                    product_id: productId,
                    product_code: productCode,
                    product_page: inputValue
                };

                thisInstance.$http.post('/bills/' + $('#bill').attr('bill-id') + '/edit-page/', data, function(response) {

                    // Handle success response
                    if (response.success) {
                        this.getBill(function() {
                            Alert.success(Translation.common('success'), Translation.bill('page-updated'));
                        }, true);
                        return true;
                    }

                }).error(function(response) {

                    if (response.message) {
                        Alert.error(response.message);
                        return false;
                    }

                    Alert.generalError();
                });

            });
        },

        /**
         * Edit product quantity.
         *
         * @param productQuantity
         * @param productId
         * @param productCode
         */
        editQuantity: function(productQuantity, productId, productCode) {

            var thisInstance = this;

            // Show edit quantity alert
            Alert.editQuantity(productQuantity, function(inputValue) {

                // Build post data
                var data = {
                    product_id: productId,
                    product_code: productCode,
                    product_quantity: inputValue
                };

                // Make post request
                thisInstance.$http.post('/bills/' + $('#bill').attr('bill-id') + '/edit-quantity', data, function(response) {

                    if (response.success) {
                        this.getBill(function() {
                            Alert.success(Translation.common('success'), Translation.bill('quantity-updated'));
                        }, true);
                        return true;
                    }

                }).error(function(response) {

                    if (response.message) {
                        Alert.error(response.title, response.message);
                        return false;
                    }

                    Alert.generalError();

                });

            });

        },

        /**
         * Delete product from bill.
         *
         * @param id
         */
        deleteProduct: function(id, code) {

            var thisInstance = this;

            // Ask for confirmation
            Alert.confirmDelete(function() {

                // Show loader
                Alert.loader();

                // Make request
                thisInstance.$http.get('/bills/' + $('#bill').attr('bill-id') + '/delete/' + id + '/' + code, function(response) {

                    // If a success response is returned reload products and show a success message
                    if (response.success) {
                        this.getBill(function() {
                            Alert.success(Translation.common('success'), Translation.common('product-deleted'));
                        });
                        return;
                    }

                    Alert.generalError();

                }).error(function(response) {
                    Alert.generalError();
                });

            });
        }

    }
});
//# sourceMappingURL=bill.js.map