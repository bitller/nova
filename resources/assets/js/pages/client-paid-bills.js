new Vue({

    /**
     * Target element.
     */
    el: '#client-paid-bills',

    ready: function() {
        this.getPageData('/clients/' + $('#client-paid-bills').attr('client-id')+'/bills/paid/get');
    },

    methods: {
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