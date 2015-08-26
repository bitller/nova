new Vue({

    el: '#clients',

    ready: function() {
        //
    },

    methods: {
        deleteClient: function(client_id, current_page, rows_on_page, loading) {
            //
        },
        createClient: function() {
            //
        },

        /**
         * Make getClients request
         *
         * @param rows_on_page
         * @param current_page
         */
        getClients: function(rows_on_page, current_page) {

            // Show loader
            swal({
                title: loading,
                type: "info",
                showConfirmButton: false
            });

            // Make request
            this.$http.get(this.buildGetClientsUrl(rows_on_page, current_page)).success(function(response) {
                this.$set('clients', response);
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

            var billUrl = '/clients/get?page=';

            if (rows_on_page < 1) {
                billUrl += current_page-1;
            } else {
                billUrl += current_page;
            }

            return billUrl;

        }
    }
});
//# sourceMappingURL=all.js.map