<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{
	Subcategory,
	Category,
	Thread,
	Post,
	User,
};
use DB;

class SearchController extends Controller
{
    public function search(Request $request)
	{
		$query = request('search');

		$subcategories = DB::table('subcategories')->select('title')->where('title', 'like', "%$query%");
		$categories    = DB::table('categories')->select('title')->where('title', 'like', "%$query%");
		$threads       = DB::table('threads')->select('title')->where('title', 'like', "%$query%");
		$posts         = DB::table('posts')->select('content')->where('content', 'like', "%$query%");
		$users         = DB::table('users')->select('username')->where('username', 'like', "%$query%")
			->union($subcategories)
			->union($categories)
			->union($threads)
			->union($posts)
			->paginate(3);

		

		$results2 = [
			'subcategories' => $subcategories,
			'categories' 	=> $categories,
			'threads' 		=> $threads,
			'posts'			=> $posts,
			'users' 		=> $users,
		];

		return view('layouts.search', ['results' => $users]);
	}
}