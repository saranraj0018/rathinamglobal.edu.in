<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Canonical URL
    |--------------------------------------------------------------------------
    |
    | Every page emits <link rel="canonical"> against this host, regardless of
    | the host the request arrived on (staging, localhost, www.).
    |
    */

    'canonical_url' => rtrim(env('RGU_CANONICAL_URL', 'https://rathinamglobal.edu.in'), '/'),

    /*
    |--------------------------------------------------------------------------
    | Analytics (homepage)
    |--------------------------------------------------------------------------
    */

    'analytics' => [
        'ga4_id' => env('RGU_GA4_ID', 'G-EKNZR4B5B8'),
        'meta_pixel_id' => env('RGU_META_PIXEL_ID', '1081423431094840'),
    ],

    /*
    |--------------------------------------------------------------------------
    | AC bus registration (/acbus)
    |--------------------------------------------------------------------------
    |
    | Submissions are forwarded server-side to a Google Apps Script web app,
    | which must be deployed as "Execute as: Me" / "Who has access: Anyone".
    | Leave the Turnstile secret empty to skip CAPTCHA verification.
    |
    */

    'bus_registration' => [
        'apps_script_url' => env('BUS_REGISTRATION_APPS_SCRIPT_URL'),
        'turnstile_site_key' => env('TURNSTILE_SITE_KEY', '0x4AAAAAAECxzNbaUSYB2bse'),
        'turnstile_secret' => env('TURNSTILE_SECRET_KEY'),
    ],

    /*
    |--------------------------------------------------------------------------
    | ESG / ESIA enquiry leads and gated brochures
    |--------------------------------------------------------------------------
    |
    | A lead is forwarded to Apps Script; only once the sheet confirms the row
    | does the visitor's session receive a short-lived grant to stream the
    | brochure. Brochures live on the private "local" disk.
    |
    */

    'brochure_leads' => [
        'apps_script_url' => env('BROCHURE_LEADS_APPS_SCRIPT_URL'),

        'grant_ttl' => 1800,

        'brochures' => [
            'esg' => ['path' => 'brochures/esg-brochure.pdf', 'download_name' => 'ESG-Brochure.pdf'],
            'esia' => ['path' => 'brochures/esia-brochure.pdf', 'download_name' => 'ESIA-Brochure.pdf'],
        ],

        'sites' => [
            'esg' => ['target_sheet' => 'esg_leads', 'default_programme' => 'ESG Course', 'default_brochure' => 'esg'],
            'esia' => ['target_sheet' => 'esia_leads', 'default_programme' => 'ESIA Course', 'default_brochure' => 'esia'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Website voice assistant
    |--------------------------------------------------------------------------
    |
    | Answers come from resources/data/voice-assistant.php, the FAQ and the
    | school pages; the AI provider is configured under services.ai. Only the
    | last few turns of a conversation are kept, in the cache, for
    | conversation_ttl seconds. Audio never reaches the server.
    |
    */

    'voice_assistant' => [
        'enabled' => (bool) env('VOICE_ASSISTANT_ENABLED', true),
        // Logs how each question was understood and which entry won (see VoiceAssistant::trace()).
        'debug' => (bool) env('VOICE_ASSISTANT_DEBUG', in_array(env('APP_ENV'), ['local', 'testing'], true)),
        'max_message_length' => 500,
        'history_turns' => 3,
        'conversation_ttl' => 1800,
        'context_entries' => 8,
        'max_answer_length' => 1200,
    ],

];
