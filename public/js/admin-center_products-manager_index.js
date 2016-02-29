new Vue({

    /**
     * Target element.
     */
    el: '#products-manager-index',

    /**
     * Called when vue si ready.
     */
    ready: function() {
        this.getProducts('/admin-center/products-manager/get');
    },

    methods: {
        getProducts: function(url, callback) {

            // Show loader if no callback was given
            if (typeof callback === 'undefined') {
                Alert.loader();
            }

            // Make get request
            this.$http.get(url, function(response) {

                this.$set('products', response);
                this.$set('loaded', true);

                // Execute callback if given
                if (typeof callback !== 'undefined') {
                    callback();
                    return;
                }

                // Else just close the loading alert
                Alert.close();

            }).error(function(response) {
                //
            });
        }
    }
});
//# sourceMappingURL=admin-center_products-manager_index.js.map
