new Vue({

    /**
     * Target element.
     */
    el: '#recover',

    /**
     * Available methods.
     */
    methods: {

        /**
         * Make post request to send email with reset link.
         */
        recover: function() {

            this.$set('loading', true);

            // Build post data
            var data = {
                _token: Token.get(),
                email: this.$get('email')
            };

            this.$http.post('/recover', data, function(response) {

                // Handle success response
                this.$set('loading', false);
                Alert.success(response.title, response.message, true);

            }).error(function(response) {

                // Handle error response
                this.$set('loading', false);
                if (!response.message) {
                    this.$set('error', Translation.common('general-error'));
                    return;
                }

                this.$set('error', response.message);

            })

        }
    }
});