<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\UserVisitedThreads;
use App\UserLikedPosts;
use App\ActivityLog;
use App\Category;
use App\Post;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('index', ['tableCategories' => Category::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$this->authorize('create', Category::class);

		request()->validate([
			'title' => 'required|min:3|max:40|unique:categories',
		]);

		$category = new Category();
		$category->title = request('title');
		$category->slug = urlencode(request('title'));
		$category->save();

		ActivityLog::create([
			'user_id' 	   => auth()->user()->id,
			'task'	  	   => __('created'),
			'performed_on' => json_encode(['table' => 'categories', 'id' => $category->id]),
		]);

		return redirect()->route('category_show', [$category->id, $category->slug]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id, string $slug)
    {
		if (item_exists(Category::find($id), $slug)) {
			return view('category.single', ['category' => Category::find($id)]);
		} else {
			return view('errors.404', ['value' => urldecode($slug)]);
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
        } else if (!Category::find(request('id'))) {
			return response()->json([
				'type'    => 'error',
				'message' => __('That category does not exist, refresh the page and try again'),
			]);
		} else if (!is_role('superadmin')) {
			return response()->json([
				'type' 	  => 'error',
				'message' => __('Insufficient permissions')
			]);
		} else if (request('title') === Category::find(request('id'))->title) {
			return response()->json([
				'type' => 'none',
			]); 
		} else {
			$category = Category::find(request('id'));
            $category->update([
                'title' => request('title'),
                'slug' => urlencode(request('title')),
            ]);

			ActivityLog::create([
				'user_id' 	   => auth()->user()->id,
				'task'	  	   => __('edited'),
				'performed_on' => json_encode(['table' => 'categories', 'id' => $category->id]),
			]);

			return response()->json([
				'type'	  => 'success',
				'message' => __('Category title was successfully changed'),
				'title'	  => $category->title,
				'url'	  => route('category_show', [$category->id, $category->slug]),
			]);
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
		$category = Category::find($id);
		$this->authorize('delete', Category::class);

        $category->subcategories->each(function($subcategory) {
            $subcategory->threads->each(function($thread) {
                $thread->posts->each(function($post) {
                    UserLikedPosts::where('post_id', $post->id)->each(function($like) {
                        $like->delete();
                    });

                    $post->delete();
                });

                UserVisitedThreads::where('thread_id', $thread->id)->each(function($visit) {
                    $visit->delete();
                });

                $thread->delete();
            });
            $subcategory->delete();
        });

		$category->delete();
		
		return redirect(route('index'));
    }

    public function restore(Request $request, $id) {
        if (empty($category = Category::onlyTrashed()->find($id))) return msg_error(__('That category does not exist'));

        $this->authorize('restore', Category::class);
        
        $category->restore();

        $category->subcategories()->onlyTrashed()->each(function($subcategory) {
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
        });

        return redirect(route('category_show', [$category->id, $category->slug]));
    }
}