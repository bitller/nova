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
            this.resetErrors();
            this.$set('loading', true);

            // Build post data
            var data = {
                _token: Token.get(),
                email: this.$get('email')
            };

            this.$http.post('/recover', data, function(response) {

                // Handle success response
                this.$set('loading', false);
                Alert.success(response.title, response.message, 'keep');

            }).error(function(response) {

                // Handle error response
                this.$set('loading', false);
                if (response.errors) {
                    this.$set('errors', response.errors);
                    return;
                }
                if (!response.message) {
                    this.$set('general_error', Translation.common('general-error'));
                    return;
                }

                this.$set('general_error', response.message);

            });
        },

        /**
         * Allow user to set a new password.
         */
        setNewPassword: function() {

            this.resetErrors();
            this.$set('loading', true);

            // Build post data
            var data = {
                _token: Token.get(),
                new_password: this.$get('new_password'),
                new_password_confirmation: this.$get('new_password_confirmation')
            };

            this.$http.post('/recover/' + $('#user_id').attr('content') + '/' + $('#code').attr('content'), data, function(response) {

                this.$set('loading', false);

                Alert.success(response.title, response.message, 'keep');
                setTimeout(function() {
                    window.location.replace('/login');
                }, 2000);

            }).error(function(response) {

                this.$set('loading', false);
                if (response.errors) {
                    this.$set('errors', response.errors);
                    return;
                }
                if (!response.message) {
                    Alert.generalError();
                    return;
                }

                this.$set('errors', response.errors);
            });
        },

        /**
         * Reset recover form errors.
         */
        resetErrors: function() {
            this.$set('errors', '');
            this.$set('general_error', '');
        }
    }
});