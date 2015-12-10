var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass('app.scss');
    mix.scripts([
        'jquery.min.js', 'bootstrap.min.js', 'vue/vue.js', 'vue/vue-resource.js', 'components/loader.js', 'sweetAlert.js',
        'custom-libs/alerts.js', 'custom-libs/swal-config.js', 'custom-libs/token.js', 'custom-libs/translations.js', 'custom-libs/data.js',
        'custom-libs/url-builder.js', 'typeahead.js'
    ], 'public/js/vendor.js')
        // Header search script
        .scripts(['jquery-scripts/header-search.js'], 'public/js/header-search.js')
        .scripts(['welcome.js'], 'public/js/welcome.js')

        // Scripts for bills page
        .scripts(['pages/bills.js', 'jquery-scripts/bills.js'], 'public/js/bills.js')
        .scripts(['pages/clients.js'], 'public/js/clients.js')
        .scripts(['pages/base.js', 'pages/client.js'], 'public/js/client.js')
        .scripts(['pages/base.js', 'pages/products.js', 'jquery-scripts/products.js'], 'public/js/products.js')
        .scripts(['pages/base.js', 'pages/my-products.js'], 'public/js/my-products.js')

        // Scripts for bill page
        .scripts(['pages/bill.js', 'jquery-scripts/bill.js', 'libs/jquery-ui.js'], 'public/js/bill.js')
        .scripts(['pages/statistics.js', 'jquery-scripts/statistics.js'], 'public/js/statistics.js')
        .scripts(['pages/settings.js', 'jquery-scripts/settings.js'], 'public/js/settings.js')
        .scripts(['pages/paid-bills.js'], 'public/js/paid-bills.js')
        .scripts(['pages/product-details.js'], 'public/js/product-details.js')
        .scripts(['pages/register.js'], 'public/js/register.js')
        .scripts(['pages/recover.js'], 'public/js/recover.js')
        .scripts(['pages/application-settings.js'], 'public/js/application-settings.js')
        .scripts(['pages/users-manager.js'], 'public/js/users-manager.js')
        .scripts(['pages/subscribe.js'], 'public/js/subscribe.js')
        .scripts(['pages/help-center-manager.js'], 'public/js/help-center-manager.js')
        .scripts(['pages/help-center-manager/category.js'], 'public/js/help-center-manager-category-page.js')
        .scripts(['pages/help-center/help-center.js'], 'public/js/help-center.js')
        .scripts(['pages/help-center/category.js'], 'public/js/help-center-category.js')
        .scripts(['pages/login.js'], 'public/js/login.js');
});
