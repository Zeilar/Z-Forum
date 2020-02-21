<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{
	TableSubcategory,
	TableCategory,
	Thread,
	Post,
	User
};

class DashboardController extends Controller
{
	public function index()
	{
		if (logged_in()) {
			return view('dashboard.index', [
				'tableSubcategories' => TableSubcategory::all(),
				'tableCategories' => TableCategory::all(),
				'threads' => Thread::all(),
				'posts' => Post::all(),
				'users' => User::all(),
			]);
		} else {
			return msg_error('login');
		}
	}

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
		return view('dashboard.account');
	}
	
	public function mass_delete(Request $request)
	{
		return request();
	}
}