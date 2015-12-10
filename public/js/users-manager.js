new Vue({

    /**
     * Target element.
     */
    el: '#users-manager',

    ready: function() {
        this.getData();
    },

    methods: {
        getData: function() {

            Alert.loader();

            this.$http.get('/admin-center/users-manager/get', function(response) {

                // Success response
                this.$set('loaded', true);
                this.$set('registered_users', response.registered_users);
                this.$set('confirmed_users', response.confirmed_users);
                this.$set('not_confirmed_users', response.not_confirmed_users);
                this.$set('confirmed_users_percentage', response.confirmed_users_percentage);
                this.$set('not_confirmed_users_percentage', response.not_confirmed_users_percentage);
                this.$set('users_registered_today_percentage', response.users_registered_today_percentage);
                Alert.close();

            }).error(function(response) {
                // Error response
                if (!response.message) {
                    Alert.generalError();
                    return;
                }
                Alert.error(response.title, response.message);
            });

        }
    }
});
$(document).ready(function() {

    /**
     * Users search engine.
     *
     * @type {Bloodhound}
     */
    var users = new Bloodhound({

        datumTokenizer: function (datum) {
            return Bloodhound.tokenizers.whitespace(datum.value);
        },

        queryTokenizer: Bloodhound.tokenizers.whitespace,

        remote: {
            ajax: {
                // Show loader when request is made
                beforeSend: function(xhr) {
                    $('.search-user-loading-icon').show();
                    $('.email-icon').hide();
                },
                // Hide loader after request
                complete: function() {
                    $('.search-user-loading-icon').hide();
                    $('.email-icon').show();
                }
            },

            cache: false,

            url: '/admin-center/users-manger/search?email=',

            replace: function() {
                var url = '/admin-center/users-manager/search?email=';
                if ($('#users-search').val()) {
                    url += encodeURIComponent($('#users-search').val())
                }
                return url;
            },

            filter: function (users) {
                // Map the remote source JSON array to a JavaScript object array
                return $.map(users, function (user) {
                    return {
                        email: user.email,
                        id: user.id
                    };
                });
            }
        }
    });

    // Initialize the Bloodhound suggestion engine
    users.initialize();

    var usersInput = $('#users-search');

    // Instantiate the Typeahead UI
    usersInput.typeahead(null, {
        displayKey: 'email',
        source: users.ttAdapter(),
        templates: {
            suggestion: function(user) {
                return '<p>' + user.email + '</p>'
            }
        }
    });

    usersInput.on('typeahead:selected', function(event, user) {
        window.location.replace('/admin-center/users-manager/user/' + user.id);
    });

    /*
     ------------------------
     Search engine for header
     ------------------------
     */
    var results = new Bloodhound({
        datumTokenizer: function (datum) {
            return Bloodhound.tokenizers.whitespace(datum.value);
        },
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            ajax: {
                beforeSend: function(xhr) {
                    $('.search-icon').hide();
                    $('.loading-icon').show();
                },
                complete: function() {
                    $('.search-icon').show();
                    $('.loading-icon').hide();
                }
            },
            cache: false,
            url: '/search/header?query=',
            replace: function() {
                var url = '/search/header?query=';
                if (document.getElementById('search-bar').value) {
                    url += encodeURIComponent(document.getElementById('search-bar').value);
                }
                return url;
            },
            filter: function (products) {
                // Map the remote source JSON array to a JavaScript object array
                return $.map(products, function (product) {
                    return {
                        value: product.code,
                        display: product.code + ' - ' + product.name
                    };
                });
            }
        }
    });

    results.initialize();

    var input = $('#search-bar');

    // Instantiate the Typeahead UI
    input.typeahead(null, {
        displayKey: 'value',
        source: results.ttAdapter(),
        templates: {
            suggestion: function(product) {
                return '<p>' + product.display + '</p>'
            }
        }
    });

    // Redirect to product details page
    input.on('typeahead:selected', function(event, product) {
        window.location.replace('/product-details/' + product.value);
    });
});
//# sourceMappingURL=users-manager.js.map