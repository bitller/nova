new Vue({

    /**
     * Target element.
     */
    el: '#products-manager-index',

    /**
     * Called when vue si ready.
     */
    ready: function() {
        this.getProducts('/admin-center/products-manager/get');
    },

    methods: {

        /**
         * Make get request and return products.
         *
         * @param url
         * @param callback
         */
        getProducts: function(url, callback) {

            // Show loader if no callback was given
            if (typeof callback === 'undefined') {
                Alert.loader();
            }

            // Make get request
            this.$http.get(url, function(response) {

                this.$set('products', response);
                this.$set('loaded', true);

                // Execute callback if given
                if (typeof callback !== 'undefined') {
                    callback();
                    return;
                }

                // Else just close the loading alert
                Alert.close();

            }).error(function(response) {
                //
            });
        },

        /**
         * Toggle search bar.
         */
        toggleSearch: function() {
            $('.search-application-products').toggle(400);
        },

        /**
         * Handle products search.
         */
        search: function() {

            Alert.loader();
            var thisInstance = this;

            this.getProducts('/admin-center/products-manager/get/search?term=' + this.$get('search_term'), function() {

                var searched = false;

                if (thisInstance.$get('search_term')) {
                    searched = true;
                }

                thisInstance.$set('searched', searched);

                Alert.close();
            });
        },

        /**
         * Reset search and display all products.
         */
        resetSearch: function() {

            Alert.loader();
            var thisInstance = this;

            this.getProducts('/admin-center/products-manager/get', function() {
                thisInstance.$set('search_term', '');
                $('#search-application-products-input').val('');
                Alert.close();
            });
        },

        /**
         * Check if given product code is used or not.
         */
        checkIfProductCodeIsUsed: function() {

            var thisInstance = this;
            var product_code = this.$get('product_code');
            this.$set('checking_product_code', true);

            // Build post data
            var postData = {
                _token: Token.get(),
                product_code: product_code
            };

            // Make post request to the server
            this.$http.post('/admin-center/products-manager/check-if-code-is-used', postData, function(response) {

                thisInstance.$set('checking_product_code', false);
                thisInstance.$set('product_used', response.used);
                thisInstance.$set('checked', true);

            }).error(function(response) {

                this.$set('checking_product_code', false);

                // Set general error message if a server occurred
                if (!response.message) {
                    this.$set('error', Translation.common('general-error'));
                    return;
                }

                this.$set('errors', response.errors);
            });
        },

        /**
         * Check if other product code is used or not.
         */
        checkIfOtherProductCodeIsUsed: function() {

            var thisInstance = this;
            this.$set('checking_other_product_code', true);

            // Build post data
            var postData = {
                _token: Token.get(),
                product_code: this.$get('other_product_code')
            };

            this.$http.post('/admin-center/products-manager/check-if-code-is-used', postData, function(response) {
                thisInstance.$set('checking_other_product_code', true);
                thisInstance.$set('other_product_used', response.used);
                thisInstance.$set('other_product_checked', true);
            }).error(function(response) {
                //
            });
        },

        /**
         * Add new application product.
         */
        addApplicationProduct: function() {

            // Hide modal and show loader
            $('#add-application-product-modal').modal('hide');
            Alert.loader();

            // Build post data
            var postData = {
                _token: Token.get(),
                product_name: this.$get('product_name'),
                product_code: this.$get('product_code')
            };

            // Check if other product code field should be added
            if (this.$get('other_product_checked') && !this.$get('other_product_used')) {
                postData.not_used_code = this.$get('other_product_code');
            }

            // Make post request
            this.$http.post('/admin-center/products-manager/add-new', postData, function(response) {

                this.getProducts('/admin-center/products-manager/get', function() {
                    Alert.success(response.title, response.message);
                });

            }).error(function(response) {
               Alert.generalError();
            });
        },

        /**
         * Reset add application product modal data.
         */
        resetAddApplicationProductModal: function() {

            var fields = [
                'product_name',
                'product_code',
                'other_product_code',
                'error',
                'errors',
                'checked',
                'checking_product_code',
                'product_used',
                'checking_other_product_code',
                'other_product_used',
                'other_product_checked'
            ];

            Reset.vueData(this, fields);

            $('#product-code').val('');
            $('#not-used-product-code').val('');
            $('#product-name').val('');
        },
    }
});
//# sourceMappingURL=admin-center_products-manager_index.js.map
