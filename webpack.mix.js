const mix = require('laravel-mix')
require('vuetifyjs-mix-extension')
require('cross-env')

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

mix.js('resources/js/app.js', 'public/js').vuetify()
    .sass('resources/sass/app.scss', 'public/css')
    .copyDirectory('resources/img', 'public/img')
    .options({
        extractVueStyles: true
    })
    .webpackConfig({
        resolve: {
            extensions: ['.js', '.vue', '.json'],
            alias: {
                'vue$': 'vue/dist/vue.esm.js',
                '@': __dirname + '/resources/js'
            },
        },
    })


if (mix.inProduction())
    mix.version()