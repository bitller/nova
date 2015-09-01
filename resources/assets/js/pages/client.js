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

            Nova.showLoader(Nova.getClientTranslation('loading'));

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
            });
        },

        /**
         * Allow user to edit clients name
         */
        saveName: function() {

            Nova.showLoader(Nova.getClientTranslation('loading'));

            // Build url and data to post
            var url = '/clients/' + Nova.getClientTranslation('client-id') + '/edit-name';
            var data = {
                name: this.$get('name'),
                _token: Nova.getToken()
            };

            var thisInstance = this;

            // Make request
            this.$http.post(url, data).success(function(response) {

                Nova.showSuccessAlert(response.title, response.message);

            }).error(function(response) {

                Nova.showErrorAlert(response.title, response.message);

                // Typed name is not valid so display the old one
                thisInstance.$set('name', thisInstance.$get('oldName'));

            });

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