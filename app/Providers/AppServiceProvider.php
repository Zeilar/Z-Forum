<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Post;

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
		// Share this variable across all views
		if (Schema::hasTable('posts')) {
			view()->share('latest_posts', Post::orderBy('updated_at')->take(5)->get());
		}
    }
}