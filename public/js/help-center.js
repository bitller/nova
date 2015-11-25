new Vue({

    /**
     * Target element.
     */
    el: '#help-center',

    /**
     * Called on ready.
     */
    ready: function() {
        this.getData();
    },

    methods: {
        getData: function() {
            Alert.loader();

            this.$http.get('/help-center/get', function(response) {

                this.$set('categories', response.categories);
                this.$set('loaded', true);
                Alert.close();

            }).error(function(response) {
                //
            });
        }
    }

});
//# sourceMappingURL=help-center.js.map