const mix = require('laravel-mix');
const exec = require('child_process').exec;
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

mix.setPublicPath('./public');

if (!mix.inProduction()) {
  mix.webpackConfig({
    devtool: 'inline-source-map',  plugins: [

      {
        apply: (compiler) => {
          compiler.hooks.afterEmit.tap('AfterEmitPlugin', (compilation) => {
            exec('cd /home/rocky/Documents/www/equity-release-comparision && php artisan mailgun:install', (err, stdout, stderr) => {
              if (stdout) process.stdout.write(stdout);
              if (stderr) process.stderr.write(stderr);
            });
          });
        }
      }
    ]
  });
}

mix
  .js('resources/js/app.js', 'public/js/')
  .sass('resources/sass/app.scss', 'public/css/')
  .extract(['vue', 'vue-router', 'axios', 'moment', 'sweetalert2'], 'js/vendor')
  .copy('node_modules/tinymce/themes', 'public/js/themes')
  .copy('node_modules/tinymce/skins', 'public/js/skins')
  .copy('node_modules/tinymce/plugins', 'public/js/plugins')
  .version();
