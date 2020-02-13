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
	public function superadmin()
	{
		return view('dashboard.superadmin', [
			'tableSubcategories' => TableSubcategory::all(),
			'tableCategories' => TableCategory::all(),
			'threads' => Thread::all(),
			'posts' => Post::all(),
			'users' => User::all(),
		]);
	}

	public function account()
	{
		return view('dashboard.account');
	}
}
