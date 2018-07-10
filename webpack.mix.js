let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------clear
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.copy('resources/assets/fonts/', 'public/fonts/', false);
mix.copy('resources/assets/web-fonts-with-css/webfonts/', 'public/webfonts/', false);

mix.styles([
    'resources/assets/css/bootstrap.min.css',
    'resources/assets/css/plugins/toastr/toastr.min.new.css',
    'resources/assets/css/plugins/gritter/jquery.gritter.css',
    'resources/assets/css/animate.css',
    'resources/assets/css/style.css',
    'resources/assets/css/custom.css',
    'resources/assets/clock/css/style.css',
    'resources/assets/css/plugins/datapicker/datepicker3.css',
    'resources/assets/css/plugins/ladda/ladda-themeless.min.css',
    'resources/assets/css/plugins/select2/select2.min.css',
    'resources/assets/css/plugins/iCheck/custom.css',
    'resources/assets/css/plugins/datapicker/datepicker3.css',
    'resources/assets/css/plugins/daterangepicker/daterangepicker-bs3.css',
    'resources/assets/css/plugins/sweetalert/sweetalert2.css',
    'resources/assets/css/plugins/jasny/jasny-bootstrap.min.css',
    'resources/assets/css/plugins/switchery/switchery.css',
    'resources/assets/css/plugins/textSpinners/spinners.css',
    'resources/assets/font-awesome/css/font-awesome.css',  // Fontawesome Version 4
    'resources/assets/web-fonts-with-css/css/fontawesome-all.min.css', // Fontawesome Version 5
    'resources/assets/css/awesome-bootstrap-checkbox.css',
],'public/css/template.css');

mix.scripts([
    'resources/assets/js/jquery-3.3.1.min.js',
    'resources/assets/js/bootstrap.min.js',
    'resources/assets/js/plugins/metisMenu/jquery.metisMenu.js',
    'resources/assets/js/plugins/slimscroll/jquery.slimscroll.min.js',
    'resources/assets/js/plugins/flot/jquery.flot.js',
    'resources/assets/js/plugins/flot/jquery.flot.tooltip.min.js',
    'resources/assets/js/plugins/flot/jquery.flot.spline.js',
    'resources/assets/js/plugins/flot/jquery.flot.resize.js',
    'resources/assets/js/plugins/flot/jquery.flot.pie.js',
    'resources/assets/js/plugins/peity/jquery.peity.min.js',
    'resources/assets/js/inspinia.js',
    'resources/assets/js/plugins/pace/pace.min.js',
    'resources/assets/js/plugins/jquery-ui/jquery-ui.min.js',
    'resources/assets/js/plugins/gritter/jquery.gritter.min.js',
    'resources/assets/js/plugins/sparkline/jquery.sparkline.min.js',
    'resources/assets/js/plugins/chartJs/Chart.min.js',
    'resources/assets/js/plugins/toastr/toastr.min.new.js',
    'resources/assets/js/plugins/fullcalendar/moment.min.js',
    'resources/assets/js/plugins/datapicker/bootstrap-datepicker.js',
    // Ladda
    'resources/assets/js/plugins/ladda/spin.min.js',
    'resources/assets/js/plugins/ladda/ladda.min.js',
    // Select2
    'resources/assets/js/plugins/select2/select2.full.min.js',
    // icheck
    'resources/assets/js/plugins/iCheck/icheck.min.js',
    // Date Picker
    'resources/assets/js/plugins/datapicker/bootstrap-datepicker.js',
    // Date Range Picker
    'resources/assets/js/plugins/daterangepicker/daterangepicker.js',
    // // jasny
    'resources/assets/js/plugins/jasny/jasny-bootstrap.min.js',
    // Sweet Alert
    'resources/assets/js/plugins/sweetalert/sweetalert2.all.js',
    // Switchery
    'resources/assets/js/plugins/switchery/switchery.js',
    // Switchery
    'resources/assets/js/jquery.stickytabs.js'
],'public/js/template.js');

mix.js('resources/assets/js/app.js', 'public/js/app.js');
mix.js('resources/assets/js/loan_matrix.js', 'public/js/loan_matrix.js');

mix.copyDirectory('resources/assets/img', 'public/img');
mix.copyDirectory('resources/assets/css/patterns', 'public/css/patterns');
mix.copyDirectory('resources/assets/font-awesome/fonts', 'public/fonts');

mix.version();