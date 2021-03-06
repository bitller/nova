new Vue({

    /**
     * Target element.
     */
    el: '#bills',

    data: {
        rows: 0,
        create_button: Translation.bills('create-button'),

        /**
         * Indicate if pagination section should be displayed.
         */
        show_pagination: true,

        /**
         * Indicate if there are search results.
         */
        search_results: false
    },

    /**
     * Called when everything ready.
     */
    ready: function() {
        this.getBills('/bills/get');
    },

    methods: {

        /**
         * Toggle search bar.
         */
        toggleSearchBar: function () {
            $('.search-bar').slideToggle();
        },

        /**
         * Search for bills.
         */
        search: function() {

            if (this.$get('search_input')) {
                this.$set('search_results', true);
            } else {
                this.$set('search_results', false);
            }
            this.getBills('/bills/get/search?term=' + this.$get('search_input'))
        },

        /**
         * Reset search results.
         */
        hideSearch: function() {
            this.$set('search_results', false);
            this.$set('search_input', '');
            $('.search-bar input').val('');
            this.getBills('/bills/get');
        },

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
                    this.$set('search_input', '');
                    $('.search-bar input').val('');
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