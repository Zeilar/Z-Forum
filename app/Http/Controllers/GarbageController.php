<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
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
            'subcategories' => Subcategory::onlyTrashed()->whereHas('category', function(Builder $query) {
                $query->where('deleted_at', null);
            })->get(),
            'threads' => Thread::onlyTrashed()->whereHas('subcategory', function(Builder $query) {
                $query->where('deleted_at', null);
            })->get(),
            'posts' => Post::onlyTrashed()->whereHas('thread', function(Builder $query) {
                $query->where('deleted_at', null);
            })->get(),
            'chat_messages' => ChatMessage::onlyTrashed()->get(),
            'user_messages' => UserMessage::onlyTrashed()->get(),
            'categories'    => Category::onlyTrashed()->get(),
        ]);
    }
}