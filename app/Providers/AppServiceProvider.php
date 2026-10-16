<?php

namespace App\Providers;

use App\Services\VoiceAssistant\ChatProvider;
use App\Services\VoiceAssistant\GoogleTextToSpeech;
use App\Services\VoiceAssistant\KnowledgeBase;
use App\Services\VoiceAssistant\OpenAiCompatibleProvider;
use App\Services\VoiceAssistant\VoiceAssistant;
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
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ChatProvider::class, fn (): ChatProvider => new OpenAiCompatibleProvider(
            apiKey: config('services.ai.key'),
            model: config('services.ai.model'),
            baseUrl: config('services.ai.base_url'),
            timeout: (int) config('services.ai.timeout'),
            maxTokens: (int) config('services.ai.max_tokens'),
        ));

        $this->app->bind(GoogleTextToSpeech::class, fn (): GoogleTextToSpeech => new GoogleTextToSpeech(
            apiKey: config('services.google_tts.key'),
            voices: config('services.google_tts.voices'),
            cache: $this->app->make('cache.store'),
            timeout: (int) config('services.google_tts.timeout'),
        ));
    }

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

        // Every answer may cost a provider call, so cap both bursts and daily use per visitor.
        RateLimiter::for('voice-assistant', function (Request $request): array {
            $tooMany = fn () => response()->json([
                'success' => false,
                'message' => 'You have asked a lot of questions. Please wait a little and try again.',
            ], 429);

            return [
                Limit::perMinute(10)->by('minute:'.$request->ip())->response($tooMany),
                Limit::perDay(150)->by('day:'.$request->ip())->response($tooMany),
            ];
        });

        // Each spoken reply is a billed text-to-speech call (unless cached), so it is capped like questions.
        RateLimiter::for('voice-assistant-speech', function (Request $request): array {
            $tooMany = fn () => response()->json(['success' => false, 'message' => 'Too many requests. Please wait a little.'], 429);

            return [
                Limit::perMinute(20)->by('minute:'.$request->ip())->response($tooMany),
                Limit::perDay(300)->by('day:'.$request->ip())->response($tooMany),
            ];
        });

        View::composer('layouts.base', function (ViewInstance $view): void {
            $path = request()->path();

            $view->with('canonicalUrl', config('rgu.canonical_url').'/'.($path === '/' ? '' : $path));
        });

        View::composer('components.voice-assistant', function (ViewInstance $view): void {
            $personas = collect($this->app->make(KnowledgeBase::class)->personas())
                ->map(fn (array $persona): array => [
                    'name' => $persona['name'],
                    'role' => $persona['role'],
                    'voice' => $persona['voice'],
                    'image' => versioned_asset($persona['image']),
                    'greeting' => $persona['greeting'],
                ])
                ->all();

            $view->with('voiceAssistant', [
                'endpoint' => route('voice-assistant.chat'),
                'speechEndpoint' => $this->app->make(GoogleTextToSpeech::class)->isConfigured() ? route('voice-assistant.speech') : '',
                'csrfToken' => csrf_token(),
                'usesAi' => $this->app->make(VoiceAssistant::class)->usesAi(),
                'providerName' => config('services.ai.provider_name'),
                'maxLength' => (int) config('rgu.voice_assistant.max_message_length'),
                'personas' => $personas,
            ]);
        });

        View::composer('partials.footer', function (ViewInstance $view): void {
            // Section links (#courses, #contact, ...) point at homepage sections.
            $view->with('homeUrl', request()->routeIs('home') ? '' : route('home'));
        });
    }
}
