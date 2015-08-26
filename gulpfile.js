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
    mix.scripts(['jquery.min.js', 'bootstrap.min.js', 'vue/vue.js', 'vue/vue-resource.js', 'components/loader.js', 'sweetAlert.js'], 'public/js/vendor.js')
        .scripts(['script.js'], 'public/js/welcome.js')
        .scripts(['bills.js'], 'public/js/bills.js')
        .scripts(['clients.js'], 'public/js/clients.js');
});
