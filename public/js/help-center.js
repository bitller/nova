new Vue({

    /**
     * Target element.
     */
    el: '#help-center',

    /**
     * Called on ready.
     */
    ready: function() {
        this.getData();
    },

    methods: {

        /**
         * Get page data.
         */
        getData: function() {
            Alert.loader();

            this.$http.get('/help-center/get', function(response) {

                this.$set('categories', response.categories);
                this.$set('loaded', true);
                Alert.close();

            }).error(function(response) {
                //
            });
        },

        /**
         * Load question categories.
         */
        loadQuestionCategories: function() {
            if (this.$get('question_categories')) {
                return;
            }

            this.$http.get('/help-center/get-question-categories', function(response) {
                this.$set('question_categories', response.question_categories);
                this.$set('question_categories_loaded', true);
            }).error(function(response) {
                if (response.message) {
                    this.$set('error', response.message);
                    return;
                }
                this.$set('error', Translation.common('error'));
            });
        },

        askQuestion: function() {

            this.$set('loading', true);
            var url = '/help-center/ask-question';
            var data = {
                _token: Token.get(),
                question_category_id: this.$get('question_category_id'),
                question_title: this.$get('question_title'),
                question_content: this.$get('question_content')
            };
            this.$http.post(url, data, function(response) {
                //
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
                this.$set('error', Translation.common('general-error'));
            });
        }
    }

});
//# sourceMappingURL=help-center.js.map