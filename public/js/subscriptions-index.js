new Vue({

    /**
     * Target element.
     */
    el: '#subscriptions',

    ready: function() {
        this.getActiveSubscriptions();
    },

    methods: {
        getActiveSubscriptions: function() {
            this._getSubscriptions('active');
        },

        getCanceledSubscriptions: function() {
            //
        },

        getFailedSubscriptions: function() {
            //
        },

        _getSubscriptions: function(status) {

            // Set a default value
            if (status !== 'active' && status !== 'canceled' && status !== 'failed') {
                status = 'active';
            }

            // Build request url, loading and subscriptions variables used by vue
            var url = '/admin-center/subscriptions/get/' + status;
            var loader = 'loading_' + status + '_subscriptions';
            var subscriptions = status + '_subscriptions';

            this.$set(loader, true);

            // Do request
            this.$http.get(url, function(response) {
                this.$set(loader, false);
                this.$set(subscriptions, response);
            }).error(function(response) {

                this.$set(loader, false);
                // Check if error message is available
                if (response.message) {
                    Alert.error(response.title, response.message);
                    return;
                }
                // Else display a general error message
                Alert.generalError();
            });

        }
    }

});
//# sourceMappingURL=subscriptions-index.js.map