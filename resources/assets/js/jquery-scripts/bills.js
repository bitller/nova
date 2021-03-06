$(document).ready(function() {

    // Search engine for client suggestions
    var clients = new Bloodhound({

        datumTokenizer: function (datum) {
            return Bloodhound.tokenizers.whitespace(datum.value);
        },

        queryTokenizer: Bloodhound.tokenizers.whitespace,

        remote: {
            ajax: {
                // Show loader when request is made
                beforeSend: function(xhr) {
                    $('.client-name i').show();
                },
                // Hide loader after request
                complete: function() {
                    $('.client-name i').hide();
                }
            },

            cache: false,

            url: '/suggest/clients?name=',

            replace: function() {
                var url = '/suggest/clients?name=';
                if ($('#client-name').val()) {
                    url += encodeURIComponent($('#client-name').val())
                }
                return url;
            },

            filter: function (clients) {
                // Map the remote source JSON array to a JavaScript object array
                return $.map(clients, function (client) {
                    return {
                        name: client.name
                    };
                });
            }
        }
    });

    // Initialize the Bloodhound suggestion engine
    clients.initialize();

    var clientInput = $('.twitter-typeahead');

    // Instantiate the Typeahead UI
    clientInput.typeahead(null, {
        displayKey: 'name',
        source: clients.ttAdapter(),
        templates: {
            suggestion: function(client) {
                return '<p>' + client.name + '</p>'
            }
        }
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