new Vue({

    /**
     * Target element.
     */
    el: '#help-center-manager-category-page',

    ready: function() {
        this.getCategory();
    },

    methods: {

        /**
         * Get category data.
         */
        getCategory: function() {

            Alert.loader();

            this.$http.get('/admin-center/help-center-manager/category/' + $('#help-center-manager-category-page').attr('category-id') + '/get', function(response) {

                // Handle success response
                this.$set('loaded', true);
                this.$set('category', response.category);
                this.$set('articles', response.articles);

                Alert.close();

            }).error(function(response) {

                // Handle error response
                this.$set('loaded', true);
                if (!response.message) {
                    Alert.generalError();
                    return;
                }
                Alert.error(response.title, response.message);
            });
        },

        /**
         * Add new article.
         */
        addArticle: function() {

            this.$set('loading', true);

            // Url used for request
            var url = '/admin-center/help-center-manager/category/' + $('#help-center-manager-category-page').attr('category-id') + '/add-article';
            var data = {
                _token: Token.get(),
                article_title: this.$get('article_title'),
                article_content: this.$get('article_content')
            };

            this.$http.post(url, data, function(response) {

                // Success response
                this.$set('loading', false);
                this.$set('articles', response.articles);
                $('#add-article-modal').modal('hide');
                Alert.success(response.title, response.message);

            }).error(function(response) {
                // Handle error response
                this.$set('loading', false);

                if (typeof response.errors !== 'undefined') {
                    this.$set('errors', response.errors);
                    return;
                }
                if (response.message) {
                    this.$set('error', response.message);
                    return;
                }
                this.$set('error', 'bbaasad');
            });
        },

        /**
         * Reset add article modal.
         */
        resetAddArticleModal: function() {
            this.$set('article_title', '');
            this.$set('article_content', '');
            this.$set('error', '');
            this.$set('errors', '');
        },

        deleteArticle: function(articleId) {

            var thisInstance = this;

            Alert.confirmDelete(function() {

                var url = '/admin-center/help-center-manager/category/' + $('#help-center-manager-category-page').attr('category-id') + '/delete-article';
                var data = {
                    _token: Token.get(),
                    article_id: articleId
                };

                thisInstance.$http.post(url, data, function(response) {
                    this.$set('articles', response.articles);
                    Alert.success(response.title, response.message);
                }).error(function(response) {

                    // Error response
                    if (!response.message) {
                        Alert.generalError();
                        return;
                    }
                    Alert.error(response.title, response.message);
                });

            }, Translation.helpCenterManager('delete-article'));

        }
    }
});
//# sourceMappingURL=help-center-manager-category-page.js.map