<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{
	Subcategory,
	Category,
	Thread,
	Post,
	User
};

class SearchController extends Controller
{
    public function search(Request $request)
	{
		return view('layouts.search');
	}

	// TODO: Search
}