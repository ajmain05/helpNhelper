<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->has('lang') && $request->get('lang') !== null) {
            session(['locale' => $request->get('lang')]);
            \Illuminate\Support\Facades\Log::info('Language set to: ' . $request->get('lang'));
        }
        
        if (session()->has('locale')) {
            app()->setLocale(session('locale'));
            \Illuminate\Support\Facades\Log::info('App locale set to: ' . session('locale'));
        } else {
            app()->setLocale(config('app.locale'));
        }

        return $next($request);
    }
}
