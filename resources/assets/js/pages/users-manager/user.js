new Vue({

    /**
     * Target element.
     */
    el: '#user',

    ready: function() {
        this.loadUser();
        this.getUserBills();
    },

    methods: {

        loadUser: function() {
            this.$http.get('/admin-center/users-manager/user/' + $('#user').attr('user-id') + '/get-user-data', function(response) {
                this.$set('user_email', response.user.email);
                this.$set('email', response.user.email);
                this.$set('active', response.user.active);
            }).error(function(response) {
                //
            });
        },

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
         * Make user bill paid.
         *
         * @param billId
         */
        makeUserBillPaid: function(billId) {

            var thisInstance = this;

            // Ask for confirmation
            Alert.confirmDelete(function() {

                // Post data
                var data = {
                    _token: Token.get(),
                    bill_id: billId
                };

                // Do request
                thisInstance.$http.post('/admin-center/users-manager/user/' + $('#user').attr('user-id') + '/make-bill-paid', data, function(response) {
                    // Handle success response
                    this.getUserBills();
                    this.$set('paid_bills', '');
                    Alert.success(response.title, response.message);
                }).error(function(response) {
                    // Handle error response
                    if (response.message) {
                        Alert.error(response.message);
                        return;
                    }
                    Alert.generalError();
                });
            });
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
        },

        /**
         * Disable user account.
         */
        disableUserAccount: function() {
            this.changeAccountStatus();
        },

        /**
         * Enable user account.
         */
        enableUserAccount: function() {
            this.changeAccountStatus(true);
        },

        /**
         * Enable or disable user account.
         *
         * @param enable
         */
        changeAccountStatus: function(enable) {

            // Base request url
            var url = '/admin-center/users-manager/user/' + $('#user').attr('user-id') + '/';
            var thisInstance = this;
            var message = 'Enable account';

            if (typeof enable === 'undefined') {
                url = url + 'disable-account';
                message = 'Disable account';
            } else {
                url = url + 'enable-account';
            }

            Alert.confirmDelete(function() {
                var data = {
                    _token: Token.get()
                };

                // Do post request
                thisInstance.$http.post(url, data, function(response) {

                    // Handle success response
                    Alert.success(response.title, response.message);
                    this.$set('active', response.active);

                }).error(function(response) {

                    // Handle error response
                    if (response.message) {
                        Alert.error(response.message);
                        return;
                    }
                    Alert.generalError();
                });
            }, message);
        },

        /**
         * Allow admin to delete user account.
         */
        deleteUserAccount: function() {

            var thisInstance = this;

            Alert.confirmDelete(function() {

                var data = {
                    _token: Token.get()
                };

                thisInstance.$http.post('/admin-center/users-manager/user/' + $('#user').attr('user-id') + '/delete-account', data, function(response) {

                    // Success response
                    window.location.replace('/admin-center/users-manager');

                }).error(function(response) {

                    // Handle error response
                    if (response.message) {
                        Alert.error(response.message);
                        return;
                    }
                    Alert.generalError();
                });

            }, 'message goes here');
        },

        /**
         * Edit user email.
         */
        editUserEmail: function() {

            this.$set('error', '');
            this.$set('loading', true);

            var data = {
                _token: Token.get(),
                email: this.$get('email')
            };

            this.$http.post('/admin-center/users-manager/user/' + $('#user').attr('user-id') + '/edit-email', data, function(response) {
                // Success response
                this.$set('loading', false);
                this.$set('user_email', response.email);
                this.$set('email', response.email);
                $('#edit-user-email-modal').modal('toggle');
                Alert.success(response.title, response.message);
            }).error(function(response) {
                // Error response
                this.$set('loading', false);
                if (response.message) {
                    this.$set('error', response.message);
                    return;
                }
                this.$set('error', Translation.common('general-error'));
            });
        },

        /**
         * Reset edit user email modal.
         */
        resetEditUserEmailModal: function() {
            this.$set('error', '');
            this.$set('email', this.$get('user_email'));
        }
    }
});