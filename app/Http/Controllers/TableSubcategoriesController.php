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
        if (auth()->user()->role !== 'Superadmin') abort(403);
        return view('table_subcategory.create', [
			'tableCategory' => TableCategory::find($id),
		]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $title, $id)
    {
        if (auth()->user()->role !== 'Superadmin') abort(403);

		$data = request()->validate([
			'title' => 'required|max:30',
		]);

        $tableSubcategory = new TableSubcategory();
		$tableSubcategory->title = request('title');
		$tableSubcategory->table_category_id = TableCategory::find($id)->id;
		$tableSubcategory->save();

		return redirect(route('tablesubcategory_show', [$tableSubcategory->title, $tableSubcategory->id]));
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
		$subcategory = TableSubcategory::find($id);
		if (($subcategory && $subcategory->title !== $title) || !$subcategory) return abort(404);

        return view('table_subcategory.single', [
			'tableSubcategory' => TableSubcategory::find($id),
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
