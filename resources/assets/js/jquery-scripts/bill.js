$(document).ready(function() {
    // Instantiate the Bloodhound suggestion engine
    var products = new Bloodhound({
        datumTokenizer: function (datum) {
            return Bloodhound.tokenizers.whitespace(datum.value);
        },
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            cache: false,
            url: 'http://localhost:8888/bills/11/suggest-products?product_code=',
            replace: function() {
                var url = 'http://localhost:8888/bills/11/suggest-products?product_code=';
                if ($('#product-code').val()) {
                    url += encodeURIComponent($('#product-code').val())
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

    // Initialize the Bloodhound suggestion engine
    products.initialize();

    var input = $('.twitter-typeahead');

    // Instantiate the Typeahead UI
    input.typeahead(null, {
        displayKey: 'value',
        source: products.ttAdapter(),
        templates: {
            suggestion: function(product) {
                return '<p>' + product.display + '</p>'
            }
        }
    });
});