<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GarbageController extends Controller
{
    public function show(Request $request) {
        return view('layouts.garbage', ['garbage' => \App\Post::onlyTrashed()->get()]);
    }
}