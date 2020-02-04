<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;
use App\Post;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('posts.index', [
			'posts' => Post::orderBy('id', 'desc')->paginate(1),
		]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($title, $id)
    {
        if (!auth()->user()) abort(403);

		// if the found thread doesn't match the URI title, or if it doesn't exist at all, throw 404
		$thread = Thread::find($id);
		if (($thread && $thread->title !== $title) || !$thread) return abort(404);

        return view('posts.create', [
			'thread' => Thread::find($id),
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
        if (!auth()->user()) abort(403);

		$data = request()->validate([
			'content' => 'required|max:500'
		]);

        $post = new Post();

		$post->content = request('content');
		$post->user_id = auth()->user()->id;
		$post->thread_id = Thread::find($id)->id;
		$post->save();

		return redirect("/post/$post->id");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('posts.single', [
			'post' => Post::find($id),
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
