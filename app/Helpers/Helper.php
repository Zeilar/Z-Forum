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
	function item_exists($item, string $slug) : bool {
		try {
			if ($item) {
				if (strtolower(urldecode($slug)) === strtolower(urldecode($item->slug))) {
					return true;
				} else {
					return false;
				}
			} else {
				return false;
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
	function logged_in() : bool {
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
 * @return mixed
 */
if (!function_exists('is_role')) {
	function is_role(string ...$roles) {
		if (auth()->user()) {
			foreach ($roles as $role) {
				if (strtolower(auth()->user()->role) === strtolower($role)) {
					return auth()->user();
				}
			}
			return false;
		} else {
			return false;
		}
	}
}

/**
 * Prettier date format including "today", "yesterday", and month abbreviations
 *
 * @param date  $date
 * @param array $args
 *
 * @return date
 */
if (!function_exists('pretty_date')) {
	function pretty_date($date, array $args = []) : string {
		$date = Carbon::createFromFormat('Y-m-d H:i:s', $date ?? Carbon::now(), $args['timezone'] ?? $_COOKIE['timezone'] ?? 'UTC');
		$now = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now(), $args['timezone'] ?? $_COOKIE['timezone'] ?? 'UTC');

		$date = $date->addSeconds($date->getOffset());

		if (isset($args['format'])) {
			return date($args['format'], strtotime($date));
		}

		if ($date->isCurrentDay()) {
			$format = __('Today');
		} else if ($date->isYesterday()) {
			$format = __('Yesterday');
		} else if ($date->year === $now->year) {
			$format = date('F jS', strtotime($date));
		} else {
			$format = date('Y-m-d', strtotime($date));
		}
		
		return $format . date(' H:i', strtotime($date));
	}
}

/**
 * Redirect with session error message
 * 
 * @param string $msg
 * 
 * @return redirect
 */
if (!function_exists('msg_error')) {
	function msg_error(string $msg = null, string $flash = 'error') {
		switch ($msg) {
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
			case null:
				return redirect()->route('index')->with('error', __('An unexpected error occurred'));
			default:
				return redirect()->back()->with($flash, $msg);
		}
	}
}

/**
 * Redirect with session success message
 * 
 * @param string $msg
 * 
 * @return redirect
 */
if (!function_exists('msg_success')) {
	function msg_success(string $msg = null, string $flash = 'success') {
		switch ($msg) {
			case 'login':
				return redirect()->back()->with('success', __('Successfully logged in'));
			case 'registered':
				return redirect()->route('index')->with('success', __('Your account has been created'));
			case 'update':
				return redirect()->back()->with('success', __('Changes were successful'));
			default:
				return redirect()->back()->with($flash, $msg);
		}
	}
}

/**
 * Get all users who are online
 * 
 * @return array
 */
if (!function_exists('get_online_users')) {
	function get_online_users() : array {
		$users = [];
		foreach (App\User::all() as $user) {
			if (\Illuminate\Support\Facades\Cache::has('user-online-' . $user->id)) array_push($users, $user);
		}
		return $users;
	}
}

/**
 * Apply HTML class string if user text should have special coloring
 * 
 * @param string $role
 * 
 * @return string
 */
if (!function_exists('role_coloring')) {
	function role_coloring(string $role) : string {
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
	function settings_put(string $key, $value, int $id = null) : bool {
		// Set user as the currently logged in if possible, default to provided ID
		$user = App\User::find($id) ?? auth()->user();

		// If no user was found, return false to prevent further issues
		if (empty($user)) return false;

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
	function settings_delete(string $key, int $id = null) : bool {
		// Set user as the currently logged in if possible, default to provided ID
		$user = App\User::find($id) ?? auth()->user();

		// If no user was found, return false to prevent further issues
		if (empty($user)) return false;

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
		$user = App\User::find($id) ?? auth()->user() ?? null;

		// If no user was found, return default value for that setting
		if (empty($user)) {
		    $default_setting = json_decode(DB::table('default_settings')->first()->settings)->$key;
			return isset($default_setting) ? $default_setting : 0;
		}

		// Fetch the settings as an associative array
		$settings = json_decode($user->settings, true);

		// Return either all or a select setting
		return ($key === 'all') ? $settings : $default_setting ?? $settings[$key] ?? 0;
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
	function get_item_page_number($collection, int $id, int $pageAmount = 0) : int {
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
		return 1;
	}
}

/**
 * Create text excerpt
 * 
 * @param string $text
 * @param int $max_length
 * @param string $cut_off
 * @param bool $keep_word
 * 
 * @return string
 */
if (!function_exists('shorten_text')) {
	function shorten_text(string $text, int $max_length = 150, string $cut_off = '...', bool $keep_word = true) : string {
		if (strlen($text) <= $max_length) return $text;

		if ($keep_word) {
			$text = substr($text, 0, $max_length + 1);

			if ($last_space = strrpos($text, ' ')) {
				$text = substr($text, 0, $last_space);
				$text = rtrim($text);
				$text .=  $cut_off;
			}
		} else {
			$text = substr($text, 0, $max_length);
			$text = rtrim($text);
			$text .=  $cut_off;
		}
		return $text;
	}
}