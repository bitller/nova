new Vue({
    el: '#paid-bills',

    ready: function() {
        console.log('also');
        this.getPaidBills();
    },

    methods: {
        getPaidBills: function() {
            console.log('here');
            Alert.loader();
            this.$http.get('/paid-bills/get', function(response) {
                this.$set('paid_bills', response);
                this.$set('loaded', true);
                Alert.close();
            }).error(function(resposne) {
                //
            })
        }
    }
});
//# sourceMappingURL=paid-bills.js.map