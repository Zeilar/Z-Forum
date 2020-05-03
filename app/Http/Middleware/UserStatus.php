<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use App\Post;
use Closure;
use Cache;
use Auth;

class UserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		if (Auth::check()) {
			$expiresAt = Carbon::now()->addMinutes(3);
			Cache::put('user-online-' . Auth::user()->id, true, $expiresAt);

            //dump(Post::orderByDesc('created_at')->limit(1)->first());
            //dump(auth()->user()->last_seen);
			
            // Determine what's new before updating last_seen
            $whats_new = Post::orderByDesc('created_at')
                ->where('created_at', '>=', auth()->user()->last_seen)
                ->limit(5)
                ->get();
            view()->share('whats_new', $whats_new);

			// Update last seen columns
			$user = Auth::user();
			$user->last_seen = Carbon::now();
			$user->save();
		}
        return $next($request);
    }
}