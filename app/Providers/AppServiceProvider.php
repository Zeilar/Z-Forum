<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use \Carbon\Carbon;
use App\Post;
use App\User;
use \Cache;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
		// FOR TESTING PURPOSES ONLY, REMOVE IN PRODUCTION

		if (Schema::hasTable('users')) {
			$users = User::where('id', '!=', '1')->get();
			$users = $users->chunk(ceil($users->count() / 2))[0];

			foreach ($users as $user) {
				$expiresAt = Carbon::now()->addYear(1);
				Cache::put('user-online-' . $user->id, true, $expiresAt);
			}
		}
    }
}