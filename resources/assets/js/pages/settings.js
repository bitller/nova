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
        },

        /**
         * Allow user to change their password.
         */
        editPassword: function() {

            var data = {
                password: this.$get('password'),
                new_password: this.$get('new_password'),
                new_password_confirmation: this.$get('confirm_password')
            };

            this.$http.post('/settings/edit-password', data, function(response) {

                $('#edit-password-modal').modal('hide');
                Alert.success(response.title, response.message);

            }).error(function(response) {

                if (!response.message) {
                    this.$set('error', Translation.common('general-error'));
                    return;
                }
                this.$set('error', response.message);

            });

        },

        /**
         * Reset edit password modal.
         */
        resetEditPasswordModal: function() {
            this.$set('password', '');
            this.$set('new_password', '');
            this.$set('confirm_password', '');
        },

        /**
         * Edit number of displayed bills on bills page.
         */
        editNumberOfDisplayedBills: function() {

            // Alert data
            var alertData = {
                title: Translation.settings('displayed-bills'),
                text: Translation.settings('displayed-bills-description'),
                requiredInput: Translation.settings('number-of-displayed-bills-required'),
                inputValue: this.$get('displayed_bills')
            };

            var thisInstance = this;

            Alert.edit(alertData, function(input) {

                // Post data
                var data = {
                    bills_to_display: input
                };

                // Do request
                thisInstance.$http.post('/settings/edit-number-of-displayed-bills', data, function(response) {

                    Alert.success(response.title, response.message);
                    this.$set('displayed_bills', input);

                }).error(function(response) {
                    if (!response.message) {
                        Alert.generalError();
                        return;
                    }
                    Alert.error(response.title, response.message);
                });

            });
        },

        /**
         * Edit number of displayed clients on clients page.
         */
        editNumberOfDisplayedClients: function() {

            // Alert data
            var alertData = {
                title: Translation.settings('displayed-clients'),
                text: Translation.settings('displayed-clients-description'),
                requiredInput: Translation.settings('number-of-displayed-clients-required'),
                inputValue: this.$get('displayed_clients')
            };

            var thisInstance = this;

            Alert.edit(alertData, function(input) {

                // Post data
                var data = {
                    clients_to_display: input
                };

                // Post request
                thisInstance.$http.post('/settings/edit-number-of-displayed-clients', data, function(response) {

                    Alert.success(response.title, response.message);
                    this.$set('displayed_clients', input);

                }).error(function(response) {
                    if (!response.message) {
                        Alert.generalError();
                        return;
                    }
                    Alert.error(response.title, response.message);
                });

            });
        },

        /**
         * Edit number of displayed products on products page.
         */
        editNumberOfDisplayedProducts: function() {

            // Alert data
            var alertData = {
                title: Translation.settings('displayed-products'),
                text: Translation.settings('displayed-products-description'),
                requiredInput: Translation.settings('number-of-displayed-products-required'),
                inputValue: this.$get('displayed_products')
            };

            var thisInstance = this;

            Alert.edit(alertData, function(input) {

                // Post data
                var data = {
                    products_to_display: input
                };

                // Do request
                thisInstance.$http.post('/settings/edit-number-of-displayed-products', data, function(response) {

                    Alert.success(response.title, response.message);
                    this.$set('displayed_products', input);

                }).error(function(response) {
                    if (!response.message) {
                        Alert.generalError();
                        return;
                    }
                    Alert.error(response.title, response.message);
                })

            });

        }

    }

});