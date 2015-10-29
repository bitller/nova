new Vue({

    el: '#my-products',

    ready: function() {
        this.getMyProducts('/my-products/get');
    },

    methods: {

        /**
         * Get my products data.
         *
         * @param url
         * @param callback
         */
        getMyProducts: function(url, callback) {

            // Show loader only if a callback is not given
            if (typeof callback === 'undefined') {
                Alert.loader();
            }

            // Do request
            this.$http.get(url, function(response) {

                this.$set('myProducts', response);
                this.$set('loaded', true);

                // Call callback if is given
                if (typeof callback !== 'undefined') {
                    callback();
                    return;
                }

                Alert.close();
            });

        },

        /**
         * Get my products data if an url was given
         *
         * @param url
         */
        paginate: function(url) {
            if (url) {
                this.getMyProducts(url);
            }
        },

        addProduct: function(current_page, rows_on_page) {

            var thisInstance = this;

            // Show product code prompt
            swal(this.getAddProductSwalConfig(), function(code) {

                if (!thisInstance.isProductCodeValid(code)) {
                    return false;
                }

                // Check if code is already used
                thisInstance.$http.get('/my-products/check/' + code).success(function(response) {

                    if (!response.success) {
                        swal.showInputError(response.message);
                        return false;
                    }

                    // Get product name
                    swal(this.getAddProductNameSwalConfig(), function(name) {

                        if (!thisInstance.isProductNameValid(name)) {
                            return false;
                        }

                        // Build data object and make request
                        var data = {
                            code: code,
                            name: name,
                            _token: Nova.getToken()
                        };

                        thisInstance.$http.post('/my-products/add', data, function(response) {

                            var paginationUrl = Nova.buildPaginationRequestUrl('/my-products/get', rows_on_page, current_page);
                            this.paginate(paginationUrl);
                            Nova.showSuccessAlert(response.title, response.message);

                        }).error(function(response) {
                            if (!response.message) {
                                Nova.showGeneralErrorAlert();
                                return false;
                            }
                            Nova.showErrorAlert(response.title, response.message);
                        });

                    });

                }).error(function(response) {

                    // Handle situations with an error response
                    if (!response.message) {
                        Nova.showGeneralErrorAlert();
                        return false;
                    }

                    Nova.showErrorAlert(response.title, response.message);
                });
            });

        },

        /**
         * Delete user product
         *
         * @param product_id
         * @param current_page
         * @param rows_on_page
         */
        deleteMyProduct: function(product_id, current_page, rows_on_page) {

            var thisInstance = this;

            Alert.confirmDeleteProductFromBill(function() {

                // Do request
                thisInstance.$http.get('/my-products/' + product_id + '/delete', function(response) {

                    // Handle success response
                    this.getMyProducts(Nova.buildPaginationRequestUrl('/my-products/get', rows_on_page, current_page), function() {
                        Alert.success(response.title, response.message);
                    });

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
         * Return swal configuration object for add product popup
         *
         * @returns {{title: (*|jQuery), text: (*|jQuery), type: string, showCancelButton: boolean, closeOnConfirm: boolean, showLoaderOnConfirm: boolean, inputPlaceholder: (*|jQuery)}}
         */
        getAddProductSwalConfig: function() {
            return {
                title: Nova.getMyProductTranslation('add-product'),
                text: Nova.getMyProductTranslation('add-product-description'),
                type: "input",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
                inputPlaceholder: Nova.getMyProductTranslation('code')
            };
        },

        /**
         * Return swal configuration object for add product popup
         *
         * @returns {{title: (*|jQuery), text: (*|jQuery), type: string, showCancelButton: boolean, closeOnConfirm: boolean, showLoaderOnConfirm: boolean, inputPlaceholder: (*|jQuery)}}
         */
        getAddProductNameSwalConfig: function() {
            return {
                title: Nova.getMyProductTranslation('add-product'),
                text: Nova.getMyProductTranslation('add-product-description'),
                type: "input",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
                inputPlaceholder: Nova.getMyProductTranslation('name')
            }
        },

        /**
         * Check if given product code is valid
         *
         * @param code
         * @returns {boolean}
         */
        isProductCodeValid: function(code) {

            if (code === false) {
                return false;
            }

            if (code === "") {
                swal.showInputError(Nova.getMyProductTranslation('product-code-required'));
                return false;
            }

            return true;
        },

        isProductNameValid: function(name) {

            if (name === false) {
                return false;
            }

            if (name === "") {
                swal.showInputError(Nova.getMyProductTranslation('product-name-required'));
                return false;
            }

            return true;

        }

    }

});