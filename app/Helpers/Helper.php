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
		return (($item && strtolower($item->title) === strtolower($title))) ? true : false;
	}
}

/**
 * Check if user is logged in
 *  * 
 * @return boolean
 */
if (!function_exists('logged_in')) {
	function logged_in() {
		if (auth()->user()) {
			return true;
		} else {
			return false;
		}
	}
}

/**
 * Check if user is logged in and if their role matches the given one
 * 
 * @param string $role
 * 
 * @return boolean
 */
if (!function_exists('is_role')) {
	function is_role(string $role) {
		if (Auth::user()) {
			if (strtolower(auth()->user()->role) === strtolower($role)) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
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

/**
 * Add a comma between numeric date and time
 * 
 * @param string $timestamp
 * 
 * @return mixed
 */
if (!function_exists('date_comma')) {
	function date_comma(string $timestamp) {
		if ($timestamp) {
			$formatted = explode(' ', $timestamp); 
			return $formatted[0] . ', ' . $formatted[1];
		} else {
			return date('Y-m-d, H:i:s');
		}
	}
}

/**
 * Redirect with session error message
 * 
 * @param string $type
 * 
 * @return redirect
 */
if (!function_exists('msg_error')) {
	function msg_error(string $type) {
		switch ($type) {
			case 'login':
				return redirect()->route('index')->with('error', __('Please log in and try again'));
			case 'role':
				return redirect()->back()->with('error', __('Insufficient permissions'));
			default:
				return redirect()->route('index')->with('error', __('An unexpected error occurred'));
		}
	}
}

/**
 * Redirect with session success message
 * 
 * @param string $type
 * 
 * @return redirect
 */
if (!function_exists('msg_success')) {
	function msg_success(string $type) {
		switch ($type) {
			case 'login':
				return redirect()->route('index')->with('success', __('Successfully logged in!'));
			case 'update':
				return redirect()->back()->with('success', __('Changes were made!'));
			default:
				return redirect()->route('index')->with('success', __('Success!'));
		}
	}
}