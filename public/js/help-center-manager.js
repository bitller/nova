new Vue({

    /**
     * Target element.
     */
    el: '#help-center-manager',

    /**
     * Called on ready event.
     */
    ready: function() {
        this.getCategories();
    },

    methods: {

        /**
         * Get categories from server.
         */
        getCategories: function() {

            Alert.loader();

            this.$http.get('/admin-center/help-center-manager/get', function(response) {
                this.$set('categories', response.categories);
                if (response.categories.length > 0) {
                    this.$set('show_categories', true);
                }
                this.$set('loaded', true);
                Alert.close();
            }).error(function(response) {
                this.$set('loaded', true);
                if (!response.message) {
                    Alert.generalError();
                    return;
                }
                Alert.error(response.title, response.message);
            });
        },

        /**
         * Add new category.
         */
        addCategory: function() {

            var alertData = {
                title: 'test',
                placeholder: 'test',
                text: 'test',
                inputValue: 'test'
            };

            var thisInstance = this;

            Alert.edit(alertData, function(input) {

                var data = {
                    _token: Token.get(),
                    category_name: input
                };

                thisInstance.$http.post('/admin-center/help-center-manager/add-category', data, function(response) {

                    // Handle success response
                    this.$set('categories', response.categories);
                    this.$set('show_categories', true);
                    Alert.success(response.title, response.message);

                }).error(function(response) {

                    // Handle response error
                    if (!response.message) {
                        Alert.generalError();
                        return;
                    }
                    Alert.error(response.title, response.message);
                });
            });
        },

        /**
         * Edit category.
         *
         * @param category_id
         */
        editCategory: function(category_id) {

            var alertData = {
                title: 'test',
                placeholder: 'test',
                text: 'test',
                inputValue: 'test'
            };

            var thisInstance = this;

            Alert.edit(alertData, function(input) {

                var data = {
                    _token: Token.get(),
                    category_id: category_id,
                    new_name: input
                };

                thisInstance.$http.post('/admin-center/help-center-manager/edit-category', data, function(response) {

                    // Handle success response
                    this.$set('categories', response.categories);
                    this.$set('show_categories', true);
                    Alert.success(response.title, response.message);

                }).error(function(response) {

                    // Handle error response
                    if (!response.message) {
                        Alert.generalError();
                        return;
                    }
                    Alert.error(response.title, response.message);
                });
            });
        },

        /**
         * Delete category.
         */
        deleteCategory: function(category_id) {

            var thisInstance = this;

            Alert.confirmDelete(function() {

                // Post data
                var data = {
                    _token: Token.get(),
                    category_id: category_id
                };

                thisInstance.$http.post('/admin-center/help-center-manager/delete-category', data, function(response) {

                    // Handle success response
                    this.$set('categories', response.categories);
                    this.$set('show_categories', true);
                    Alert.success(response.title, response.message);

                }).error(function(response) {

                    // Handle error response
                    if (!response.message) {
                        Alert.generalError();
                        return;
                    }
                    Alert.error(response.title, response.message);
                });
            }, Translation.helpCenterManager('delete-category'));
        }
    }

});
//# sourceMappingURL=help-center-manager.js.map