$(document).ready(function() {

    // Instantiate the Bloodhound suggestion engine
    var products = new Bloodhound({
        datumTokenizer: function (datum) {
            return Bloodhound.tokenizers.whitespace(datum.value);
        },
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            ajax: {
                beforeSend: function(xhr) {
                    $('.product-code i').show();
                },
                complete: function() {
                    $('.product-code i').hide();
                }
            },
            cache: false,
            url: '/bills/' + $('#bill').attr('bill-id') + '/suggest-products?product_code=',
            replace: function() {
                var url = '/bills/' + $('#bill').attr('bill-id') + '/suggest-products?product_code=';
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


    $('#payment-term').datepicker({dateFormat: 'dd-mm-yy'});

    $('[data-toggle="tooltip"]').tooltip();

    $('#other-details').summernote({
        focus: true,
        height: 300,
        toolbar: [
            ['style', ['bold', 'italic', 'underline']]
        ]
    });

    $('.edit-other-details').click(function() {
        $('#other-details').summernote('code', $('#other-details').attr('current'));
    });
});