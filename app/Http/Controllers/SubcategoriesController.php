<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ActivityLog;
use App\Subcategory;
use App\Category;

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
			'icon'  => 'required|image',
		]);

		// Store the file and use the path for the database
		$path = $request->file('icon')->store('/public/icons');

		$subcategory = new Subcategory();
		$subcategory->title = request('title');
		$subcategory->slug = urlencode(request('title'));
		$subcategory->icon = explode('icons/', $path)[1];
		$subcategory->category_id = Category::find($id)->id;
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
			return view('subcategory.single', [
				'subcategory' => Subcategory::find($id),
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
		$this->authorize('update', Subcategory::class);

		if (item_exists(Subcategory::find($id), $slug)) return view('subcategory.edit', ['subcategory' => Subcategory::find($id)]);
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
		$this->authorize('update', Subcategory::class);

		if (item_exists(Subcategory::find($id), $slug)) {
			$data = request()->validate([
				'title' => 'required|max:40',
			]);

			$subcategory = Subcategory::find($id);
			$subcategory->title = request('title');
			$subcategory->slug = urlencode(request('title'));
			$subcategory->save();

			ActivityLog::create([
				'user_id' 	   => auth()->user()->id,
				'task'	  	   => __('edited'),
				'performed_on' => json_encode(['table' => 'subcategories', 'id' => $subcategory->id]),
			]);

			return redirect(route('subcategory_show', [$subcategory->id, $subcategory->slug]));
		} else {
			return view('errors.404');
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
		$this->authorize('delete', Subcategory::class);

		if (item_exists(Subcategory::find($id), $slug)) {
			$subcategory = Subcategory::find($id);
			$category = $subcategory->category;

			if ($subcategory->threads) {
				foreach ($subcategory->threads as $thread) {
					foreach ($thread->posts as $post) {
						$post->delete();
					}
					$thread->delete();
				}
			}

			ActivityLog::create([
				'user_id' 	   => auth()->user()->id,
				'task'	  	   => __('deleted'),
				'performed_on' => json_encode(['table' => 'subcategories', 'id' => $subcategory->id]),
			]);

			$subcategory->delete();
			
			return redirect(route('category_show', [$category->id, $category->slug]));
		} else {
			return view('errors.404', ['value' => urldecode($slug)]);
		}
    }
}