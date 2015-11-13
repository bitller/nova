new Vue({

    /**
     * Target element.
     */
    el: '#application-settings',

    data: {
        loaded: true
    },

    ready: function() {
        this.getSettings();
    },

    methods: {
        getSettings: function() {

            Alert.loader();
            this.$set('loaded', false);

            this.$http.get('/admin-center/application-settings/get', function(response) {

                Alert.close();

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
        },

        /**
         * Edit default number of bills displayed.
         */
        editNumberOfDisplayedBills: function() {

            var alertData = {
                title: Translation.applicationSettings('displayed-bills'),
                text: Translation.applicationSettings('edit-displayed-bills'),
                requiredInput: Translation.applicationSettings('displayed-bills-required'),
                inputValue: this.$get('displayed_bills')
            };

            var thisInstance = this;

            Alert.edit(alertData, function(input) {

                // Build post data
                var data = {
                    _token: Token.get(),
                    displayed_bills: input
                };

                // Do post request
                thisInstance.$http.post('/admin-center/application-settings/edit-displayed-bills', data, function(response) {

                    // Handle success response
                    this.$set('displayed_bills', response.displayed_bills);
                    Alert.success(response.title, response.message);

                }).error(function(response) {
                    // Handle response error
                    if (!response.message) {
                        Alert.generalError();
                        return;
                    }
                    Alert.error(response.title, response.message);
                });
            });
        },

        /**
         * Edit default number of clients displayed.
         */
        editNumberOfDisplayedClients: function() {

            var alertData = {
                title: Translation.applicationSettings('displayed-clients'),
                text: Translation.applicationSettings('edit-displayed-clients'),
                requiredInput: Translation.applicationSettings('displayed-clients-required'),
                inputValue: this.$get('displayed_clients')
            };

            var thisInstance = this;

            Alert.edit(alertData, function(input) {

                // Build post data
                var data = {
                    _token: Token.get(),
                    displayed_clients: input
                };

                // Post request
                thisInstance.$http.post('/admin-center/application-settings/edit-displayed-clients', data, function(response) {

                    // Handle success response
                    this.$set('displayed_clients', response.displayed_clients);
                    Alert.success(response.title, response.message);

                }).error(function(response) {
                    // Handle error response
                    if (!response.message) {
                        Alert.generalError();
                        return;
                    }
                    Alert.error(response.title, response.message);
                });
            });
        },

        /**
         * Edit number of products displayed.
         */
        editNumberOfDisplayedProducts: function() {

            var alertData = {
                title: Translation.applicationSettings('displayed-products'),
                text: Translation.applicationSettings('edit-displayed-products'),
                requiredInput: Translation.applicationSettings('displayed-products-required'),
                inputValue: this.$get('displayed_products')
            };

            var thisInstance = this;

            Alert.edit(alertData, function(input) {

                // Build post data
                var data = {
                    _token: Token.get(),
                    displayed_products: input
                };

                thisInstance.$http.post('/admin-center/application-settings/edit-displayed-products', data, function(response) {

                    // Success response
                    this.$set('displayed_products', response.displayed_products);
                    Alert.success(response.title, response.message);

                }).error(function(response) {
                    // Handle error response
                    if (!response.message) {
                        Alert.generalError();
                        return;
                    }
                    Alert.error(response.title, response.message);
                });
            })
        },

        /**
         * Edit number of custom products displayed.
         */
        editNumberOfDisplayedCustomProducts: function() {

            var alertData = {
                title: Translation.applicationSettings('displayed-custom-products'),
                text: Translation.applicationSettings('edit-displayed-custom-products'),
                requiredInput: Translation.applicationSettings('displayed-custom-products-required'),
                inputValue: this.$get('displayed_custom_products')
            };

            var thisInstance = this;

            Alert.edit(alertData, function(input) {

                // Post data
                var data = {
                    _token: Token.get(),
                    displayed_custom_products: input
                };

                thisInstance.$http.post('/admin-center/application-settings/edit-displayed-custom-products', data, function(response) {

                    // Success response
                    this.$set('displayed_custom_products', response.displayed_custom_products);
                    Alert.success(response.title, response.message);

                }).error(function(response) {
                    // Handle error response
                    if (!response.message) {
                        Alert.generalError();
                        return;
                    }
                    Alert.error(response.title, response.message);
                });
            });
        },

        /**
         * Set how many minutes recover code is valid.
         */
        editRecoverCodeValidTime: function() {

            var alertData = {
                title: Translation.applicationSettings('recover-code-valid-time'),
                text: Translation.applicationSettings('edit-recover-code-valid-time'),
                requiredInput: Translation.applicationSettings('recover-code-valid-time-required'),
                inputValue: this.$get('recover_code_valid_minutes')
            };

            var thisIntance = this;

            Alert.edit(alertData, function(input) {

                // Build post data
                var data = {
                    _token: Token.get(),
                    recover_code_valid_minutes: input
                };

                thisIntance.$http.post('/admin-center/application-settings/edit-recover-code-valid-time', data, function(response) {

                    // Success response
                    this.$set('recover_code_valid_minutes', response.recover_code_valid_minutes);
                    Alert.success(response.title, response.message);

                }).error(function(response) {
                    // Handle error response
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
//# sourceMappingURL=application-settings.js.map