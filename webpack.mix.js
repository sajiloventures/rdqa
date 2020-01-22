let mix = require('laravel-mix');

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

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');

/*
 |--------------------------------------------------------------------------
 | Admin Asset Management
 |--------------------------------------------------------------------------
 |
 */
/*smartadmin theme*/
mix.styles([
        'resources/assets/smartadmin/css/bootstrap.min.css',
        'resources/assets/smartadmin/css/font-awesome.min.css',
        'resources/assets/smartadmin/css/smartadmin-production.min.css',
        'resources/assets/smartadmin/css/smartadmin-production-plugins.min.css',
        'resources/assets/smartadmin/css/smartadmin-skins.min.css',
        'resources/assets/smartadmin/css/smartadmin-skins.min.css',

    ],
    'public/smartadmin/css/all.css');

/*samrtmain js*/
mix.scripts([
        'resources/assets/smartadmin/js/libs/jquery-3.2.1.min.js',
        'resources/assets/smartadmin/js/libs/jquery-ui-1.10.3.min.js',
        'resources/assets/smartadmin/js/app.config.js',
        'resources/assets/smartadmin/js/plugin/jquery-touch/jquery.ui.touch-punch.min.js',
        'resources/assets/smartadmin/js/bootstrap/bootstrap.min.js',
        'resources/assets/smartadmin/js/notification/SmartNotification.min.js',
        'resources/assets/smartadmin/js/plugin/jquery-validate/jquery.validate.min.js',
        'resources/assets/smartadmin/js/plugin/bootstrap-slider/bootstrap-slider.min.js',
        'resources/assets/smartadmin/js/plugin/msie-fix/jquery.mb.browser.min.js',
        'resources/assets/smartadmin/js/plugin/fastclick/fastclick.min.js',
        'resources/assets/smartadmin/js/smart-chat-ui/smart.chat.ui.min.js',
        'resources/assets/smartadmin/js/smartwidgets/jarvis.widget.min.js',
        'resources/assets/smartadmin/js/smart-chat-ui/smart.chat.manager.min.js',
        'resources/assets/smartadmin/js/plugin/select2/select2.min.js',
        'resources/assets/smartadmin/js/app.min.js',

    ],
    'public/smartadmin/js/all.js');
