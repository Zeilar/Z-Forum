<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserVisitedThreads;
use App\Thread;

class UserVisitedThreadsController extends Controller
{
	public function mark_as_read(Request $request)
	{
		if (!logged_in()) {
			return response()->json([
				'type'	  => 'error',
				'message' => __('Insufficient permissions'),
			]);
		}

		$user_id = auth()->user()->id;
		$threads = Thread::where(request('collection'), request('id'))->get();

		foreach ($threads as $thread) {
			UserVisitedThreads::create([
				'user_id' 	=> $user_id,
				'thread_id' => $thread->id,
			]);
		}

		return response()->json([
			'type' => 'success',
		]);
	}
}