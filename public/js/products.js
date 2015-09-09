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

    el: '#products',

    /**
     * Called when page is ready
     */
    ready: function() {
        this.getProducts('/products/get');
    },

    methods: {

        /**
         * Get products data
         *
         * @param url
         */
        getProducts: function(url) {

            Nova.showLoader(Nova.getCommonTranslation('loading'));

            this.$http.get(url, function(response) {
                this.$set('products', response);
                this.$set('loaded', true);
                Nova.hideLoader();
            });
        },

        /**
         * Get products data if an url was given
         *
         * @param url
         */
        paginate: function(url) {
            if (url) {
                this.getProducts(url);
            }
        },

        editProduct: function(product_id, product_name, current_page, rows_on_page) {

            var thisInstance = this;

            // Show product name prompt
            swal({
                title: Nova.getProductTranslation('edit-product-name'),
                type: 'input',
                inputValue: product_name,
                showCancelButton: true,
                closeOnConfirm: false,
                animation: "slide-from-top",
                confirmButtonText: Nova.getProductTranslation('edit-product-name'),
                cancelButtonText: Nova.getProductTranslation('cancel')

            }, function(inputValue) {

                if (inputValue === false) {
                    return false;
                }

                if (inputValue === "") {
                    swal.showInputError('');
                    return false;
                }

                // Show loader
                Nova.showLoader(Nova.getProductTranslation('loading'));

                // Build data
                var url = Nova.buildEditProductNameRequestUrl(product_id, rows_on_page, current_page);
                var data = {
                    name: inputValue,
                    _token: Nova.getToken()
                };

                // Make request
                thisInstance.$http.post(url, data, function(response) {

                    var getProductsUrl = Nova.buildProductsRequestUrl(rows_on_page, current_page);
                    thisInstance.paginate(getProductsUrl);

                    Nova.showSuccessAlert(response.title, response.message);
                }).error(function(response) {
                    Nova.showErrorAlert(response.title, response.message);
                });

            });

        },

        addProduct: function() {

            // Show product code modal
            swal({
                title: Nova.getProductTranslation('add-product-title'),
                type: 'input',
                inputPlaceholder: Nova.getProductTranslation('product-name'),
                showCancelButton: true,
                closeOnConfirm: false,
                animation: 'slide-from-top',
                confirmButtonText: '',
                cancelButtonText: ''
            });

            // Ask for product code

            // Do request and show errors or success message if all is ok

        }

    }

});

$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});
//# sourceMappingURL=products.js.map