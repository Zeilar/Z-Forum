<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ProfileController extends Controller
{
    public function index($user)
	{
		return view('home', [
			'user' => User::find($user),
		]);
	}
}