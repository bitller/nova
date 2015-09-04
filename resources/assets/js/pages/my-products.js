new Vue({

    el: '#my-products',

    ready: function() {
        this.getMyProducts('/my-products/get');
    },

    methods: {

        /**
         * Get my products data
         *
         * @param url
         */
        getMyProducts: function(url) {

            Nova.showLoader(Nova.getCommonTranslation('loading'));

            this.$http.get(url, function(response) {
                this.$set('myProducts', response);
                this.$set('loaded', true);
                Nova.hideLoader();
            });

        },

        /**
         * Get my products data if an url was given
         *
         * @param url
         */
        paginate: function(url) {
            if (url) {
                this.getMyProducts(url);
            }
        },

        editCode: function() {
            //
        },

        editName: function() {
            //
        },

        deleteMyProduct: function() {
            //
        }

    }

});