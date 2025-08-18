<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Telescope\TelescopeServiceProvider;
use Laravel\Telescope\Telescope;
use OwenIt\Auditing\Models\Audit;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        if ($this->app->environment('local')) {
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        if ($this->app->environment('local')) {
            Telescope::auth(function () {
                return true; // libera o acesso para todo mundo localmente
            });
        }

        Audit::creating(function($audit) {
            $user = auth()->user();

            if (!$user) {
                $user = auth('sanctum')->user();
            }

            if (!$user && app()->runningInConsole()) {
                $user = \App\Models\User::first(); // ou null
            }

            $audit->user_id = $user->id ?? null;

        });

        // Audit::resolveUserUsing(function () {
        // // Pega usuário logado via web ou via Sanctum
        //     return auth()->user() ?? auth('sanctum')->user();
        // });
    }
}
