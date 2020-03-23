<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subcategory;
use App\Category;

class SubcategoriesController extends Controller
{
	/**
	 * Error handling for various table subcategory actions
	 * 
	 * @param  int $id
	 * @return mixed
	 */
	public function subcategory_validation() 
	{
		if (!logged_in()) {
			return msg_error('login');
		} else if (!is_role('superadmin')) {
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
		if ($this->subcategory_validation() !== true) {
			return $this->subcategory_validation();
		} else {
			if (item_exists(Category::find($id), $slug)) {
				return view('subcategory.create', [
					'category' => Category::find($id),
				]);
			} else {
				return view('errors.404', ['value' => urldecode($slug)]);
			}
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
		if ($this->subcategory_validation() !== true) {
			return $this->subcategory_validation();
		} else {
			request()->validate([
				'title' => 'required|min:3|max:40|unique:subcategories',
			]);

			$subcategory = new Subcategory();
			$subcategory->title = request('title');
			$subcategory->slug = urlencode(request('title'));
			$subcategory->category_id = Category::find($id)->id;
			$subcategory->save();

			return redirect(route('subcategory_show', [$subcategory->id, $subcategory->slug]));
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
		if ($this->subcategory_validation() !== true) {
			return $this->subcategory_validation();
		} else {
			if (item_exists(Subcategory::find($id), $slug)) {
				return view('subcategory.edit', ['subcategory' => Subcategory::find($id)]);
			} else {
				return view('errors.404', ['value' => urldecode($slug)]);
			}
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
        if (logged_in()) {
			if (item_exists(Subcategory::find($id), $slug)) {
				if (is_role('superadmin')) {
					$data = request()->validate([
						'title' => 'required|max:40'
					]);

					$subcategory = Subcategory::find($id);
					$subcategory->title = request('title');
					$subcategory->slug = urlencode(request('title'));
					$subcategory->save();

					return redirect(route('subcategory_show', [$subcategory->id, $subcategory->slug]));
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
    public function destroy(int $id, string $slug)
    {
		if (item_exists(Subcategory::find($id), $slug)) {
			if (logged_in()) {
				if (is_role('superadmin')) {
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

					$subcategory->delete();
					return redirect(route('category_show', [$category->id, $category->slug]));
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