<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;

class AuthController extends Controller
{
    public function login(Request $request)
	{
		$this->validate($request, [
			//'username' => 'required|',
			'email'    => 'required|email',
			'password' => 'required',
		]);

		$user_data = [
			//'username' => request('username'),
			'email'	   => request('email'),
		];

		if (Auth::attempt(request('email'))) {
			return msg_success('login');
		} else {
			return msg_error('invalid');
		}
	}

	public function logout()
	{
		return 'logout';
	}

	/* Register

		return Validator::make($data, [
			'username' => ['required', 'string', 'min:3', 'max:255', 'unique:users', 'alpha_dash'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
	*/
}