new Vue({

    /**
     * Target element.
     */
    el: '#products-manager-product',

    ready: function() {
        this.getProduct();
    },

    methods: {
        getProduct: function() {
            Alert.loader();
            this.$set('loaded', false);

            this.$http.get('/admin-center/products-manager/product/' + $('#products-manager-product').attr('product-id') + '/' + $('#products-manager-product').attr('product-code') + '/get', function(response) {
                this.$set('product', response.product);
                this.$set('loaded', true);
                Alert.close();
            }).error(function(response) {
                this.$set('loaded', true);
            });
        }
    }
});