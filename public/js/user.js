new Vue({

    /**
     * Target element.
     */
    el: '#user',

    ready: function() {
        this.getUserBills();
    },

    methods: {
        getUserBills: function() {
            this.$set('loading_user_bills', true);
            this.$http.get('/admin-center/users-manager/user/' + $('#user').attr('user-id') + '/get', function(response) {
                this.$set('loading_user_bills', false);
                this.$set('bills', response);
            }).error(function(response) {
                //
            });
        },

        getUserPaidBills: function() {

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
        }
    }
});
//# sourceMappingURL=user.js.map