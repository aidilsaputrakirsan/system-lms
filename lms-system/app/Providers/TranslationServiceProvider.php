<?php

namespace App\Providers;

use App\Services\LanguageService;
use Illuminate\Support\ServiceProvider;

class TranslationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(LanguageService::class, function ($app) {
            return new LanguageService();
        });
    }

    public function boot(): void
    {
        //
    }
}