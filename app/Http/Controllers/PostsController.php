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
    public function index($id)
    {
		return (Post::find($id)
			? view('post.single', ['post' => Post::find($id)])
			: abort(404)
		);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($title, $id)
    {
        if (logged_in()) {
			if (item_exists(Thread::find($id), $title)) {
				return view('post.create', ['thread' => Thread::find($id)]);
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
			if (Thread::find($id)) {
				$data = request()->validate([
					'content' => 'required|max:500'
				]);

				$thread = Thread::find($id);
				$post = new Post();
				$post->content = request('content');
				$post->user_id = auth()->user()->id;
				$post->thread_id = $thread->id;
				$post->save();

				return redirect(route('thread_show', [$thread->title, $thread->id]));
			} else {
				return abort(404);
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
    public function show($id)
    {
		if (Post::find($id)) {
			return view('post.single', [
				'post' => Post::find($id),
			]);
		} else {
			return abort(404);
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
		if (logged_in()) {
			if (Post::find($id)) {
				if (Post::find($id)->user_id === auth()->user()->id) {
					return vieW('post.edit', [
						'post' => Post::find($id),
					]);
				} else {
					return redirect()->back()->with('error', __('Insufficient permissions'));
				}
			} else {
				return abort(404);
			}
		} else {
			return redirect()->back()->with('error', __('Please log in and try again'));
		}
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
        if (logged_in()) {
			if (Post::find($id)) {
				if (Post::find($id)->user_id === auth()->user()->id) {
					$data = request()->validate([
						'content' => 'required|max:500'
					]);

					$post = Post::find($id);
					$post->content = request('content');
					$post->save();

					return redirect(route('post_show', [$post->thread->title, $post->thread->id, $post->id]))->with('success', __('Post updated'));
				} else {
					return redirect()->back()->with('error', __('Insufficient permissions'));
				}
			} else {
				return abort(404);
			}
		} else {
			return redirect()->back()->with('error', __('Please log in and try again'));
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (logged_in()) {
			if (Post::find($id)) {
				if (Post::find($id)->user_id === auth()->user()->id) {
					$post = Post::find($id);
					$thread = $post->thread;
					$post->delete();
					return redirect(route('thread_show', [$thread->title, $thread->id]))->with('success', __('Post was successfully deleted'));
				} else {
					return redirect()->back()->with('error', __('Insufficient permissions'));
				}
			} else {
				return abort(404);
			}
		} else {
			return redirect()->back()->with('error', __('Please log in and try again'));
		}
    }
}
