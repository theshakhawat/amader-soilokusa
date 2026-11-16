<?php

namespace App\Providers;

use App\Models\MailSetting;
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
        // Super Admin & Admin bypass all permissions
        Gate::before(function ($user, $ability) {
            return ($user->hasRole('admin') || $user->hasRole('super-admin')) ? true : null;
        });

        // Dynamically configure Mail settings from database
        MailSetting::applyMailConfig();
    }
}
