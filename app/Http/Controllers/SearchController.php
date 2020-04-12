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
		$query = request('search');

		$subcategories = Subcategory::where('title', 'like', "%$query%")->orderBy('updated_at')->get();
		$categories    = Category::where('title', 'like', "%$query%")->orderBy('updated_at')->get();
		$threads       = Thread::where('title', 'like', "%$query%")->orderBy('updated_at')->get();
		$posts         = Post::where('content', 'like', "%$query%")->orderBy('updated_at')->get();
		$users         = User::where('username', 'like', "%$query%")->orderBy('updated_at')->get();

		$results = [
			'subcategories' => $subcategories,
			'categories' 	=> $categories,
			'threads' 		=> $threads,
			'posts'			=> $posts,
			'users' 		=> $users,
		];

		return view('layouts.search', ['results' => $results]);
	}
}