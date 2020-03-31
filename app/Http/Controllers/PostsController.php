<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subcategory;
use App\Category;
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
		return Post::find($id) ? view('post.single', ['post' => Post::find($id)]) : view('errors.404');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, int $id, string $slug)
    {
		$this->authorize('create', [Post::class, Thread::find($id)]);

		$data = request()->validate([
			'content' => 'required|max:500'
		]);

		$thread = Thread::find($id);
		$post = new Post();
		$post->content = request('content');
		$post->user_id = auth()->user()->id;
		$post->thread_id = $thread->id;
		$post->subcategory_id = $thread->subcategory->id;
		$post->category_id = $thread->category->id;
		$post->save();

		return redirect(route('post_show', [
			$thread->id,
			$thread->slug,
			get_item_page_number($thread->posts->sortBy('created_at'), $post->id, settings_get('posts_per_page')),
			$post->id,
		]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
		
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
		$this->authorize('update', Post::class);

		request()->validate([
			'content' => 'required|max:500'
		]);

		$post = Post::find($id);
		$post->content = request('content');
		$post->save();

		return redirect(route('post_show', [$post->thread->id, $post->thread->slug, $post->id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
		$this->authorize('delete', Post::class);

		$post = Post::find($id);
		$thread = $post->thread;

		if (count($thread->posts) <= 1) {
			$subcategory = $thread->subcategory;
			$thread->delete();
			$post->delete();
			return redirect(route('subcategory_show', [$subcategory->id, $subcategory->slug]));
		}

		$post->delete();
		
		return redirect(route('thread_show', [$thread->id, $thread->slug]));
    }

	/**
     * Update the specified resource in storage, using AJAX.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_ajax(Request $request)
    {
		if (!logged_in()) {
			return response()->json([
				'type'    => 'error',
				'message' => __('Please log in and try again'),
			]);
		} else if (!Post::find(request('id'))) {
			return response()->json([
				'type'    => 'error',
				'message' => __('That post does not exist, refresh the page and try again'),
			]);
		} else if (Post::find(request('id'))->thread->locked && !is_role('superadmin', 'moderator')) {
			return response()->json([
				'type'    => 'error',
				'message' => __('The thread has been locked'),
			]);
		} else if (Post::find(request('id'))->user_id !== auth()->user()->id && !is_role('superadmin', 'moderator')) {
			return response()->json([
				'type'    => 'error',
				'message' => __('That post does not belong to you, contact an administrator if you believe this is false'),
			]);
		} else if (request('content') === Post::find(request('id'))->content) {
			return response()->json([
				'type' => 'none',
			]);
		} else {
			$post = Post::find(request('id'));
			$post->content = request('content');
		
			$post->save();

			// If the edit was 3 or more minutes after creation, put a notation of it at the bottom
			if ($post->created_at->diffInMinutes($post->updated_at) >= 3) {
				$post->edited_by  = '<p class="edited-by ' . role_coloring(auth()->user()->role) . '">' . __('Edited by ');
				$post->edited_by .= '<a href="' . route('user_show', auth()->user()->id) . '">' . auth()->user()->username . '</a>';
				$post->edited_by .= __(' at ') . $post->updated_at . '</p>';

				$post->save();
			}

			return response()->json([
				'type'	  	=> 'success',
				'message' 	=> __('Post was successfully changed'),
				'content' 	=> $post->content,
				'edited_by' => $post->edited_by,
			]);
		}
    }

	/**
     * Remove the specified resource from storage, using AJAX.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_ajax(Request $request)
    {
		if (!logged_in()) {
			return response()->json([
				'type'    => 'error',
				'message' => __('Please log in and try again'),
			]);
		} else if (!Post::find(request('id'))) {
			return response()->json([
				'type'    => 'error',
				'message' => __('That post does not exist, refresh the page and try again'),
			]);
		} else if (Post::find(request('id'))->thread->locked && !is_role('superadmin', 'moderator')) {
			return response()->json([
				'type'    => 'error',
				'message' => __('The thread has been locked'),
			]);
		} else if (Post::find(request('id'))->user_id !== auth()->user()->id && !is_role('superadmin', 'moderator')) {
			return response()->json([
				'type'    => 'error',
				'message' => __('That post does not belong to you, contact an administrator if you believe this is false'),
			]);
		} else {
			$redirect = false;
			$post = Post::find(request('id'));
			
			$thread = $post->thread;

			$post->delete();

			if (count($thread->posts) <= 0) {
				$subcategory = $thread->subcategory;
				$redirect = route('subcategory_show', [$subcategory->id, $subcategory->slug]);
				
				$thread->delete();
			}
			
			return response()->json([
				'type'     => 'success',
				'message'  => __('Post was successfully deleted'),
				'redirect' => $redirect,
			]);
		}
    }
}