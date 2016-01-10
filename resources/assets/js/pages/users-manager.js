new Vue({

    /**
     * Target element.
     */
    el: '#users-manager',

    ready: function() {
        this.getData();
    },

    methods: {
        /**
         * Get users manager index page data.
         *
         * @param callback
         */
        getData: function(callback) {

            if (typeof callback === 'undefined') {
                Alert.loader();
            }

            this.$http.get('/admin-center/users-manager/get', function(response) {

                // Success response
                this.$set('loaded', true);
                this.$set('registered_users', response.registered_users);
                this.$set('confirmed_users', response.confirmed_users);
                this.$set('not_confirmed_users', response.not_confirmed_users);
                this.$set('confirmed_users_percentage', response.confirmed_users_percentage);
                this.$set('not_confirmed_users_percentage', response.not_confirmed_users_percentage);
                this.$set('users_registered_today_percentage', response.users_registered_today_percentage);

                // Check if callback should be executed
                if (typeof callback !== 'undefined') {
                    callback();
                } else {
                    Alert.close();
                }

            }).error(function(response) {
                // Error response
                if (!response.message) {
                    Alert.generalError();
                    return;
                }
                Alert.error(response.title, response.message);
            });

        },

        /**
         * Allow admin to create new user.
         */
        createNewUser: function() {

            this.$set('loading', true);
            Reset.vueData(this, ['error', 'errors']);

            // Build post data
            var data = {
                _token: Token.get(),
                new_user_email: this.$get('new_user_email'),
                new_user_password: this.$get('new_user_password'),
                new_user_password_confirmation: this.$get('new_user_password_confirmation'),
                make_special_user: this.$get('make_special_user'),
                user_password: this.$get('user_password')
            };

            this.$http.post('/admin-center/users-manager/create-new-user', data, function(response) {

                this.getData(function() {
                    this.$set('loading', false);
                    $('#create-new-user-modal').modal('hide');
                    Alert.success(response.title, response.message);
                });

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
         * Reset create new user modal data.
         */
        resetCreateNewUserModal: function() {
            Reset.vueData(this, [
                'new_user_email',
                'new_user_password',
                'new_user_password_confirmation',
                'make_special_user',
                'user_password',
                'error',
                'errors'
            ]);
        }
    }
});