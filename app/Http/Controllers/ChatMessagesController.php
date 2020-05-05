<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ChatMessage;
use \Carbon\Carbon;

class ChatMessagesController extends Controller
{
    public function send() {
        if (!logged_in()) {
            return msg_error('login');
        }

        $user = auth()->user();
        
        if ($user->chat_messages()->where('created_at', '>=', \Carbon\Carbon::now()->subSeconds(30))->count() >= 5) {
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

        ChatMessage::create([
            'user_id' => $user->id,
            'content' => request('content'),
        ]);

        $author = '<a class="' . role_coloring($user->role) . '" href="' . route('user_show', [$user->id]) . '">' . $user->username . '</a>';

        return response()->json([
            'error'   => false,
            'author'  => $author,
            'content' => request('content'),
        ]);
    }
}