new Vue({
    el: '#paid-bills',

    ready: function() {
        this.getPaidBills('/paid-bills/get');
    },

    methods: {

        /**
         * Get user paid bills.
         */
        getPaidBills: function(url, hideLoader, successCallback) {

            if (typeof hideLoader === 'undefined') {
                Alert.loader();
            }

            this.$http.get(url, function(response) {

                this.$set('paid_bills', response);
                this.$set('loaded', true);
                //Alert.close();
                if (typeof successCallback !== 'undefined') {
                    successCallback();
                } else {
                    Alert.close();
                }

            }).error(function(resposne) {

                if (!response.message) {
                    Alert.generalError();
                    return;
                }
                Alert.error(resposne.title, response.message);

            });
        },

        /**
         * Delete paid bill.
         *
         * @param bill_id
         * @param current_page
         * @param rows_on_page
         */
        deleteBill: function(bill_id, current_page, rows_on_page) {

            var thisInstance = this;

            Alert.confirmDeleteBill(function() {

                thisInstance.$http.get('/bills/' + bill_id + '/delete', function(response) {

                    this.getPaidBills(UrlBuilder.getPaidBill(rows_on_page, current_page), true, function() {
                        Alert.success(response.title, response.message);
                    });
                        //console.log('h');
                        //Alert.success(response.title, response.message);
                    //);

                }).error(function(response) {

                    if (!response.message) {
                        Alert.generalError();
                        return;
                    }
                    Alert.error(response.title, response.message);

                });

            });
        },

        /**
         * Paginate user paid bills.
         *
         * @param url
         */
        paginate: function(url) {
            if (url) {
                this.getPaidBills(url);
            }
        }
    }
});
//# sourceMappingURL=paid-bills.js.map
