<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Socialite;
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
			return redirect()->back()->with('success', __('Successfully logged in'));
		} else {
			// If a user exists with the input username/email and the login failed, the password was incorrect
			if (count(User::where('username', request('id'))->orWhere('email', request('id'))->get())) {
				return msg_error('incorrect-password')->withInput($request->except('password'));
			}
			return msg_error('incorrect-id');
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
				'username' => 'required|string|min:3|max:15|unique:users|alpha_dash',
				'email'	   => 'required|string|min:3|max:30|unique:users|email',
				'password' => 'required|string|min:6|max:30|confirmed',
			],
			[
				// Custom error messages, ordered by priority
				'username.required' 	=> __('Username is required'),
				'password.required' 	=> __('Password is required'),
				'email.required' 		=> __('Email is required'),
				'username.unique' 		=> __('That username has already been taken'),
				'email.unique' 			=> __('That email has already been taken'),
				'email.email'			=> __('Invalid email'),
				'username.alpha_dash'	=> __('Username must consist of alphabetic and numeric characters'),
				'username.min'	 		=> __('Username must be at least 3 characters long'),
				'password.min'	 		=> __('Password must be at least 6 characters long'),
				'email.min'	 			=> __('Email must be at least 3 characters long'),
				'username.max'			=> __('Username must not exceed 30 characters'),
				'password.max'			=> __('Password must not exceed 30 characters'),
				'email.max'				=> __('Email must not exceed 30 characters'),
				'password.confirmed'	=> __('Passwords did not match'),
			]
		);

		// If validation checks out, create our new user
		User::create([
			'username' => request('username'),
			'email'	   => request('email'),
			'password' => Hash::make(request('password')),
		]);

		// Try to log in with the newly created user - careful not to use the hashed password when attempting to authenticate
		$data = [
			'email'	   => request('email'),
			'password' => request('password'),
		];

		if (Auth::attempt($data)) {
			return msg_success('login');
		} else {
			return msg_error('incorrect');
		}
	}

	// Log out
	public function logout()
	{
		Auth::logout();
		return redirect(route('index'));
	}

	public function admin_login_page()
	{
		if (!logged_in()) {
			return view('layouts.admin-login');
		} else {
			return view('errors.405');
		}
	}

	public function admin_login(Request $request)
	{
		// Validation
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

		// Check if the provided user exists and if that user is an admin
		$user = User::where('username', request('id'))->orWhere('email', request('id'))->first();
		if (count($user)) {
			if ($user->role !== 'superadmin') {
				return msg_error(__('You must be an administrator to proceed'), 'error-id');
			}
		}

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
			return redirect(route('index'))->with('success', __('Successfully logged in'));
		} else {
			// If a user exists with the input username/email and the login failed, the password was incorrect
			if (count(User::where('username', request('id'))->orWhere('email', request('id'))->get())) {
				return msg_error('incorrect-password')->withInput($request->except('password'));
			}
			return msg_error('incorrect-id');
		}
	}

	/**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
	public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        try {
            $user = Socialite::driver('github')->user();
        } catch (Exception $e) {
            return redirect(route('index'));
        }

        $authUser = $this->findOrCreateUser($user);

        Auth::login($authUser, true);

        return redirect(route('index'));
    }

    /**
     * Return user if exists; create and return if doesn't
     *
     * @param $githubUser
     * @return User
     */
    private function findOrCreateUser($githubUser)
    {
        if ($authUser = User::where('github_id', $githubUser->id)->first()) {
            return $authUser;
        }

        return User::create([
            'github_id' => $githubUser->id,
			'username' => $githubUser->name,
            'email' => $githubUser->email,
            'avatar' => $githubUser->avatar
        ]);
    }
}