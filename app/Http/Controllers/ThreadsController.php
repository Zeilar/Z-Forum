<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TableSubcategory;
use App\Thread;
use App\Post;
use App\TableCategory;

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
		if (logged_in()) {
			if (item_exists(TableSubcategory::find($id), $title)) {
				return view('thread.create', [
					'subcategory' => TableSubcategory::find($id),
				]);
			}
		} else {
			return redirect()->back()->with('error', 'You must be logged in to do that');
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
			$data = request()->validate([
				'title' => 'required|max:100',
				'content' => 'required|max:500',
			]);

			$thread = new Thread();
			$thread->title = request('title');
			$thread->user_id = auth()->user()->id;
			$thread->table_subcategory_id = TableSubcategory::find($id)->id;
			$thread->save();

			$post = new Post();
			$post->content = request('content');
			$post->user_id = auth()->user()->id;
			$post->thread_id = $thread->id;
			$post->save();

			return redirect(route('thread_show', [$thread->title, $thread->id]));
		} else {
			return redirect()->back()->with('error', 'You must be logged in to do that');
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
		if (item_exists(Thread::find($id), $title)) {
			return view('thread.single', [
				'thread' => Thread::find($id),
				'posts' => Post::where('thread_id', $id)->paginate(1),
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