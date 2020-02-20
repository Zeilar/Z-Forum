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
	function is_role(...$role) {
		if (auth()->user()) {
			foreach ($role as $key) {
				if (strtolower(auth()->user()->role) === strtolower($key)) {
					return true;
				}
			}
			return false;
		} else {
			return false;
		}
	}
}

/**
 * Render date with "Today" or "Yesterday" instead of numerics, when applicable
 *
 * @param string $date
 *
 * @return date
 */
if (!function_exists('pretty_date')) {
	function pretty_date(string $date) {
		$date = strtotime($date);
		$day = 60 * 60 * 24;

		if ((time() - $date < $day)) {
			return __('Today') . ', ' . date('H:i', $date);
		} else if ((time() - $date) > 60 * 60 * 24 && (time() - $date) < $day * 2) {
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
			case 'incorrect-id':
				return redirect()->back()->with('error', __('That user does not exist'));
			case 'incorrect-password':
				return redirect()->back()->with('error', __('Incorrect password'));
			case null:
				return redirect()->route('index')->with('error', __('An unexpected error occurred'));
			default:
				return redirect()->route('index')->with('error', __($type));
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

/**
 * Check if user is online
 * 
 * @param int $id
 * 
 * @return boolean
 */
if (!function_exists('is_user_online')) {
	function is_user_online($id) {
		if (Illuminate\Support\Facades\Cache::has('user-online-' . $id)) {
			return true;
		} else {
			return false;
		}
	}
}

/**
 * Get all users that are online
 * 
 * @return array
 */
if (!function_exists('get_online_users')) {
	function get_online_users() {
		$online_users = [];
		foreach (App\User::all() as $user) {
			if (is_user_online($user->id)) {
				array_push($online_users, $user);
			}
		}
		return $online_users;
	}
}

/**
 * Decide text color of a user link based on that user's role
 * 
 * @param string $role
 * 
 * @return string
 */
if (!function_exists('link_role_coloring')) {
	function link_role_coloring(string $role) {
		switch ($role) {
			case 'superadmin':
				return 'is-superadmin';
			case 'moderator':
				return 'is-moderator';
			default:
				return '';
		}
	}
}