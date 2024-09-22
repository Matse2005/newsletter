<?php

namespace App\Providers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Queue;

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
    public function boot()
    {
        Queue::failing(function ($connection, $job, $data) {
            Log::error('Queue job failed', [
                'connection' => $connection,
                'job' => $job,
                'exception' => $data,
            ]);
        });
    }
}
