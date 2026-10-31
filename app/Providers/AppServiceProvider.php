<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View as ViewInstance;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        URL::forceHttps($this->app->isProduction());

        // Keyed by IP: a session key resets whenever a bot drops its cookies.
        RateLimiter::for('brochure-leads', function (Request $request): Limit {
            return Limit::perMinutes(10, 5)
                ->by($request->ip())
                ->response(fn () => response()->json([
                    'success' => false,
                    'message' => 'Too many submissions. Please try again in a few minutes.',
                ], 429));
        });

        RateLimiter::for('bus-registration', function (Request $request): Limit {
            return Limit::perMinutes(10, 10)
                ->by($request->ip())
                ->response(fn () => response()->json([
                    'ok' => false,
                    'message' => 'Too many submissions. Please try again in a few minutes.',
                ], 429));
        });

        // Every question may cost a Gemini call and every spoken reply a billed TTS call, so cap bursts and daily use.
        foreach (['assistant' => [10, 150], 'assistant-media' => [20, 300]] as $name => [$perMinute, $perDay]) {
            RateLimiter::for($name, function (Request $request) use ($perMinute, $perDay): array {
                $tooMany = fn () => response()->json([
                    'success' => false,
                    'message' => 'You have made a lot of requests. Please wait a little and try again.',
                ], 429);

                return [
                    Limit::perMinute($perMinute)->by('minute:'.$request->ip())->response($tooMany),
                    Limit::perDay($perDay)->by('day:'.$request->ip())->response($tooMany),
                ];
            });
        }

        View::composer('layouts.base', function (ViewInstance $view): void {
            $path = request()->path();

            $view->with('canonicalUrl', config('rgu.canonical_url').'/'.($path === '/' ? '' : $path));
        });

        View::composer('partials.footer', function (ViewInstance $view): void {
            // Section links (#courses, #contact, ...) point at homepage sections.
            $view->with('homeUrl', request()->routeIs('home') ? '' : route('home'));
        });
    }
}
