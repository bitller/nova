new Vue({

    el: '#bill',

    data: {
        pageHover: false,
        counter: 0
    },

    ready: function() {
        this.getBill();
    },

    methods: {

        /**
         * @param showSuccess
         */
        getBill: function(showSuccess) {

            Alert.loader();

            this.$http.get('/bills/' + $('#bill').attr('bill-id') + '/get', function(response) {

                this.$set('bill', response);
                this.$set('loaded', true);

                if (typeof showSuccess === 'undefined') {
                    Alert.close();
                    return;
                }
                showSuccess();
            });

        },

        /**
         * Delete product from bill
         *
         * @param id
         */
        deleteProduct: function(id) {

            var thisInstance = this;

            // Ask for confirmation
            Alert.confirmDelete(function() {

                // Show loader
                Alert.loader();

                // Make request
                thisInstance.$http.get('/bills/' + $('#bill').attr('bill-id') + '/delete/' + id, function(response) {

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
        }

    }
});