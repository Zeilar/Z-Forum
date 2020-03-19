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
   .sass('resources/sass/app.scss', 'public/css');

// Copy into dist folder for production
if (mix.inProduction()) {
	// App
	mix.copyDirectory('app', 'dist/miss_hosting/zforum/app');
	mix.copyDirectory('config', 'dist/miss_hosting/zforum/config');
	mix.copyDirectory('database', 'dist/miss_hosting/zforum/database');
	mix.copyDirectory('resources', 'dist/miss_hosting/zforum/resources');
	mix.copyDirectory('routes', 'dist/miss_hosting/zforum/routes');
	mix.copyDirectory('tests', 'dist/miss_hosting/zforum/tests');

	// Public
	mix.copyDirectory('public/images', 'dist/miss_hosting/public_html/images');
	mix.copyDirectory('public/fonts', 'dist/miss_hosting/public_html/fonts');
	mix.copyDirectory('public/css', 'dist/miss_hosting/public_html/css');
	mix.copyDirectory('public/js', 'dist/miss_hosting/public_html/js');
}