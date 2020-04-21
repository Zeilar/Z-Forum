<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{
	Subcategory,
	Category,
	Thread,
	Post,
	User
};

class DashboardController extends Controller
{
	public function account()
	{
		if (logged_in()) {
			return view('dashboard.account', ['user' => auth()->user()]);
		} else {
			return msg_error('login');
		}
	}
}