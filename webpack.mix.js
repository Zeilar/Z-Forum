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

mix.react('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .options({
	   processCssUrls: false
   });

// Copy into dist folder for production
if (mix.inProduction()) {
	// Folders
	mix.copyDirectory('app', 'dist/miss_hosting/zforum/app');
	mix.copyDirectory('bootstrap', 'dist/miss_hosting/zforum/bootstrap');
	mix.copyDirectory('config', 'dist/miss_hosting/zforum/config');
	mix.copyDirectory('database', 'dist/miss_hosting/zforum/database');
	mix.copyDirectory('public', 'dist/miss_hosting/public_html');
	mix.copyDirectory('resources', 'dist/miss_hosting/zforum/resources');
	mix.copyDirectory('routes', 'dist/miss_hosting/zforum/routes');
	mix.copyDirectory('storage', 'dist/miss_hosting/zforum/storage');
	mix.copyDirectory('tests', 'dist/miss_hosting/zforum/tests');
}