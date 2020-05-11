<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ActivityLog;
use App\Subcategory;
use App\Category;
use App\Thread;

class SubcategoriesController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, int $id, string $slug)
    {
		$this->authorize('create', Subcategory::class);

		request()->validate([
			'title' => 'required|min:3|max:40',
			'icon'  => 'image',
		]);

		$subcategory = new Subcategory();
		$subcategory->title = request('title');
		$subcategory->slug = urlencode(request('title'));
		if (isset($request->icon)) {
			$path = $request->file('icon')->store('/public/icons');
			$subcategory->icon = explode('icons/', $path)[1];
		}
		$subcategory->category_id = Subcategory::find($id)->id;
		$subcategory->save();

		ActivityLog::create([
			'user_id' 	   => auth()->user()->id,
			'task'	  	   => __('created'),
			'performed_on' => json_encode(['table' => 'subcategories', 'id' => $subcategory->id]),
		]);

		return redirect(route('subcategory_show', [$subcategory->id, $subcategory->slug]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id, string $slug)
    {
		if (item_exists(Subcategory::find($id), $slug)) {
			$subcategory = Subcategory::find($id);

			return view('subcategory.single', [
				'subcategory' => $subcategory,
				'threads'	  => Thread::where('subcategory_id', $subcategory->id)->paginate(settings_get('posts_per_page')),
			]);
		} else {
			return view('errors.404', ['value' => urldecode($slug)]);
		}
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (empty($subcategory = Subcategory::find($id))) return msg_error(__('That subcategory does not exist'));

        $this->authorize('update', Subcategory::class);

        request()->validate([
            'title' => 'required|min:3|max:40',
            'icon'	=> 'max:5120|file|image|nullable',
        ]);

        if (isset($request->icon)) {
			$path = $request->file('icon')->store('/public/icons');
			$path = explode('public/', $path)[1];
		}

        $subcategory->update([
            'title' => request('title'),
            'slug'  => urlencode(request('title')),
            'icon'  => $path ?? $subcategory->icon,
        ]);

        return redirect(route('subcategory_show', [$subcategory->id, $subcategory->slug]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
		$subcategory = Subcategory::find($id);
		$this->authorize('delete', Subcategory::class);

        $subcategory->threads->each(function($thread) {
            $thread->posts->each(function($post) {
                $post->likes()->onlyTrashed()->each(function($like) {
                    $like->delete();
                });

                $post->delete();
            });

            $thread->visits()->onlyTrashed()->each(function($visit) {
                $visit->delete();
            });

            $thread->delete();
        });

        $subcategory->delete();
		
		return redirect(route('index'));
    }

    public function restore(Request $request, $id) {
        if (empty($subcategory = Subcategory::onlyTrashed()->find($id))) return msg_error(__('That subcategory does not exist'));

        $this->authorize('restore', Subcategory::class);
        
        $subcategory->restore();

        $subcategory->threads()->onlyTrashed()->each(function($thread) {
            $thread->restore();

            $thread->posts()->onlyTrashed()->each(function($post) {
                $post->restore();

                $post->likes()->onlyTrashed()->each(function($like) {
                    $like->restore();
                });
            });

            $thread->visits()->onlyTrashed()->each(function($visit) {
                $visit->restore();
            });
        });

        return redirect(route('subcategory_show', [$subcategory->id, $subcategory->slug]));
    }
}