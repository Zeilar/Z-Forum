<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{
	UserMessage,
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

	public function messages()
	{
		if (logged_in()) {
			return view('dashboard.messages', ['user' => auth()->user()]);
		} else {
			return msg_error('login');
		}
	}

	public function message(Request $request)
	{
		$message = UserMessage::find(request('id'));

		if (!logged_in()) {
			return msg_error('login');
		} else if (empty($message)) {
			return view('errors.404');
		} else {
			if (auth()->user()->id === $message->author->id || auth()->user()->id === $message->recipient->id) {
				return view('message.single', ['message' => $message]);
			} else {
				return view('errors.403');
			}
		}
	}

	public function message_create()
	{
		if (logged_in()) {
			return view('message.new');
		} else {
			return msg_error('login');
		}
	}

	public function message_send()
	{
		if (!logged_in()) {
			return msg_error('login');
		}

		request()->validate([
			'title'   	=> 'required|string|min:3|max:50',
			'recipient' => 'required|exists:users,username',
			'content' 	=> 'required|string|min:3|max:500',
		]);
	}
}