<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\ActivityLog;
use App\User;
use Auth;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
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
    public function update(Request $request)
    {
		if (!logged_in()) {
			return msg_error('login');
		} else if (!Hash::check(request('password_current'), auth()->user()->password)) {
			return msg_error(__('Incorrect password'), 'password_current')->withInput($request->except('password'));
		}

		request()->validate([
			'avatar'	   	   		=> 'max:5120|file|image|nullable',
			'signature'		   		=> 'max:100|nullable',
			'items_per_page'   		=> 'min:0|max:50|numeric',
			'email'	  		   		=> 'min:3|max:30|unique:users|email|nullable',
			'password'	   			=> 'min:6|max:30|confirmed|nullable',
			'password_current'		=> 'required',
		]);

		$user = auth()->user();

		if (request('delete')) {
			$user->posts()->each(function($post) {
				$post->content 		     = '<i>' . __('Deleted') . '</i>';
				$post->edited_by 		 = null;
				$post->edited_by_message = null;
				$post->save();
			});
			$user->threads()->each(function($thread) {
				$thread->title 	 = __('Deleted');
				$thread->slug 	 = __('Deleted');
				$thread->save();
			});
			$user->likes()->each(function($like) {
				$like->delete();
			});
			$user->messages_sent()->each(function($message) {
				$message->delete();
			});
			$user->visited_threads()->each(function($visit) {
				$visit->delete();
			});
			$user->visited_messages()->each(function($visit) {
				$visit->delete();
			});
			ActivityLog::where('user_id', $user->id)->each(function($activity) {
				$activity->delete();
			});

            $user->update([
                'username' => null,
                'github_id' => null,
                'email' => null,
                'password' => null,
                'role' => 'Member',
                'signature' => null,
                'avatar' => route('index') . '/storage/user-avatars/default.svg',
                'remember_token' => null,
                'suspended' => null,
                'suspended_reason' => null,
            ]);

			return redirect(route('logout'));
		}
		
		if (isset($request->avatar)) {
			// Store the avatar as an absolute URI path
			$path = $request->file('avatar')->store('/public/user-avatars');
			$path = explode('public/', $path)[1];
			$path = route('index') . '/storage/' . $path;
			$user->avatar = $path;
		}

		if (isset($request->signature)) {
			$user->signature = $request->signature;
		}

		if (isset($request->items_per_page)) {
			$settings = json_decode($user->settings, true);
			$settings['posts_per_page'] = request('items_per_page');
			$settings = json_encode($settings);

			$user->settings = $settings;
		}

		if (isset($request->email)) {
			$user->email = $request->email;
		}

		if (isset($request->password)) {
			$user->password = Hash::make(request('password'));
		}

		$user->save();

        return msg_success('update');
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
}
