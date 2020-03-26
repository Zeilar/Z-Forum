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
		$id = User::find(request('user'))->id ?? User::where('username', request('user'))->get()[0]->id ?? null;

		if (isset($id)) {
			Auth::loginUsingId($id, true);
		}
		return redirect(url()->previous());
	}

	public function toggle_maintenance_mode(Request $request)
	{
		$this->authorize('update', MaintenanceMode::all()[0]);

		$mode = MaintenanceMode::all()[0];

		if ($mode->enabled) {
			$mode->enabled = false;
		} else {
			$mode->enabled = true;
		}
		$mode->save();

		return redirect(url()->previous());
	}
}