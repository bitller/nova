new Vue({

    /**
     * Target element.
     */
    el: '#campaign-statistics',

    ready: function() {
        this.getPageData();
    },

    methods: {
        getPageData: function() {

            Alert.loader();
            this.$set('loading', true);

            this.$http.get(this._getCampaignDataRequestUrl(), function(response) {

                this.$set('statistics', response.statistics);
                this.$set('loading', false);
                Alert.close();
            }).error(function(response) {
                Alert.generalError();
            });
        },

        _getCampaignDataRequestUrl: function() {
            return '/statistics/campaign/' + $('#campaign-statistics').attr('campaign-number') + '/' + $('#campaign-statistics').attr('campaign-year') + '/get';
        }
    }

});
//# sourceMappingURL=campaign-statistics.js.map