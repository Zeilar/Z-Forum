<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GarbageController extends Controller
{
    public function show(Request $request) {
        return view('layouts.garbage', [
            'subcategories' => \App\Subcategory::onlyTrashed()->get(),
            'chat_messages' => \App\ChatMessage::onlyTrashed()->get(),
            'user_messages' => \App\UserMessage::onlyTrashed()->get(),
            'categories' => \App\Category::onlyTrashed()->get(),
            'threads' => \App\Thread::onlyTrashed()->get(),
            'posts' => \App\Post::onlyTrashed()->get(),
        ]);
    }
}