<?php

/**
 * Custom functions
 * @author Philip Angelin
 */

if (!function_exists('item_exists')) {
	function item_exists($item, $title) {
		return (($item && strtolower($item->title) === strtolower($title))) ? true : abort(404);
	}
}

if (!function_exists('logged_in')) {
	function logged_in() {
		return (auth()->user()) ? true : abort(403, __('User Not Found'));
	}
}

if (!function_exists('is_role')) {
	function is_role($role) {
		if (logged_in()) return (strtolower(auth()->user()->role) === strtolower($role)) ? true : abort(403, __('Unauthorized'));
	}
}