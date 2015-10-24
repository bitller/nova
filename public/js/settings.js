new Vue({
    el: '#settings',

    ready: function() {
        this.getSettings();
    },

    methods: {

        /**
         * Get current user settings.
         */
        getSettings: function() {
            Alert.loader();
            this.$http.get('/settings/get', function(response) {
                this.$set('loaded', true);
                this.$set('email', response.data.email);
                this.$set('displayed_bills', response.data.displayed_bills);
                this.$set('displayed_clients', response.data.displayed_clients);
                this.$set('displayed_products', response.data.displayed_products);
                this.$set('displayed_custom_products', response.data.displayed_custom_products);
                Alert.close();
            }).error(function(response) {
                Alert.generalError();
            });
        },

        /**
         * Allow user to change their email.
         */
        editEmail: function() {

            // Data for alert
            var alertData = {
                title: Translation.settings('edit-email'),
                text: Translation.settings('edit-email-description'),
                requiredInput: Translation.settings('email-input-required'),
                inputValue: this.$get('email')
            };

            var thisInstance = this;

            // Show alert
            Alert.edit(alertData, function(input) {

                // Post data
                var data = {
                    email: input
                };

                // Make request and handle response
                thisInstance.$http.post('/settings/edit-email', data, function(response) {

                    this.$set('email', response.email);

                    // Update email from header with jquery
                    $('#user-email').html(this.$get('email'));

                    Alert.success(response.title, response.message);

                }).error(function(response) {
                    if (!response.message) {
                        Alert.generalError();
                        return;
                    }
                    Alert.error(response.title, response.message);
                });

            });
        }

    }

});
//# sourceMappingURL=settings.js.map