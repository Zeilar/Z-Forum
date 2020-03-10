<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TableSubcategory;
use App\TableCategory;
use App\Thread;
use App\Post;

class PostsController extends Controller
{
	/**
	 * Error handling for various post actions
	 * 
	 * @param  int $id
	 * @return mixed
	 */
	public function post_validation(int $id) 
	{
		if (!logged_in()) {
			return msg_error('login');
		} elseif (!Post::find($id)) {
			return view('errors.404');
		} elseif (Post::find($id)->user_id !== auth()->user()->id) {
			if (is_role('superadmin', 'moderator')) {
				return true;
			} else {
				return msg_error('That post does not belong to you');
			}
		} elseif (Post::find($id)->thread->locked) {
			if (is_role('superadmin', 'moderator')) {
				return true;
			} else {
				return msg_error('locked');
			}
		} else {
			return true;
		}
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
		return Post::find($id) ? view('post.single', ['post' => Post::find($id)]) : view('errors.404');
    }

    /**
     * Show the form for creating a new resource.
     *
	 * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function create(int $id, string $slug)
    {
		if (!logged_in()) {
			return msg_error('login');
		} elseif (!item_exists(Thread::find($id), $slug)) {
			return view('errors.404', ['value' => urldecode($slug)]);
		} elseif (Thread::find($id)->locked) {
			return msg_error('locked');
		} else {
			return view('post.create', ['thread' => Thread::find($id)]);
		}
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, int $id, string $slug)
    {
		if (!logged_in()) {
			return msg_error('login');
		} elseif (!Thread::find($id)) {
			return view('errors.404', ['value' => urldecode($slug)]);
		} elseif (Thread::find($id)->locked) {
			return msg_error('locked');
		} else {
			$data = request()->validate([
				'content' => 'required|max:500'
			]);

			$thread = Thread::find($id);
			$post = new Post();
			$post->content = request('content');
			$post->user_id = auth()->user()->id;
			$post->thread_id = $thread->id;
			$post->table_subcategory_id = $thread->tableSubcategory->id;
			$post->table_category_id = $thread->tableCategory->id;
			$post->save();

			return redirect(route('thread_show', [$thread->id, $thread->slug]));
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
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
    public function edit(int $id)
    {
		if ($this->post_validation($id) !== true) {
			return $this->post_validation($id);
		} else {
			return view('post.edit', [
				'post' => Post::find($id),
			]);
		}
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
		if ($this->post_validation($id) !== true) {
			return $this->post_validation($id);
		} else {
			$data = request()->validate([
				'content' => 'required|max:500'
			]);

			$post = Post::find($id);
			$post->content = request('content');
			$post->save();

			return redirect(route('post_show', [$post->thread->id, $post->thread->slug, $post->id]));
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
		if ($this->post_validation($id) !== true) {
			return $this->post_validation($id);
		} else {
			$post = Post::find($id);
			$thread = $post->thread;
			$post->delete();
			
			return redirect(route('thread_show', [$thread->id, $thread->slug]));
		}
    }
}