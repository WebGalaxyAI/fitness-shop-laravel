<?php

namespace App\Providers;

use Illuminate\Foundation\Support;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends Support\Providers\AuthServiceProvider
{
    protected $policies = [
    ];

    public function boot(): void
    {
        Gate::before(function ($user, $ability) {
            return $user->hasRole('super admin') ? true : null;
        });
    }
}
