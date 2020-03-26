<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class ToolbarController extends Controller
{
    public function spoof_login(Request $request)
	{
		$id = User::find(request('user'))->id ?? User::where('username', request('user'))->get()[0]->id ?? null;

		if (isset($id)) {
			Auth::loginUsingId($id, true);
		}
	}
}