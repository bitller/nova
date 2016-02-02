new Vue({

    /**
     * Target element.
     */
    el: '#client-unpaid-bills',

    /**
     * Called when all is ready.
     */
    ready: function() {
        this.getPageData('/clients/' + $('#client-unpaid-bills').attr('client-id') + '/bills/unpaid/get')
    },

    methods: {

        /**
         * Paginate client unpaid bills.
         *
         * @param url
         */
        getPageData: function(url) {

            Alert.loader();
            this.$set('loaded', false);

            this.$http.get(url, function(response) {

                this.$set('data', response);
                this.$set('loaded', true);
                Alert.close();

            }).error(function(response) {
                Alert.generalError();
            });
        }
    }
});
//# sourceMappingURL=client-unpaid-bills.js.map