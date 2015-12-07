new Vue({

    /**
     * Register page is the target.
     */
    el: '#register',

    methods: {
        register: function() {

            if (!this.validateForm()) {
                return false;
            }

            this.$set('loading', true);

            // Build post data
            var data = {
                _token: Token.get(),
                first_name: this.$get('first_name'),
                last_name: this.$get('last_name'),
                email: this.$get('email'),
                password: this.$get('password'),
                password_confirmation: this.$get('password_confirmation')
            };

            // Make post request
            this.$http.post('/register', data, function(response) {
                this.$set('loading', false);
                window.location.replace('/next');
                Alert.success(response.title, response.message);

            }).error(function(response) {

                this.$set('loading', false);

                if (!response.message) {
                    Alert.generalError();
                    return;
                }
                this.$set('errors', response.errors);
            });

            // Make request

            // Parse errors to highlight each input

        },

        responseHandler: function(error, result) {
            //
        },

        validateForm: function() {
            // Email
            if (!this.validateEmail()) {
                return false;
            }
            // Password
            if (!this.validatePassword()) {
                return false;
            }
            // Password confirmation
            if (!this.validatePasswordConfrimation()) {
                return false;
            }
            // Card number
            if (!this.validateCardNumber()) {
                return false;
            }
            // Card expiry date
            if (!this.validateExpiryDate()) {
                return false;
            }
            // Card cvv code
            if (!this.validateCardCvc()) {
                return false;
            }
        },

        validateEmail: function() {
            if (this.$get('email').length() > 0) {
                return true;
            }
            this.$set('email_error', Translation.register('email-error'));
            return false;
        },

        validatePassword: function() {
            if (this.$get('password').length() > 0) {
                return true;
            }
            this.$set('password_error', Translation.register('password-error'));
            return false;
        },

        validatePasswordConfrimation: function() {
            if (this.$get('password-confirmation').length() > 0) {
                return true;
            }
            this.$set('password_confirmation_error', Translation.register('password-confirmation-error'));
            return false;
        },

        /**
         * Validate card number.
         *
         * @returns {boolean}
         */
        validateCardNumber: function() {
            // Do nothing if card number is valid
            if (paymill.validateCardNumber(this.$get('card_number'))) {
                return true;
            }

            // Show error message if card number is invalid
            this.$set('card_number_error', Translation.subscribe('card-number-error'));
        },

        /**
         * Validate expiry date.
         *
         * @returns {boolean}
         */
        validateExpiryDate: function() {
            // Do nothing if expiry date is valid
            if (paymill.validateExpiry(this.$get('card_expiry_month'), this.$get('card_expiry_year'))) {
                return true;
            }

            // Show error message if expiry date is invalid
            this.$set('card_expiry_date_error', Translation.subscribe('card-expiry-date-error'));
        },

        /**
         * Validate card cvc.
         *
         * @returns {boolean}
         */
        validateCardCvc: function() {
            if (paymill.validateCvc(this.$get('card_cvc'))) {
                return true;
            }

            // Show error if cvc is invalid
            this.$set('card_cvc_error', Translation.subscribe('card-cvc-error'));
        },

        /**
         * Return translated version of api error message.
         *
         * @param apiErrorMessage
         */
        setApiErrorMessage: function(apiErrorMessage) {

            // All errors
            var errors = {
                internal_server_error: 'internal_server_error',
                invalid_public_key: 'invalid_public_key',
                unknown_error: 'unknown_error',
                cancelled_3ds: '3ds_cancelled',
                field_invalid_card_number: 'field_invalid_card_number',
                field_invalid_card_exp_year: 'field_invalid_card_exp_year',
                field_invalid_card_exp_month: 'field_invalid_card_exp_month',
                field_invalid_card_exp: 'field_invalid_card_exp',
                field_invalid_card_cvc: 'field_invalid_card_cvc',
                field_invalid_card_holder: 'field_invalid_card_holder',
                field_invalid_amount_int: 'field_invalid_amount_int',
                field_invalid_amount: 'field_invalid_amount',
                field_invalid_currency: 'field_invalid_currency'
            };

            switch (apiErrorMessage) {

                // Internal server error
                case errors.internal_server_error:
                    this.set('general_error', Translation.subscribe('internal-server-error'));
                    break;

                // Invalid public key
                case errors.invalid_public_key:
                    this.set('general_error',  Translation.subscribe('internal-server-error'));
                    break;

                // Unknown error
                case errors.unknown_error:
                    this.$set('general_error', Translation.subscribe('internal-server-error'));
                    break;

                // 3ds cancelled
                case errors.cancelled_3ds:
                    this.$set('general_error', Translation.subscribe('payment-aborted'));
                    break;

                // Invalid card number
                case errors.field_invalid_card_number:
                    this.$set('card_number_error', Translation.subscribe('card-number-error'));
                    break;

                // Invalid card expiry year
                case errors.field_invalid_card_exp_year:
                    this.$set('card_expiry_date_error', Translation.subscribe('card-expiry-date-error'));
                    break;

                // Invalid card expiry month
                case errors.field_invalid_card_exp_month:
                    this.$set('card_expiry_date_error', Translation.subscribe('card-expiry-date-error'));
                    break;

                // Invalid card expiry date
                case errors.field_invalid_card_exp:
                    this.$set('card_expiry_date_error', Translation.subscribe('card-expiry-date-error'));
                    break;

                // Invalid card cvc
                case errors.field_invalid_card_cvc:
                    this.$set('card_cvc_error', Translation.subscribe('card-cvc-error'));
                    break;

                // Invalid card holder
                case errors.field_invalid_card_holder:
                    this.$set('card_holder_error', Translation.subscribe('card-holder-error'));
                    break;

                // Invalid amount for 3d secure
                case errors.field_invalid_amount_int:
                    this.$set('general_error', Translation.subscribe('internal-server-error'));
                    break;

                // Invalid amount
                case errors.field_invalid_amount:
                    this.$set('general_error', Translation.subscribe('internal-server-error'));
                    break;

                // Invalid currency
                case errors.field_invalid_currency:
                    this.$set('general_error', Translation.subscribe('internal-server-error'));
                    break;
            }
        }
    }
});