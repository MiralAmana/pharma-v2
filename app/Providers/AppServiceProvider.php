<?php

namespace App\Providers;

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
        // Source unique de vérité pour "est-ce un gérant ?" — utilisée par IsAdmin,
        // et disponible partout via @can('gerant') / Gate::allows('gerant').
        Gate::define('gerant', fn (User $user) => $user->role === 'gerant');
    }
}
