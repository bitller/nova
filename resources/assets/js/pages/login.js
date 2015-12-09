new Vue({

    /**
     * Target element.
     */
    el: '#login',

    methods: {

        /**
         * Handle user login.
         */
        login: function() {
            this.resetErrors();
            this.$set('loading', true);

            var data = {
                _token: Token.get(),
                email: this.$get('email'),
                password: this.$get('password')
            };

            this.$http.post('/login', data, function(response) {
                window.location.replace('/bills');
            }).error(function(response) {
                this.$set('loading', false);
                if (response.errors) {
                    this.$set('errors', response.errors);
                    return;
                }
                if (response.message) {
                    this.$set('general_error', response.message);
                    return;
                }
                this.$set('general_error', Translation.common('general-error'));
            });
        },

        /**
         * Reset form errors.
         */
        resetErrors: function() {
            this.$set('errors', '');
            this.$set('general_error', '');
        }
    }

});