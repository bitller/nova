

new Vue({

    /**
     * Target element.
     */
    el: '#campaign-statistics',

    ready: function() {
        this.getPageData();
    },

    methods: {

        /**
         * Query server for page statistics.
         */
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

        /**
         * Get all campaigns years.
         */
        getCampaignsYears: function() {

            this.$set('loading_modal_data', true);
            var thisInstance = this;

            this.$http.get('/statistics/campaign/get-all-years', function(response) {

                thisInstance.$set('loading_modal_data', false);
                thisInstance.$set('years', response.years)

            }).error(function(response) {
                thisInstance.$set('loading_modal_data', false);
            });
        },

        /**
         * Get campaign numbers for given years.
         */
        getCampaignNumbers: function() {

            this.$set('loading_modal_data', true);
            var thisInstance = this;

            var postData = {
                year: this.$get('selected_year'),
                _token: Token.get()
            };

            this.$http.post('/statistics/campaign/get-numbers', postData, function(response) {

                thisInstance.$set('loading_modal_data', false);
                thisInstance.$set('numbers', response.numbers);
                thisInstance.$set('numbers_loaded', true);

            }).error(function(response) {
                this.$set('loading_modal_data', false);
            });
        },

        /**
         * Generate link that compare the two campaigns.
         */
        compareCampaigns: function() {
            Alert.loader();
            window.location.href = '/statistics/campaign/' + $('#campaign-statistics').attr('campaign-number') + '/' + $('#campaign-statistics').attr('campaign-year') + '/compare-with/' + this.$get('selected_number') + '/' + this.$get('selected_year');
        },

        /**
         * Build url used to query the server.
         *
         * @returns {string}
         * @private
         */
        _getCampaignDataRequestUrl: function() {
            return '/statistics/campaign/' + $('#campaign-statistics').attr('campaign-number') + '/' + $('#campaign-statistics').attr('campaign-year') + '/get';
        }
    }

});
//# sourceMappingURL=campaign-statistics.js.map
