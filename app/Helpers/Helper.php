<?php
/**
 * Custom functions
 * 
 * @author Philip Angelin
 */

/**
 * Check if item exists, it should have a title and id
 * Do not use in views
 * 
 * @param object item - Object of the item
 * @param string slug - Compare URL slug with item slug
 * 
 * @return mixed
 */
if (!function_exists('item_exists')) {
	function item_exists(object $item, string $slug) {
		if ($item) {
			if (strtolower(urldecode($slug)) === strtolower(urldecode($item->slug))) {
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
 * Calculate difference between UNIX and given timestamp
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
 * Render date with "Today" or "Yesterday" instead of numerics
 * Will use numerics if date is more than 1 day in the past
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
 * @return date
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
	function msg_error(string $type = null) {
		switch ($type) {
			case 'login':
				return redirect()->back()->with('error', __('Please log in and try again'));
			case 'role':
				return redirect()->back()->with('error', __('Insufficient permissions'));
			case 'invalid':
				return redirect()->back()->with('error', __('Incorrect credentials, please try again'));
			case null:
				return redirect()->route('index')->with('error', __('An unexpected error occurred'));
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
			case 'registered':
				return redirect()->route('index')->with('success', __('Your account has been created!'));
			case 'update':
				return redirect()->back()->with('success', __('Changes were successful!'));
			default:
				return redirect()->route('index')->with('success', __('Success!'));
		}
	}
}

/**
 * Calculate breadcrumbs from your position and upwards in the hierarchy
 * The breadcrumb at your current position will by defualt not be a hyperlink
 * 
 * @param object $position
 * 
 * @return array
 */
function breadcrumb_guesser(object $position) {
	if ($position) {
		if (isset($position->tableSubcategories)) {
			return [
				[
					$position,
					'route' => false,
				],
			];
		} else if (isset($position->tableCategory)) {
			return [
				[
					$position->tableCategory,
					'route' => route('tablecategory_show', [
						$position->tableCategory->id,
						$position->tableCategory->slug
					]),
				],
				[
					$position,
					'route' => false,
				],
			];
		} else if (isset($position->tableSubcategory)) {
			return [
				[
					$position->tableSubcategory->tableCategory,
					'route' => route('tablecategory_show', [
						$position->tableSubcategory->tableCategory->id,
						$position->tableSubcategory->tableCategory->slug
					]),
				],
				[
					$position->tableSubcategory,
					'route' => route('tablesubcategory_show', [
						$position->tableSubcategory->id,
						$position->tableSubcategory->slug
					]),
				],
				[
					$position,
					'route' => false,
				],
			];
		}
	} else {
		return null;
	}
}