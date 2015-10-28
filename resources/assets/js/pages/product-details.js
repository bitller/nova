/**
 * Handle product details page.
 */
new Vue({

    /**
     * Target element.
     */
    el: '#product-details',

    /**
     * Called on ready.
     */
    ready: function() {
        this.getData();
    },

    /**
     * Available methods.
     */
    methods: {

        /**
         * Get product data.
         */
        getData: function() {

            Alert.loader();

            this.$http.get('/product-details/' + $('#product-details').attr('product-code') + '/get', function(response) {

                this.$set('product', response);
                this.$set('loaded', true);
                Alert.close();

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