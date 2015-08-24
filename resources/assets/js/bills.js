new Vue({
    el: '#bills',

    data: {
        rows: 0
    },

    ready: function() {
        this.getBills('/ajax/get-bills');
    },

    methods: {

        deleteBill: function(bill_id, current_page, rows_on_page, loading) {

            // Show loader
            swal({
                title: loading,
                type: "info",
                showConfirmButton: false
            });

            // Build request url and make request
            var url = '/bills/delete/'+bill_id;
            this.$http.get(url).success(function(response) {

                // Build url for bills request
                var billUrl = this.buildBillUrl(rows_on_page, current_page);

                this.$http.get(billUrl).success(function(data) {
                    swal({
                        title: response.title,
                        text: response.message,
                        type: "success",
                        timer: 1750,
                        showConfirmButton: false
                    });

                    this.$set('bills', data);
                });

            }).error(function(response) {
                //
            });

        },

        paginate: function(page_url) {
            if (page_url) {
                this.getBills(page_url);
            }
        },

        getBills: function(url) {

            this.$set('loaded', false);

            this.$http.get(url, function(data) {
                //
            }).success(function(data) {
                this.$set('bills', data);
                this.$set('loaded', true);
            });
        },

        buildBillUrl: function(rows_on_page, current_page) {

            var billUrl;

            if (rows_on_page < 1) {
                billUrl = '/ajax/get-bills?page=' + (current_page - 1);
            } else {
                billUrl = '/ajax/get-bills?page=' + current_page;
            }

            return billUrl;
        }

    }
});