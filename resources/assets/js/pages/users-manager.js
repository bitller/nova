new Vue({

    /**
     * Target element.
     */
    el: '#users-manager',

    ready: function() {
        this.getData();
    },

    methods: {
        getData: function() {

            Alert.loader();

            this.$http.get('/admin-center/users-manager/get', function(response) {

                // Success response
                this.$set('loaded', true);
                this.$set('registered_users', response.registered_users);
                this.$set('confirmed_users', response.confirmed_users);
                this.$set('not_confirmed_users', response.not_confirmed_users);
                this.$set('confirmed_users_percentage', response.confirmed_users_percentage);
                this.$set('not_confirmed_users_percentage', response.not_confirmed_users_percentage);
                this.$set('users_registered_today_percentage', response.users_registered_today_percentage);
                Alert.close();

            }).error(function(response) {
                // Error response
                if (!response.message) {
                    Alert.generalError();
                    return;
                }
                Alert.error(response.title, response.message);
            });

        }
    }
});