<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TableSubcategory;
use App\TableCategory;

class TableSubcategoriesController extends Controller
{
	/**
	 * Error handling for various table subcategory actions
	 * 
	 * @param  int $id
	 * @return mixed
	 */
	public function tablesubcategory_validation() 
	{
		if (!logged_in()) {
			return msg_error('login');
		} elseif (!is_role('superadmin')) {
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
		if ($this->tablesubcategory_validation() !== true) {
			return $this->tablesubcategory_validation();
		} else {
			if (item_exists(TableCategory::find($id), $slug)) {
				return view('table_subcategory.create', [
					'tableCategory' => TableCategory::find($id),
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
		if ($this->tablesubcategory_validation() !== true) {
			return $this->tablesubcategory_validation();
		} else {
			request()->validate([
				'title' => 'required|min:3|max:30|unique:table_subcategories',
			]);

			$tableSubcategory = new TableSubcategory();
			$tableSubcategory->title = request('title');
			$tableSubcategory->slug = urlencode(request('title'));
			$tableSubcategory->table_category_id = TableCategory::find($id)->id;
			$tableSubcategory->save();

			return redirect(route('tablesubcategory_show', [$tableSubcategory->id, $tableSubcategory->slug]));
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
		if (item_exists(TableSubcategory::find($id), $slug)) {
			return view('table_subcategory.single', [
				'tableSubcategory' => TableSubcategory::find($id),
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
		if ($this->tablesubcategory_validation() !== true) {
			return $this->tablesubcategory_validation();
		} else {
			if (item_exists(TableSubcategory::find($id), $slug)) {
				return view('table_subcategory.edit', ['tableSubcategory' => TableSubcategory::find($id)]);
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
			if (item_exists(TableSubcategory::find($id), $slug)) {
				if (is_role('superadmin')) {
					$data = request()->validate([
						'title' => 'required|max:30'
					]);

					$tableSubcategory = TableSubcategory::find($id);
					$tableSubcategory->title = request('title');
					$tableSubcategory->slug = urlencode(request('title'));
					$tableSubcategory->save();

					return redirect(route('tablesubcategory_show', [$tableSubcategory->id, $tableSubcategory->slug]));
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
		if (item_exists(TableSubcategory::find($id), $slug)) {
			if (logged_in()) {
				if (is_role('superadmin')) {
					$tableSubcategory = TableSubcategory::find($id);
					$tableCategory = $tableSubcategory->tableCategory;

					if ($tableSubcategory->threads) {
						foreach ($tableSubcategory->threads as $thread) {
							foreach ($thread->posts as $post) {
								$post->delete();
							}
							$thread->delete();
						}
					}

					$tableSubcategory->delete();
					return redirect(route('tablecategory_show', [$tableCategory->id, $tableCategory->slug]));
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