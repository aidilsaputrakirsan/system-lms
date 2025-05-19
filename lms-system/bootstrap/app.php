<?php
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Mendaftarkan middleware dengan nama class-nya
        $middleware->append(\App\Http\Middleware\SetLocaleMiddleware::class);
        
        // Atau bisa juga didaftarkan ke grup web seperti ini:
        $middleware->web(append: [\App\Http\Middleware\SetLocaleMiddleware::class]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->withProviders([
        App\Providers\TranslationServiceProvider::class,
    ])
    ->create();