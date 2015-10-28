new Vue({
    el: '#product-details',

    ready: function() {
        this.getData();
    },

    methods: {
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
//# sourceMappingURL=product-details.js.map