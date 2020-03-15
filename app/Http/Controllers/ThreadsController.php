<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TableSubcategory;
use App\TableCategory;
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
		} else if (!item_exists(TableSubcategory::find($id), $slug)) {
			return view('errors.404', ['value' => urldecode($slug)]);
		} else {
			return view('thread.create', [
				'subcategory' => TableSubcategory::find($id),
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
		if (logged_in()) {
			request()->validate([
				'title'   => 'required|max:100',
				'content' => 'required|max:500',
			]);

			$tableCategory = TableSubcategory::find($id)->tableCategory;
			$tableSubcategory = TableSubcategory::find($id);

			$thread = new Thread();
			$thread->title = request('title');
			$thread->slug = urlencode(request('title'));
			$thread->user_id = auth()->user()->id;
			$thread->table_category_id = $tableCategory->id;
			$thread->table_subcategory_id = $tableSubcategory->id;
			$thread->save();

			$post = new Post();
			$post->content = request('content');
			$post->user_id = auth()->user()->id;
			$post->thread_id = $thread->id;
			$post->table_category_id = $tableCategory->id;
			$post->table_subcategory_id = $tableSubcategory->id;
			$post->save();

			return redirect(route('thread_show', [$thread->id, $thread->slug]));
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
    public function show(int $id, string $slug)
    {
		if (item_exists(Thread::find($id), $slug)) {
			$thread = Thread::find($id);
			$thread->views += 1;
			$thread->save();
			return view('thread.single', [
				'thread' => Thread::find($id),
				'posts'  => Post::where('thread_id', $id)->paginate(settings_get('posts_per_page') ?? 5),
			]);
		} else {
			return view('errors.404', ['value' => urldecode($slug)]);
		}
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id, string $slug)
    {
		if ($this->thread_validation($id, $slug) !== true) {
			return $this->thread_validation($id, $slug);
		} else {
			return view('thread.edit', ['thread' => Thread::find($id)]);
		}
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id, string $slug)
    {
		if ($this->thread_validation($id, $slug) !== true) {
			return $this->thread_validation($id, $slug);
		} else {
			$data = request()->validate([
				'title' => 'required|max:30'
			]);

			$thread = Thread::find($id);
			$thread->title = request('title');
			$thread->slug = urlencode(request('title'));
			$thread->save();

			return redirect(route('thread_show', [$thread->id, $thread->slug]));
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
		if ($this->thread_validation($id, $slug) !== true) {
			return $this->thread_validation($id, $slug);
		} else {
			$thread = Thread::find($id);
			$tableSubcategory = $thread->tableSubcategory;
			foreach ($thread->posts as $post) {
				$post->delete();
			}
			$thread->delete();
			return redirect(route('tablesubcategory_show', [$tableSubcategory->id, $tableSubcategory->slug]));
		}
    }

	/**
     * Lock the specified resource in storage.
     *
     * @param  int  $id
	 * @param  string $slug
     * @return mixed
     */
    public function lock(int $id, string $slug)
    {
		if ($this->thread_validation($id, $slug) !== true) {
			return $this->thread_validation($id, $slug);
		} else {
			$thread = Thread::find($id);
			$thread->locked = true;
			$thread->save();

			return redirect(route('thread_show', [$thread->id, $thread->slug]));
		}
    }

	/**
     * Unlock the specified resource in storage.
     *
     * @param  int  $id
	 * @param  string $slug
     * @return mixed
     */
    public function unlock(int $id, string $slug)
    {
		if ($this->thread_validation($id, $slug) !== true) {
			return $this->thread_validation($id, $slug);
		} else {
			$thread = Thread::find($id);
			$thread->locked = false;
			$thread->save();

			return redirect(route('thread_show', [$thread->id, $thread->slug]));
		}
    }
}