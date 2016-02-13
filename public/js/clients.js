new Vue({

    el: '#clients',

    /**
     * Called when page is ready and paginate initial clients
     */
    ready: function() {
        this.getClients('/clients/get');
    },

    methods: {

        /**
         * Delete client.
         *
         * @param client_id
         * @param current_page
         * @param rows_on_page
         */
        deleteClient: function(client_id, current_page, rows_on_page) {

            var thisInstance = this;

            Alert.confirmDeleteClient(function() {
                thisInstance.$http.get('/clients/' + client_id + '/delete', function(response) {

                    // Handle success response
                    thisInstance.$http.get(this.buildGetClientsUrl(rows_on_page, current_page), function(response) {

                        this.$set('clients', response);
                        Alert.success(Translation.common('success'), Translation.clients('client-deleted'));

                    }).error(function(response) {

                        // Handle response error
                        if (!response.message) {
                            Alert.generalError();
                            return;
                        }

                        Alert.error(response.title, response.message);
                    })

                }).error(function(response) {

                    // Handle error response
                    if (!response.message) {
                        Alert.generalError();
                        return;
                    }

                    Alert.error(resoponse.title, response.message);
                });
            });
        },

        /**
         * Create a new client
         */
        createClient: function() {

            // Build post data
            var data = {
                _token: Token.get(),
                client_name: this.$get('client_name'),
                client_email: this.$get('client_email'),
                client_phone_number: this.$get('client_phone_number')
            };

            this.$set('loading', true);

            this.$http.post('/clients/create', data, function(response) {

                this.getClients('/clients/get', function() {
                    this.$set('loading', false);
                    $('#create-new-client-modal').modal('hide');
                    Alert.success(response.message);
                });

            }).error(function(response) {

                this.$set('loading', false);

                if (!response.message) {
                    Alert.generalError();
                    return;
                }

                this.$set('errors', response.errors);
            });
        },

        /**
         * This method is used by pagination links
         *
         * @param page_url
         */
        paginate: function(page_url) {
            if (page_url) {
                this.getClients(page_url);
            }
        },

        /**
         * Make getClients request
         *
         * @param url
         * @param callback
         */
        getClients: function(url, callback) {

            // Show loader
            if (typeof callback === 'undefined') {
                swal({
                    title: $('#clients').attr('loading'),
                    type: "info",
                    showConfirmButton: false
                });
            }

            // Make request
            this.$http.get(url).success(function(data) {
                this.$set('loaded', true);
                this.$set('clients', data);

                if (typeof callback === 'undefined') {
                    swal.close();
                } else {
                    callback();
                }
            });
        },

        /**
         * Reset create client modal data.
         */
        resetCreateClientModal: function() {
            this.$set('loading', false);
            Reset.vueData(this, ['errors', 'error', 'client_name', 'client_phone_number', 'client_email'])
        },

        /**
         * Return url used by getClients request
         *
         * @param rows_on_page
         * @param current_page
         * @returns {string}
         */
        buildGetClientsUrl: function(rows_on_page, current_page) {

            if (rows_on_page < 1) {
                current_page = current_page - 1;
            }

            return '/clients/get?page=' + current_page;
        }
    }
});

$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});
//# sourceMappingURL=clients.js.map
