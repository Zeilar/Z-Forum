window._ = require('lodash');
import cookieCutter from 'cookie-cutter-helpers';

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// TinyMCE default values
tinymce.init({
	selector: '#form-content',
	plugins: 'advlist autolink lists link image media charmap print preview hr anchor pagebreak bbcode code',
	height: 300,
});

// Customize scrollbar, but on PC Windows only
if (navigator.platform === 'Win32') {
    cookieCutter.set('custom-scrollbar', true);
	$('html').addClass('custom-scrollbar');
}