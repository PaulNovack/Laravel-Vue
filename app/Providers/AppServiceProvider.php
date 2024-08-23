<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
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
        Response::macro(
            'prettyJson',
            function ($data, $status = 200) {
                return response()->make(
                    json_encode($data, JSON_PRETTY_PRINT),
                    $status,
                    ['Content-Type' => 'application/json']
                );
            }
        );
    }
}
