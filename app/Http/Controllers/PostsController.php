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
			: view('errors.404')
		);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id, $slug)
    {
        if (logged_in()) {
			if (item_exists(Thread::find($id), $slug)) {
				return view('post.create', ['thread' => Thread::find($id)]);
			} else {
				return view('errors.404', ['value' => urldecode($slug)]);
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
    public function store(Request $request, $id, $slug)
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

				return redirect(route('thread_show', [$thread->id, $thread->slug]));
			} else {
				return view('errors.404', ['value' => urldecode($slug)]);
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
    public function show($id)
    {
		if (Post::find($id)) {
			return view('post.single', [
				'post' => Post::find($id),
			]);
		} else {
			return view('errors.404');
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
				if (Post::find($id)->user_id === auth()->user()->id || is_role('superadmin')) {
					return vieW('post.edit', [
						'post' => Post::find($id),
					]);
				} else {
					return msg_error('role');
				}
			} else {
				return view('errors.404');
			}
		} else {
			return msg_error('login');
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
				if (Post::find($id)->user_id === auth()->user()->id || is_role('superadmin')) {
					$data = request()->validate([
						'content' => 'required|max:500'
					]);

					$post = Post::find($id);
					$post->content = request('content');
					$post->save();

					return redirect(route('post_show', [$post->thread->id, $post->thread->slug, $post->id]));
				} else {
					return msg_error('role');
				}
			} else {
				return view('errors.404');
			}
		} else {
			return msg_error('login');
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
				if (Post::find($id)->user_id === auth()->user()->id || is_role('superadmin', 'moderator')) {
					$post = Post::find($id);
					$thread = $post->thread;
					$post->delete();
					return redirect(route('thread_show', [$thread->id, $thread->slug]));
				} else {
					return msg_error('role');
				}
			} else {
				return view('errors.404');
			}
		} else {
			return msg_error('login');
		}
    }
}