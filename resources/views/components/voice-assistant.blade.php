{{--
    Website voice assistant: floating button + chat panel, on every page that
    uses layouts.base (opt out with @section('without-voice-assistant', true)).

    Speech recognition and speech synthesis run in the browser
    (public/js/voice-assistant.js); questions go to route voice-assistant.chat.
    The microphone is only requested after the visitor presses the mic button.
    Text is in English here and swapped by the script when Tamil is chosen.
    Questions are spoken only — there is no text input.

    The panel opens on the "AI team": the visitor picks a persona (resources/data/voice-assistant.php)
    and presses "Let's Talk" to start a voice call with them (data-view="call": call timer,
    mic mute and "End Call"; no typing).

    Expects: $voiceAssistant ['endpoint', 'speechEndpoint', 'csrfToken', 'usesAi', 'providerName', 'maxLength', 'personas']
    (view composer in AppServiceProvider).
--}}
<style>#rva{visibility:hidden}</style>
<link rel="preload" href="{{ versioned_asset('css/voice-assistant.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">

<div id="rva" class="rva" hidden
     data-endpoint="{{ $voiceAssistant['endpoint'] }}"
     data-speech-endpoint="{{ $voiceAssistant['speechEndpoint'] }}"
     data-csrf="{{ $voiceAssistant['csrfToken'] }}"
     data-uses-ai="{{ $voiceAssistant['usesAi'] ? '1' : '0' }}"
     data-provider="{{ $voiceAssistant['providerName'] }}"
     data-max-length="{{ $voiceAssistant['maxLength'] }}">

    <button type="button" class="rva-launcher" aria-expanded="false" aria-controls="rva-panel" data-rva="launcher">
        <span class="rva-launcher__orb" aria-hidden="true">
            <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="2" width="6" height="12" rx="3"/><path d="M5 10a7 7 0 0 0 14 0M12 17v5M8 22h8"/></svg>
        </span>
        <span class="rva-launcher__label" data-i18n="launcher">Ask RGU</span>
    </button>

    <section id="rva-panel" class="rva-panel" role="dialog" aria-modal="false" aria-labelledby="rva-title" hidden data-rva="panel" data-state="idle" data-view="intro">
        <header class="rva-head">
            <span class="rva-head__orb" aria-hidden="true"><i></i></span>
            <span class="rva-head__avatar" aria-hidden="true"><img src="" alt="" width="40" height="40" data-rva="head-avatar"></span>
            <div class="rva-head__text">
                <h2 id="rva-title" class="rva-head__title" data-i18n="title">Rathinam Assistant</h2>
                <p class="rva-head__status" data-rva="status" aria-live="polite" data-i18n="statusIdle">Ask about admissions, programmes and campus</p>
            </div>
            <span class="rva-timer" data-rva="timer" role="timer" aria-label="Call duration" data-i18n-label="callTimer">0:00</span>
            <div class="rva-head__actions">
                <button type="button" class="rva-icon" data-rva="team" aria-label="Choose someone else" data-i18n-label="changePersona">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="9" cy="8" r="3.5"/><path d="M2.5 20a6.5 6.5 0 0 1 13 0M16 4.5a3.5 3.5 0 0 1 0 7M18 14a6.5 6.5 0 0 1 3.5 6"/></svg>
                </button>
                <div class="rva-lang" role="group" aria-label="Language" data-i18n-label="language">
                    <button type="button" class="rva-lang__btn" data-lang="en" aria-pressed="true" lang="en">EN</button>
                    <button type="button" class="rva-lang__btn" data-lang="ta" aria-pressed="false" lang="ta">தமிழ்</button>
                </div>
                <button type="button" class="rva-icon" data-rva="mute" aria-pressed="false" aria-label="Mute voice replies" data-i18n-label="mute">
                    <svg class="rva-ico-on" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M11 5 6 9H2v6h4l5 4zM15.5 8.5a5 5 0 0 1 0 7M19 5a10 10 0 0 1 0 14"/></svg>
                    <svg class="rva-ico-off" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M11 5 6 9H2v6h4l5 4zM22 9l-6 6M16 9l6 6"/></svg>
                </button>
                <button type="button" class="rva-icon" data-rva="close" aria-label="Close assistant" data-i18n-label="close">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M18 6 6 18M6 6l12 12"/></svg>
                </button>
            </div>
        </header>

        <div class="rva-body" data-rva="body">
            <div class="rva-intro" data-rva="intro">
                <h3 class="rva-intro__title" data-i18n="teamTitle">Rathinam AI Team</h3>
                <p class="rva-intro__text" data-i18n="teamText">Choose who you’d like to talk to.</p>

                <div class="rva-team" role="group" aria-label="Rathinam AI Team" data-i18n-label="teamTitle">
                    @foreach ($voiceAssistant['personas'] as $key => $persona)
                        <button type="button" class="rva-member" data-persona="{{ $key }}" aria-pressed="false">
                            <span class="rva-member__photo"><img src="{{ $persona['image'] }}" alt="" width="240" height="240" loading="lazy" decoding="async"></span>
                            <span class="rva-member__name" data-persona-name>{{ $persona['name']['en'] }}</span>
                            <span class="rva-member__role" data-persona-role>{{ $persona['role']['en'] }}</span>
                        </button>
                    @endforeach
                </div>

                <button type="button" class="rva-talk" data-rva="start-voice">
                    <span class="rva-talk__logo" aria-hidden="true">R</span>
                    <span data-i18n="letsTalk">Let’s Talk</span>
                </button>

                <div class="rva-notice">
                    <p data-i18n="micNotice">Voice needs microphone permission. Your browser will ask only after you press “Let’s Talk”.</p>
                    <details>
                        <summary data-i18n="privacyTitle">How your voice and questions are handled</summary>
                        <ul>
                            <li data-i18n="privacy1">Your browser turns speech into text. In Chrome, Edge and Safari this uses the browser maker’s online speech service.</li>
                            <li data-i18n="privacy2">We never record or store audio. Only the text of your question is sent to our server.</li>
                            <li data-rva="privacy-ai" data-i18n="privacy3">To write an answer, your question text is sent to our AI provider.</li>
                            <li data-i18n="privacy4">The last few messages are kept for 30 minutes so follow-up questions make sense, then deleted.</li>
                            <li data-i18n="privacy5">Please do not share personal details such as phone numbers or addresses.</li>
                        </ul>
                    </details>
                </div>
            </div>

            <ol class="rva-log" data-rva="log" aria-live="polite" aria-relevant="additions"></ol>
        </div>

        <div class="rva-stage" data-rva="stage">
            <div class="rva-wave" aria-hidden="true">
                @for ($bar = 0; $bar < 14; $bar++)<span style="--i:{{ $bar }}"></span>@endfor
            </div>
            <p class="rva-transcript" data-rva="transcript" aria-live="polite"></p>
            <p class="rva-caption" data-rva="caption"></p>
            <p class="rva-call-note" data-rva="call-note" aria-live="polite"></p>
            <div class="rva-confirm" data-rva="confirm" hidden role="alertdialog" aria-labelledby="rva-confirm-text">
                <p id="rva-confirm-text" data-i18n="confirmPersonal">Your message looks like it contains a phone number or email address. Send it anyway?</p>
                <div>
                    <button type="button" class="rva-btn rva-btn--primary rva-btn--sm" data-rva="confirm-send" data-i18n="confirmSend">Send</button>
                    <button type="button" class="rva-btn rva-btn--ghost rva-btn--sm" data-rva="confirm-edit" data-i18n="confirmEdit">Ask again</button>
                </div>
            </div>
        </div>

        <footer class="rva-foot">
            <button type="button" class="rva-mic" data-rva="mic" aria-label="Start speaking" data-i18n-label="micStart">
                <span class="rva-mic__ring" aria-hidden="true"></span>
                <svg class="rva-mic__ico" viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="9" y="2" width="6" height="12" rx="3"/><path d="M5 10a7 7 0 0 0 14 0M12 17v5"/></svg>
                <svg class="rva-mic__stop" viewBox="0 0 24 24" width="18" height="18" aria-hidden="true"><rect x="6" y="6" width="12" height="12" rx="2" fill="currentColor"/></svg>
            </button>
            <button type="button" class="rva-stop" data-rva="stop" hidden data-i18n="stopSpeaking">Stop speaking</button>
        </footer>

        <div class="rva-call" data-rva="call-bar">
            <button type="button" class="rva-call__mic" data-rva="call-mic" aria-pressed="false" aria-label="Mute microphone" data-i18n-label="muteMic">
                <svg class="rva-call__mic-on" viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="9" y="2" width="6" height="12" rx="3"/><path d="M5 10a7 7 0 0 0 14 0M12 17v5"/></svg>
                <svg class="rva-call__mic-off" viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 9.3V5a3 3 0 0 0-5.7-1.3M9 9v3a3 3 0 0 0 5.1 2.1M19 10a7 7 0 0 1-1.2 3.9M5 10a7 7 0 0 0 10.9 5.8M12 17v5M3 3l18 18"/></svg>
            </button>
            <button type="button" class="rva-call__end" data-rva="end-call">
                <svg viewBox="0 0 24 24" width="16" height="16" aria-hidden="true"><rect x="5" y="5" width="14" height="14" rx="2" fill="currentColor"/></svg>
                <span data-i18n="endCall">End Call</span>
            </button>
        </div>
    </section>
</div>
<script type="application/json" id="rva-personas">@json($voiceAssistant['personas'])</script>
<script src="{{ versioned_asset('js/voice-assistant.js') }}" defer></script>
