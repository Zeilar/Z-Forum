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

		$user = [
			//'username' => request('username'),
			'email'	   => request('email'),
			'password' => request('password'),
		];

		if (Auth::attempt($user)) {
			return msg_success('login');
		} else {
			return msg_error('invalid');
		}
	}

	public function logout()
	{
		Auth::logout();
		return redirect(route('index'));
	}

	/* Register

		return Validator::make($data, [
			'username' => ['required', 'string', 'min:3', 'max:255', 'unique:users', 'alpha_dash'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
	*/
}