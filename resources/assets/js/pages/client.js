new Vue({

    el: "#client",

    /**
     * Called when page is loaded
     */
    ready: function() {
        this.getPageData();
    },

    methods: {

        /**
         * Make ajax request to load initial page data
         */
        getPageData: function() {

            Alert.loader();

            var url = '/clients/' + Nova.getClientTranslation('client-id') + '/get';

            // Make request to get page data
            this.$http.get(url, function(response) {

                // Update models
                this.$set('name', response.data.name);
                this.$set('phone', response.data.phone_number);
                this.$set('oldName', this.$get('name'));
                this.$set('oldPhone', this.$get('phone'));

                this.$set('client', response.data);

                // Hide loader
                this.$set('loaded', true);
                swal.close();
            }).error(function(response) {

                if (response.message) {
                    Alert.error(response.title, response.message);
                    window.location.replace(response.redirect_to);
                    return;
                }

                Alert.generalError();
            });
        },

        /**
         * Allow user to edit clients name
         */
        editClientName: function() {

            this.$set('loading', true);

            // Build post data
            var data = {
                _token: Token.get(),
                client_name: this.$get('client_name')
            };

            // Make post request
            this.$http.post('/clients/' + $('#client').attr('client-id') + '/edit-name', data, function(response) {

                // Update client name, stop loading, close modal and show success alert
                this.$set('name', data.client_name);
                $('#edit-client-name-modal').modal('hide');
                this.$set('loading', false);
                Alert.success(response.message);

            }).error(function(response) {

                // Handle error response
                this.$set('loading', false);

                // Set corresponded error
                if (!response.message) {
                    this.$set('error', Translation.common('general-error'));
                }

                this.$set('errors', response.errors);
            });
        },

        /**
         * Reset edit client name modal data.
         */
        resetEditClientNameModal: function() {
            this.$set('loading', false);
            Reset.vueData(this, ['errors', 'error', 'client_name']);
        },

        /**
         * Allow user to edit clients phone number
         */
        savePhone: function() {

            Nova.showLoader(Nova.getClientTranslation('loading'));

            // Build url and data object to post
            var url = '/clients/' + Nova.getClientTranslation('client-id') + '/edit-phone';
            var data = {
                phone: this.$get('phone'),
                _token: Nova.getToken()
            };

            var thisInstance = this;

            // Make request
            this.$http.post(url, data, function(response) {

                Nova.showSuccessAlert(response.title, response.message);

            }).error(function(response) {

                Nova.showErrorAlert(response.title, response.message);

                // Typed phone is not valid so display the old one
                thisInstance.$set('phone', thisInstance.$get('oldPhone'));

            });

        }
    }
});