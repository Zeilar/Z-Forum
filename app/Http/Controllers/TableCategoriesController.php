<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TableSubcategory;
use App\TableCategory;
use App\Post;

class TableCategoriesController extends Controller
{
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
		if (logged_in()) {
			if (is_role('superadmin')) {
				return view('table_category.create');
			} else {
				return msg_error('role');
			}
		} else {
			return msg_error('login');
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
		if (logged_in()) {
			if (is_role('superadmin')) {
				$data = request()->validate([
					'title' => 'required|max:30',
				]);

				$tableCategory = new TableCategory();
				$tableCategory->title = request('title');
				$tableCategory->slug = urlencode(request('title'));
				$tableCategory->save();

				return redirect()->route('tablecategory_show', [$tableCategory->id, $tableCategory->slug]);
			} else {
				return msg_error('role');
			}
		} else {
			return msg_error('login');
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $slug)
    {
		if (item_exists(TableCategory::find($id), $slug)) {
			return view('table_category.single', [
				'tableCategory' => TableCategory::find($id),
			]);
		} else {
			return view('errors.404', ['value' => $slug]);
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}