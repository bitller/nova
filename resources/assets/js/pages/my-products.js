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

        }

    }

});