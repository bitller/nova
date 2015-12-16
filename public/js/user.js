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
         * Get clients of given user.
         */
        getUserClients: function() {

            // Check if clients are already loaded to avoid useless requests
            if (this.$get('clients')) {
                return;
            }

            this.$set('loading_user_clients', true);
            this.$http.get('/admin-center/users-manager/user/' + $('#user').attr('user-id') + '/get-clients', function(response) {

                // Success response
                this.$set('loading_user_clients', false);
                this.$set('clients', response);

            }).error(function(response) {

                // Handle error response
                if (response.message) {
                    Alert.error(response.message);
                    return;
                }
                Alert.generalError();
            });
        },

        /**
         * Get custom products of given user.
         */
        getUserCustomProducts: function() {

            // Check if custom products are already loaded to avoid useless requests
            if (this.$get('custom_products')) {
                return;
            }

            this.$set('loading_user_custom_products', true);
            this.$http.get('/admin-center/users-manager/user/' + $('#user').attr('user-id') + '/get-custom-products', function(response) {

                // Success response
                this.$set('loading_user_custom_products', false);
                this.$set('custom_products', response);

            }).error(function(response) {

                // Handle error response
                if (response.message) {
                    Alert.error(response.message);
                    return;
                }
                Alert.generalError();
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
                    this.$set('paid_bills', '');
                    this.getUserPaidBills();
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
            this.changeUserBillPaidStatus(billId);
        },

        /**
         * Allow admin to make user bill unpaid.
         *
         * @param billId
         */
        makeUserBillUnpaid: function(billId) {
            this.changeUserBillPaidStatus(billId, true);
        },

        /**
         * Allow admin to change user bill paid status.
         *
         * @param billId
         * @param makeUnpaid If present, bill will pe maked unpaid
         */
        changeUserBillPaidStatus: function(billId, makeUnpaid) {

            var thisInstance = this;
            var message = 'make paid';
            var url = '/admin-center/users-manager/user/' + $('#user').attr('user-id') + '/make-bill-';

            // Decide which url to use
            if (typeof makeUnpaid !== 'undefined') {
                message = 'make unpaid';
                url = url + 'unpaid';
            } else {
                url = url + 'paid'
            }

            // Ask for confirmation
            Alert.confirmDelete(function() {

                var data = {
                    _token: Token.get(),
                    bill_id: billId
                };

                thisInstance.$http.post(url, data, function(response) {

                    // Success handler when bill will be marked unpaid
                    if (typeof makeUnpaid !== 'undefined') {
                        this.getUserBills();
                        this.$set('paid_bills', '');
                        this.getUserPaidBills();
                        Alert.success(response.title, response.message);
                        return;
                    }

                    // Success handler when bill will be marked as paid
                    this.getUserBills();
                    this.$set('paid_bills', '');
                    Alert.success(response.title, response.message);

                }).error(function(response) {

                    // Error response handler, valid for both situations
                    if (typeof response.message !== 'undefined') {
                        Alert.error(response.message);
                        return;
                    }
                    Alert.generalError();
                });
            }, message);
        },

        /**
         * Delete user bills.
         *
         * @param onlyUnpaid If present, only unpaid bills will be deleted
         * @param onlyPaid If preset, only paid bills will be deleted
         */
        deleteAllUserBills: function(onlyUnpaid, onlyPaid) {

            var thisInstance = this;
            var url = '/admin-center/users-manager/user/' + $('#user').attr('user-id');
            var message = '';

            // Determine which ulr to use
            if (typeof onlyPaid === 'undefined' && typeof onlyUnpaid === 'undefined') {
                // Url used to delete all bills
                url = url + '/delete-all-bills';
                message = 'bla bla';
            } else if (typeof onlyPaid !== 'undefined') {
                // Url used to delete only paid bills
                url = url + '/delete-paid-bills';
                message = 'bla';
            } else {
                // Url used to delete only unpaid bills
                url = url + '/delete-unpaid-bills';
                message = 'sasda';
            }

            // Ask for confirmation
            Alert.confirmDelete(function() {

                var data = {
                    _token: Token.get()
                };
                // Post request
                thisInstance.$http.post(url, data, function(response) {
                    this.getUserBills();
                    this.$set('paid_bills', '');
                    this.getUserPaidBills();
                    Alert.success(response.title, response.message);
                }).error(function(response) {
                    if (response.message) {
                        Alert.error(response.message);
                        return;
                    }
                    Alert.generalError();
                });

            }, message);
        },

        /**
         * Allow admin to make user bills paid or unpaid.
         *
         * @param makeUnpaid If present, user bills are marked paid, else unpaid
         */
        changeUserBillsPaidStatus: function(makeUnpaid) {

            var thisInstance = this;
            var url = '/admin-center/users-manager/user/' + $('#user').attr('user-id') + '/make-all-bills-';
            var message;

            if (typeof makeUnpaid !== 'undefined') {
                // Url to make bills unpaid
                url = url + 'unpaid';
                message = 'make unpaid';
            } else {
                // Url to make bills paid
                url = url + 'paid';
                message = 'make paid';
            }

            Alert.confirmDelete(function() {

                // Post data
                var data = {
                    _token: Token.get()
                };

                // Make post request
                thisInstance.$http.post(url, data, function (response) {

                    // Handle success response
                    this.getUserBills();
                    this.$set('paid_bills', '');
                    this.getUserPaidBills();
                    Alert.success(response.title, response.message);

                }).error(function (response) {
                    // Handle response error
                    if (response.message) {
                        Alert.error(response.message);
                        return;
                    }
                    Alert.generalError();
                });
            }, message);
        },

        /**
         * Delete user custom product.
         *
         * @param custom_product_id If present, only product with given id will be deleted
         */
        deleteUserCustomProducts: function(custom_product_id) {

            var thisInstance = this;
            var url = '/admin-center/users-manager/user/' + $('#user').attr('user-id') + '/delete-custom-';
            var message = 'delete user custom product?';

            // Build post data
            var data = {
                _token: Token.get()
            };

            if (typeof custom_product_id === 'undefined') {
                // Prepare to delete all user custom products
                url = url + 'products';
                message = 'delete all user custom products?';
            } else {
                url = url + 'product';
                data.custom_product_id = custom_product_id;
            }

            // Ask for confirmation
            Alert.confirmDelete(function() {
                // Do post request
                thisInstance.$http.post(url, data, function(response) {

                    this.$set('custom_products', '');
                    this.getUserCustomProducts();
                    Alert.success(response.title, response.message);

                }).error(function(response) {
                    // Error response
                    if (response.message) {
                        Alert.error(response.message);
                        return;
                    }
                    Alert.generalError();
                });
            }, message);
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
        },

        /**
         * Allow admin to change user password.
         */
        changeUserPassword: function() {

            this.$set('error', '');
            this.$set('loading', true);

            var data = {
                _token: Token.get(),
                new_password: this.$get('new_password'),
                new_password_confirmation: this.$get('confirm_new_password')
            };

            this.$http.post('/admin-center/users-manager/user/' + $('#user').attr('user-id') + '/change-password', data, function(response) {

                // Success response
                this.$set('loading', false);
                $('#change-user-password-modal').modal('toggle');
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
         * Allow admin to delete user client.
         *
         * @param clientId
         */
        deleteUserClient: function(clientId) {

            var thisInstance = this;

            Alert.confirmDelete(function() {
                // Post data
                var data = {
                    _token: Token.get(),
                    client_id: clientId
                };

                thisInstance.$http.post('/admin-center/users-manager/user/' + $('#user').attr('user-id') + '/delete-client', data, function(response) {

                    // Success response
                    this.$set('clients', '');
                    this.getUserClients();
                    Alert.success(response.title, response.message);

                }).error(function(response) {
                    // Handle error response
                    if (response.message) {
                        Alert.error(response.message);
                        return;
                    }
                    Alert.generalError();
                });

            }, 'message');
        },

        /**
         * Delete all user clients.
         */
        deleteAllUserClients: function() {

            var thisInstance = this;

            Alert.confirmDelete(function() {

                var data = {
                    _token: Token.get()
                };

                thisInstance.$http.post('/admin-center/users-manager/user/' + $('#user').attr('user-id') + '/delete-clients', data, function(response) {

                    // Success response
                    this.$set('clients', '');
                    this.getUserClients();
                    Alert.success(response.title, response.message);

                }).error(function(response) {

                    // Error response
                    if (response.message) {
                        Alert.error(response.message);
                        return;
                    }
                    Alert.generalError();
                });

            }, 'delete all user clients');

        },

        /**
         * Reset change user password modal.
         */
        resetChangeUserPasswordModal: function() {
            this.$set('error', '');
            this.$set('new_password', '');
            this.$set('confirm_new_password', '');
        }
    }
});
//# sourceMappingURL=user.js.map