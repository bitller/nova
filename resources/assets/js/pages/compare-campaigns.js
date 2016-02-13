new Vue({

    /**
     * Target element.
     */
    el: '#compare-campaigns',

    /**
     * Called on ready.
     */
    ready: function() {
        this.getCharts();
    },

    methods: {

        /**
         * Get data used in charts.
         *
         * @param callback
         */
        getData: function(callback) {

            var thisInstance = this;

            this.$http.get(this._buildRequestUrl(), function(response) {
                thisInstance.$set('data', response.statistics);
                callback();
            }).error(function(response) {
                //
            });

        },

        /**
         * Get data and generate charts.
         */
        getCharts: function() {

            var thisInstance = this;

            this.getData(function() {
                thisInstance._buildSalesChart();
                thisInstance._buildClientsChart();
                thisInstance._buildBillsChart();
                thisInstance._buildDiscountChart();
                thisInstance._buildSoldProductsChart();
            });
        },

        /**
         * Build sales chart.
         *
         * @private
         */
        _buildSalesChart: function() {

            var data = this.$get('data');
            data = data.details_about_sales;

            // Set title and message
            this.$set('sales_title', data.title);
            this.$set('sales_message', data.message);

            // Set displayed icon
            if (data.sales > data.sales_in_campaign_to_compare) {
                this.$set('sales_plus', true);
            } else if (data.sales < data.sales_in_campaign_to_compare) {
                this.$set('sales_minus', true);
            } else {
                this.$set('sales_equal', true);
            }

            // Generate chart
            var salesChart = document.getElementById("sales-chart").getContext("2d");
            var salesData = [
                {
                    value: data.sales,
                    color: "#46BFBD",
                    highlight: "#5AD3D1",
                    label: data.sales_label
                },
                {
                    value: data.sales_in_campaign_to_compare,
                    color: "#FDB45C",
                    highlight: "#FFC870",
                    label: data.sales_in_campaign_to_compare_label
                }
            ];

            new Chart(salesChart).Pie(salesData);
        },

        /**
         * Build clients chart.
         *
         * @private
         */
        _buildClientsChart: function() {

            var data = this.$get('data');
            data = data.details_about_number_of_clients;

            // Set title and message
            this.$set('clients_title', data.title);
            this.$set('clients_message', data.message);

            // Set displayed icon
            if (data.number_of_clients > data.number_of_clients_in_campaign_to_compare) {
                this.$set('number_of_clients_plus', true);
            } else if (data.number_of_clients < data.number_of_clients_in_campaign_to_compare) {
                this.$set('number_of_clients_minus', true);
            } else {
                this.$set('number_of_clients_equal', true);
            }

            var clientsChart = document.getElementById("clients-chart").getContext("2d");
            var clientsData = [
                {
                    value: data.number_of_clients,
                    color: "#46BFBD",
                    highlight: "#5AD3D1",
                    label: data.number_of_clients_label
                },
                {
                    value: data.number_of_clients_in_campaign_to_compare,
                    color: "#FDB45C",
                    highlight: "#FFC870",
                    label: data.number_of_clients_in_campaign_to_compare_label
                }
            ];

            new Chart(clientsChart).Pie(clientsData);
        },

        /**
         * Generate bills chart.
         *
         * @private
         */
        _buildBillsChart: function() {

            var data = this.$get('data');
            data = data.details_about_number_of_bills;

            // Set title and message
            this.$set('bills_title', data.title);
            this.$set('bills_message', data.message);

            // Set displayed icon
            if (data.number_of_bills > data.number_of_bills_in_campaign_to_compare) {
                this.$set('number_of_bills_plus', true);
            } else if (data.number_of_bills < data.number_of_bills_in_campaign_to_compare) {
                this.$set('number_of_bills_minus', true);
            } else {
                this.$set('number_of_bills_equal', true);
            }

            var billsChart = document.getElementById("bills-chart").getContext("2d");
            var billsData = [
                {
                    value: data.number_of_bills,
                    color: "#46BFBD",
                    highlight: "#5AD3D1",
                    label: data.number_of_bills_label
                },
                {
                    value: data.number_of_bills_in_campaign_to_compare,
                    color: "#FDB45C",
                    highlight: "#FFC870",
                    label: data.number_of_bills_in_campaign_to_compare_label
                }
            ];

            new Chart(billsChart).Pie(billsData);
        },

        /**
         * Build discount chart.
         *
         * @private
         */
        _buildDiscountChart: function() {

            var data = this.$get('data');
            data = data.details_about_offered_discount;

            // Set title and message
            this.$set('discount_title', data.title);
            this.$set('discount_message', data.message);

            // Check what icon should be displayed
            if (data.discount_offered > data.discount_offered_in_campaign_to_compare) {
                this.$set('discount_plus', true);
            } else if (data.discount_offered < data.discount_offered_in_campaign_to_compare) {
                this.$set('discount_minus', true);
            } else {
                this.$set('discount_equal', true);
            }

            var discountChart = document.getElementById("discount-chart").getContext("2d");
            var discountData = [
                {
                    value: data.discount_offered,
                    color: "#46BFBD",
                    highlight: "#5AD3D1",
                    label: data.discount_offered_label
                },
                {
                    value: data.discount_offered_in_campaign_to_compare,
                    color: "#FDB45C",
                    highlight: "#FFC870",
                    label: data.discount_offered_in_campaign_to_compare_label
                }
            ];

            new Chart(discountChart).Pie(discountData);
        },

        /**
         * Build sold products chart.
         *
         * @private
         */
        _buildSoldProductsChart: function() {

            var data = this.$get('data');
            data = data.details_about_sold_products;

            this.$set('sold_products_title', data.title);
            this.$set('sold_products_message', data.message);

            // Check which icon should be displayed
            if (data.products_sold_in_campaign > data.products_in_campaign_to_compare) {
                this.$set('sold_products_plus', true);
            } else if (data.products_sold_in_campaign < data.products_in_campaign_to_compare) {
                this.$set('sold_products_minus', true);
            } else {
                this.$set('sold_products_equal', true);
            }

            var soldProductsChart = document.getElementById("sold-products-chart").getContext("2d");
            var soldProductsData = [
                {
                    value: data.products_sold_in_campaign,
                    color: "#46BFBD",
                    highlight: "#5AD3D1",
                    label: data.sold_products_label
                },
                {
                    value: data.products_in_campaign_to_compare,
                    color: "#FDB45C",
                    highlight: "#FFC870",
                    label: data.sold_products_in_campaign_to_compare_label
                }
            ];

            new Chart(soldProductsChart).Pie(soldProductsData);
        },

        /**
         * Return url used in request.
         *
         * @returns {string}
         * @private
         */
        _buildRequestUrl: function() {

            var selector = $('#compare-campaigns');

            return '/statistics/campaign/' + selector.attr('campaign-number') + '/' + selector.attr('campaign-year') + '/compare-with/' + selector.attr('other-campaign-number') + '/' + selector.attr('other-campaign-year') + '/get';
        }
    }
});