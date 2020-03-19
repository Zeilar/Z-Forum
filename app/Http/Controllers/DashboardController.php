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
	public function superadmin()
	{
		if (logged_in()) {
			if (is_role('superadmin')) {
				return view('dashboard.superadmin');
			} else {
				return msg_error('role');
			}
		} else {
			return msg_error('login');
		}
	}

	public function account()
	{
		if (logged_in()) {
			return view('dashboard.account');
		} else {
			return msg_error('login');
		}
	}
}