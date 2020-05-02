const mix = require('laravel-mix');

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

mix.js(['resources/js/app.js', 'resources/js/application_charts.js', 'resources/js/calendar.js'], 'public/js')
   .sass('resources/sass/app.scss', 'public/css');

mix.styles([
    'node_modules/@fullcalendar/core/main.css',
    'node_modules/@fullcalendar/daygrid/main.css',
    'node_modules/@fullcalendar/timeline/main.css',
    'node_modules/@fullcalendar/timegrid/main.css',
    'node_modules/@fullcalendar/list/main.css'
], 'public/css/fullcalendar.css');

mix.webpackConfig({
    stats: {
        warnings: false
    }
});

mix.disableNotifications();
