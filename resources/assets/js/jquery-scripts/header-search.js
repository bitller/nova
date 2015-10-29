$(document).ready(function() {
    // Instantiate the Bloodhound suggestion engine
    var results = new Bloodhound({
        datumTokenizer: function (datum) {
            return Bloodhound.tokenizers.whitespace(datum.value);
        },
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            ajax: {
                beforeSend: function(xhr) {
                    //$('.product-code i').show();
                },
                complete: function() {
                    //$('.product-code i').hide();
                }
            },
            cache: false,
            url: '/search/header?query=',
            replace: function() {
                var url = '/search/header?query=';
                if ($('#search-bar').val()) {
                    url += encodeURIComponent($('#search-bar').val())
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
        updater: function(product) {
            window.location.href = '/product-details/' + product.code;
        },
        displayKey: 'value',
        source: results.ttAdapter(),
        templates: {
            suggestion: function(product) {
                return '<p>' + product.display + '</p>'
            }
        }
    });
});