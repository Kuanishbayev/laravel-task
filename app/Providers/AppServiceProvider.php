<?php

namespace App\Providers;

use App\Models\Application;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        Gate::define('answer-to-application', function (User $user) {
            $manager_id = 1;
            return $user->id === $manager_id;
        });
    }
}
