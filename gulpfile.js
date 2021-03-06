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
    mix.sass('app.scss')
        .sass('print.scss', 'public/css/print.css');
    mix.scripts([
        'jquery.min.js', 'bootstrap.min.js', 'vue/vue.js', 'vue/vue-resource.js', 'components/loader.js', 'sweetAlert.js',
        'custom-libs/alerts.js', 'custom-libs/swal-config.js', 'custom-libs/token.js', 'custom-libs/translations.js', 'custom-libs/data.js',
        'custom-libs/url-builder.js', 'typeahead.js', 'jquery-scripts/tooltips.js', 'custom-libs/reset.js', 'libs/pusher.js', 'pages/notifications.js',
    ], 'public/js/vendor.js')
        // Header search script
        .scripts(['jquery-scripts/header-search.js'], 'public/js/header-search.js')
        .scripts(['welcome.js'], 'public/js/welcome.js')

        // Scripts for bills page
        .scripts(['pages/bills.js', 'jquery-scripts/bills.js'], 'public/js/bills.js')
        .scripts(['pages/clients.js'], 'public/js/clients.js')
        .scripts(['pages/base.js', 'pages/client.js'], 'public/js/client.js')
        // Client paid bills page
        .scripts(['pages/client-paid-bills.js'], 'public/js/client-paid-bills.js')
        // Client unpaid bills page
        .scripts(['pages/client-unpaid-bills.js'], 'public/js/client-unpaid-bills.js')
        .scripts(['pages/base.js', 'pages/products.js', 'jquery-scripts/products.js'], 'public/js/products.js')
        .scripts(['pages/base.js', 'pages/my-products.js'], 'public/js/my-products.js')

        // Scripts for bill page
        .scripts(['pages/bill.js', 'jquery-scripts/bill.js', 'libs/jquery-ui.js', 'libs/trumbowyg.js'], 'public/js/bill.js')
        .scripts(['pages/statistics.js', 'jquery-scripts/statistics.js'], 'public/js/statistics.js')
        .scripts(['pages/settings.js', 'jquery-scripts/settings.js'], 'public/js/settings.js')
        .scripts(['pages/paid-bills.js'], 'public/js/paid-bills.js')
        .scripts(['pages/product-details.js'], 'public/js/product-details.js')
        .scripts(['pages/register.js'], 'public/js/register.js')
        .scripts(['pages/recover.js'], 'public/js/recover.js')
        .scripts(['pages/application-settings.js'], 'public/js/application-settings.js')

        // Scripts for users manager page
        .scripts(['pages/users-manager.js', '/jquery-scripts/users-manager.js'], 'public/js/users-manager.js')
        // Scripts for user section of users manager
        .scripts(['pages/users-manager/user.js'], 'public/js/user.js')
        .scripts(['pages/subscribe.js'], 'public/js/subscribe.js')
        .scripts(['pages/help-center-manager.js'], 'public/js/help-center-manager.js')
        .scripts(['pages/help-center-manager/category.js'], 'public/js/help-center-manager-category-page.js')
        .scripts(['pages/help-center/help-center.js'], 'public/js/help-center.js')
        .scripts(['pages/help-center/category.js'], 'public/js/help-center-category.js')
        .scripts(['pages/login.js'], 'public/js/login.js')
        .scripts(['pages/subscriptions/index.js'], 'public/js/subscriptions-index.js')
        .scripts(['pages/subscriptions/offers.js'], 'public/js/offers.js')
        .scripts(['pages/subscriptions/offer.js'], 'public/js/offer.js')
        // Campaign statistics
        .scripts(['pages/campaign-statistics.js'], 'public/js/campaign-statistics.js')
        .scripts(['libs/chart.js', 'pages/compare-campaigns.js'], 'public/js/compare-campaigns.js')
        // Notifications manager
        .scripts(['pages/notifications-manager/index.js'], 'public/js/notifications-manager.js')
        .scripts(['pages/admin-center/products-manager/index.js'], 'public/js/admin-center_products-manager_index.js')
        .scripts(['pages/admin-center/products-manager/product.js'], 'public/js/admin-center_products-manager_product.js');

});
