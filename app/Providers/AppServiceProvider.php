<?php

namespace App\Providers;

use App\Models\Role;
use App\Models\User;
use App\Policies\RolesPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Role::class, RolesPolicy::class);
        Gate::policy(User::class, UserPolicy::class);
    }
}
