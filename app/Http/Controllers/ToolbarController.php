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

		// Get user id via input, whether it's id directly or username
		$user = User::find(request('user')) ?? User::where('username', request('user'))->first() ?? null;

		if (isset($user)) {
            if ($user->id === auth()->user()->id) {
                return msg_error(__('You are already logged in to this account'));
            } else {
                Auth::loginUsingId($user->id, true);
            }
        } else {
            return msg_error(__('That user does not exist'));
        }

		return redirect()->back();
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