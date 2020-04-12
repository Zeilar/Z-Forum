<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ActivityLog;
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
			'content' => 'required|max:1000'
		]);

		$thread = Thread::find($id);
		$post = new Post();
		$post->content = request('content');
		$post->user_id = auth()->user()->id;
		$post->thread_id = $thread->id;
		$post->subcategory_id = $thread->subcategory->id;
		$post->category_id = $thread->category->id;
		$post->save();

		ActivityLog::create([
			'user_id' 	   => auth()->user()->id,
			'task'	  	   => __('created'),
			'performed_on' => json_encode([['table' => 'posts'], ['id' => $post->id]]),
		]);

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
		} else {
			$post = Post::find(request('id'));
			$post->content = request('content');
			$post->edited_by_message = request('edit_message');
		
			$post->save();

			// If the edit was 3 or more minutes after creation, put a notation of it at the bottom
			if ($post->created_at->diffInMinutes($post->updated_at) >= 3) {
				$post->edited_by  = '<p class="edited-by ' . role_coloring(auth()->user()->role) . '">' . __('Edited by ');
				$post->edited_by .= '<a href="' . route('user_show', auth()->user()->id) . '">' . auth()->user()->username . '</a>';
				$post->edited_by .= __(' at ') . $post->updated_at . '</p>';

				$post->save();
			}

			ActivityLog::create([
				'user_id' 	   => auth()->user()->id,
				'task'	  	   => __('edited'),
				'performed_on' => json_encode([['table' => 'posts'], ['id' => $post->id]]),
			]);

			return response()->json([
				'type'	  			=> 'success',
				'message' 			=> __('Post was successfully changed'),
				'content' 			=> $post->content,
				'edited_by'		    => $post->edited_by,
				'edited_by_message' => $post->edited_by_message,
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

			ActivityLog::create([
				'user_id' 	   => auth()->user()->id,
				'task'	  	   => __('deleted'),
				'performed_on' => json_encode([['table' => 'posts'], ['id' => $post->id]]),
			]);

			$post->delete();

			if (count($thread->posts) <= 0) {
				$subcategory = $thread->subcategory;
				$redirect = route('subcategory_show', [$subcategory->id, $subcategory->slug]);

				ActivityLog::create([
					'user_id' 	   => auth()->user()->id,
					'task'	  	   => __('deleted'),
					'performed_on' => json_encode([['table' => 'threads'], ['id' => $thread->id]]),
				]);
				
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