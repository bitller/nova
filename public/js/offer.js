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
        },

        /**
         * Edit offer amount.
         */
        editOfferAmount: function() {

            this.$set('loading', true);

            // Build post data
            var data = {
                _token: Token.get(),
                offer_amount: this.$get('offer_amount'),
                user_password: this.$get('user_password')
            };

            this.$http.post('/admin-center/subscriptions/offers/' + $('#offer').attr('offer-id') + '/edit-amount', data, function(response) {

                // Handle success response
                this.$set('loading', false);
                this.$set('offer', response.offer);
                $('#edit-offer-amount-modal').modal('hide');
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
         * Reset offer amount modal data.
         */
        resetEditOfferAmountModal: function() {
            this.$set('offer_amount', '');
            this.$set('user_password', '');
            this.$set('error', '');
            this.$set('errors', '');
        },

        /**
         * Edit offer promo code.
         */
        editOfferPromoCode: function() {

            var config = {
                action_url: 'edit-promo-code',
                modal_selector: '#edit-offer-promo-code-modal',
                post: {
                    promo_code: this.$get('promo_code'),
                    user_password: this.$get('user_password')
                }
            };

            this._generalEdit(config);
        },

        /**
         * Reset edit offer promo code modal data.
         */
        resetEditOfferPromoCodeModal: function() {
            this.$set('promo_code', '');
            this.$set('user_password', '');
            this.$set('error', '');
            this.$set('errors', '');
        },

        useOfferOnSignUp: function() {

            var config = {
                action_url: 'use-on-sign-up',
                modal_selector: '#use-offer-on-sign-up-modal',
                post: {
                    use_on_sign_up: this.$get('use_on_sign_up'),
                    user_password: this.$get('user_password')
                }
            };

            this._generalEdit(config);
        },

        /**
         * Reset use offer on sign up modal data.
         */
        resetUseOfferOnSignUpModal: function() {
            this._resetModal(['user_password']);
        },

        /**
         * Edit offer data based on given config.
         *
         * @param config
         * @private
         */
        _generalEdit: function(config) {

            // Set loading variable to true. Use default if no loading variable name was given
            if (!config.loading_variable_name) {
                config.loading_variable_name = 'loading';
            }
            this.$set(config.loading_variable_name, true);

            // Add token to post data
            config.post._token = Token.get();

            // Make post request
            this.$http.post('/admin-center/subscriptions/offers/' + $('#offer').attr('offer-id') + '/' + config.action_url, config.post, function(response) {

                // Handle success response
                this.$set(config.loading_variable_name, false);
                this.$set('offer', response.offer);
                $(config.modal_selector).modal('hide');
                Alert.success(response.title, response.message);

            }).error(function(response) {

                // Handle error response
                this.$set(config.loading_variable_name, false);
                if (!response.message) {
                    this.$set('error', Translation.common('general-error'));
                    return;
                }
                this.$set('errors', response.errors);
            });
        },

        /**
         * Reset given modal fields.
         *
         * @param fields
         * @private
         */
        _resetModal: function(fields) {
            for (var index = 0; index < fields.length; index++) {
                this.$set(fields[index], '');
            }
        }
    }
});
//# sourceMappingURL=offer.js.map