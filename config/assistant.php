<?php

/*
|--------------------------------------------------------------------------
| AI FAQ & voice assistant
|--------------------------------------------------------------------------
|
| Knowledge comes from the admin-managed FAQs and knowledge documents (see
| /admin). Gemini only rephrases retrieved chunks; it never answers from
| general knowledge. Every value is read from .env (documented in
| .env.example).
|
*/

return [

    // Configurable diagnostic mode: when true, bypasses retrieval to test Gemini API key directly.
    'diagnostic_mode' => (bool) env('ASSISTANT_DIAGNOSTIC_MODE', false),

    'enabled' => (bool) env('ASSISTANT_ENABLED', true),

    /** Language used when the visitor's message gives no signal: ta | en. */
    'default_language' => env('ASSISTANT_DEFAULT_LANGUAGE', 'ta'),

    /** Previous turns sent to Gemini so follow-up questions make sense. */
    'max_context_messages' => (int) env('ASSISTANT_MAX_CONTEXT_MESSAGES', 6),

    /** Chunks handed to Gemini per question. */
    'retrieval_limit' => (int) env('ASSISTANT_RETRIEVAL_LIMIT', 5),

    /** Normalised relevance (0-1) a chunk needs to count as an answer. */
    'min_relevance_score' => (float) env('ASSISTANT_MIN_RELEVANCE_SCORE', 0.25),

    // Simplified two-path architecture: General Gemini Intelligence + Hostel & Transport only.
    'hostel_only_knowledge' => (bool) env('ASSISTANT_HOSTEL_ONLY_KNOWLEDGE', true),

    // THIS IS NEW CODE — enable approved bundled facts while the live index is incomplete. Reason: local DB has no BCA coverage.
    'temporary_knowledge_mode' => (bool) env('ASSISTANT_TEMPORARY_KNOWLEDGE_MODE', true),

    // THIS IS NEW CODE — allow retrieval from the canonical Rathinam host. Reason: local index lacks course coverage.
    'official_website' => ['enabled' => (bool) env('ASSISTANT_OFFICIAL_WEBSITE_ENABLED', false)],
    'max_message_length' => (int) env('ASSISTANT_MAX_MESSAGE_LENGTH', 500),

    /** Maximum characters per knowledge chunk when long content is split. */
    'chunk_size' => 700,

    'gemini' => [
        'key' => env('GEMINI_API_KEY'),
        'model' => env('GEMINI_MODEL'),
        'url' => rtrim((string) env('GEMINI_API_URL', 'https://generativelanguage.googleapis.com/v1beta'), '/'),
        // OLD CODE — NOT USED NOW: the 20-second default made one generation call consume most of the browser's 30-second deadline.
        // 'timeout' => (int) env('GEMINI_TIMEOUT', 20),
        'timeout' => (int) env('GEMINI_TIMEOUT', 15),
        'max_output_tokens' => (int) env('GEMINI_MAX_OUTPUT_TOKENS', 800),
        'retries' => (int) env('GEMINI_RETRIES', 2),
        'retry_delay_ms' => 600,
    ],
    // Separate Gemini Live configuration
    'gemini_live' => [
        'key' => env('GEMINI_LIVE_API_KEY'),
        // THIS IS NEW CODE — select the native-audio Live path through configuration. Reason: keep the prior transcription/answer/TTS implementation available as a reversible fallback.
        'native_enabled' => (bool) env('GEMINI_LIVE_NATIVE_ENABLED', true),
        // OLD CODE — NOT USED NOW: the default previously pointed at the standard Live model; set GEMINI_LIVE_MODEL=gemini-3.8-live to switch back.
        // THIS IS NEW CODE — default to the requested Extended Thinking Live model when the environment does not specify one. Reason: keep Laravel and the browser token on the intended Live model.
        'model' => env('GEMINI_LIVE_MODEL', 'gemini-3.8-live-extended-thinking'),
        // THIS IS NEW CODE — use Google's dedicated Live transcription model for speech-to-text before verified server retrieval.
        'transcription_model' => env('GEMINI_LIVE_TRANSCRIPTION_MODEL', 'gemini-3.5-transcribe-live'),
        // THIS IS NEW CODE — bound ephemeral-token provisioning to the same short upstream budget used by text generation.
        'token_timeout' => (int) env('GEMINI_LIVE_TOKEN_TIMEOUT', 8),
        'url' => 'https://generativelanguage.googleapis.com/v1beta',
    ],

    'google' => [
        'project_id' => env('GOOGLE_CLOUD_PROJECT_ID'),
        'credentials' => env('GOOGLE_APPLICATION_CREDENTIALS'),
        'api_key' => env('GOOGLE_API_KEY'),
        'timeout' => 15,
    ],

    'tts' => [
        'voices' => [
            'ta' => ['language_code' => 'ta-IN', 'name' => env('GOOGLE_TTS_VOICE_TA', 'ta-IN-Chirp3-HD-Aoede'), 'name_male' => env('GOOGLE_TTS_VOICE_TA_MALE', 'ta-IN-Chirp3-HD-Charon')],
            'en' => ['language_code' => 'en-IN', 'name' => env('GOOGLE_TTS_VOICE_EN', 'en-IN-Chirp3-HD-Aoede'), 'name_male' => env('GOOGLE_TTS_VOICE_EN_MALE', 'en-IN-Chirp3-HD-Charon')],
        ],
        'speaking_rate' => (float) env('GOOGLE_TTS_SPEAKING_RATE', 1.0),
        'pitch' => 0.0,
        'cache_seconds' => 604800,
        'max_characters' => 1000,
        /** Share of Tamil-script letters a text needs to be read by the Tamil voice. */
        'min_tamil_ratio' => 0.3,
    ],

    'transcription' => [
        'max_kilobytes' => 4096,
    ],

    /** Shown when nothing verified is available; {contact} is the admin-set admissions contact. */
    'messages' => [
        'no_information' => [
            'en' => 'I do not have verified information about that. Please contact our admissions team: {contact}',
            'ta' => 'அதைப் பற்றிய சரிபார்க்கப்பட்ட தகவல் என்னிடம் இல்லை. தயவுசெய்து எங்கள் சேர்க்கை அலுவலகத்தைத் தொடர்பு கொள்ளுங்கள்: {contact}',
        ],
        'unavailable' => [
            'en' => 'The assistant is temporarily unavailable. Please try again shortly or contact admissions: {contact}',
            'ta' => 'உதவியாளர் தற்போது கிடைக்கவில்லை. சிறிது நேரம் கழித்து முயற்சிக்கவும் அல்லது சேர்க்கை அலுவலகத்தைத் தொடர்பு கொள்ளுங்கள்: {contact}',
        ],
        'greeting' => [
            'en' => 'Hello! Ask me anything about Rathinam admissions, courses, fees, hostel or placements.',
            'ta' => 'வணக்கம்! ரத்தினம் சேர்க்கை, படிப்புகள், கட்டணம், விடுதி, வேலைவாய்ப்பு பற்றி எதையும் கேளுங்கள்.',
        ],
        'default_contact' => 'Please visit the Contact section of our website.',
    ],

];
