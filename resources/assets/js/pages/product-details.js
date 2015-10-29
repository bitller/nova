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

            this.$http.get('/product-details/' + Data.getProductCode() + '/get', function(response) {

                this.$set('name', response.name);
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
        },

        /**
         *
         * @param currentName
         */
        editName: function(currentName, productCode, productId) {

            var thisInstance = this;

            Alert.editProductName(currentName, function(newName) {

                var data = {
                    _token: Token.get(),
                    id: productId,
                    name: newName
                };

                thisInstance.$http.post('/product-details/' + Data.getProductCode() + '/edit-name', data, function(response) {
                    this.$set('name', response.name);
                    Alert.success(response.title, response.message);

                }).error(function(response) {

                    if (!response.message) {
                        Alert.generalError();
                        return;
                    }

                    Alert.error(response.title, response.message);
                });
            });
        }
    }
});