<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MaintenanceMode;
use App\User;
use Auth;

class ToolbarController extends Controller
{
    public function spoof_login(Request $request)
	{
		$this->authorize('delete', User::find(1));

		// If target user is equal to the logged in user, do nothing
		if (request('id') === auth()->user()->id) return;

		// Get user id via input, whether it's id directly or username
		$id = User::find(request('user'))->id ?? User::where('username', request('user'))->get()[0]->id ?? null;

		if (isset($id)) {
			Auth::loginUsingId($id, true);
		}
		return redirect(url()->previous());
	}

	public function toggle_maintenance_mode(Request $request)
	{
		$this->authorize('update', MaintenanceMode::find(1));

		$mode = MaintenanceMode::find(1);

		if ($mode->enabled) {
			$mode->enabled = false;
		} else {
			$mode->enabled = true;
		}
		$mode->save();

		return redirect(url()->previous());
	}
}