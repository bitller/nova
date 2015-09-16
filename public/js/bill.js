new Vue({

    el: '#bill',

    ready: function() {
        this.getBill();
    },

    methods: {
        getBill: function(url) {

            Alert.loader();

            this.$http.get('/bills/' + $('#bill').attr('bill-id') + '/get', function(response) {
                this.$set('bill', response);
                this.$set('loaded', true);
                Alert.close();
            });

        }
    }
});
//# sourceMappingURL=bill.js.map