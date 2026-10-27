<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Resend, Postmark, AWS, and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    /*
    | AI provider for the website voice assistant. Any service that speaks the
    | OpenAI "chat/completions" format works (Google Gemini, Groq, OpenRouter,
    | OpenAI, a self-hosted Ollama, ...): change the three AI_* values only.
    | With no key and model set, the assistant answers from the knowledge base.
    */
    'ai' => [
        'key' => env('AI_API_KEY'),
        'model' => env('AI_MODEL'),
        'base_url' => env('AI_BASE_URL'),
        'provider_name' => env('AI_PROVIDER_NAME', 'an external AI service'),
        'timeout' => (int) env('AI_TIMEOUT', 20),
        'max_tokens' => (int) env('AI_MAX_TOKENS', 800),
    ],

    /*
    | Google Cloud Text-to-Speech: reads the voice assistant's answers aloud in
    | browsers that have no voice for the language (most desktops lack Tamil).
    | Without a key, answers are spoken only where the browser has a voice.
    | Voice names: https://cloud.google.com/text-to-speech/docs/voices
    */
     'google_tts' => [
        'key' => env('GOOGLE_TTS_KEY'),
        'timeout' => (int) env('GOOGLE_TTS_TIMEOUT', 15),
        'voices' => [
            'ta' => [
                'female' => env('GOOGLE_TTS_VOICE_TA_FEMALE', 'ta-IN-Chirp3-HD-Aoede'),
                'male' => env('GOOGLE_TTS_VOICE_TA_MALE', 'ta-IN-Chirp3-HD-Charon'),
            ],
            'en' => [
                'female' => env('GOOGLE_TTS_VOICE_EN_FEMALE', 'en-IN-Chirp3-HD-Aoede'),
                'male' => env('GOOGLE_TTS_VOICE_EN_MALE', 'en-IN-Chirp3-HD-Charon'),
            ],
        ],
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

];
