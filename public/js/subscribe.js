new Vue({

    /**
     * Target element.
     */
    el: '#subscribe',

    methods: {
        subscribe: function() {

            // Run validation functions
            this.validateCardNumber();
            this.validateExpiryDate();
            this.validateCardCvc();

            paymill.createToken({
                number: this.$get('card_number'),
                exp_month: this.$get('card_expiry_month'),
                exp_year: this.$get('card_expiry_year'),
                cvc: this.$get('card_cvc'),
                cardholder: this.$get('card_holdername'),
                amount: this.$get('amount'),
                currency: this.$get('currency')
            }, this.responseHandler);
        },

        responseHandler: function(error, result) {
            // Handle error response
            if (error) {
                this.setApiErrorMessage(error.apierror);
                return false;
            }

            // All is ok, send token to the server
            var data = {
                _token: Token.get(),
                token: result.token
            };
            this.$http.post('/subscribe/process', data, function(response) {
                //
            }).error(function(response) {
                //
            });
        }
    }

});
//# sourceMappingURL=subscribe.js.map