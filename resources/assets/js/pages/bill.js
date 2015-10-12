new Vue({

    el: '#bill',

    data: {
        code: '',
        page: '',
        discount: '',
        price: '',
        quantity: ''
    },

    ready: function() {
        this.getBill();
    },

    methods: {

        /**
         * Make request to get user bills.
         *
         * @param showSuccess callback when get bills request is finished
         * @param hideLoader If set to true, loading alert will not be displayed
         */
        getBill: function(showSuccess, hideLoader) {

            if (typeof hideLoader === 'undefined') {
                Alert.loader();
            }

            this.$http.get('/bills/' + $('#bill').attr('bill-id') + '/get', function(response) {

                this.$set('bill', response);
                this.$set('other_details', response.data.other_details);
                this.$set('loaded', true);

                if (typeof showSuccess === 'undefined') {
                    Alert.close();
                    return;
                }
                showSuccess();
            });

        },

        /**
         *
         * @param productId
         * @param productCode
         */
        addProduct: function(productId, productCode) {

            // Build post data
            var data = {};

            if ($('#product-code').val()) {
                data.product_code = $('#product-code').val();
            }

            if (this.$get('page')) {
                data.product_page = this.$get('page');
            }
            if (this.$get('price')) {
                data.product_price = this.$get('price');
            }
            if (this.$get('discount')) {
                data.product_discount = this.$get('discount');
            }
            if (this.$get('quantity')) {
                data.product_quantity = this.$get('quantity');
            }

            // Make post request
            this.$http.post('/bills/' + Data.getBillId() + '/add', data, function(response) {

                if (!response.success) {
                    this.$set('error', response.message);
                    return;
                }

                this.getBill(function() {
                    $('#addProductToBillModal').modal('hide');
                    Alert.success(response.title, response.message);
                }, true);

            }).error(function(response) {
                if (response.message) {
                    this.$set('error', response.message)
                }
            });

        },

        resetModal: function() {
            // Reset vue data
            this.$set('page', '');
            this.$set('code', '');
            this.$set('price', '');
            this.$set('quantity', '');
            this.$set('discount', '');
            this.$set('error', false);
            // Reset inputs
            $('#product-code').val('');
            $('#product-price').val('');
            $('#product-page').val('');
            $('#product-quantity').val('');
            $('#product-discount').val('');
        },

        /**
         * Edit product page from bill.
         *
         * @param productPage
         * @param productId
         * @param productCode
         * @param billProductId
         */
        editPage: function(productPage, productId, productCode, billProductId) {

            var thisInstance = this;

            Alert.editPage(productPage, function(inputValue) {

                var data = {
                    product_id: productId,
                    bill_product_id: billProductId,
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
        editQuantity: function(productQuantity, productId, productCode, billProductId) {

            var thisInstance = this;

            // Show edit quantity alert
            Alert.editQuantity(productQuantity, function(inputValue) {

                // Build post data
                var data = {
                    product_id: productId,
                    bill_product_id: billProductId,
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
         * Edit product price.
         *
         * @param productPrice
         * @param productId
         * @param productCode
         */
        editPrice: function(productPrice, productId, productCode, billProductId) {

            var thisInstance = this;

            // Show edit price alert
            Alert.editPrice(productPrice, function(inputValue) {

                // Post data
                var data = {
                    product_id: productId,
                    bill_product_id: billProductId,
                    product_code: productCode,
                    product_price: inputValue
                };

                // Make post request
                thisInstance.$http.post('/bills/' + $('#bill').attr('bill-id') + '/edit-price', data, function(response) {

                    if (response.success) {
                        this.getBill(function() {
                            Alert.success(Translation.common('success'), Translation.bill('price-updated'));
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
         * Edit product discount.
         *
         * @param productDiscount
         * @param productId
         * @param productCode
         */
        editDiscount: function(productDiscount, productId, productCode, billProductId) {

            var thisInstance = this;

            // Show edit discount alert
            Alert.editDiscount(productDiscount, function(inputValue) {

                // Data used is post request
                var data = {
                    product_id: productId,
                    bill_product_id: billProductId,
                    product_code: productCode,
                    product_discount: inputValue
                };

                // Do request
                thisInstance.$http.post('/bills/' + $('#bill').attr('bill-id') + '/edit-discount', data, function(response) {

                    // Handle success response
                    if (response.success) {
                        this.getBill(function() {
                            Alert.success(Translation.common('success'), Translation.bill('discount-updated'));
                        }, true);
                        return true;
                    }
                }).error(function(response) {

                    // Handle error response
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
         * @param code
         */
        deleteProduct: function(id, code, billProductId) {

            var thisInstance = this;

            // Ask for confirmation
            Alert.confirmDelete(function() {

                // Show loader
                Alert.loader();

                // Make request
                thisInstance.$http.get('/bills/' + $('#bill').attr('bill-id') + '/delete/' + id + '/' + code + '/' + billProductId, function(response) {

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
        },

        saveOtherDetails: function() {

            var data = {
                other_details: this.$get('otherDetails')
            };

            this.$http.post('/bills/' + Data.getBillId() + '/edit-other-details', data, function(response) {
                if (response.success) {
                    $('#other-details-modal').modal('toggle');
                    this.$set('other_details', response.other_details);
                    Alert.success(response.title, response.message);
                }
                return;

                this.$set('error', Translation.common('general-error'));

            }).error(function(response) {

                if (response.message) {
                    this.$set('error', response.message);
                    return;
                }
                this.$set('error', Translation.common('general-error'));
            });

        },

        resetOtherDetailsModal: function() {
            this.$set('error', '');
        }
    }
});