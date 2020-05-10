<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{
	UserVisitedMessage,
	UserMessage,
	Subcategory,
	Category,
	Thread,
	Post,
	User
};
use DB;

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
            $messages = DB::table('user_messages')
            ->where('deleted_at', null)
            ->where('author_id', auth()->user()->id)
            ->orWhere('recipient_id', auth()->user()->id)
            ->orderByDesc('created_at')
            ->paginate(settings_get('posts_per_page'));
			return view('dashboard.messages', ['user' => auth()->user(), 'messages' => $messages]);
		} else {
			return msg_error('login');
		}
	}

	public function message(Request $request)
	{
		$message = UserMessage::find(request('id'));
        $this->authorize('create', $message);

		if (!logged_in()) {
			return msg_error('login');
		} else if (empty($message)) {
			return view('errors.404');
		} else {
			if (auth()->user()->id === $message->author->id || auth()->user()->id === $message->recipient->id) {
				if (!UserVisitedMessage::where(['user_id' => auth()->user()->id, 'user_message_id' => $message->id])->count()) {
					UserVisitedMessage::create([
						'user_id' => auth()->user()->id,
						'user_message_id' => $message->id,
					]);
				}

				return view('message.single', ['message' => $message]);
			} else {
				return view('errors.403');
			}
		}
	}

	public function message_create()
	{
        $this->authorize('create', UserMessage::class);

		if (logged_in()) {
            if (auth()->user()->is_suspended()) {
                return msg_error(__('You are suspended'));
            }
			return view('message.new');
		} else {
			return msg_error('login');
		}
	}

	public function message_send()
	{
        $this->authorize('create', UserMessage::class);

		if (!logged_in()) {
			return msg_error('login');
		} else if (auth()->user()->is_suspended()) {
            return msg_error(__('You are suspended'));
        }

		request()->validate([
			'title'   	=> 'required|string|min:3|max:100',
			'recipient' => 'required|exists:users,username',
			'content' 	=> 'required|string|min:3|max:500',
		]);

		$recipient = User::where('username', request('recipient'))->first();

		$message = UserMessage::create([
			'title' 	   => request('title'),
			'content' 	   => request('content'),
			'recipient_id' => $recipient->id,
			'author_id'    => auth()->user()->id,
		]);

        UserVisitedMessage::create([
            'user_id' => auth()->user()->id,
            'user_message_id' => $message->id,
        ]);

		return redirect(route('dashboard_messages'))->with('success', __('Message was successfully sent'));
	}

    public function message_delete(Request $request, $id) {
        if (!logged_in()) return msg_error('login');

        $message = UserMessage::find($id);
        $this->authorize('delete', $message);

        if (empty($message)) return msg_error(__('That message does not exist'));

        $message->delete();

        return redirect(route('index'));
    }

    public function message_restore(Request $request, $id) {
        if (!logged_in()) return msg_error('login');

        $message = UserMessage::onlyTrashed()->find($id);
        $this->authorize('restore', $message);

        if (empty($message)) return msg_error(__('That message does not exist'));

        $message->restore();

        return redirect()->back();
    }
}