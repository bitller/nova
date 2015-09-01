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

            Nova.showLoader(Nova.getProductTranslation('loading'));

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