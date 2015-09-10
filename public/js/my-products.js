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
         * Get my products data
         *
         * @param url
         */
        getMyProducts: function(url) {

            Nova.showLoader(Nova.getCommonTranslation('loading'));

            this.$http.get(url, function(response) {
                this.$set('myProducts', response);
                this.$set('loaded', true);
                Nova.hideLoader();
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

            // Show confirmation
            swal({
                title: Nova.getMyProductTranslation('confirm'),
                text: Nova.getMyProductTranslation('delete-warning'),
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: Nova.getMyProductTranslation('confirm-delete'),
                cancelButtonText: Nova.getMyProductTranslation('cancel'),
                closeOnConfirm: false
            }, function() {

                // Show loader
                Nova.showLoader(Nova.getCommonTranslation('loading'));

                // Build request url
                var url = '/my-products/' + product_id + '/delete';
                thisInstance.$http.get(url).success(function(response) {

                    var paginationUrl = Nova.buildPaginationRequestUrl('/my-products/get', rows_on_page, current_page);
                    this.paginate(paginationUrl);

                }).error(function(response) {

                    var error = response.title;
                    var generalError = response.message;

                    if (!generalError) {
                        generalError = Nova.getCommonTranslation('general-error');
                    }

                    if (!error) {
                        error = Nova.getCommonTranslation('fail');
                    }

                    Nova.showErrorAlert(error, generalError);

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