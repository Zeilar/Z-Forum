<?php

/**
 * Custom functions
 * 
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
		return (logged_in()
			? (strtolower(auth()->user()->role) === strtolower($role)) ? true : abort(403, __('Unauthorized'))
			: false
		);
	}
}

if (!function_exists('time_difference')) {
	function time_difference($date) {
		return $difference = [
			'sec' => date('s', strtotime($date)) - date('s'),
			'min' => date('i', strtotime($date)) - date('i'),
			'hour' => date('H', strtotime($date)) - date('H'),
			'day' => date('j', strtotime($date)) - date('j'),
			'week' => date('W', strtotime($date)) - date('W'),
			'month' => date('n', strtotime($date)) - date('n'),
			'year' => date('Y', strtotime($date)) - date('Y'),
		];
	}
}

if (!function_exists('prettydate')) {
	function pretty_date($date) {
		$diff = time_difference($date);
		$date = strtotime($date);

		if ($diff['day'] === 0 && $diff['month'] === 0 && $diff['week'] === 0 && $diff['year'] === 0) {
			return __('Today') . ' ' . '<span class="color-gray">' . date('H:i', $date) . '</span>';
		} else if ($diff['day'] === -1 && $diff['month'] === 0 && $diff['week'] === 0 && $diff['year'] === 0) {
			return __('Yesterday') . ' ' . '<span class="color-gray">' . date('H:i', $date) . '</span>';
		} else {
			return date('Y-m-d', $date);
		}
	}
}