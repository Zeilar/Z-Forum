<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subcategory;
use App\Category;
use App\Thread;
use App\Post;

class ThreadsController extends Controller
{
	/**
	 * Error handling for various thread actions
	 * 
	 * @param  int $id
	 * @return mixed
	 */
	public function thread_validation(int $id, string $slug) 
	{
		if (!logged_in()) {
			return msg_error('login');
		} else if (!item_exists(Thread::find($id), $slug)) {
			return view('errors.404');
		} else if (!is_role('superadmin', 'moderator')) {
			return msg_error('role');
		} else {
			return true;
		}
	}

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
    public function create(int $id, string $slug)
    {
		if (!logged_in()) {
			return msg_error('login');
		} else if (!item_exists(Subcategory::find($id), $slug)) {
			return view('errors.404', ['value' => urldecode($slug)]);
		} else {
			return view('thread.create', [
				'subcategory' => Subcategory::find($id),
			]);
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
		$this->authorize('create', Thread::class);

		request()->validate([
			'title'   => 'required|alpha_dash|max:40|min:3',
			'content' => 'required|max:500',
		]);

		$category = Subcategory::find($id)->category;
		$subcategory = Subcategory::find($id);

		$thread = new Thread();
		$thread->title = request('title');
		$thread->slug = urlencode(request('title'));
		$thread->user_id = auth()->user()->id;
		$thread->category_id = $category->id;
		$thread->subcategory_id = $subcategory->id;
		$thread->save();

		$post = new Post();
		$post->content = request('content');
		$post->user_id = auth()->user()->id;
		$post->thread_id = $thread->id;
		$post->category_id = $category->id;
		$post->subcategory_id = $subcategory->id;
		$post->save();

		return redirect(route('thread_show', [$thread->id, $thread->slug]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id, string $slug)
    {
		if (item_exists(Thread::find($id), $slug)) {
			$thread = Thread::find($id);
			$thread->views += 1;
			$thread->save();

			return view('thread.single', [
				'thread' => Thread::find($id),
				'posts'  => Post::where('thread_id', $id)->orderBy('created_at')->paginate(settings_get('posts_per_page')),
			]);
		} else {
			return view('errors.404', ['value' => urldecode($slug)]);
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id, string $slug)
    {
		$this->authorize('delete', Thread::class);

		$thread = Thread::find($id);
		$subcategory = $thread->subcategory;

		foreach ($thread->posts as $post) {
			$post->delete();
		}

		$thread->delete();
		
		return redirect(route('subcategory_show', [$subcategory->id, $subcategory->slug]));
    }

	/**
     * Toggle locked or unlocked state the specified resource in storage, using AJAX.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function toggle(Request $request)
    {
		if (!logged_in()) {
			return response()->json([
				'type'    => 'error',
				'message' => __('Please log in and try again'),
			]);
		} else if (!Thread::find(request('id'))) {
			return response()->json([
				'type'    => 'error',
				'message' => __('That thread does not exist, refresh the page and try again'),
			]);
		} else if (!is_role('superadmin', 'moderator')) {
			return response()->json([
				'type'    => 'error',
				'message' => __('Insufficient permissions'),
			]);
		} else {
			$thread = Thread::find(request('id'));

			if ($thread->locked) {
				$thread->locked = false;
				$state = __('unlocked');
			} else {
				$thread->locked = true;
				$state = __('locked');
			}
			
			$thread->save();
			
			return response()->json([
				'type'	  => 'success',
				'message' => __("Thread was successfully $state"),
				'state'   => $state,
			]);
		}
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
		} else if (!Thread::find(request('id'))) {
			return response()->json([
				'type'    => 'error',
				'message' => __('That thread does not exist, refresh the page and try again'),
			]);
		} else if (!is_role('superadmin', 'moderator')) {
			return response()->json([
				'type' 	  => 'error',
				'message' => __('Insufficient permissions')
			]);
		} else if (request('title') === Thread::find(request('id'))->title) {
			return response()->json([
				'type' => 'none',
			]); 
		} else {
			$thread = Thread::find(request('id'));
			$thread->title = request('title');
			$thread->slug = urlencode(request('title'));

			$thread->save();

			return response()->json([
				'type'	  => 'success',
				'message' => __('Thread title was successfully changed'),
				'title'	  => $thread->title,
				'url'	  => route('thread_show', [$thread->id, $thread->slug]),
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
		} else if (!Thread::find(request('id'))) {
			return response()->json([
				'type'    => 'error',
				'message' => __('That thread does not exist, refresh the page and try again'),
			]);
		} else if (!is_role('superadmin', 'moderator')) {
			return response()->json([
				'type'    => 'error',
				'message' => __('Insufficient permissions'),
			]);
		} else {
			$post = Post::find(request('id'));
			$thread = $post->thread;

			$subcategory = $thread->subcategory;
			$redirect = route('subcategory_show', [$subcategory->id, $subcategory->slug]);

			foreach ($thread->posts as $post) {
				$post->delete();
			}

			$thread->delete();
			
			return response()->json([
				'type'     => 'success',
				'message'  => __('Thread was successfully deleted'),
				'redirect' => $redirect,
			]);
		}
    }
}