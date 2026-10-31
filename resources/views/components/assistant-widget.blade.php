{{--
    Floating AI FAQ & voice assistant. Included once by layouts.base on every
    page (opt out with @section('without-voice-assistant', true)).
    Behaviour: public/js/assistant.js, styles: public/css/assistant.css.
    The microphone is only requested after the visitor presses the mic button.
--}}
<link rel="stylesheet" href="{{ versioned_asset('css/assistant.css') }}" media="print" onload="this.media='all'">
<div id="rga" class="rga" hidden
     data-ask="{{ route('assistant.ask') }}"
     data-history="{{ url('api/assistant/history') }}"
     data-feedback="{{ route('assistant.feedback') }}"
     data-transcribe="{{ route('assistant.transcribe') }}"
     data-speak="{{ route('assistant.speak') }}"
     data-csrf="{{ csrf_token() }}"
     data-default-language="{{ config('assistant.default_language') }}"
     data-max-length="{{ config('assistant.max_message_length') }}"
     data-voice-output="{{ app(\App\Services\Assistant\TextToSpeechService::class)->isConfigured() ? '1' : '0' }}"
     data-voice-input-fallback="{{ app(\App\Services\Assistant\SpeechTranscriptionService::class)->isConfigured() ? '1' : '0' }}">
    <button type="button" class="rga-launcher" data-rga="open" aria-label="Open Rathinam assistant" aria-expanded="false">
        <svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="9" y="2" width="6" height="12" rx="3"/><path d="M5 10a7 7 0 0 0 14 0M12 17v5M8 22h8"/></svg>
    </button>

    <section class="rga-panel" data-rga="panel" role="dialog" aria-label="Rathinam assistant" hidden>
        <header class="rga-head">
            <div class="rga-head__title"><strong>Rathinam Assistant</strong><span data-rga="status" aria-live="polite">Ask in Tamil, English or Tanglish</span></div>
            <select data-rga="language" aria-label="Language">
                <option value="auto">Auto</option>
                <option value="ta">தமிழ்</option>
                <option value="en">English</option>
            </select>
            <button type="button" data-rga="voice-toggle" aria-pressed="true" title="Voice replies on/off" aria-label="Toggle voice replies">🔊</button>
            <button type="button" data-rga="clear" title="Clear conversation" aria-label="Clear conversation">🗑</button>
            <button type="button" data-rga="minimize" title="Minimize" aria-label="Minimize">–</button>
            <button type="button" data-rga="close" title="Close" aria-label="Close">✕</button>
        </header>
        <ol class="rga-log" data-rga="log" aria-live="polite"></ol>
        <p class="rga-error" data-rga="error" role="alert" hidden></p>
        <form class="rga-form" data-rga="form" autocomplete="off">
            <button type="button" class="rga-mic" data-rga="mic" aria-label="Start speaking" title="Speak">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="9" y="2" width="6" height="12" rx="3"/><path d="M5 10a7 7 0 0 0 14 0M12 17v5"/></svg>
            </button>
            <input type="text" data-rga="input" maxlength="{{ config('assistant.max_message_length') }}" placeholder="Type or speak your question" aria-label="Your question">
            <button type="submit" class="rga-send" data-rga="send">Send</button>
        </form>
    </section>
</div>
<script src="{{ versioned_asset('js/assistant.js') }}" defer></script>
