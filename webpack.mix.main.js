const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/public/market.js', 'public/js/public')
    .js('resources/js/public/history.js', 'public/js/public')
    .extract(['vue', 'axios', 'v-calendar', 'laravel-echo', 'pusher-js'])
    .postCss('resources/css/app.css', 'public/css', [
      require('postcss-import'),
      require('tailwindcss'),
    ])
    .mergeManifest();

if (mix.inProduction()) {
  mix.version();
}
