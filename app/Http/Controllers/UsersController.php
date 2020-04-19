<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ActivityLog;
use UserLikedPosts;
use Carbon\Carbon;
use App\User;
use Cache;
use Auth;
use DB;

class UsersController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		// Make it possible to go to /user/1 or /user/john but the latter is bound to the 'user_show' route
		if (User::find($id) || User::where('username', $id)) {
			$user = User::find($id) ?? User::where('username', $id)->first();

			if (logged_in() && auth()->user()->id !== $user->id) {
				ActivityLog::create([
					'user_id' 	   => auth()->user()->id,
					'task'	  	   => __('visited'),
					'performed_on' => json_encode([['table' => 'users'], ['id' => $user->id]]),
				]);
			}

			$posts = DB::table('user_liked_posts')
				->join('posts', 'posts.id', '=', 'user_liked_posts.post_id')->where('posts.user_id', $user->id)
				->get()
				->unique();

			return view('user.single', [
				'posts_with_likes' => $posts,
				'user' => $user,
			]);
		} else {
			return view('errors.404');
		}
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

	public function push_status()
	{
		if (Auth::check()) {
			$expiresAt = Carbon::now()->addMinutes(3);
			Cache::put('user-online-' . Auth::user()->id, true, $expiresAt);

			// Update last seen row
			$user = Auth::user();
			$user->last_seen = Carbon::now();
			$user->save();
		}
	}
}