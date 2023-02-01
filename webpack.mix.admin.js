const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');

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

mix.js('resources/js/dashboard/genericDeleteModel.js', 'public/js/dashboard')
    .js('resources/js/dashboard/transactionsDataTable.js', 'public/js/dashboard')
    .extract(['vue', 'axios'])
    .postCss('resources/css/dashboard.css', 'public/css', [
      require('postcss-import'),
      tailwindcss('./tailwind.config.admin.js'),
    ])
    .mergeManifest();

if (mix.inProduction()) {
  mix.version();
}
