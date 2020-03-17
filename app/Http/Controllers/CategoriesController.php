<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Post;

class CategoriesController extends Controller
{
	/**
	 * Error handling for various table category actions
	 * 
	 * @param  int $id
	 * @return mixed
	 */
	public function category_validation() 
	{
		if (!logged_in()) {
			return msg_error('login');
		} else if (!is_role('superadmin')) {
			return msg_error('role');
		} else {
			return true;
		}
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('index', [
			'tableCategories' => Category::all(),
		]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		if ($this->category_validation() !== true) {
			return $this->category_validation();
		} else {
			return view('category.create');
		}
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		if ($this->category_validation() !== true) {
			return $this->category_validation();
		} else {
			request()->validate([
				'title' => 'required|max:30|unique:categories',
			]);

			$category = new Category();
			$category->title = request('title');
			$category->slug = urlencode(request('title'));
			$category->save();

			return redirect()->route('category_show', [$category->id, $category->slug]);
		}
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
			return view('category.single', [
				'category' => Category::find($id),
			]);
		} else {
			return view('errors.404', ['value' => urldecode($slug)]);
		}
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id, string $slug)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id, string $slug)
    {
        //
    }
}