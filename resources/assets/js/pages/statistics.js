new Vue({
    el: '#statistics',

    ready: function() {
        this.getStatistics();
    },

    methods: {
        getStatistics: function() {
            Alert.loader();
            this.$http.get('/statistics/get', function(response) {
                this.$set('loaded', true);
                this.$set('statistics', response);
                Alert.close();
            }).error(function(response) {
                Alert.generalError();
            });
        }
    }

});