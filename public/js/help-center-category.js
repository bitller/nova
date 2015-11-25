new Vue({

    /**
     * Target element.
     */
    el: '#help-center-category',

    ready: function() {
        this.getData();
    },

    methods: {
        getData: function() {

            Alert.loader();
            var url = '/help-center/category/' + $('#help-center-category').attr('category-id') + '/get';

            this.$http.get(url, function(response) {

                this.$set('loaded', true);
                this.$set('category', response.category);
                Alert.close();

            }).error(function(response) {
                //
            });
            
        }
    }

});
//# sourceMappingURL=help-center-category.js.map