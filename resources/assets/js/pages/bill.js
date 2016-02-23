new Vue({

    el: '#bill',

    data: {
        code: '',
        page: '',
        discount: '',
        price: '',
        quantity: '',
        add_product: Translation.bill('add-product')
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

                // Make sure bill exists
                if (!response.data) {
                    Alert.error(Translation.bill('bill-not-found'), Translation.bill('bill-not-found-description'), 'keep');
                    setInterval(function() {
                        window.location.replace('/bills');
                    }, 2000);
                    return;
                }

                this.$set('bill', response);
                this.$set('other_details', response.data.other_details);
                this.$set('payment_term', response.data.payment_term);
                this.$set('payment_term_not_set', response.data.payment_term_not_set);
                this.$set('total', response.total);
                this.$set('saved_money', response.saved_money);
                this.$set('to_pay', response.to_pay);
                this.$set('paid', response.data.paid);
                this.$set('number_of_products', response.number_of_products);
                this.$set('payment_term_passed', response.data.payment_term_passed);
                this.$set('loaded', true);
                this.$set('loading', false);

                if (typeof showSuccess === 'undefined') {
                    Alert.close();
                    return;
                }
                showSuccess();
            });

        },

        /**
         * Print bill.
         */
        printBill: function() {
            window.print();
        },

        /**
         *
         * @param productId
         * @param productCode
         */
        addProduct: function(productId, productCode) {

            this.$set('add_product', Translation.common('loading'));
            this.$set('loading', true);

            // Build post data
            var data = {
                _token: Token.get()
            };

            if ($('#product-code').val()) {
                data.product_code = $('#product-code').val();
                this.$set('code', $('#product-code').val());
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
            if (this.$get('product_not_available')) {
                data.product_not_available = true;
            } else {
                data.product_not_available = false;
            }

            this.$set('post_data', data);

            // Make post request
            this.$http.post('/bills/' + Data.getBillId() + '/add', data, function(response) {

                if (!response.success) {
                    this.$set('error', response.message);
                    return;
                }

                this.getBill(function() {
                    this.$set('add_product', Translation.bill('add-product'));
                    this.$set('loading', false);
                    $('#addProductToBillModal').modal('hide');
                    Alert.success(response.title, response.message);
                }, true);

            }).error(function(response) {

                if (response.product_not_exists) {
                    this.$set('product_not_exists', true);
                }

                if (!response.message) {
                    this.$set('error', Translation.common('error'));
                    return;
                }

                this.$set('add_product', Translation.bill('add-product'));
                this.$set('errors', response.errors);
                this.$set('loading', false);
            });
        },

        /**
         * Handle case when a product does not exists in database.
         */
        addNotExistentProduct: function() {

            this.$set('loading', true);
            var thisInstance = this;

            var postData = this.$get('post_data');
            postData.product_name = this.$get('name');

            this.$http.post('/bills/' + Data.getBillId() + '/add-not-existent-product', postData, function (response) {

                this.getBill(function() {
                    thisInstance.$set('add_product', Translation.bill('add-product'));
                    thisInstance.$set('loading', false);
                    $('#addProductToBillModal').modal('hide');
                    Alert.success(response.title, response.message);
                }, true);

            }).error(function (response) {

                this.$set('loading', false);

                if (!response.message) {
                    this.$set('error', Translation.common('error'));
                    return;
                }

                this.$set('errors', response.errors);
            });
        },

        /**
         * Reset add product to bill modal.
         */
        resetAddProductToBillModal: function() {
            // Reset vue data
            this.$set('page', '');
            this.$set('code', '');
            this.$set('price', '');
            this.$set('quantity', '');
            this.$set('discount', '');
            this.$set('error', false);
            this.$set('loading', false);
            this.$set('add_product', Translation.bill('add-product'));
            this.$set('errors', []);
            this.$set('code', '');
            this.$set('product_not_exists', false);
            this.$set('post_data', false);
            this.$set('product_name', '');

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
                    _token: Token.get(),
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
         * @param billProductId
         */
        editQuantity: function(productQuantity, productId, productCode, billProductId) {

            var thisInstance = this;

            // Show edit quantity alert
            Alert.editQuantity(productQuantity, function(inputValue) {

                // Build post data
                var data = {
                    _token: Token.get(),
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
         * @param billProductId
         */
        editPrice: function(productPrice, productId, productCode, billProductId) {

            var thisInstance = this;

            // Show edit price alert
            Alert.editPrice(productPrice, function(inputValue) {

                // Post data
                var data = {
                    _token: Token.get(),
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
                    _token: Token.get(),
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
            Alert.confirmDeleteProductFromBill(function() {

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

        /**
         * Edit bill other details.
         */
        saveOtherDetails: function() {

            // Post data
            var data = {
                _token: Token.get(),
                other_details: this.$get('otherDetails')
            };

            this.$set('loading', true);

            // Request
            this.$http.post('/bills/' + Data.getBillId() + '/edit-other-details', data, function(response) {

                this.$set('loading', false);
                // Success response
                if (response.success) {
                    $('#other-details-modal').modal('toggle');
                    this.$set('other_details', response.other_details);
                    Alert.success(response.title, response.message);
                    return;
                }

                this.$set('error', Translation.common('general-error'));

            }).error(function(response) {
                this.$set('loading', false);
                // Fail response
                if (response.message) {
                    this.$set('error', response.message);
                    return;
                }
                this.$set('error', Translation.common('general-error'));
            });

        },

        /**
         * Reset other details modal.
         */
        resetOtherDetailsModal: function() {
            this.$set('error', '');
        },

        /**
         * Edit bill payment term.
         */
        setPaymentTerm: function() {

            // Build post data
            var data = {
                _token: Token.get(),
                payment_term: $('#payment-term').val()
            };
            this.$set('loading', true);

            // Make post request
            this.$http.post('/bills/' + Data.getBillId() + '/edit-payment-term', data, function(response) {

                this.$set('loading', false);
                // Handle success response
                if (response.success) {
                    $('#payment-term-modal').modal('toggle');
                    this.$set('payment_term', response.payment_term);
                    this.$set('payment_term_passed', response.payment_term_passed);
                    Alert.success(response.title, response.message);
                    return;
                }

                this.$set('error', Translation.common('general-error'));

            }).error(function(response) {

                this.$set('loading', false);
                // Handle error response
                if (response.message) {
                    this.$set('error', response.message);
                    return;
                }
                this.$set('error', Translation.common('general-error'));
            });

        },

        /**
         * Reset payment term modal.
         */
        resetPaymentTermModal: function() {
            this.$set('error', '');
        },

        /**
         * Delete bill from bill page.
         */
        deleteBill: function() {

            Alert.loader();

            // Make request
            this.$http.get('/bills/' + Data.getBillId() + '/delete', function(response) {

                // Show success message and redirect on success
                if (response.success) {
                    Alert.success(response.title, response.message);
                    window.location.replace('/bills');
                    return;
                }

                Alert.generalError();

            }).error(function(response) {

                // Handle error response
                if (response.message) {
                    Alert.error(response.title, response.message);
                    return;
                }

                Alert.generalError();
            });

        },

        /**
         * Mark bill as paid.
         */
        markAsPaid: function() {

            Alert.loader();

            this.$http.get('/bills/' + Data.getBillId() + '/mark-as-paid', function(response) {
                Alert.success(response.title, response.message);
                this.$set('paid', response.paid);
            }).error(function(response) {
                if (!response.message) {
                    Alert.generalError();
                    return;
                }
                Alert.error(response.title, response.message);
            });
        },

        /**
         * Mark bill as unpaid.
         */
        markAsUnpaid: function() {

            Alert.loader();

            this.$http.get('/bills/' + Data.getBillId() + '/mark-as-unpaid', function(response) {

                Alert.success(response.title, response.message);
                this.$set('paid', response.paid);

            }).error(function(response) {

                if (!response.message) {
                    Alert.generalError();
                    return;
                }
                Alert.error(response.title, response.message);

            });
        }
    }
});