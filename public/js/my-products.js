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

        /**
         * Add product.
         */
        addProduct: function() {

            // Reset errors
            this.$set('error', '');
            this.$set('errors', '');

            var thisInstance = this;
            this.$set('loading', true);

            var postData = {
                _token: Token.get(),
                name: this.$get('name'),
                code: this.$get('code')
            };

            this.$http.post('/my-products/add', postData, function(response) {

                this.getMyProducts('/my-products/get', function() {

                    thisInstance.$set('loading', false);

                    // Reset modal
                    thisInstance.resetAddProductModal();

                    Alert.success(response.message);

                    // Hide if is required
                    if (!thisInstance.$get('add_another_product')) {
                        $('#add-custom-product-modal').modal('hide');
                    }
                });

            }).error(function(response) {

                thisInstance.$set('loading', false);

                if (!response.message) {
                    this.$set('error', Translation.common('general-error'));
                    return;
                }

                this.$set('errors', response.errors);

            });
        },

        /**
         * Toggle search products bar.
         */
        toggleSearch: function() {
            $('.search-products').toggle();
        },

        /**
         * Search user custom products.
         */
        search: function() {

            var thisInstance = this;
            
            this.getMyProducts('/my-products/get/search?term=' + this.$get('search_term'), function() {

                var searched = false;

                if (thisInstance.$get('search_term')) {
                    searched = true;
                }

                thisInstance.$set('searched', searched);
                Alert.close();
            });
        },

        resetSearch: function() {
            Alert.loader();
            var thisInstance = this;

            this.paginate('/my-products/get', function() {
                thisInstance.$set('search_term', '');
                $('#search-products-input').val('');
                Alert.close();
            });
        },

        /**
         * Reset add product modal.
         */
        resetAddProductModal: function() {

            this.$set('name', '');
            this.$set('code', '');

            $('#product-code').val('');
            $('#product-name').val('');
            $('#product-code').focus();
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
//# sourceMappingURL=my-products.js.map
