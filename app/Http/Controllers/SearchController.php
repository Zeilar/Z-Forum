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
		request()->validate([
			'query' => 'required|min:3|max:30',
		]);

		$query = request('query');

		$subcategories = DB::table('subcategories')->select('table_name', 'id')->where('title', 'like', "%$query%");
		$categories    = DB::table('categories')->select('table_name', 'id')->where('title', 'like', "%$query%");
		$threads       = DB::table('threads')->select('table_name', 'id')->where('title', 'like', "%$query%");
		$posts         = DB::table('posts')->select('table_name', 'id')->where('content', 'like', "%$query%");
		$results       = DB::table('users')
			->select('table_name', 'id')
			->where('username', 'like', "%$query%")->orWhere('role', 'like', "%$query%")
			->union($subcategories)->union($categories)->union($threads)->union($posts)
			->paginate(settings_get('posts_per_page'));

		return view('layouts.search', ['results' => $results]);
	}
}