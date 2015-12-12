new Vue({

    /**
     * Target element.
     */
    el: '#user',

    ready: function() {
        this.getUserBills();
    },

    methods: {
        /**
         * Get user bills.
         */
        getUserBills: function() {
            this.$set('loading_user_bills', true);
            this.$http.get('/admin-center/users-manager/user/' + $('#user').attr('user-id') + '/get', function(response) {
                this.$set('loading_user_bills', false);
                this.$set('bills', response);
            }).error(function(response) {
                if (response.message) {
                    Alert.error(response.message);
                    return;
                }
                Alert.generalError();
            });
        },

        /**
         * Get paid bills of given user.
         */
        getUserPaidBills: function() {

            // Check if paid bills are already loaded to avoid non sense requests
            if (this.$get('paid_bills')) {
                return;
            }

            this.$set('loading_user_paid_bills', true);
            this.$http.get('/admin-center/users-manager/user/' + $('#user').attr('user-id') + '/get-paid-bills', function(response) {
                this.$set('loading_user_paid_bills', false);
                this.$set('paid_bills', response);
            }).error(function(response) {
                //
            });
        },

        /**
         * Delete user bill.
         *
         * @param billId
         */
        deleteUserBill: function(billId) {
            var thisInstance = this;
            Alert.confirmDelete(function() {

                var postData = {
                    _token: Token.get(),
                    bill_id: billId
                };

                thisInstance.$http.post('/admin-center/users-manager/user/' + $('#user').attr('user-id') + '/delete-bill', postData, function(response) {
                    this.getUserBills();
                    Alert.success(response.title, response.message);
                }).error(function(response) {
                    if (response.message) {
                        Alert.error(response.message);
                        return;
                    }
                    Alert.generalError();
                });

            }, 'bla bla');
        },

        /**
         * Delete all user bills.
         */
        deleteAllUserBills: function() {
            var thisInstance = this;
            Alert.confirmDelete(function() {
                var data = {
                    _token: Token.get()
                };
                thisInstance.$http.post('/admin-center/users-manager/user/' + $('#user').attr('user-id') + '/delete-all-bills', data, function(response) {
                    this.getUserBills();
                    Alert.success(response.title, response.message);
                }).error(function(response) {
                    if (response.message) {
                        Alert.error(response.message);
                        return;
                    }
                    Alert.generalError();
                });
            })
        },

        /**
         * Make all user bills paid.
         */
        makeAllUserBillsPaid: function() {
            var thisInstance = this;
            Alert.confirmDelete(function() {

                var data = {
                    _token: Token.get()
                };
                // Post request
                thisInstance.$http.post('/admin-center/users-manager/user/' + $('#user').attr('user-id') + '/make-all-bills-paid', data, function(response) {
                    this.getUserBills();
                    this.$set('paid_bills', '');
                    //Alert.close();
                    Alert.success(response.title, response.message);
                }).error(function(response) {
                    if (response.message) {
                        Alert.error(response.message);
                        return;
                    }
                    Alert.generalError();
                });
            });
        }
    }
});
//# sourceMappingURL=user.js.map