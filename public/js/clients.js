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

            var thisInstance = this;
            var clientsSelector = $('#clients');

            // Show prompt
            swal({
                    title: clientsSelector.attr('add-client'),
                    text: clientsSelector.attr('insert-client-name'),
                    type: "input",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    animation: "slide-from-top",
                    cancelButtonText: clientsSelector.attr('cancel'),
                    confirmButtonText: clientsSelector.attr('continue'),
                    inputPlaceholder: clientsSelector.attr('client-name')
                },
                function(inputValue) {
                    if (inputValue === false) {
                        return false;
                    }

                    if (inputValue === "") {
                        swal.showInputError(clientsSelector.attr('client-name-required'));
                        return false
                    }

                    // Show phone number prompt
                    swal({
                        title: clientsSelector.attr('add-client'),
                        text: clientsSelector.attr('phone-is-optional'),
                        type: "input",
                        closeOnConfirm: false,
                        confirmButtonText: clientsSelector.attr('continue'),
                        inputPlaceholder: clientsSelector.attr('client-phone-number')
                    }, function(phoneInput) {

                        swal({
                            title: clientsSelector.attr('loading'),
                            type: "info",
                            showConfirmButton: false
                        });

                        var dataToPost = {
                            name: inputValue,
                            phone: phoneInput,
                            _token: $('#token').attr('content')
                        };

                        // Make create client request
                        thisInstance.$http.post('/clients/create', dataToPost).success(function(response) {

                            // Make request to get clients
                            thisInstance.$http.get('/clients/get', function(data) {

                                thisInstance.$set('loaded', true);
                                thisInstance.$set('clients', data);

                                if (response.success) {
                                    swal({
                                        title: response.title,
                                        text: response.message,
                                        type: "success",
                                        timer: 1750,
                                        showConfirmButton: false
                                    });
                                    return true;
                                }

                                swal({
                                    title: response.title,
                                    text: response.message,
                                    type: "error",
                                    confirmationButtonText: clientsSelector.attr('ok-button')
                                });

                            });
                        }).error(function(response) {
                            // Make request to get clients
                            thisInstance.$http.get('/clients/get', function(data) {

                                thisInstance.$set('loaded', true);
                                thisInstance.$set('clients', data);

                                if (response.success) {
                                    swal({
                                        title: response.title,
                                        text: response.message,
                                        type: "success",
                                        timer: 1750,
                                        showConfirmButton: false
                                    });
                                    return true;
                                }

                                swal({
                                    title: response.title,
                                    text: response.message,
                                    type: "error",
                                    confirmationButtonText: clientsSelector.attr('ok-button')
                                });

                            });
                        });
                    });
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
         */
        getClients: function(url) {

            // Show loader
            swal({
                title: $('#clients').attr('loading'),
                type: "info",
                showConfirmButton: false
            });

            // Make request
            this.$http.get(url).success(function(data) {
                this.$set('loaded', true);
                this.$set('clients', data);
                swal.close();
            });
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