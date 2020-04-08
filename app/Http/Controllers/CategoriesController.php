<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\ActivityLog;
use App\Category;
use App\Post;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('index', ['tableCategories' => Category::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$this->authorize('create', Category::class);

		request()->validate([
			'title' => 'required|min:3|max:40|unique:categories',
			'icon'  => 'required',
		]);

		// Store the file and use the path for the database
		$path = $request->file('icon')->store('/public/icons');

		$category = new Category();
		$category->title = request('title');
		$category->slug = urlencode(request('title'));
		$category->icon = explode('icons/', $path)[1];
		$category->save();

		ActivityLog::create([
			'user_id' 	   => auth()->user()->id,
			'task'	  	   => __('created'),
			'performed_on' => json_encode([['table' => 'categories'], ['id' => $category->id]]),
		]);

		return redirect()->route('category_show', [$category->id, $category->slug]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id, string $slug)
    {
		if (item_exists(Category::find($id), $slug)) {
			return view('category.single', ['category' => Category::find($id)]);
		} else {
			return view('errors.404', ['value' => urldecode($slug)]);
		}
    }

	/**
     * Update the specified resource in storage, using AJAX.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
	public function update(Request $request)
	{
		
	}
}