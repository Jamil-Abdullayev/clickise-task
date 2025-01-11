<?php

namespace App\Providers;

use App\Interfaces\VerificationServiceInterface;
use App\Services\VerificationService;
use Illuminate\Support\ServiceProvider;

class VerificationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->bind(VerificationServiceInterface::class, function ($app) {
            return new VerificationService([
            ]);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
