new Vue({

    /**
     * Register page is the target.
     */
    el: '#register',

    methods: {
        register: function() {

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
                swal(response.message);

            }).error(function(response) {
                this.$set('loading', false);
                this.$set('errors', response.errors);
            });

            // Make request

            // Parse errors to highlight each input

        }
    }
});
//# sourceMappingURL=register.js.map