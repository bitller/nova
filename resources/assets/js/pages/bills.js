new Vue({
    el: '#bills',

    data: {
        rows: 0
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
        deleteBill: function(bill_id, current_page, rows_on_page, loading) {

            var thisInstance = this;

            Alert.confirmDeleteBill(function() {

                Alert.loader();

                // Build request url and make request
                var url = '/bills/'+bill_id+'/delete';
                thisInstance.$http.get(url).success(function(response) {

                    // Build url for bills request
                    var billUrl = this.buildBillUrl(rows_on_page, current_page);

                    thisInstance.$http.get(billUrl).success(function(data) {
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

        createBill: function(title, placeholder, empty_input_error, message, loading, success) {

            var before = this;

            // Show prompt
            swal({
                    title: title,
                    type: "input",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    animation: "slide-from-top",
                    inputPlaceholder: placeholder
                },
                function(inputValue) {
                    if (inputValue === false) return false;

                    if (inputValue === "") {
                        swal.showInputError(empty_input_error);
                        return false
                    }

                    swal({
                        title: loading,
                        type: "info",
                        showConfirmButton: false
                    });

                    before.$http.post('/bills/create', {client:inputValue, _token:$('#token').attr('content')}).success(function() {
                        this.paginate('/bills/get');
                        swal({
                            title: success,
                            text: message,
                            type: "success",
                            timer: 1750,
                            showConfirmButton: false
                        });
                    });
            });

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
         */
        getBills: function(url) {

            this.$set('loaded', false);

            swal({
                title: Nova.getCommonTranslation('loading'),
                type: "info",
                showConfirmButton: false
            });

            this.$http.get(url).success(function(data) {
                this.$set('bills', data);
                this.$set('loaded', true);
                swal.close();
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