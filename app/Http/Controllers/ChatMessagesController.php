<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ChatMessage;
use \Carbon\Carbon;

class ChatMessagesController extends Controller
{
    public function send() {
        if (!logged_in()) {
            return response()->json([
                'error' => true,
            ]);
        }

        $user = auth()->user();

        if ($user->is_suspended()) {
            return response()->json([
                'error'   => true,
                'message' => __('You are suspended'),
            ]);
        } else if ($user->chat_messages()->where('created_at', '>=', \Carbon\Carbon::now()->subSeconds(30))->count() >= 5) {
            return response()->json([
                'error'   => true,
                'message' => __('Wait a moment before you post again'),
            ]);
        } else if (request('content') === null || request('content') === '' || request('content') === false) {
            return response()->json([
                'error' => true,
            ]);
        } else if (strlen(request('content')) >= 100) {
            return response()->json([
                'error'   => true,
                'message' => __('Message must not exceed 100 characters'),
            ]);
        }

        $message = ChatMessage::create([
            'user_id' => $user->id,
            'content' => request('content'),
        ]);

        $author = '<a class="' . role_coloring($user->role) . '" href="' . route('user_show', [$user->id]) . '">' . $user->username . '</a>';

        return response()->json([
            'error'     => false,
            'author'    => $author,
            'id'        => $message->id,
            'timestamp' => pretty_date($message->created_at),
            'content'   => request('content'),
        ]);
    }

    public function update() {        
        if (ChatMessage::orderByDesc('id')->first()->id !== (int)request('latest_msg')) {
            $message = ChatMessage::orderByDesc('id')->first();
            $user = $message->user;
            $author = '<a class="' . role_coloring($user->role) . '" href="' . route('user_show', [$user->id]) . '">' . $user->username . '</a>';

            return response()->json([
                'update'    => true,
                'message'   => $message,
                'timestamp' => pretty_date($message->created_at),
                'author'    => $author,
            ]);
        } else {
            return response()->json([
                'update' => false,
            ]);
        }
    }

    public function remove() {
        if (!logged_in()) {
            return response()->json([
                'openModal' => true,
            ]);
        }

        $message = ChatMessage::find(request('msgId'));

        if (empty($message)) {
            return;
        }
        
        if ((int)$message->user_id !== auth()->user()->id) {
            if (!is_role('superadmin', 'moderator')) {
                return;
            }
        }

        $messageId = $message->id;
        $message->delete();

        return response()->json([
            'removedMsg' => $messageId,
        ]);
    }

    public function restore(Request $request, $id) {
        $message = ChatMessage::onlyTrashed()->find($id);

        if (empty($message)) return msg_error(__('That message does not exist'));

        $message->restore();

        return redirect()->back();
    }
}