mix.js(['resources/js/app.js', 'resources/js/application_charts.js', 'resources/js/calendar.js'], 'public/js')
    .sass('resources/sass/app.scss', 'public/css');

mix.styles([
    'node_modules/@fullcalendar/core/main.css',
    'node_modules/@fullcalendar/daygrid/main.css',
    'node_modules/@fullcalendar/timeline/main.css',
    'node_modules/@fullcalendar/timegrid/main.css',
    'node_modules/@fullcalendar/list/main.css',
    'node_modules/flatpickr/dist/flatpickr.min.css'
], 'public/css/mixed.css');


mix.webpackConfig({
    stats: {
        warnings: false
    }
});

mix.disableNotifications();
