<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TableCategory;
use App\Post;

class TableCategoriesController extends Controller
{
	/**
	 * Error handling for various table category actions
	 * 
	 * @param  int $id
	 * @return mixed
	 */
	public function tablecategory_validation() 
	{
		if (!logged_in()) {
			return msg_error('login');
		} elseif (!is_role('superadmin')) {
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
			'tableCategories' => TableCategory::all(),
			'latest_posts' => Post::orderBy('updated_at')->take(5)->get(),
		]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		if ($this->tablecategory_validation() !== true) {
			return $this->tablecategory_validation();
		} else {
			return view('table_category.create');
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
		if ($this->tablecategory_validation() !== true) {
			return $this->tablecategory_validation();
		} else {
			$data = request()->validate([
				'title' => 'required|max:30',
			]);

			$tableCategory = new TableCategory();
			$tableCategory->title = request('title');
			$tableCategory->slug = urlencode(request('title'));
			$tableCategory->save();

			return redirect()->route('tablecategory_show', [$tableCategory->id, $tableCategory->slug]);
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
		if (item_exists(TableCategory::find($id), $slug)) {
			return view('table_category.single', [
				'tableCategory' => TableCategory::find($id),
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