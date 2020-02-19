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
    public function create($id, $slug)
    {
		if (logged_in()) {
			if (item_exists(TableSubcategory::find($id), $slug)) {
				return view('thread.create', [
					'subcategory' => TableSubcategory::find($id),
				]);
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
			$data = request()->validate([
				'title' => 'required|max:100',
				'content' => 'required|max:500',
			]);

			$thread = new Thread();
			$thread->title = request('title');
			$thread->slug = urlencode(request('title'));
			$thread->user_id = auth()->user()->id;
			$thread->table_subcategory_id = TableSubcategory::find($id)->id;
			$thread->save();

			$post = new Post();
			$post->content = request('content');
			$post->user_id = auth()->user()->id;
			$post->thread_id = $thread->id;
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
    public function show($id, $slug)
    {
		if (item_exists(Thread::find($id), $slug)) {
			return view('thread.single', [
				'thread' => Thread::find($id),
				'posts' => Post::where('thread_id', $id)->paginate(3),
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
        if (item_exists(Thread::find($id), $slug)) {
			if (logged_in()) {
				if (is_role('superadmin', 'moderator')) {
					return view('thread.edit', ['thread' => Thread::find($id)]);
				} else {
					return msg_error('role');
				}
			} else {
				return msg_error('login');
			}
		} else {
			return view('errors.404', ['value' => urldecode($slug)]);
		}
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $slug)
    {
        if (logged_in()) {
			if (item_exists(Thread::find($id), $slug)) {
				if (is_role('superadmin', 'moderator')) {
					$data = request()->validate([
						'title' => 'required|max:30'
					]);

					$thread = Thread::find($id);
					$thread->title = request('title');
					$thread->slug = urlencode(request('title'));
					$thread->save();

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $slug)
    {
        if (item_exists(Thread::find($id), $slug)) {
			if (logged_in()) {
				if (is_role('superadmin', 'moderator')) {
					$thread = Thread::find($id);
					$tableSubcategory = $thread->tableSubcategory;
					foreach ($thread->posts as $post) {
						$post->delete();
					}
					$thread->delete();
					return redirect(route('tablesubcategory_show', [$tableSubcategory->id, $tableSubcategory->slug]));
				} else {
					return msg_error('role');
				}
			} else {
				return msg_error('login');
			}
		} else {
			return view('errors.404', ['value' => urldecode($slug)]);
		}
    }
}