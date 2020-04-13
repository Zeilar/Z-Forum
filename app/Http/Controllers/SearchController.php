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

		$subcategories = DB::table('subcategories')->select('table_name', 'id')->where('title', 'like', "%$query%");
		$categories    = DB::table('categories')->select('table_name', 'id')->where('title', 'like', "%$query%");
		$threads       = DB::table('threads')->select('table_name', 'id')->where('title', 'like', "%$query%");
		$posts         = DB::table('posts')->select('table_name', 'id')->where('content', 'like', "%$query%");
		$users         = DB::table('users')->select('table_name', 'id')->where('username', 'like', "%$query%")
			->union($subcategories)->union($categories)->union($threads)->union($posts)
			->paginate(3);

		return view('layouts.search', ['results' => $users]);
	}
}