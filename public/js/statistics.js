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
$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
});
//# sourceMappingURL=statistics.js.map