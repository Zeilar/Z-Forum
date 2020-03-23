<?php

use \Carbon\Carbon;

require_once 'Variables.php';
/**
 * Custom functions
 * 
 * @author Philip Angelin
 */

/**
 * Check if and item with both the provided object and slug exists
 * Do not use in views
 * 
 * @param object item
 * @param string slug
 * 
 * @return mixed
 */
if (!function_exists('item_exists')) {
	function item_exists($item, string $slug) {
		try {
			if ($item) {
				if (strtolower(urldecode($slug)) === strtolower(urldecode($item->slug))) {
					return true;
				} else {
					return false;
				}
			}
		} catch (Exception $e) {
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
 * @param date $date
 *
 * @return date
 */
if (!function_exists('pretty_date')) {
	function pretty_date($date) {
		$date = new Carbon($date);
		$now = Carbon::now();
		$difference = $date->diff($now)->days;

		if ($difference = $date->diff($now)->days === 0) {
			return __('Today') . ', ' . date('H:i', strtotime($date));
		} else if ($difference = $date->diff($now)->days === 1) {
			return __('Yesterday') . ', ' . date('H:i', strtotime($date));
		} else {
			return date('Y-m-d', strtotime($date));
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
				return redirect()->back()->with('error-id', __('Please log in and try again'));
			case 'role':
				return redirect()->back()->with('error', __('Insufficient permissions'));
			case 'incorrect-id':
				return redirect()->back()->with('error-id', __('That user does not exist'));
			case 'incorrect-password':
				return redirect()->back()->with('error-password', __('Incorrect password'));
			case 'locked':
				return redirect()->back()->with('error', __('The thread is locked, please contact a moderator'));
			case 'create-item':
				return redirect()->back()->with('error-create', __('Test'));
			case null:
				return redirect()->route('index')->with('error', __('An unexpected error occurred'));
			default:
				return redirect()->back()->with('error', __($type));
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
 * Check if user is online
 * 
 * @param int $id
 * 
 * @return boolean
 */
if (!function_exists('is_user_online')) {
	function is_user_online($id) {
		return Illuminate\Support\Facades\Cache::has('user-online-' . $id) ? true : false;
	}
}

/**
 * Get all users who are online
 * 
 * @return array
 */
if (!function_exists('get_online_users')) {
	function get_online_users() {
		$users = [];
		foreach (App\User::all() as $user) {
			if (is_user_online($user->id)) {
				array_push($users, $user);
			}
		}
		return $users;
	}
}

// TODO: User activity
if (!function_exists('get_user_activity')) {
	function get_user_activity(int $id) {
		return Illuminate\Support\Facades\Cache::get('user-activity-' . $id ?? auth()->user()->id);
	}
}

/**
 * Decide text color of a user link based on that user's role
 * 
 * @param string $role
 * 
 * @return string
 */
if (!function_exists('role_coloring')) {
	function role_coloring(string $role) {
		switch ($role) {
			case 'superadmin':
				return 'is_superadmin';
			case 'moderator':
				return 'is_moderator';
			default:
				return '';
		}
	}
}

/**
 * Add or change settings
 * 
 * @param string $key
 * @param mixed $value
 * @param int $id
 * 
 * @return boolean
 */
if (!function_exists('settings_put')) {
	function settings_put(string $key, $value, int $id = null) {
		// Set user as the currently logged in if possible, default to provided ID
		$user = App\User::find($id) ?? auth()->user();

		// If no user was found, return false to prevent further issues
		if (empty($user)) return null;

		// Fetch the settings as an associative array
		$settings = json_decode($user->settings, true);

		// Prepare the provided key and value pair
		$settings[$key] = $value;

		// Prepare the new user object propety
		$user->settings = json_encode($settings);

		// Save settings
		return $user->save();
	}
}

/**
 * Delete settings
 * 
 * @param string $key
 * @param int $id
 * 
 * @return boolean
 */
if (!function_exists('settings_delete')) {
	function settings_delete(string $key, int $id = null) {
		// Set user as the currently logged in if possible, default to provided ID
		$user = App\User::find($id) ?? auth()->user();

		// If no user was found, return false to prevent further issues
		if (empty($user)) return null;

		// Fetch the settings as an associative array
		$settings = json_decode($user->settings, true);

		// Prepare the provided key and value pair
		unset($settings[$key]);

		// Prepare the new user object propety
		$user->settings = json_encode($settings);

		// Save settings
		return $user->save();
	}
}

/**
 * Get settings
 * 
 * @param string $key
 * @param int $id
 * 
 * @return mixed
 */
if (!function_exists('settings_get')) {
	function settings_get(string $key = 'all', int $id = null) {
		// Set user as the currently logged in if possible, default to provided ID
		$user = App\User::find($id) ?? auth()->user();

		// If no user was found, return default value for that setting
		if (empty($user)) {
			$settings = json_decode(DB::table('default_settings')->get()[0]->settings);
			return isset($settings->$key) ? $settings->$key : null;
		}

		// Fetch the settings as an associative array
		$settings = json_decode($user->settings, true);

		// Return either all or a select setting
		return ($key === 'all') ? $settings : $settings[$key];
	}
}

/**
 * Get which page in pagination of a given item
 * 
 * @param $colletion
 * @param int $id
 * @param int $pageAmount
 */
if (!function_exists('get_item_page_number')) {
	function get_item_page_number($collection, int $id, int $pageAmount = 0) {
		foreach ($collection->sortBy('created_at') as $item) {
			if (empty($page)) $page = 1;

			isset($j) ? $j++ : $j = 0;

			if ($j === $pageAmount) {
				$page ++;
				$j = 0;
			}

			if ($id === $item->id) {
				return $page;
			}
		}
		return '';
	}
}