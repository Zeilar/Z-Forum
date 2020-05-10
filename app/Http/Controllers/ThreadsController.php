<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserVisitedThreads;
use App\ActivityLog;
use App\Subcategory;
use App\Category;
use App\Thread;
use App\Post;

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
    public function create(int $id, string $slug)
    {
        $this->authorize('create', Thread::class);

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
			'title'   => 'required|max:100|min:3',
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

		ActivityLog::create([
			'user_id' 	   => auth()->user()->id,
			'task'	  	   => __('created'),
			'performed_on' => json_encode(['table' => 'threads', 'id' => $thread->id]),
		]);

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

			if (logged_in()) {
				$visitedThread = UserVisitedThreads::where([['user_id', auth()->user()->id], ['thread_id', $thread->id]])->get();

				if (!count($visitedThread)) {
					UserVisitedThreads::create([
						'user_id' => auth()->user()->id,
						'thread_id' => $thread->id,
					]);
				} else {
					$visitedThread[0]->updated_at = \Carbon\Carbon::now();
					$visitedThread[0]->save();
				}

				ActivityLog::create([
					'user_id' 	   => auth()->user()->id,
					'task'	  	   => __('visited'),
					'performed_on' => json_encode(['table' => 'threads', 'id' => $thread->id]),
				]);
			}

			return view('thread.single', [
				'thread' => $thread,
				'posts'  => $thread->posts()->orderBy('created_at')->paginate(settings_get('posts_per_page')),
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
    public function destroy(int $id)
    {
		$thread = Thread::find($id);
		$this->authorize('delete', $thread);

		$subcategory = $thread->subcategory;

		$thread->posts->each(function($post) {
            $post->delete();
        });

        UserVisitedThreads::where('thread_id', $thread->id)->each(function($visit) {
            $visit->delete();
        });

		ActivityLog::create([
			'user_id' 	   => auth()->user()->id,
			'task'	  	   => __('deleted'),
			'performed_on' => json_encode(['table' => 'threads', 'id' => $thread->id]),
		]);

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
		} else if (auth()->user()->is_suspended()) {
            return response()->json([
                'type'    => 'error',
                'message' => __('You are suspended'),
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
				$thread->unlock();
				$state = __('unlocked');

				ActivityLog::create([
					'user_id' 	   => auth()->user()->id,
					'task'	  	   => __('unlocked'),
					'performed_on' => json_encode(['table' => 'threads', 'id' => $thread->id]),
				]);
			} else {
				$thread->lock();
				$state = __('locked');

				ActivityLog::create([
					'user_id' 	   => auth()->user()->id,
					'task'	  	   => __('locked'),
					'performed_on' => json_encode(['table' => 'threads', 'id' => $thread->id]),
				]);
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
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
		if (!logged_in()) {
			return response()->json([
				'type'    => 'error',
				'message' => __('Please log in and try again'),
			]);
		} else if (auth()->user()->is_suspended()) {
            return response()->json([
                'type'    => 'error',
                'message' => __('You are suspended'),
            ]);
        } else if (!Thread::find(request('id'))) {
			return response()->json([
				'type'    => 'error',
				'message' => __('That thread does not exist, refresh the page and try again'),
			]);
		} else if (!is_role('superadmin')) {
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

			ActivityLog::create([
				'user_id' 	   => auth()->user()->id,
				'task'	  	   => __('edited'),
				'performed_on' => json_encode(['table' => 'threads', 'id' => $thread->id]),
			]);

			return response()->json([
				'type'	  => 'success',
				'message' => __('Thread title was successfully changed'),
				'title'	  => $thread->title,
				'url'	  => route('thread_show', [$thread->id, $thread->slug]),
			]);
		}
    }

    public function restore(Request $request, $id) {
        $thread = Thread::onlyTrashed()->find($id);

        if (empty($thread)) return msg_error(__('That thread does not exist'));

        $thread->restore();

        Post::onlyTrashed()->where('thread_id', $thread->id)->each(function($post) {
            $post->restore();
        });

        return redirect(route('thread_show', [$thread->id, $thread->slug]));
    }
}