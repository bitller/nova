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

        /**
         * Make get request and return products.
         *
         * @param url
         * @param callback
         */
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
        },

        toggleSearch: function() {
            $('.search-application-products').toggle(400);
        },

        search: function() {

            Alert.loader();
            var thisInstance = this;

            this.getProducts('/admin-center/products-manager/get/search?term=' + this.$get('search_term'), function() {

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

            this.getProducts('/admin-center/products-manager/get', function() {
                thisInstance.$set('search_term', '');
                $('#search-application-products-input').val('');
                Alert.close();
            });
        }
    }
});