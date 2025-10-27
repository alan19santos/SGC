<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use OwenIt\Auditing\Contracts\UserResolver as UserResolverContract;

class SanctumUserResolver extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
