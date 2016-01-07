new Vue({

    /**
     * Target element.
     */
    el: '#offer',

    ready: function() {
        this.getOffer();
    },

    methods: {

        /**
         * Ajax request to get offer data.
         *
         * @param successCallback
         */
        getOffer: function(successCallback) {

            this.$set('loaded', false);

            if (typeof successCallback === 'undefined') {
                Alert.loader();
            }

            this.$http.get('/admin-center/subscriptions/offers/' + $('#offer').attr('offer-id') + '/get', function(response) {

                this.$set('loaded', true);
                this.$set('offer', response.offer);

                // Check if a callback was given
                if (typeof successCallback === 'undefined') {
                    Alert.close();
                    return;
                }

                // Execute callback
                successCallback();
            }).error(function(response) {

                // Handle error response
                this.$set('loaded', false);
                if (response.message) {
                    Alert.error(response.title, response.message);
                    return;
                }
                Alert.generalError();
            });
        },

        /**
         * Edit offer name.
         */
        editOfferName: function() {

            this.$set('loading', true);

            // Build post data
            var data = {
                _token: Token.get(),
                offer_name: this.$get('offer_name'),
                user_password: this.$get('user_password')
            };

            this.$http.post('/admin-center/subscriptions/offers/' + $('#offer').attr('offer-id') + '/edit-name', data, function(response) {

                // Handle success response
                this.$set('loading', false);
                this.$set('offer', response.offer);
                $('#edit-offer-name-modal').modal('hide');
                Alert.success(response.title, response.message);

            }).error(function(response) {

                // Handle error response
                this.$set('loading', false);
                if (!response.message) {
                    this.$set('error', Translation.common('general-error'));
                    return;
                }
                this.$set('errors', response.errors);
            });
        },

        /**
         * Reset edit offer name modal data.
         */
        resetEditOfferNameModal: function() {
            this.$set('offer_name', '');
            this.$set('user_password', '');
            this.$set('error', '');
            this.$set('errors', '');
        }
    }
});
//# sourceMappingURL=offer.js.map