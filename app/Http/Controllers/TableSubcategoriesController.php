<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TableSubcategory;
use App\TableCategory;

class TableSubcategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($title, $id)
    {
		if (logged_in()) {
			if (is_role('superadmin')) {
				if (item_exists(TableCategory::find($id), $title)) {
					return view('table_subcategory.create', [
						'tableCategory' => TableCategory::find($id),
					]);
				}
			} else {
				return redirect()->back()->with('error', __('Insufficient permissions'));
			}
		} else {
			return redirect()->back()->with('error', __('Please log in and try again'));
		}
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $title, $id)
    {
		if (logged_in()) {
			if (is_role('superadmin')) {
				$data = request()->validate([
					'title' => 'required|max:30',
				]);

				$tableSubcategory = new TableSubcategory();
				$tableSubcategory->title = request('title');
				$tableSubcategory->table_category_id = TableCategory::find($id)->id;
				$tableSubcategory->save();

				return redirect(route('tablesubcategory_show', [$tableSubcategory->title, $tableSubcategory->id]));
			} else {
				return redirect()->back()->with('error', __('Insufficient permissions'));
			}
		} else {
			return redirect()->back()->with('error', __('Please log in and try again'));
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($title, $id)
    {
		if (item_exists(TableSubcategory::find($id), $title)) {
			return view('table_subcategory.single', [
				'tableSubcategory' => TableSubcategory::find($id),
			]);
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