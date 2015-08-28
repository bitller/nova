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

            this.showLoader(this.getClientTranslation('loading'));

            var url = '/clients/' + this.getClientTranslation('client-id') + '/get';

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

            this.showLoader(this.getClientTranslation('title'));

            // Build url and data to post
            var url = '/clients/' + this.getClientTranslation('client-id') + '/edit-name';
            var data = {
                name: this.$get('name'),
                _token: this.getToken()
            };

            var thisInstance = this;

            // Make request
            this.$http.post(url, data).success(function(response) {

                this.showSuccessAlert(response.title, response.message);

            }).error(function(response) {

                this.showErrorAlert(response.title, response.message);

                // Typed name is not valid so display the old one
                thisInstance.$set('name', thisInstance.$get('oldName'));

            });

        },

        /**
         * Allow user to edit clients phone number
         */
        savePhone: function() {

            this.showLoader(this.getClientTranslation('loading'));

            // Build url and data object to post
            var url = '/clients/' + this.getClientTranslation('client-id') + '/edit-phone';
            var data = {
                phone: this.$get('phone'),
                _token: this.getToken()
            };

            var thisInstance = this;

            // Make request
            this.$http.post(url, data, function(response) {

                this.showSuccessAlert(response.title, response.message);

            }).error(function(response) {

                this.showErrorAlert(response.title, response.message);

                // Typed phone is not valid so display the old one
                thisInstance.$set('phone', thisInstance.$get('oldPhone'));

            });

        },

        /**
         * Show sweet alert loader
         *
         * @param title
         */
        showLoader: function(title) {
            swal({
                title: title,
                type: "info",
                showConfirmButton: false
            });
        },


        /**
         * Show success alert
         *
         * @param title
         * @param message
         */
        showSuccessAlert: function(title, message) {
            this.showAlert('success', title, message);
        },

        /**
         * Show error alert
         *
         * @param title
         * @param message
         */
        showErrorAlert: function(title, message) {
            this.showAlert('error', title, message);
        },

        /**
         * Show sweet alert box
         *
         * @param type
         * @param title
         * @param message
         */
        showAlert: function(type, title, message) {
            swal({
                title: title,
                text: message,
                type: type,
                timer: 1750,
                showConfirmButton: false
            });
        },

        /**
         * Get client page translation that match given attribute
         *
         * @param attribute
         * @returns {*|jQuery}
         */
        getClientTranslation: function(attribute) {
            return $('#client-trans').attr(attribute);
        },

        /**
         * Return application token
         *
         * @returns {*|jQuery}
         */
        getToken: function() {
            return $('#token').attr('content');
        }
    }
});