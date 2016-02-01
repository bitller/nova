new Vue({
    el: '#bills',

    data: {
        rows: 0,
        create_button: Translation.bills('create-button')
    },

    ready: function() {
        this.getBills('/bills/get');
    },

    methods: {

        /**
         * Make request to delete bill.
         *
         * @param bill_id
         * @param current_page
         * @param rows_on_page
         * @param loading
         */
        deleteBill: function(bill_id, current_page, rows_on_page) {

            var thisInstance = this;

            Alert.confirmDeleteBill(function() {

                Alert.loader();

                // Make request to delete bill
                thisInstance.$http.get(UrlBuilder.deleteBill(bill_id)).success(function(response) {

                    // Make request to get bills
                    thisInstance.$http.get(UrlBuilder.getBill(rows_on_page, current_page)).success(function(data) {
                        Alert.success(response.title, response.message);
                        this.$set('bills', data);
                    });

                }).error(function(response) {

                    if (response.message) {
                        Alert.error(response.title, response.message);
                        return;
                    }

                    Alert.generalError();

                });
            });
        },

        /**
         * Create new bill.
         */
        createBill: function() {

            this.$set('loading', true);

            // Build post data
            var data = {
                _token: Token.get(),
                client: $('#client-name').val(),
                use_current_campaign: this.$get('use_current_campaign')
            };

            if (!this.$get('use_current_campaign')) {
                data.campaign_year = this.$get('campaign_year');
                data.campaign_number = this.$get('campaign_number');
            }

            this.$http.post('/bills/create', data, function(response) {

                // Handle success response
                this.getBills('/bills/get', function() {
                    this.$set('loading', false);
                    $('#create-bill-modal').modal('hide');
                    Alert.success(response.title, response.message);
                });

            }).error(function(response) {
                this.$set('loading', false);

                // Handle error response
                if (!response.message) {
                    this.$set('error', Translation.common('general-error'));
                    return;
                }

                this.$set('error', response.message);
            });

        },

        /**
         * Reset create bill modal.
         */
        resetCreateBillModal: function() {
            this.$set('loading', false);
            this.$set('create_button', Translation.bills('create-button'));
            this.$set('error', false);
            $('#client-name').val('');
        },

        /**
         * This method is called by pagination links
         *
         * @param page_url
         */
        paginate: function(page_url) {
            if (page_url) {
                this.getBills(page_url);
            }
        },

        /**
         * Make ajax request to get bills
         *
         * @param url
         * @param callback
         */
        getBills: function(url, callback) {


            if (typeof callback === 'undefined') {
                this.$set('loaded', false);
                Alert.loader();
            }

            this.$http.get(url).success(function(data) {
                this.$set('bills', data);
                this.$set('loaded', true);

                if (typeof callback === 'undefined') {
                    swal.close();
                    return;
                }
                callback();
            });
        },

        /**
         * Return url to paginate bills
         *
         * @param rows_on_page
         * @param current_page
         * @returns {string}
         */
        buildBillUrl: function(rows_on_page, current_page) {

            if (rows_on_page < 1) {
                current_page = current_page - 1;
            }

            return '/bills/get?page=' + current_page;
        }

    }
});
$(document).ready(function() {

    // Search engine for client suggestions
    var clients = new Bloodhound({

        datumTokenizer: function (datum) {
            return Bloodhound.tokenizers.whitespace(datum.value);
        },

        queryTokenizer: Bloodhound.tokenizers.whitespace,

        remote: {
            ajax: {
                // Show loader when request is made
                beforeSend: function(xhr) {
                    $('.client-name i').show();
                },
                // Hide loader after request
                complete: function() {
                    $('.client-name i').hide();
                }
            },

            cache: false,

            url: '/suggest/clients?name=',

            replace: function() {
                var url = '/suggest/clients?name=';
                if ($('#client-name').val()) {
                    url += encodeURIComponent($('#client-name').val())
                }
                return url;
            },

            filter: function (clients) {
                // Map the remote source JSON array to a JavaScript object array
                return $.map(clients, function (client) {
                    return {
                        name: client.name
                    };
                });
            }
        }
    });

    // Initialize the Bloodhound suggestion engine
    clients.initialize();

    var clientInput = $('.twitter-typeahead');

    // Instantiate the Typeahead UI
    clientInput.typeahead(null, {
        displayKey: 'name',
        source: clients.ttAdapter(),
        templates: {
            suggestion: function(client) {
                return '<p>' + client.name + '</p>'
            }
        }
    });

    /*
     ------------------------
     Search engine for header
     ------------------------
     */
    var results = new Bloodhound({
        datumTokenizer: function (datum) {
            return Bloodhound.tokenizers.whitespace(datum.value);
        },
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            ajax: {
                beforeSend: function(xhr) {
                    $('.search-icon').hide();
                    $('.loading-icon').show();
                },
                complete: function() {
                    $('.search-icon').show();
                    $('.loading-icon').hide();
                }
            },
            cache: false,
            url: '/search/header?query=',
            replace: function() {
                var url = '/search/header?query=';
                if (document.getElementById('search-bar').value) {
                    url += encodeURIComponent(document.getElementById('search-bar').value);
                }
                return url;
            },
            filter: function (products) {
                // Map the remote source JSON array to a JavaScript object array
                return $.map(products, function (product) {
                    return {
                        value: product.code,
                        display: product.code + ' - ' + product.name
                    };
                });
            }
        }
    });

    results.initialize();

    var input = $('#search-bar');

    // Instantiate the Typeahead UI
    input.typeahead(null, {
        displayKey: 'value',
        source: results.ttAdapter(),
        templates: {
            suggestion: function(product) {
                return '<p>' + product.display + '</p>'
            }
        }
    });

    // Redirect to product details page
    input.on('typeahead:selected', function(event, product) {
        window.location.replace('/product-details/' + product.value);
    });

});
//# sourceMappingURL=bills.js.map