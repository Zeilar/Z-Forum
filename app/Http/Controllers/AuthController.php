<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Validator;
use App\User;
use Auth;

class AuthController extends Controller
{
	// Log in
    public function login(Request $request)
	{
		// Validation - since user is already created nothing is required except the field not being empty
		$this->validate(
			$request,
			[
				'id'	   => 'required',
				'password' => 'required',
			],
			[
				'id.required' 		=> __('Username or email is required'),
				'password.required' => __('Password is required'),
			]
		);

		// Determine if input is email or username
		$id = request()->input('id');
        $fieldType = filter_var($id, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        request()->merge([$fieldType => $id]);

		// Prepare login data now that we have determined what login to use
		$data = [
			$fieldType => request('id'),
			'password' => request('password'),
		];

		// Try to log in with the given data
		if (Auth::attempt($data)) {
			return msg_success('login');
		} else {
			return msg_error('invalid');
		}
	}

	// Register
	public function register(Request $request)
	{
		// Validation
		$this->validate(
			$request,
			[
				// The rules
				'username' => 'required|string|min:3|max:30|unique:users|alpha_dash',
				'email'	   => 'required|string|min:3|max:30|unique:users|email',
				'password' => 'required|string|min:6|max:30|confirmed',
			],
			[
				// Custom error messages, ordered by priority
				'username.required' 	=> __('Username is required'),
				'password.required' 	=> __('Password is required'),
				'email.required' 		=> __('Email is required'),
				'username.unique:users' => __('That username is already taken'),
				'email.unique:users' 	=> __('That email is already taken'),
				'username.alpha_dash'	=> __('Username must consist of alphabetic and numeric characters'),
				'username.min:3' 		=> __('Password must be at least 3 character long'),
				'password.min:6' 		=> __('Password must be at least 6 character long'),
				'email.min:3' 			=> __('Email must be at least 3 character long'),
				'username.max:30'		=> __('Username may not exceed 30 characters'),
				'password.max:30'		=> __('Password may not exceed 30 characters'),
				'email.max:30'			=> __('Email may not exceed 30 characters'),
				'password.confirmed'	=> __('Passwords do not match'),
			]
		);

		// Prepare the user data
		$data = [
			'username' => request('username'),
			'email'	   => request('email'),
			'password' => Hash::make(request('password')),
		];

		// If validation checks out, create our new user
		User::create($data);

		// Try to log in with the newly created user - careful to not use the hashed password when attempting to authenticate
		$data = [
			'email'	   => request('email'),
			'password' => request('password'),
		];
		
		if (Auth::attempt($data)) {
			return msg_success('login');
		} else {
			return msg_error();
		}
	}

	// Log out
	public function logout()
	{
		Auth::logout();
		return redirect(route('index'));
	}
}