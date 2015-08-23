new Vue({
    el: '#bills',

    ready: function() {
        this.getBills('/ajax/get-bills');
    },

    methods: {

        deleteBill: function(bill_id, current_page, loading) {

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
                var billUrl = '/ajax/get-bills?page='+current_page;
                this.$http.get(billUrl).success(function(data) {

                    //swal.close();

                    swal({
                        title: response.title,
                        text: response.message,
                        type: "success",
                        timer: 1750,
                        showConfirmButton: false
                    });

                    this.$set('bills', data);

                    //this.$set('loaded', true);
                    //swal({
                    //    title: response.title,
                    //    text: response.message,
                    //    type: "success",
                    //    timer: 1750,
                    //    showConfirmButton: false
                    //});
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
        }

    }
});
//# sourceMappingURL=bills.js.map