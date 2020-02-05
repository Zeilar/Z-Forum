<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TableCategory;
use App\TableSubcategory;

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
		]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($title, $id)
    {
		if (auth()->user()->role !== 'Superadmin') abort(403);
        return view('table_category.create', [
			'tableCategory' => TableCategory::find($id),
		]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (auth()->user()->role !== 'Superadmin') abort(403);

		$data = request()->validate([
			'title' => 'required|max:30',
		]);

        $tableCategory = new TableCategory();
		$tableCategory->title = request('title');
		$tableCategory->save();

		return redirect(route('index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($title, $id)
    {
		// if the found subcategory doesn't match the URI title, or if it doesn't exist at all, throw 404
		$tableCategory = TableCategory::find($id);
		if (($tableCategory && $tableCategory->title !== $title) || !$tableCategory) return abort(404);

		return view('table_category.single', [
			'tableCategory' => TableCategory::find($id),
		]);
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
