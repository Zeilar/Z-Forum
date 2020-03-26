<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
		'App\MaintenanceMode' => 'App\Policies\MaintenanceModePolicy',
		'App\Subcategory' => 'App\Policies\SubcategoriesPolicy',
		'App\Category' => 'App\Policies\CategoriesPolicy',
		'App\Thread' => 'App\Policies\ThreadsPolicy',
        'App\Post' => 'App\Policies\PostsPolicy',
		'App\User' => 'App\Policies\UsersPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
