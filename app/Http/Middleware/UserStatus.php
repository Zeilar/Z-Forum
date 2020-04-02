<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
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
			
			// Update last seen row
			$user = Auth::user();
			$user->last_seen = Carbon::now();
			$user->save();
		}
        return $next($request);
    }
}