new Vue({

    /**
     * Target element.
     */
    el: '#application-settings',

    data: {
        loaded: true,
    },

    ready: function() {
        this.getSettings();
    },

    methods: {
        getSettings: function() {

            Alert.loader();
            this.$set('loaded', false);

            this.$http.get('/admin-center/application-settings/get', function(response) {

                this.$set('loaded', true);
                this.$set('displayed_bills', response.displayed_bills);
                this.$set('displayed_clients', response.displayed_clients);
                this.$set('displayed_products', response.displayed_products);
                this.$set('displayed_custom_products', response.displayed_custom_products);
                this.$set('recover_code_valid_minutes', response.recover_code_valid_minutes);
                this.$set('login_attempts', response.login_attempts);
                this.$set('allow_new_accounts', response.allow_new_accounts);

            }).error(function(response) {
                //
            });
        }
    }

});
//# sourceMappingURL=application-settings.js.map