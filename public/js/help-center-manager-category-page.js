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

            // Url used for request and post data
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

        /**
         * Delete article.
         *
         * @param articleId
         */
        deleteArticle: function(articleId) {

            var thisInstance = this;

            Alert.confirmDelete(function() {

                // Request url and post data
                var url = '/admin-center/help-center-manager/category/' + $('#help-center-manager-category-page').attr('category-id') + '/delete-article';
                var data = {
                    _token: Token.get(),
                    article_id: articleId
                };

                thisInstance.$http.post(url, data, function(response) {

                    // Update articles and show success alert
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
        },

        /**
         * Edit article.
         */
        editArticle: function() {

            this.$set('loading', true);

            // Request url and post data
            var url = '/admin-center/help-center-manager/category/' + $('#help-center-manager-category-page').attr('category-id') + '/edit-article';
            var data = {
                _token: Token.get(),
                article_id: this.$get('clicked_article_id'),
                article_title: this.$get('article_title'),
                article_content: this.$get('article_content')
            };

            // Do request
            this.$http.post(url, data, function(response) {

                // Success
                this.$set('articles', response.articles);
                this.$set('loading', false);
                $('#edit-article-modal').modal('hide');
                Alert.success(response.title, response.message);

            }).error(function(response) {
                // Error response
                this.$set('loading', false);

                // Check if there are errors for multiple fields
                if (typeof response.errors !== 'undefined') {
                    this.$set('errors', response.errors);
                    return;
                }
                // Check if error alert should be displayed
                if (response.message) {
                    this.$set('error', response.message);
                    return;
                }
                // Else show general error
                this.$set('error', Translation.common('error'));
            });
        },

        /**
         * Set clicked article details.
         *
         * @param articleId
         * @param articleTitle
         * @param articleContent
         */
        setClickedArticle: function(articleId, articleTitle, articleContent) {
            this.$set('clicked_article_id', articleId);
            this.$set('article_title', articleTitle);
            this.$set('article_content', articleContent);
        }
    }
});
//# sourceMappingURL=help-center-manager-category-page.js.map
