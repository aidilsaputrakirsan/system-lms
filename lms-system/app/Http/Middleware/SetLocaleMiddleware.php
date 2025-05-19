<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SetLocaleMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is logged in and has a language preference
        if (Auth::check() && !empty(Auth::user()->language_preference)) {
            App::setLocale(Auth::user()->language_preference);
        } 
        // Otherwise, use the default locale from config
        else {
            App::setLocale(config('app.locale', 'id'));
        }

        return $next($request);
    }
}