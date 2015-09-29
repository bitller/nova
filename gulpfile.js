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
        'custom-libs/alerts.js', 'custom-libs/swal-config.js', 'custom-libs/token.js', 'custom-libs/translations.js', 'custom-libs/data.js'
    ], 'public/js/vendor.js')
        .scripts(['welcome.js'], 'public/js/welcome.js')
        .scripts(['pages/base.js', 'pages/bills.js'], 'public/js/bills.js')
        .scripts(['pages/clients.js'], 'public/js/clients.js')
        .scripts(['pages/base.js', 'pages/client.js'], 'public/js/client.js')
        .scripts(['pages/base.js', 'pages/products.js'], 'public/js/products.js')
        .scripts(['pages/base.js', 'pages/my-products.js'], 'public/js/my-products.js')
        .scripts(['pages/bill.js'], 'public/js/bill.js');
});
