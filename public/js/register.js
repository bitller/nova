new Vue({

    /**
     * Target element.
     */
    el: '#register',

    methods: {
        register: function() {

            var postData = {
                _token: Token.get(),
                email: this.$get('email'),
                password: this.$get('password'),
                password_confirmation: this.$get('password_confirmation')
            };

            this.$set('loading', true);

            this.$http.post('/register', postData, function(response) {
                window.location.href = '/next';
            }).error(function(response) {

                this.$set('loading', false);

                if (!response.message) {
                    this.$set('error', Translation.common('general-error'));
                    return;
                }

                this.$set('errors', response.errors);
            });
        }
    }
})
//# sourceMappingURL=register.js.map
