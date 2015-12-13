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
    mix.sass('app.scss', 'resources/assets/css');

    mix.styles([
       'libs/bootstrap.min.css',
        'libs/select2.min.css',
        'libs/sweetalert.css',
        'app.css'
    ], 'public/css/stylesheet.css');

    mix.scripts([
        'libs/jquery.min.js',
        'libs/select2.min.js',
        'libs/bootstrap.min.js',
        'libs/sweetalert-dev.js'
    ], 'public/js/script.js');
});
