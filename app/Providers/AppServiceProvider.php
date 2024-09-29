<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        if($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Inertia::share([
            'user' => function () {
                return Auth::user() ? [
                    'id' => Auth::user()->id,
                    'roles' => Auth::user()->getRoleNames(),
                    'permissions' => Auth::user()->getAllPermissions()->pluck('name'),
                ] : null;
            },
            'appUrl'=> env('APP_URL')
        ]);
    }
}
