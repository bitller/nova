new Vue({
    el: '#settings',

    data: {
        save_button: Translation.common('save')
    },

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
                this.$set('language_name', response.data.language);
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
                    _token: Token.get(),
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

            this.$set('loading', true);

            var data = {
                _token: Token.get(),
                password: this.$get('password'),
                new_password: this.$get('new_password'),
                new_password_confirmation: this.$get('confirm_password')
            };

            this.$http.post('/settings/edit-password', data, function(response) {

                $('#edit-password-modal').modal('hide');
                this.$set('loading', false);
                Alert.success(response.title, response.message);

            }).error(function(response) {

                this.$set('loading', false);

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
            this.$set('error', '');
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
                    _token: Token.get(),
                    bills_to_display: input
                };

                // Do request
                thisInstance.$http.post('/settings/edit-number-of-displayed-bills', data, function(response) {

                    Alert.success(response.title, response.message);
                    this.$set('displayed_bills', response.displayed_bills);

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
                    _token: Token.get(),
                    clients_to_display: input
                };

                // Post request
                thisInstance.$http.post('/settings/edit-number-of-displayed-clients', data, function(response) {

                    Alert.success(response.title, response.message);
                    this.$set('displayed_clients', response.displayed_clients);

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
                    _token: Token.get(),
                    products_to_display: input
                };

                // Do request
                thisInstance.$http.post('/settings/edit-number-of-displayed-products', data, function(response) {

                    Alert.success(response.title, response.message);
                    this.$set('displayed_products', response.displayed_products);

                }).error(function(response) {
                    if (!response.message) {
                        Alert.generalError();
                        return;
                    }
                    Alert.error(response.title, response.message);
                })

            });
        },

        /**
         * Edit number of custom products displayed.
         */
        editNumberOfDisplayedCustomProducts: function() {

            // Alert data
            var alertData = {
                title: Translation.settings('displayed-custom-products'),
                text: Translation.settings('displayed-custom-products-description'),
                requiredInput: Translation.settings('number-of-displayed-custom-products-required'),
                inputValue: this.$get('displayed_custom_products')
            };

            var thisInstance = this;

            Alert.edit(alertData, function(input) {

                // Post data
                var data = {
                    _token: Token.get(),
                    custom_products_to_display: input
                };

                // Do request
                thisInstance.$http.post('/settings/edit-number-of-displayed-custom-products', data, function(response) {

                    Alert.success(response.title, response.message);
                    this.$set('displayed_custom_products', response.displayed_custom_products);

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
         * Make request to get available languages.
         */
        loadLanguages: function() {

            if (this.$get('languages')) {
                return;
            }

            this.$http.get('settings/get-languages', function(response) {
                this.$set('languages', response.languages);
                this.$set('languages_loaded', true);
            }).error(function(response) {
                if (!response.message) {
                    this.$set('error', Translation.common('general-error'));
                    return;
                }
                this.$set('error', response.message);
            });

        },

        /**
         * Edit application language.
         */
        editLanguage: function() {

            this.$set('save_button', Translation.common('loading'));
            this.$set('loading', true);

            var data = {
                _token: Token.get(),
                language: this.$get('language')
            };

            this.$http.post('/settings/change-language', data, function(response) {

                $('#edit-language-modal').modal('hide');
                window.location.replace('/settings');

            }).error(function(response) {

                this.$set('save_button', Translation.common('save'));
                this.$set('loading', false);

                if (!response.message) {
                    this.$set('error', Translation.common('general-error'));
                    return;
                }
                this.$set('error', response.message);
            });
        },

        /**
         * Reset user settings to default values.
         */
        resetToDefaultValues: function() {

            var thisInstance = this;

            // Show confirmation
            Alert.confirmResetToDefault(function() {

                thisInstance.$http.get('/settings/reset-to-default-values', function(response) {

                    Alert.success(response.title, response.message);
                    this.$set('displayed_bills', response.displayed_bills);
                    this.$set('displayed_clients', response.displayed_clients);
                    this.$set('displayed_products', response.displayed_products);
                    this.$set('displayed_custom_products', response.displayed_custom_products);

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