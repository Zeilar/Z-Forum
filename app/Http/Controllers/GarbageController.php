<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{
    UserMessage,
    ChatMessage,
	Subcategory,
	Category,
	Thread,
	Post,
};
use DB;

class GarbageController extends Controller
{
    public function show(Request $request) {
        if (!logged_in()) return msg_error('login');
        if (!is_role('superadmin')) return msg_error('role');
        
        return view('layouts.garbage', [
            'subcategories' => Subcategory::onlyTrashed()->get(),
            'chat_messages' => ChatMessage::onlyTrashed()->get(),
            'user_messages' => UserMessage::onlyTrashed()->get(),
            'categories' => Category::onlyTrashed()->get(),
            'threads' => Thread::onlyTrashed()->get(),
            'posts' => Post::onlyTrashed()->get(),
        ]);
    }
}