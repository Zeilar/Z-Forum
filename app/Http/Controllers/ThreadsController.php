<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TableSubcategory;
use App\Thread;
use App\Post;
use Auth;

class ThreadsController extends Controller
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
		if (!auth()->user()) abort(403);

		// if the found subcategory doesn't match the URI title, or if it doesn't exist at all, throw 404
		$subcategory = TableSubcategory::find($id);
		if (($subcategory && $subcategory->title !== $title) || !$subcategory) return abort(404);

        return view('threads.create', [
			'subcategory' => TableSubcategory::find($id),
		]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
		$data = request()->validate([
			'title' => 'required|regex:/^[a-zA-Z0-9]+$/u|max:100'
		]);

        $thread = new Thread();

		$thread->title = request('title');
		$thread->user_id = 1;
		$thread->table_subcategory_id = 2;
		$thread->save();

		return redirect("/thread/$thread->title-$thread->id");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($title, $id)
    {
		return view('threads.single', [
			'posts' => Thread::find($id)->posts,
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
