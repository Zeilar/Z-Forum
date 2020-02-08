<?php
/**
 * Custom functions
 * 
 * @author Philip Angelin
 */

/**
 * Check if item exists, it should have a title and id
 * Recommended usage is inside a REST Controller
 * 
 * @param object item - Object of the item (required)
 * @param string title - Title to compare the item title propety with (required)
 * 
 * @return mixed
 */
if (!function_exists('item_exists')) {
	function item_exists(object $item, string $title) {
		return (($item && strtolower($item->title) === strtolower($title))) ? true : abort(404);
	}
}

/**
 * Check if user is logged in
 * 
 * @return mixed
 */
if (!function_exists('logged_in')) {
	function logged_in() {
		return (auth()->user()) ? true : abort(403, __('User Not Found'));
	}
}

/**
 * Check if user is logged in and if their role matches the given one
 * @see function logged_in()
 * 
 * @param string $role
 * 
 * @return mixed
 */
if (!function_exists('is_role')) {
	function is_role(string $role) {
		return (logged_in()
			? (strtolower(auth()->user()->role) === strtolower($role)) 
				? true 
				: abort(403, __('Unauthorized'))
			: false
		);
	}
}

/**
 * Calculate difference between now and given timestamp
 *
 * @param string $date
 *
 * @return array
 */
if (!function_exists('time_difference')) {
	function time_difference(string $date) {
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

/**
 * Write out date in a prettier format
 *
 * @param string $date
 *
 * @return date
 */
if (!function_exists('pretty_date')) {
	function pretty_date(string $date) {
		$diff = time_difference($date);
		$date = strtotime($date);

		if ($diff['day'] === 0 && $diff['month'] === 0 && $diff['week'] === 0 && $diff['year'] === 0) {
			return __('Today') . ', ' . date('H:i', $date);
		} else if ($diff['day'] === -1 && $diff['month'] === 0 && $diff['week'] === 0 && $diff['year'] === 0) {
			return __('Yesterday') . ', ' . date('H:i', $date);
		} else {
			return date('Y-m-d', $date);
		}
	}
}