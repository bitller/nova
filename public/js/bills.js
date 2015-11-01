var Nova = {

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
     * Hide sweet alert loader
     */
    hideLoader: function() {
        swal.close();
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
     * Show general error alert
     */
    showGeneralErrorAlert: function() {
        this.showErrorAlert(this.getCommonTranslation('fail'), this.getCommonTranslation('general-error'));
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
     * Get common translation that match given attribute
     *
     * @param attribute
     * @returns {*|jQuery}
     */
    getCommonTranslation: function(attribute) {
        return this.getTranslation('#common-trans', attribute);
    },

    /**
     * Get client page translation that match given attribute
     *
     * @param attribute
     * @returns {*|jQuery}
     */
    getClientTranslation: function(attribute) {
        return this.getTranslation('#client-trans', attribute);
    },

    /**
     * Get product page translation that match given attribute
     *
     * @param attribute
     * @returns {*|jQuery}
     */
    getProductTranslation: function(attribute) {
        return this.getTranslation('#product-trans', attribute);
    },

    /**
     * Get my products page translation that match given attribute
     *
     * @param attribute
     * @returns {*|jQuery}
     */
    getMyProductTranslation: function(attribute) {
        return this.getTranslation('#my-products-trans', attribute);
    },

    /**
     * Get page translation
     *
     * @param pageSelector
     * @param attribute
     * @returns {*|jQuery}
     */
    getTranslation: function(pageSelector, attribute) {
        return $(pageSelector).attr(attribute);
    },

    /**
     * Return application token
     *
     * @returns {*|jQuery}
     */
    getToken: function() {
        return $('#token').attr('content');
    },

    /**
     * Return url used to get products data
     *
     * @param rows_on_page
     * @param current_page
     * @returns {string}
     */
    buildProductsRequestUrl: function(rows_on_page, current_page) {
        return this.buildPaginationRequestUrl('/products/get', rows_on_page, current_page);
    },

    /**
     *
     * Return url used to edit product name
     *
     * @param product_id
     * @param rows_on_page
     * @param current_page
     * @returns {string}
     */
    buildEditProductNameRequestUrl: function(product_id, rows_on_page, current_page) {
        return '/products/' + product_id + '/edit-name';
        //return this.buildPaginationRequestUrl('/products/' + product_id + '/edit-name', rows_on_page, current_page);
    },

    /**
     * Return url for pagination with given route
     *
     * @param route
     * @param rows_on_page
     * @param current_page
     * @returns {string}
     */
    buildPaginationRequestUrl: function(route, rows_on_page, current_page) {

        if (rows_on_page < 1) {
            current_page = current_page - 1;
        }

        return route + '?page=' + current_page;
    }
};
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
            this.$set('create_button', Translation.common('loading'));

            // Build post data
            var data = {
                _token: Token.get(),
                client: $('#client-name').val()
            };

            this.$http.post('/bills/create', data, function(response) {

                // Handle success response
                this.getBills('/bills/get', function() {
                    this.$set('loading', false);
                    this.$set('create_button', Translation.bills('create-button'));
                    $('#create-bill-modal').modal('hide');
                    Alert.success(response.title, response.message);
                });

            }).error(function(response) {
                this.$set('loading', false);
                this.$set('create_button', Translation.bills('create-button'));

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

    // Instantiate the Bloodhound suggestion engine
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

    var input = $('.twitter-typeahead');

    // Instantiate the Typeahead UI
    input.typeahead(null, {
        displayKey: 'name',
        source: clients.ttAdapter(),
        templates: {
            suggestion: function(client) {
                return '<p>' + client.name + '</p>'
            }
        }
    });
});
//# sourceMappingURL=bills.js.map