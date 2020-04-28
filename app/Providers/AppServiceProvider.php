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
        if ($this->app->isLocal()) {
			$this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
			$this->app->register(TelescopeServiceProvider::class);
		}
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
		if ($this->app->isLocal()) {
			if (Schema::hasTable('users')) {
				$users = User::where('id', '!=', '1')->limit(10)->get();

				foreach ($users as $user) {
					$expiresAt = Carbon::now()->addYear(1);
					Cache::put('user-online-' . $user->id, true, $expiresAt);
				}
			}
		}
    }
}