new Vue({

    /**
     * Target element.
     */
    el: '#offers',

    /**
     * Called on ready.
     */
    ready: function() {
        this.getOffers();
    },

    methods: {

        /**
         * Paginate offers.
         */
        getOffers: function(successCallback) {

            if (typeof successCallback === 'undefined') {
                Alert.loader();
            }

            this.$http.get('/admin-center/subscriptions/offers/get', function(response) {

                // Handle success response case
                this.$set('offers', response);

                // Check if a callback was given
                if (typeof successCallback === 'undefined') {
                    Alert.close();
                    return;
                }

                // Execute if arrived here
                successCallback();

            }).error(function(response) {

                // Handle error response case
                if (response.message) {
                    Alert.error(response.title, response.message);
                    return;
                }
                Alert.generalError();
            });

        },

        createNewOffer: function() {

            this.$set('loading', true);

            // Build post data
            var data = {
                _token: Token.get(),
                offer_name: this.$get('offer_name'),
                offer_amount: this.$get('offer_amount'),
                promo_code: this.$get('promo_code'),
                user_password: this.$get('user_password')
            };

            // Make post request
            this.$http.post('/admin-center/subscriptions/offers/create', data, function(response) {

                // Handle success response
                this.getOffers(function() {
                    $('#create-new-offer-modal').modal('hide');
                    Alert.success(response.title, response.message);
                    this.$set('loading', false);
                });

            }).error(function(response) {

                this.$set('loading', false);

                // Handle error response
                if (!response.message) {
                    this.$set('error', Translation.common('general-error'));
                    return;
                }

                this.$set('errors', response.errors);
                console.log(this.$get('errors'));
            });
        },

        /**
         * Reset create new offer modal.
         */
        resetCreateNewOfferModal: function() {
            this.$set('errors', '');
            this.$set('error', '');
        }
    }
})
//# sourceMappingURL=offers.js.map