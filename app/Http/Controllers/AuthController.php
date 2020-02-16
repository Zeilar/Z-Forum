<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;

class AuthController extends Controller
{
	// Log in
    public function login(Request $request)
	{
		// Validation - since user is already created nothing is required except the field not being empty
		$this->validate($request, [
			'id'	   => 'required',
			'password' => 'required',
		]);

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

	// Log out
	public function logout()
	{
		Auth::logout();
		return redirect(route('index'));
	}

	// Register
	public function register(Request $request)
	{
		// Validation
		$this->validate($request, [
			'username' => 'required|string|min:3|max:255|unique:users|alpha_dash',
			'email'	   => 'required|string|min:3|max:255|unique:users|email',
			'password' => 'required|string|min:6|max:255|confirmed',
		]);

		User::create($request);
		return msg_success('login');
	}
}