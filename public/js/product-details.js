/**
 * Handle product details page.
 */
new Vue({

    /**
     * Target element.
     */
    el: '#product-details',

    /**
     * Called on ready.
     */
    ready: function() {
        this.getData();
    },

    /**
     * Available methods.
     */
    methods: {

        /**
         * Get product data.
         */
        getData: function() {

            Alert.loader();

            this.$http.get('/product-details/' + Data.getProductCode() + '/get', function(response) {

                this.$set('name', response.name);
                this.$set('product', response);
                this.$set('loaded', true);
                Alert.close();

            }).error(function(response) {

                if (!response.message) {
                    Alert.generalError();
                    return;
                }

                Alert.error(response.title, response.message);
            });
        },

        /**
         * Edit product name.
         *
         * @param currentName
         * @param productCode
         * @param productId
         */
        editName: function(currentName, productCode, productId) {

            var thisInstance = this;

            // Show edit alert
            Alert.editProductName(currentName, function(newName) {

                // Build post data
                var data = {
                    _token: Token.get(),
                    id: productId,
                    name: newName
                };

                // Make post request
                thisInstance.$http.post('/product-details/' + Data.getProductCode() + '/edit-name', data, function(response) {

                    // Handle success response
                    this.$set('product.name', response.name);
                    Alert.success(response.title, response.message);

                }).error(function(response) {

                    // Handle error response
                    if (!response.message) {
                        Alert.generalError();
                        return;
                    }

                    Alert.error(response.title, response.message);
                });
            });
        },

        /**
         * Edit product code.
         *
         * @param productCode
         * @param productId
         */
        editCode: function(productCode, productId) {

            var thisInstance = this;

            // Show edit code alert
            Alert.editProductCode(productCode, function(newCode) {

                // Build post data
                var data = {
                    _token: Token.get(),
                    id: productId,
                    code: newCode
                };

                // Make post request
                thisInstance.$http.post('/product-details/' + Data.getProductCode() + '/edit-code', data, function(response) {

                    // Handle success response
                    window.location.replace('/product-details/' + response.code);
                    Alert.success(response.title, response.message);

                }).error(function(response) {

                    // Handle error response
                    if (!response.message) {
                        Alert.generalError();
                        return;
                    }

                    Alert.error(response.title, response.message);
                });
            });
        },

        /**
         * Delete user product.
         *
         * @param productCode
         * @param productId
         */
        deleteProduct: function(productCode, productId) {

            var thisInstance = this;

            // Show confirm alert
            Alert.confirmDeleteProductFromBill(function() {

                // Build post data
                var data = {
                    _token: Token.get(),
                    id: productId
                };

                // Make post request
                thisInstance.$http.post('/product-details/' + Data.getProductCode() + '/delete', data, function(response) {

                    // Handle success response
                    window.location.replace('/my-products');
                    Alert.success(response.title, response.message);

                }).error(function(response) {

                    // Handle error response
                    if (!response.message) {
                        Alert.generalError();
                        return;
                    }

                    Alert.error(response.title, response.message);
                });
            });

        }
    }
});
//# sourceMappingURL=product-details.js.map
