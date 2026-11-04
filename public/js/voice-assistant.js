/*
 * Website voice assistant (resources/views/components/voice-assistant.blade.php).
 *
 * Voice chat: Web Speech API input and browser/server speech output.
 * Apply:     a reply with a `redirect` (the visitor asked to apply) is spoken, then the
 *            tab goes to that admissions page.
 * Answers:   POST to the Laravel endpoint in data-endpoint (CSRF protected).
 * AI team:   the panel opens on a choice of personas (#rva-personas JSON); each has
 *            its own greeting and a female or male voice, and is
 *            sent with every question so the answer comes "from" them.
 * Voice call: "Let's Talk" starts Gemini Live transcription and RAG answer speech with
 *            the chosen persona. The team stays on screen with a timer, mic mute and
 *            "End Call" controls.
 * Voice only: questions are spoken, never typed or picked from a list. "Let's Talk"
 *            asks for the microphone straight away (the browser's permission
 *            popup), plays a short connect tone, then the persona greets the
 *            visitor and listens. Browsers without speech recognition (e.g.
 *            Firefox) or plain http only get a notice.
 * Speech input and output can be swapped for server-side services by
 * replacing listen() and speak(); nothing else depends on the Web Speech API.
 */
(() => {
  "use strict";

  const root = document.getElementById("rva");
  if (!root) return;

  const $ = (name) => root.querySelector(`[data-rva="${name}"]`);
  const el = {
    launcher: $("launcher"), panel: $("panel"), status: $("status"), mute: $("mute"), close: $("close"),
    body: $("body"), intro: $("intro"), log: $("log"),
    transcript: $("transcript"), confirm: $("confirm"), confirmSend: $("confirm-send"), confirmEdit: $("confirm-edit"),
    mic: $("mic"), stop: $("stop"),
    startVoice: $("start-voice"), privacyAi: $("privacy-ai"),
    team: $("team"), headAvatar: $("head-avatar"), title: root.querySelector("#rva-title"),
    timer: $("timer"), callMic: $("call-mic"), endCall: $("end-call"), callNote: $("call-note"), caption: $("caption"),
    members: [...root.querySelectorAll("[data-persona]")],
  };

  /** @type {Record<string, {name: Record<string, string>, role: Record<string, string>, voice: "female"|"male", image: string, greeting: Record<string, string>}>} */
  const PERSONAS = (() => {
    try { return JSON.parse(document.getElementById("rva-personas")?.textContent || "{}"); } catch { return {}; }
  })();

  const config = {
    endpoint: root.dataset.endpoint,
    speechEndpoint: root.dataset.speechEndpoint || "",
    csrf: root.dataset.csrf,
    usesAi: root.dataset.usesAi === "1",
    provider: root.dataset.provider || "",
    maxLength: parseInt(root.dataset.maxLength, 10) || 500,
    // OLD CODE — NOT USED NOW: 30 seconds exceeded the visible response deadline after repeated backend retries.
    // requestTimeout: 30000,
    // THIS IS NEW CODE — leave enough time to render a verified fallback, while backend retries now remain well below this limit.
    requestTimeout: 27000,
    listenTimeout: 15000,
    relistenDelay: 450,
    /* Rounds of silence (each up to listenTimeout) before a call mutes the mic. */
    maxSilentRounds: 4,
  };

  const LANG_CODES = { en: "en-IN", ta: "ta-IN" };
  const Recognition = window.SpeechRecognition || window.webkitSpeechRecognition || null;
  const synth = "speechSynthesis" in window && "SpeechSynthesisUtterance" in window ? window.speechSynthesis : null;
  const voiceSupported = Boolean(Recognition) && window.isSecureContext;
  /* Speech engines don't report a voice's gender, so it is guessed from well-known voice names. */
  const FEMALE_VOICE = /female|woman|neerja|pallavi|heera|kalpana|swara|veena|lekha|aditi|raveena|kajal|zira|samantha|karen|moira|tessa|susan|hazel|jenny|aria|sonia|libby|natasha|google us english|google uk english female/i;
  const MALE_VOICE = /\bmale\b|\bman\b|prabhat|valluvar|ravi|hemant|rishi|madhur|david|mark|george|daniel|alex|fred|guy|ryan|thomas|google uk english male/i;
  /* Neural voices (Edge "Online (Natural)", Safari "Enhanced"/"Premium", Chrome's online Google voices) sound human; older local ones sound robotic. */
  const NATURAL_VOICE = /natural|neural|online|premium|enhanced/i;
  const TAMIL_SCRIPT = /[\u0B80-\u0BFF]/;
  const PERSONAL_DATA = /[^\s@]+@[^\s@]+\.[a-z]{2,}|(?:\+?\d[\s-]?){10,}/i;

  const TEXT = {
    en: {
      launcher: "Ask RGU",
      // THIS IS NEW CODE — use Priya's name in the widget header. Reason: the assistant should present as a voice companion rather than a generic site bot.
      title: "Priya",
      language: "Language",
      mute: "Mute voice replies",
      unmute: "Turn voice replies on",
      close: "Close assistant",
      statusIdle: "Ready when you are",
      // THIS IS NEW CODE — label connection and interruption states in the compact voice header. Reason: keep status copy aligned with Live lifecycle events.
      statusConnecting: "Connecting…",
      statusListening: "Listening… speak now",
      statusProcessing: "Thinking…",
      statusSpeaking: "Speaking…",
      statusInterrupted: "Interrupted",
      statusError: "Connection error",
      // THIS IS NEW CODE — present Priya as the one assistant and tell visitors to tap her to begin.
      teamTitle: "Meet Priya",
      teamText: "Tap Priya to start. She can help in English or Tamil.",
      letsTalk: "Let’s Talk",
      endCall: "End Call",
      callTimer: "Call duration",
      callWith: (name) => `On a call with ${name}`,
      muteMic: "Mute microphone",
      unmuteMic: "Unmute microphone",
      micMuted: "Microphone muted — tap the mic to talk",
      stillThere: "Are you still there? Tap the mic to keep talking.",
      openNow: "Open now",
      changePersona: "Choose someone else",
      // THIS IS NEW CODE — match the single-action Priya welcome flow and automatic language detection.
      micNotice: "Tap Priya to begin. After her welcome, your browser will ask for microphone permission. Answers use approved Rathinam Global University information.",
      privacyTitle: "How your voice and questions are handled",
      privacy1: "During a voice call, your microphone audio streams to Google Gemini Live, which transcribes your speech.",
      privacy2: "The transcript of your question is sent to our server to look up an approved Rathinam answer.",
      privacy3: (p) => `To prepare and speak the answer, your question and approved answer text are sent to our AI provider${p ? ` (${p})` : ""}.`,
      privacy4: "The last few messages are kept for 30 minutes so follow-up questions make sense, then deleted.",
      privacy5: "Please do not share personal details such as phone numbers or addresses.",
      allowMic: "Allow the microphone to start the call…",
      micStart: "Start speaking",
      micStop: "Stop listening",
      micEnd: "End voice chat",
      stopSpeaking: "Stop speaking",
      voicePaused: "Voice chat paused because I didn’t hear anything. Press the mic to continue talking.",
      replay: "Replay",
      retry: "Try again",
      source: "Source",
      confirmPersonal: "Your message looks like it contains a phone number or email address. Send it anyway?",
      confirmSend: "Send",
      confirmEdit: "Ask again",
      chatNote: "Just talk — I’ll answer aloud and then listen for your next question. Press the mic to end or restart the conversation. You can switch between English and தமிழ் at any time.",
      noVoiceSupport: "Voice calls need Chrome, Edge or Safari. Please open this page in one of those browsers to talk to us.",
      insecure: "Voice calls need a secure (https) connection. Please open the https version of this page to talk to us.",
      langSwitched: "Switched to English.",
      noVoiceForLanguage: "This computer has no Tamil voice, so Tamil answers are shown as text below. Switch to English, or use a phone or a PC with a Tamil voice installed.",
      micDenied: "Microphone access is blocked. Click the lock icon next to the address bar, allow the microphone for this site, then tap the mic.",
      serviceDenied: "Speech recognition isn’t available for this language or is blocked in this browser.",
      noSpeech: "I didn’t hear anything. Press the mic and try again.",
      noMic: "No microphone was found. Check that one is connected, then tap the mic.",
      speechNetwork: "Speech recognition needs an internet connection. Check your connection and press the mic to try again.",
      langUnsupported: "This browser can’t recognise speech in the selected language. Try switching language.",
      speechGeneric: "Voice input stopped unexpectedly. Press the mic to try again.",
      tooShort: "Please ask a longer question.",
      tooLong: (n) => `Please keep your question under ${n} characters.`,
      offline: "You appear to be offline. Check your connection and try again.",
      timeout: "The answer is taking too long. Please try again.",
      network: "We couldn’t reach the server. Check your connection and try again.",
      sessionExpired: "This page has been open for a while. Please reload it and ask again.",
      server: "Sorry, something went wrong on our side. Please try again in a moment.",
    },
    ta: {
      launcher: "RGU-விடம் கேளுங்கள்",
      // THIS IS NEW CODE — localize Priya's name in the same compact header.
      title: "பிரியா",
      language: "மொழி",
      mute: "குரல் பதில்களை நிறுத்து",
      unmute: "குரல் பதில்களை இயக்கு",
      close: "உதவியாளரை மூடு",
      statusIdle: "தொடங்கத் தயார்",
      // THIS IS NEW CODE — provide Tamil copy for the same Live lifecycle states.
      statusConnecting: "இணைக்கிறது…",
      statusListening: "கேட்டுக்கொண்டிருக்கிறேன்… இப்போது பேசுங்கள்",
      statusProcessing: "சிந்திக்கிறேன்…",
      statusSpeaking: "பேசுகிறேன்…",
      statusInterrupted: "இடைநிறுத்தப்பட்டது",
      statusError: "இணைப்புப் பிழை",
      // THIS IS NEW CODE — keep the simplified welcome view clear in Tamil too.
      teamTitle: "பிரியாவைச் சந்திக்கவும்",
      teamText: "தொடங்க பிரியாவைத் தட்டுங்கள். அவர் தமிழ் அல்லது ஆங்கிலத்தில் உதவுவார்.",
      letsTalk: "பேசலாம்",
      endCall: "அழைப்பை முடி",
      callTimer: "அழைப்பு நேரம்",
      callWith: (name) => `${name} உடன் அழைப்பில்`,
      muteMic: "மைக்ரோஃபோனை அணை",
      unmuteMic: "மைக்ரோஃபோனை இயக்கு",
      micMuted: "மைக் அணைக்கப்பட்டது — பேச மைக்கைத் தட்டுங்கள்",
      stillThere: "நீங்கள் இன்னும் இருக்கிறீர்களா? தொடர்ந்து பேச மைக்கைத் தட்டுங்கள்.",
      openNow: "இப்போது திற",
      changePersona: "வேறொருவரைத் தேர்ந்தெடு",
      // THIS IS NEW CODE — use the same simple Priya-first instruction in Tamil.
      micNotice: "தொடங்க பிரியாவைத் தட்டுங்கள். அவரது வரவேற்புக்குப் பிறகு மைக்ரோஃபோன் அனுமதியை உலாவி கேட்கும். பதில்கள் ரத்தினம் குளோபல் பல்கலைக்கழகத்தின் அங்கீகரிக்கப்பட்ட தகவல்களைப் பயன்படுத்தும்.",
      privacyTitle: "உங்கள் குரலும் கேள்விகளும் எவ்வாறு கையாளப்படுகின்றன",
      privacy1: "குரல் அழைப்பின்போது, உங்கள் மைக்ரோஃபோன் ஒலி Google Gemini Live-க்கு அனுப்பப்பட்டு பேச்சு எழுத்தாக மாற்றப்படும்.",
      privacy2: "அங்கீகரிக்கப்பட்ட ரத்தினம் பதிலைத் தேட, உங்கள் கேள்வியின் உரை எங்கள் சேவையகத்திற்கு அனுப்பப்படும்.",
      privacy3: (p) => `பதிலைத் தயாரித்து பேச, உங்கள் கேள்வியும் அங்கீகரிக்கப்பட்ட பதில் உரையும் எங்கள் AI சேவை வழங்குநருக்கு${p ? ` (${p})` : ""} அனுப்பப்படும்.`,
      privacy4: "தொடர் கேள்விகள் புரிய, கடைசி சில செய்திகள் 30 நிமிடங்கள் மட்டும் வைக்கப்பட்டு பின்னர் நீக்கப்படும்.",
      privacy5: "தொலைபேசி எண், முகவரி போன்ற தனிப்பட்ட விவரங்களைப் பகிர வேண்டாம்.",
      allowMic: "அழைப்பைத் தொடங்க மைக்ரோஃபோனை அனுமதியுங்கள்…",
      micStart: "பேசத் தொடங்கு",
      micStop: "கேட்பதை நிறுத்து",
      micEnd: "குரல் உரையாடலை முடி",
      stopSpeaking: "பேசுவதை நிறுத்து",
      voicePaused: "எதுவும் கேட்காததால் குரல் உரையாடல் இடைநிறுத்தப்பட்டது. தொடர்ந்து பேச மைக்கை அழுத்துங்கள்.",
      replay: "மீண்டும் கேள்",
      retry: "மீண்டும் முயல்க",
      source: "ஆதாரம்",
      confirmPersonal: "உங்கள் செய்தியில் தொலைபேசி எண் அல்லது மின்னஞ்சல் முகவரி இருப்பது போல் தெரிகிறது. இருந்தாலும் அனுப்பவா?",
      confirmSend: "அனுப்பு",
      confirmEdit: "மீண்டும் கேள்",
      chatNote: "பேசுங்கள் — நான் பதிலைச் சொல்லிவிட்டு உங்கள் அடுத்த கேள்வியைக் கேட்பேன். உரையாடலை முடிக்க அல்லது மீண்டும் தொடங்க மைக்கை அழுத்துங்கள். எப்போது வேண்டுமானாலும் English / தமிழ் மாற்றலாம்.",
      noVoiceSupport: "குரல் அழைப்புக்கு Chrome, Edge அல்லது Safari தேவை. எங்களுடன் பேச இந்தப் பக்கத்தை அவற்றில் ஒன்றில் திறக்கவும்.",
      insecure: "குரல் அழைப்புக்குப் பாதுகாப்பான (https) இணைப்பு தேவை. எங்களுடன் பேச இந்தப் பக்கத்தின் https பதிப்பைத் திறக்கவும்.",
      langSwitched: "தமிழுக்கு மாற்றப்பட்டது.",
      noVoiceForLanguage: "இந்தக் கணினியில் தமிழ்க் குரல் இல்லை, எனவே தமிழ்ப் பதில்கள் கீழே எழுத்தாகக் காட்டப்படும். ஆங்கிலத்துக்கு மாறவும், அல்லது தமிழ்க் குரல் உள்ள கைபேசி / கணினியைப் பயன்படுத்தவும்.",
      micDenied: "மைக்ரோஃபோன் அனுமதி மறுக்கப்பட்டுள்ளது. முகவரிப் பட்டையின் அருகிலுள்ள பூட்டுக் குறியைக் கிளிக் செய்து, இந்தத் தளத்திற்கு மைக்ரோஃபோனை அனுமதித்து, மைக்கைத் தட்டுங்கள்.",
      serviceDenied: "இந்த உலாவியில் இந்த மொழிக்கான பேச்சு அறிதல் கிடைக்கவில்லை.",
      noSpeech: "எதுவும் கேட்கவில்லை. மைக்கை அழுத்தி மீண்டும் முயலுங்கள்.",
      noMic: "மைக்ரோஃபோன் கண்டறியப்படவில்லை. இணைக்கப்பட்டுள்ளதா எனச் சரிபார்த்து மைக்கைத் தட்டுங்கள்.",
      speechNetwork: "பேச்சு அறிதலுக்கு இணைய இணைப்பு தேவை. இணைப்பைச் சரிபார்த்து மைக்கை அழுத்தி மீண்டும் முயலுங்கள்.",
      langUnsupported: "இந்த உலாவியால் தமிழ்ப் பேச்சை அறிய முடியவில்லை. மொழியை மாற்றிப் பாருங்கள்.",
      speechGeneric: "குரல் உள்ளீடு எதிர்பாராமல் நின்றது. மைக்கை அழுத்தி மீண்டும் முயலுங்கள்.",
      tooShort: "சற்று விரிவான கேள்வியைக் கேளுங்கள்.",
      tooLong: (n) => `உங்கள் கேள்வியை ${n} எழுத்துகளுக்குள் வைத்திருங்கள்.`,
      offline: "நீங்கள் இணைய இணைப்பில் இல்லை போல் தெரிகிறது. இணைப்பைச் சரிபார்த்து மீண்டும் முயலுங்கள்.",
      timeout: "பதில் வர நீண்ட நேரம் ஆகிறது. மீண்டும் முயலுங்கள்.",
      network: "சர்வரை அடைய முடியவில்லை. இணைப்பைச் சரிபார்த்து மீண்டும் முயலுங்கள்.",
      sessionExpired: "இந்தப் பக்கம் நீண்ட நேரமாகத் திறந்துள்ளது. பக்கத்தை மீண்டும் ஏற்றி கேளுங்கள்.",
      server: "மன்னிக்கவும், எங்கள் பக்கத்தில் ஏதோ தவறு நடந்தது. சிறிது நேரம் கழித்து முயலுங்கள்.",
    },
  };

  /* Per-visitor preferences: browser storage may be unavailable (private mode), so every access is guarded. */
  const store = {
    get(key, fallback) {
      try { return window.localStorage.getItem(`rva:${key}`) ?? fallback; } catch { return fallback; }
    },
    set(key, value) {
      try { window.localStorage.setItem(`rva:${key}`, value); } catch { /* preference simply isn't remembered */ }
    },
  };

  const state = {
    lang: store.get("lang", "en") === "ta" ? "ta" : "en",
    persona: PERSONAS[store.get("persona", "")] ? store.get("persona", "") : Object.keys(PERSONAS)[0] || null,
    greeted: null,
    muted: store.get("muted", "0") === "1",
    view: "intro",
    status: "idle",
    conversationId: null,
    busy: false,
    handsFree: false,
    relistenTimer: null,
    recognition: null,
    speakToken: 0,
    pending: null,
    notesShown: new Set(),
    voices: [],
    micMuted: false,
    silentRounds: 0,
    callStartedAt: 0,
    callTimer: null,
    callAttempt: 0,
    lastLiveTranscript: "",
    // THIS IS NEW CODE — track which Live transport owns this call. Reason: native speech must not fall through into the old transcript-to-Flash path.
    nativeCall: false,
  };

  const t = (key, ...args) => {
    const value = TEXT[state.lang][key] ?? TEXT.en[key];
    return typeof value === "function" ? value(...args) : value;
  };

  function safeDiagnosticText(value) {
    return String(value || "")
      .replace(/(access_token=)[^&\s)]+/gi, "$1[redacted]")
      .replace(/(Bearer\s+)[^\s,;]+/gi, "$1[redacted]")
      .replace(/AIza[0-9A-Za-z_-]{20,}/g, "[redacted-api-key]")
      .replace(/((?:api[_-]?key|token)\s*[:=]\s*)[^\s,;]+/gi, "$1[redacted]")
      .slice(0, 1200);
  }

  // THIS IS NEW CODE — route shared call controls to the selected Live transport. Reason: keep mute, playback and cleanup behavior consistent across native mode and rollback mode.
  const liveClient = () => state.nativeCall ? window.GeminiLiveNative : window.GeminiLive;

  /** A persona's text in the current language, falling back to English. */
  const personaText = (key, field) => {
    const values = PERSONAS[key]?.[field] || {};
    return values[state.lang] ?? values.en;
  };

  /* ---------------------------------------------------------------- UI state */

  // THIS IS NEW CODE — map every visible Live status to localized header text. Reason: connecting and interrupted states previously had no readable label.
  const STATUS_TEXT = { idle: "statusIdle", connecting: "statusConnecting", listening: "statusListening", processing: "statusProcessing", speaking: "statusSpeaking", interrupted: "statusInterrupted", error: "statusError" };

  function setStatus(status) {
    state.status = status;
    el.panel.dataset.state = status;
    // When idle in a conversation, the status line names the persona's role instead.
    const showRole = status === "idle" && state.view === "chat" && state.persona;
    if (state.view === "call" && state.micMuted && status === "listening") {
      // THIS IS NEW CODE — show the paused microphone state without changing its existing mute/resume behavior. Reason: the header must not say “Listening” while the call mic is muted.
      el.status.textContent = t("micMuted");
    } else if (state.view === "call" && status === "idle") {
      el.status.textContent = state.micMuted ? t("micMuted") : t("callWith", personaText(state.persona, "name"));
    } else {
      el.status.textContent = showRole ? personaText(state.persona, "role") : t(STATUS_TEXT[status]);
    }
    el.callMic.setAttribute("aria-pressed", String(state.micMuted));
    el.callMic.setAttribute("aria-label", t(state.micMuted ? "unmuteMic" : "muteMic"));
    const listening = status === "listening";
    el.panel.dataset.conversation = state.handsFree ? "on" : "off";
    el.mic.setAttribute("aria-label", t(state.handsFree ? "micEnd" : listening ? "micStop" : "micStart"));
    el.mic.setAttribute("aria-pressed", String(state.handsFree || listening));
  }

  function setBusy(busy) {
    state.busy = busy;
    // In a voice chat the mic stays usable so the visitor can always end it.
    el.mic.disabled = busy && !state.handsFree;
  }

  /* ------------------------------------------------------ Voice chat loop */

  function startConversation() {
    state.handsFree = true;
    listen();
  }

  /** Ends the hands-free loop; anything already heard is still sent and answered once. */
  function endConversation() {
    state.handsFree = false;
    window.clearTimeout(state.relistenTimer);
    stopListening();
    stopSpeaking();
    setStatus(state.status);
    setBusy(state.busy);
  }

  /** Called when an answer has been spoken (or could not be): listen for the next question. */
  function continueConversation() {
    if (state.view === "call") {
      if (!state.micMuted) {
        state.lastLiveTranscript = "";
        liveClient()?.resumeMicrophone();
        setStatus("listening");
      }
      return;
    }
    window.clearTimeout(state.relistenTimer);
    if (!state.handsFree) return;
    // Short pause so the microphone doesn't pick up the tail of the spoken answer.
    state.relistenTimer = window.setTimeout(() => {
      if (state.handsFree && !el.panel.hidden && !state.busy && !state.recognition && state.status !== "speaking" && el.confirm.hidden) listen();
    }, config.relistenDelay);
  }

  function applyLanguage() {
    el.panel.setAttribute("lang", state.lang);
    root.querySelectorAll("[data-i18n]").forEach((node) => {
      const value = node === el.privacyAi ? t("privacy3", config.provider) : t(node.dataset.i18n);
      if (typeof value === "string") node.textContent = value;
    });
    root.querySelectorAll("[data-i18n-label]").forEach((node) => node.setAttribute("aria-label", t(node.dataset.i18nLabel)));
    root.querySelectorAll("[data-i18n-placeholder]").forEach((node) => node.setAttribute("placeholder", t(node.dataset.i18nPlaceholder)));
    root.querySelectorAll("[data-lang]").forEach((btn) => btn.setAttribute("aria-pressed", String(btn.dataset.lang === state.lang)));
    el.mute.setAttribute("aria-label", t(state.muted ? "unmute" : "mute"));
    el.mute.setAttribute("aria-pressed", String(state.muted));

    el.members.forEach((member) => {
      const key = member.dataset.persona;
      member.querySelector("[data-persona-name]").textContent = personaText(key, "name");
      member.querySelector("[data-persona-role]").textContent = personaText(key, "role");
      member.setAttribute("aria-pressed", String(key === state.persona));
    });

    const inChat = state.view === "chat" && state.persona;
    // THIS IS NEW CODE — keep Priya's name in the compact call header. Reason: the call view should identify the assistant instead of showing a team heading.
    el.title.textContent = inChat || (state.view === "call" && state.persona) ? personaText(state.persona, "name") : t("title");
    if (state.persona) el.headAvatar.src = PERSONAS[state.persona].image;

    setStatus(state.status);
  }

  function setView(view) {
    state.view = view;
    el.panel.dataset.view = view;
    el.intro.hidden = view === "chat";
    el.log.hidden = view !== "chat";
    applyLanguage();
  }

  /** Opens the conversation with the chosen persona; a new persona starts a fresh conversation. */
  function showChat() {
    if (state.view === "chat") return;
    setView("chat");
    if (state.greeted === state.persona) return;

    if (state.greeted !== null) {
      el.log.replaceChildren();
      state.conversationId = null;
    }
    state.greeted = state.persona;
    noteOnce("chatNote");
    addMessage("bot", personaText(state.persona, "greeting"), { lang: state.lang, replay: true });
  }

  function showTeam() {
    if (state.view === "call") endCall();
    state.handsFree = false;
    window.clearTimeout(state.relistenTimer);
    stopListening(true);
    stopSpeaking();
    cancelConfirm();
    setView("intro");
    (el.members.find((member) => member.dataset.persona === state.persona) || el.startVoice).focus();
  }

  function choosePersona(key) {
    if (!PERSONAS[key]) return;
    state.persona = key;
    store.set("persona", key);
    applyLanguage();
  }

  /** "Let's Talk": a voice call with the chosen persona; without speech recognition it falls back to the text chat. */
  function letsTalk() {
    window.GeminiLiveNative?.unlockAudio?.();
    if (state.view === "call") return;
    if (!voiceSupported) {
      const isNewConversation = state.greeted !== state.persona;
      showChat();
      if (isNewConversation) speak(personaText(state.persona, "greeting"), state.lang);
      listen();
      return;
    }
    startCall();
  }

  /* ------------------------------------------------------------ Voice call */

  function formatDuration(ms) {
    const seconds = Math.floor(ms / 1000);
    return `${Math.floor(seconds / 60)}:${String(seconds % 60).padStart(2, "0")}`;
  }

  function tickTimer() {
    el.timer.textContent = formatDuration(Date.now() - state.callStartedAt);
  }

  /** The call is timed from the moment the microphone is allowed. */
  function startCallTimer() {
    state.callStartedAt = Date.now();
    window.clearInterval(state.callTimer);
    state.callTimer = window.setInterval(tickTimer, 1000);
    tickTimer();
  }

  /** Each persona keeps their own conversation; switching starts a fresh one. */
  function joinPersonaConversation() {
    if (state.greeted === state.persona) return;
    el.log.replaceChildren();
    state.conversationId = null;
    state.greeted = state.persona;
  }

  async function startCall() {
    window.GeminiLiveNative?.unlockAudio?.();
    const attempt = ++state.callAttempt;
    state.lastLiveTranscript = "";
    state.nativeCall = false;
    joinPersonaConversation();
    state.micMuted = false;
    state.silentRounds = 0;
    state.handsFree = false;
    window.clearInterval(state.callTimer);
    state.callStartedAt = 0;
    el.timer.textContent = "0:00";
    el.callNote.textContent = "";
    el.caption.textContent = "";
    setView("call");
    setBusy(state.busy);
    el.endCall.focus();
    // Created inside the click so browsers allow the connect tone and server speech to play later.
    playTone("prime");
    state.player = state.player || new Audio();
    el.status.textContent = t("allowMic");

    if (!window.GeminiLive && !window.GeminiLiveNative) {
      // THIS IS NEW CODE — keep the existing Google TTS and browser recognition flow when the Live script fails to load.
      state.handsFree = true;
      state.greeted = null;
      setView("chat");
      showChat();
      speak(personaText(state.persona, "greeting"), state.lang, listen);
      return;
    }
    try {
      // THIS IS NEW CODE — show the real connection phase before Live becomes ready. Reason: the header should describe connection progress accurately.
      setStatus("connecting");
      // Use native Gemini Live audio with the model-only conversational policy.
      if (root.dataset.nativeLive === "1" && window.GeminiLiveNative) {
        try {
          await window.GeminiLiveNative.connect({
            csrf: config.csrf,
            requestUrl: "/api/gemini-live/native-token",
          });
          state.nativeCall = true;
        } catch (nativeError) {
          console.warn("[Voice Assistant] Native Live setup failed.", {
            requestId: window.GeminiLiveNative?.diagnosticSessionId || null,
            errorName: nativeError?.name || "Error",
            errorMessage: safeDiagnosticText(nativeError?.message || "Native Live setup failed."),
            errorStack: safeDiagnosticText(nativeError?.stack || ""),
          });
          window.GeminiLiveNative?.disconnect();
          throw nativeError;
        }
      } else {
        await window.GeminiLive.connect();
      }
      const client = liveClient();
      if (attempt !== state.callAttempt || state.view !== "call") {
        client?.disconnect();
        return;
      }

      // THIS IS NEW CODE — play the requested welcome before asking for or streaming microphone audio.
      const welcome = state.lang === "ta"
        ? "ரத்தினம் AI உதவியாளருக்கு வரவேற்கிறோம். உங்களுக்கு என்ன தகவல் வேண்டும்?"
        // OLD CODE — NOT USED NOW: Live startup used a different outdated welcome string.
        // : "Welcome to Rathinam AI Assistant. What information do you want?";
        // THIS IS NEW CODE — use the requested Live welcome. Reason: the Live path had a separate outdated hard-coded phrase.
        : "Welcome to Rathinam AI. What information do you need?";
      el.caption.textContent = welcome;
      setStatus("speaking");
      await new Promise((resolve, reject) => {
        const timeout = window.setTimeout(() => {
          console.info("[Voice Assistant] Welcome speech completed or passed; ready for microphone.");
          resolve();
        }, 4000);
        try {
          const onDone = () => {
            window.clearTimeout(timeout);
            resolve();
          };
          if (state.nativeCall) window.GeminiLiveNative.sayWelcome(welcome, onDone);
          else window.GeminiLive.speak(welcome, onDone);
        } catch (error) {
          window.clearTimeout(timeout);
          resolve();
        }
      });
      if (attempt !== state.callAttempt || state.view !== "call") {
        client?.disconnect();
        return;
      }

      const micError = await requestMicrophone();
      if (state.view !== "call") return;
      if (micError) {
        client?.disconnect();
        setMicMuted(true, t(micError));
        return;
      }
      await client.startMicrophone();
    } catch (error) {
      console.error("[Voice Assistant] Gemini Live call startup failed:", {
        requestId: window.GeminiLiveNative?.diagnosticSessionId || null,
        errorName: error?.name || "Error",
        errorMessage: safeDiagnosticText(error?.message || "Gemini Live startup failed."),
        errorStack: safeDiagnosticText(error?.stack || ""),
      });
      liveClient()?.disconnect();
      if (attempt === state.callAttempt && state.view === "call") {
        // THIS IS NEW CODE — preserve the existing Google TTS and browser recognition fallback if Live cannot start.
        state.handsFree = true;
        state.greeted = null;
        setView("chat");
        showChat();
        speak(personaText(state.persona, "greeting"), state.lang, listen);
      }
      return;
    }

    state.handsFree = true;
    startCallTimer();
    playTone("start");
    setStatus("listening");
  }

  /**
   * Opens the browser's microphone permission popup from the call button. Releases this
   * permission-check stream; Gemini Live opens the call's audio stream after connecting.
   * Resolves to an error text key, or null when microphone access is allowed.
   */
  async function requestMicrophone() {
    if (!navigator.mediaDevices?.getUserMedia) return null;
    try {
      const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
      stream.getTracks().forEach((track) => track.stop());
      return null;
    } catch (error) {
      if (error.name === "NotFoundError" || error.name === "OverconstrainedError") return "noMic";
      if (error.name === "NotAllowedError" || error.name === "SecurityError") return "micDenied";
      return "speechGeneric";
    }
  }

  /** Short two-note tone like a phone line connecting ("start") or hanging up ("end"); "prime" only unlocks audio. */
  function playTone(kind) {
    if (state.muted) return;
    try {
      const AudioContext = window.AudioContext || window.webkitAudioContext;
      if (!AudioContext) return;
      state.audio = window.GeminiLiveNative?.unlockAudio?.() || window.GeminiLive?.unlockAudio?.()
        || (state.audio && state.audio.state !== "closed" ? state.audio : new AudioContext());
      const context = state.audio;
      context.resume?.();
      if (kind === "prime") return;
      (kind === "start" ? [660, 880] : [880, 520]).forEach((frequency, index) => {
        const oscillator = context.createOscillator();
        const gain = context.createGain();
        const start = context.currentTime + index * 0.17;
        oscillator.type = "sine";
        oscillator.frequency.value = frequency;
        gain.gain.setValueAtTime(0.0001, start);
        gain.gain.exponentialRampToValueAtTime(0.16, start + 0.02);
        gain.gain.exponentialRampToValueAtTime(0.0001, start + 0.16);
        oscillator.connect(gain).connect(context.destination);
        oscillator.start(start);
        oscillator.stop(start + 0.17);
      });
    } catch {
      /* the tone is decoration only */
    }
  }

  function endCall() {
    if (state.view !== "call") return;
    state.callAttempt += 1;
    playTone("end");
    state.handsFree = false;
    state.micMuted = false;
    window.clearTimeout(state.relistenTimer);
    window.clearInterval(state.callTimer);
    stopListening(true);
    stopSpeaking();
    // THIS IS NEW CODE — revoke the short-lived server capability when native mode ends. Reason: prevent late retrieval calls from surviving hang-up.
    window.GeminiLiveNative?.disconnect();
    window.GeminiLive?.disconnect();
    state.nativeCall = false;
    el.transcript.textContent = "";
    // THIS IS NEW CODE — clear server conversation linkage when the call ends. Reason: each voice call must start with a clean, current-call-only history.
    state.conversationId = null;
    state.greeted = null;
    state.lastLiveTranscript = "";
    cancelConfirm();
    el.callNote.textContent = "";
    setView("intro");
    // THIS IS NEW CODE — reset the status after stopping the call. Reason: the intro view otherwise kept showing a stale “Listening” state.
    setStatus("idle");
  }

  /** Mutes or unmutes the visitor's microphone; replies are still spoken while muted. */
  function setMicMuted(muted, note = "") {
    state.micMuted = muted;
    state.handsFree = !muted;
    state.silentRounds = 0;
    el.callNote.textContent = note;
    if (muted) {
      window.clearTimeout(state.relistenTimer);
      stopListening(true);
      liveClient()?.pauseMicrophone();
    } else {
      liveClient()?.resumeMicrophone();
      if (!state.callStartedAt) startCallTimer();
      if (state.view === "call") setStatus("listening");
      else if (state.status !== "speaking") listen();
    }
    setStatus(state.status);
  }

  /** Tapping another team member mid-call hands the call over to them. */
  function switchCallPersona(key) {
    if (!PERSONAS[key] || key === state.persona) return;
    window.clearTimeout(state.relistenTimer);
    stopListening(true);
    stopSpeaking();
    cancelConfirm();
    choosePersona(key);
    joinPersonaConversation();
    el.callNote.textContent = "";
    setStatus("listening");
  }

  function openPanel() {
    el.panel.hidden = false;
    el.launcher.setAttribute("aria-expanded", "true");
    if (state.view === "call") { el.endCall.focus(); return; }
    // THIS IS NEW CODE — Priya is the only intro action now, so focus her card when the panel opens.
    (state.view === "intro" ? el.members.find((member) => member.dataset.persona === state.persona) : el.mic).focus();
  }

  function closePanel() {
    endCall();
    state.handsFree = false;
    window.clearTimeout(state.relistenTimer);
    stopListening(true);
    stopSpeaking();
    cancelConfirm();
    el.panel.hidden = true;
    el.launcher.setAttribute("aria-expanded", "false");
    el.launcher.focus();
  }

  /* ------------------------------------------------------------- Messages */

  function scrollToEnd() {
    el.body.scrollTop = el.body.scrollHeight;
  }

  function addMessage(kind, text, options = {}) {
    const item = document.createElement("li");
    item.className = `rva-msg rva-msg--${kind}`;
    if (options.lang) item.lang = options.lang;

    const bubble = document.createElement("div");
    bubble.className = "rva-msg__bubble";
    bubble.textContent = text;
    item.append(bubble);

    const actions = [];

    if (options.replay && synth) {
      actions.push(actionButton(t("replay"), () => speak(text, options.lang)));
    }
    if (options.retry) {
      actions.push(actionButton(t("retry"), () => { item.remove(); options.retry(); }));
    }
    (options.sources || []).forEach((source) => {
      const link = document.createElement("a");
      link.className = "rva-msg__source";
      link.href = source.url;
      link.textContent = `${t("source")}: ${source.title}`;
      actions.push(link);
    });

    if (actions.length) {
      const meta = document.createElement("div");
      meta.className = "rva-msg__meta";
      meta.append(...actions);
      item.append(meta);
    }

    el.log.append(item);
    scrollToEnd();
    return item;
  }

  function actionButton(label, onClick) {
    const button = document.createElement("button");
    button.type = "button";
    button.className = "rva-msg__action";
    button.textContent = label;
    button.addEventListener("click", onClick);
    return button;
  }

  function addNote(text) {
    if (!text) return;
    // A call has no visible message log, so notes go under the team instead.
    if (state.view === "call") el.callNote.textContent = text;
    addMessage("note", text);
  }

  function noteOnce(key) {
    if (state.notesShown.has(`${key}:${state.lang}`)) return;
    state.notesShown.add(`${key}:${state.lang}`);
    addNote(t(key));
  }

  function showError(text, retry) {
    // A call has no message log: the problem is shown under the team and the call carries on.
    if (state.view === "call") {
      el.callNote.textContent = text;
      setStatus("error");
      if (!state.micMuted) liveClient()?.resumeMicrophone();
      continueConversation();
      return;
    }
    if (state.handsFree) endConversation();
    addMessage("error", text, { retry });
    setStatus("error");
  }

  function addTyping() {
    const item = document.createElement("li");
    item.className = "rva-msg rva-msg--bot";
    item.setAttribute("aria-hidden", "true");
    item.innerHTML = '<div class="rva-msg__bubble rva-typing"><i></i><i></i><i></i></div>';
    el.log.append(item);
    scrollToEnd();
    return item;
  }

  /* ------------------------------------------------------------- Asking */

  function cancelConfirm() {
    state.pending = null;
    el.confirm.hidden = true;
  }

  async function submit(rawText, { confirmed = false } = {}) {
    const text = rawText.replace(/\s+/g, " ").trim();
    if (state.busy) return;

    if (text.length < 2) { showError(t("tooShort")); return; }
    if (text.length > config.maxLength) { showError(t("tooLong", config.maxLength)); return; }

    if (!confirmed && PERSONAL_DATA.test(text)) {
      state.pending = text;
      el.confirm.hidden = false;
      el.confirmSend.focus();
      return;
    }
    cancelConfirm();

    if (!navigator.onLine) { showError(t("offline"), () => submit(text, { confirmed: true })); return; }

    if (state.view === "call") liveClient()?.pauseMicrophone();
    stopSpeaking();
    setBusy(true);
    addMessage("user", text);
    const typing = addTyping();
    setStatus("processing");
    // THIS IS NEW CODE — voice callers use automatic language detection instead of the removed language selector.
    const lang = state.view === "call" ? "auto" : state.lang;

    const controller = new AbortController();
    // THIS IS NEW CODE — match the browser lifecycle to safe Laravel diagnostics without recording question text.
    const diagnosticRequestId = crypto.randomUUID();
    const diagnosticStartedAt = performance.now();
    console.info("[RVA diagnostics] request_started", { requestId: diagnosticRequestId, elapsedMs: 0 });
    const timer = window.setTimeout(() => controller.abort(), config.requestTimeout);
    const retry = () => submit(text, { confirmed: true });

    try {
      const response = await fetch(config.endpoint, {
        method: "POST",
        headers: { "Content-Type": "application/json", Accept: "application/json", "X-CSRF-TOKEN": config.csrf, "X-Requested-With": "XMLHttpRequest", "X-Assistant-Request-Id": diagnosticRequestId },
        credentials: "same-origin",
        body: JSON.stringify({ message: text, language: lang, conversation_id: state.conversationId, persona: state.persona }),
        signal: controller.signal,
      });
      // THIS IS NEW CODE — log only request ID, duration and HTTP status; reason: correlate browser and Laravel without exposing content.
      console.info("[RVA diagnostics] response_headers", { requestId: diagnosticRequestId, elapsedMs: Math.round(performance.now() - diagnosticStartedAt), httpStatus: response.status });
      const data = await response.json().catch(() => ({}));
      // THIS IS NEW CODE — report whether an answer was returned without recording the answer body.
      console.info("[RVA diagnostics] response_parsed", { requestId: diagnosticRequestId, elapsedMs: Math.round(performance.now() - diagnosticStartedAt), hasAnswer: typeof data.answer === "string" && data.answer.length > 0 });
      typing.remove();
      if (state.view === "intro") return;

      if (response.ok && data.success && typeof data.answer === "string" && data.answer.trim()) {
        state.conversationId = data.conversation_id;
        const redirect = safeRedirect(data.redirect);
        const sources = redirect ? [...(data.sources || []), { title: redirect.label, url: redirect.url }] : data.sources;
        addMessage("bot", data.answer, { lang: data.language || lang, replay: true, sources });
        setStatus("idle");
        el.callNote.textContent = "";
        showCaption(data.answer, redirect);
        if (!el.panel.hidden) {
          const done = redirect ? () => openRedirect(redirect) : continueConversation;
          if (state.view === "call" && !state.nativeCall && window.GeminiLive?.status() === "connected") {
            if (state.muted) { if (!state.micMuted) liveClient()?.resumeMicrophone(); done(); }
            else {
              setStatus("speaking");
              try { window.GeminiLive.speak(data.answer, () => { console.info("[RVA diagnostics] answer_audio_complete", { requestId: diagnosticRequestId, elapsedMs: Math.round(performance.now() - diagnosticStartedAt) }); if (!state.micMuted) liveClient()?.resumeMicrophone(); done(); }); }
              catch { if (!state.micMuted) liveClient()?.resumeMicrophone(); speak(data.answer, data.language || lang, done); }
            }
          } else speak(data.answer, data.language || lang, done);
        }
        return;
      }

      if (response.status === 419) showError(t("sessionExpired"));
      else if ([409, 422, 429].includes(response.status) && data.message) showError(data.message, response.status === 422 ? undefined : retry);
      else showError(t("server"), retry);
    } catch (error) {
      // THIS IS NEW CODE — report only failure class and elapsed time; never include the transcript or audio.
      console.warn("[RVA diagnostics] request_failed", { requestId: diagnosticRequestId, elapsedMs: Math.round(performance.now() - diagnosticStartedAt), failureType: error?.name || "Error" });
      typing.remove();
      if (state.view === "intro") return;
      showError(t(error.name === "AbortError" ? "timeout" : "network"), retry);
    } finally {
      window.clearTimeout(timer);
      setBusy(false);
    }
  }

  /* ------------------------------------------------- Captions and apply links */

  /** In a call, the latest answer is also shown as text under the team. */
  function showCaption(text, redirect = null) {
    el.caption.replaceChildren(document.createTextNode(text));
    if (!redirect) return;
    const link = document.createElement("a");
    link.className = "rva-caption__link";
    link.href = redirect.url;
    link.textContent = `${t("openNow")}: ${redirect.label}`;
    el.caption.append(" ", link);
  }

  window.addEventListener("gemini-live-interim-transcript", (event) => {
    if (state.view === "call" && !state.micMuted) {
      const text = event.detail?.text || "";
      if (text && text !== state.lastLiveTranscript) state.lastLiveTranscript = "";
      el.transcript.textContent = text;
    }
  });
  window.addEventListener("gemini-live-user-transcript", (event) => {
    if (state.view !== "call" || state.micMuted) return;
    const text = String(event.detail?.text || "").trim();
    if (!text || text === state.lastLiveTranscript) return;
    state.lastLiveTranscript = text;
    el.transcript.textContent = text;
    state.silentRounds = 0;
    if (state.nativeCall) return;
    window.GeminiLive?.pauseMicrophone();
    submit(text);
  });
  // THIS IS NEW CODE — display native transcription without submitting it to the legacy chat endpoint. Reason: Gemini Live itself now understands audio and must produce the response.
  window.addEventListener("gemini-live-native-transcript", (event) => {
    if (state.view === "call" && state.nativeCall && !state.micMuted) el.transcript.textContent = String(event.detail?.text || "");
  });
  // THIS IS NEW CODE — stream native Priya captions live to the UI so the user sees her spoken reply.
  window.addEventListener("gemini-live-native-caption", (event) => {
    if (state.view === "call" && state.nativeCall) {
      const text = String(event.detail?.text || "").trim();
      if (text) el.caption.textContent = text;
    }
  });
  // THIS IS NEW CODE — map native interaction lifecycle and playback events onto the existing call status. Reason: intermediate turnComplete must not reactivate the mic before final IDLE and playback completion.
  window.addEventListener("gemini-live-native-status", (event) => {
    if (state.view !== "call" || !state.nativeCall) return;
    const status = event.detail?.state;
    if (status === "thinking") setStatus("processing");
    else if (status === "speaking") setStatus("speaking");
    else if (status === "listening") setStatus(state.micMuted ? "idle" : "listening");
  });
  // THIS IS NEW CODE — surface Live VAD interruptions immediately. Reason: drop queued assistant audio and allow the incoming speech to take priority.
  window.addEventListener("gemini-live-native-interrupted", () => {
    if (state.view === "call" && state.nativeCall) {
      el.caption.textContent = "";
      el.transcript.textContent = "";
      setStatus("interrupted");
      window.setTimeout(() => {
        if (state.view === "call" && !state.micMuted) setStatus("listening");
      }, 250);
    }
  });
  window.addEventListener("gemini-live-native-error", (event) => {
    if (state.view !== "call") return;
    console.error("[Voice Assistant] Gemini Live Native error:", event.detail?.message || "unknown reason");
    setMicMuted(true, t("speechGeneric"));
    setStatus("idle");
  });
  window.addEventListener("gemini-live-connection-error", (event) => {
    if (state.view !== "call" || state.micMuted) return;
    console.error("[Voice Assistant] Gemini Live connection ended:", event.detail?.message || "unknown reason");
    setMicMuted(true, t("speechGeneric"));
  });

  /** Only https links from the server's list are followed. */
  function safeRedirect(redirect) {
    if (!redirect || typeof redirect.url !== "string") return null;
    try {
      return new URL(redirect.url).protocol === "https:" ? redirect : null;
    } catch {
      return null;
    }
  }

  /** After the "opening the page" answer has been spoken, the tab goes to the admissions page. */
  function openRedirect(redirect) {
    if (el.panel.hidden) return;
    endCall();
    window.setTimeout(() => window.location.assign(redirect.url), 700);
  }

  /* ------------------------------------------------------- Speech input */

  const RECOGNITION_ERRORS = {
    "not-allowed": "micDenied",
    "service-not-allowed": "serviceDenied",
    "no-speech": "noSpeech",
    "audio-capture": "noMic",
    network: "speechNetwork",
    "language-not-supported": "langUnsupported",
  };

  function listen() {
    if (!voiceSupported) {
      state.handsFree = false;
      noteOnce(window.isSecureContext ? "noVoiceSupport" : "insecure");
      return;
    }
    if (state.busy || state.recognition) return;

    stopSpeaking();
    cancelConfirm();

    const recognition = new Recognition();
    recognition.lang = LANG_CODES[state.lang];
    recognition.interimResults = true;
    recognition.continuous = false;
    recognition.maxAlternatives = 1;

    let finalText = "";
    let errorCode = null;
    let silenceTimer = null;

    recognition.onstart = () => {
      setStatus("listening");
      el.caption.textContent = "";
      silenceTimer = window.setTimeout(() => recognition.stop(), config.listenTimeout);
    };
    recognition.onresult = (event) => {
      let interim = "";
      for (let i = event.resultIndex; i < event.results.length; i += 1) {
        const piece = event.results[i][0].transcript;
        if (event.results[i].isFinal) finalText += piece; else interim += piece;
      }
      el.transcript.textContent = `${finalText} ${interim}`.trim();
    };
    recognition.onerror = (event) => { errorCode = event.error; };
    recognition.onend = () => {
      window.clearTimeout(silenceTimer);
      const aborted = recognition.aborted;
      state.recognition = null;
      el.transcript.textContent = "";
      setStatus("idle");

      if (aborted || errorCode === "aborted") return;
      if (errorCode && errorCode !== "no-speech") {
        const message = t(RECOGNITION_ERRORS[errorCode] || "speechGeneric");
        // In a call, pause rather than retry in a tight loop; tapping the mic tries again.
        if (state.view === "call") setMicMuted(true, message); else showError(message);
        return;
      }
      if (finalText.trim()) { state.silentRounds = 0; submit(finalText); return; }
      if (state.view === "call") {
        state.silentRounds += 1;
        if (state.silentRounds >= config.maxSilentRounds) setMicMuted(true, t("stillThere"));
        else continueConversation();
        return;
      }
      // Silence ends a voice chat quietly rather than looping on an empty room.
      if (state.handsFree) { endConversation(); addNote(t("voicePaused")); return; }
      showError(t("noSpeech"));
    };

    state.recognition = recognition;
    try {
      recognition.start();
    } catch {
      state.recognition = null;
      showError(t("speechGeneric"));
    }
  }

  /** Ends listening: `discard` drops what was heard (close, language switch); otherwise it is sent. */
  function stopListening(discard = false) {
    const recognition = state.recognition;
    if (!recognition) return;
    if (discard) { recognition.aborted = true; recognition.abort(); } else { recognition.stop(); }
  }

  /* ------------------------------------------------------ Speech output */

  function loadVoices() {
    if (synth) state.voices = synth.getVoices();
  }

  function isGender(voice, gender) {
    const female = FEMALE_VOICE.test(voice.name);
    return gender === "female" ? female : !female && MALE_VOICE.test(voice.name);
  }


  function isNatural(voice) {
    return voice.localService === false || NATURAL_VOICE.test(voice.name);
  }

  /**
   * The best voice for the language, preferring the persona's gender and then a natural-sounding voice;
   * `matched` says whether the gender preference worked and `natural` whether the voice sounds human.
   */
  function voiceFor(lang, gender) {
    const code = LANG_CODES[lang].toLowerCase();
    const normalised = state.voices.map((voice) => ({ voice, lang: voice.lang.replace("_", "-").toLowerCase() }));
    const exact = normalised.filter((v) => v.lang === code);
    const candidates = exact.length ? exact : normalised.filter((v) => v.lang === lang || v.lang.startsWith(`${lang}-`));
    const score = (v) => (gender && isGender(v.voice, gender) ? 2 : 0) + (isNatural(v.voice) ? 1 : 0);
    const match = candidates.reduce((best, v) => (!best || score(v) > score(best) ? v : best), null);
    return {
      voice: match ? match.voice : null,
      matched: Boolean(match && gender && isGender(match.voice, gender)),
      natural: Boolean(match && isNatural(match.voice)),
    };
  }

  /** Splits text into short chunks: some browsers stop long utterances part-way. */
  function chunks(text) {
    const sentences = text.match(/[^.!?।]+[.!?।]*\s*/g) || [text];
    const parts = [];
    let current = "";
    sentences.forEach((sentence) => {
      if ((current + sentence).length > 180 && current) { parts.push(current.trim()); current = ""; }
      current += sentence;
    });
    if (current.trim()) parts.push(current.trim());
    return parts;
  }

  /** `onDone` runs once the text has been read out, or straight away when it can't be; not when speech is stopped. */
  function speak(text, lang = state.lang, onDone = () => {}) {
    if (state.muted) { onDone(); return; }

    loadVoices();
    // The server's voices sound human, so they are used unless the browser has a natural voice of the persona's gender.
    const gender = PERSONAS[state.persona]?.voice;
    const browser = synth ? voiceFor(lang, gender) : { voice: null };
    const hasNaturalBrowserVoice = Boolean(browser.voice) && browser.natural && (browser.matched || !gender);
    if (!hasNaturalBrowserVoice && config.speechEndpoint) { speakWithServer(text, lang, onDone); return; }
    speakWithBrowser(text, lang, onDone);
  }

  /** Reads the reply with the server's text-to-speech; falls back to the browser's voices if that fails. */
  async function speakWithServer(text, lang, onDone) {
    stopSpeaking();
    const token = state.speakToken;
    el.stop.hidden = false;
    setStatus("speaking");

    const finish = () => {
      if (token !== state.speakToken) return;
      el.stop.hidden = true;
      if (state.status === "speaking") setStatus("idle");
      onDone();
    };

    try {
      const response = await fetch(config.speechEndpoint, {
        method: "POST",
        headers: { "Content-Type": "application/json", Accept: "audio/mpeg, application/json", "X-CSRF-TOKEN": config.csrf, "X-Requested-With": "XMLHttpRequest" },
        credentials: "same-origin",
        body: JSON.stringify({ text, language: lang, conversation_id: state.conversationId, persona: state.persona }),
      });
      if (token !== state.speakToken) return;
      if (!response.ok) throw new Error(`speech ${response.status}`);
      const url = URL.createObjectURL(await response.blob());
      if (token !== state.speakToken) { URL.revokeObjectURL(url); return; }

      state.player = state.player || new Audio();
      const player = state.player;
      player.onended = () => { URL.revokeObjectURL(url); finish(); };
      player.onerror = () => { URL.revokeObjectURL(url); finish(); };
      player.src = url;
      await player.play();
    } catch {
      if (token === state.speakToken) speakWithBrowser(text, lang, onDone);
    }
  }

  function speakWithBrowser(text, lang, onDone) {
    if (!synth) { onDone(); return; }

    const gender = PERSONAS[state.persona]?.voice;
    const { voice, matched } = voiceFor(lang, gender);
    const english = lang === "en" ? null : voiceFor("en", gender);
    // Without a voice of the right gender, a slight pitch shift keeps personas sounding different;
    // a larger shift makes the voice sound artificial.
    const pitch = matched || !gender ? 1 : gender === "male" ? 0.9 : 1.08;
    // Without a voice for the language, parts already in English (e.g. knowledge-base text) are
    // still read with an English voice; Tamil script is never read with an English voice.
    const parts = chunks(text)
      .map((part) => (voice || !TAMIL_SCRIPT.test(part) ? { text: part, voice: voice || english?.voice, lang: voice ? lang : "en" } : null))
      .filter((part) => part && (part.voice || part.lang === lang));
    if (!voice && lang !== "en") noteOnce("noVoiceForLanguage");
    if (!parts.length) { onDone(); return; }

    stopSpeaking();
    const token = state.speakToken;
    el.stop.hidden = false;
    setStatus("speaking");

    const finish = () => {
      if (token !== state.speakToken) return;
      el.stop.hidden = true;
      if (state.status === "speaking") setStatus("idle");
      onDone();
    };

    const next = (index) => {
      if (token !== state.speakToken) return;
      if (index >= parts.length) { finish(); return; }
      const part = parts[index];
      const utterance = new SpeechSynthesisUtterance(part.text);
      utterance.lang = LANG_CODES[part.lang];
      if (part.voice) utterance.voice = part.voice;
      utterance.rate = part.lang === "ta" ? 0.95 : 1;
      utterance.pitch = pitch;
      utterance.onend = () => next(index + 1);
      utterance.onerror = (event) => { if (event.error !== "interrupted" && event.error !== "canceled") finish(); };
      synth.speak(utterance);
    };

    next(0);
  }

  function stopSpeaking() {
    state.speakToken += 1;
    if (state.view === "call") liveClient()?.stopPlayback();
    if (synth && (synth.speaking || synth.pending)) synth.cancel();
    if (state.player && !state.player.paused) state.player.pause();
    el.stop.hidden = true;
    if (state.status === "speaking") setStatus("idle");
  }

  /* -------------------------------------------------------------- Wiring */

  function setLanguage(lang) {
    if (lang === state.lang || !TEXT[lang]) return;
    const inCall = state.view === "call";
    state.handsFree = false;
    window.clearTimeout(state.relistenTimer);
    stopListening(true);
    stopSpeaking();
    state.lang = lang;
    store.set("lang", lang);
    applyLanguage();
    if (state.view === "chat") addNote(t("langSwitched"));
    if (inCall) {
      state.handsFree = !state.micMuted;
      continueConversation();
    }
  }

  el.launcher.addEventListener("click", openPanel);
  el.close.addEventListener("click", closePanel);
  el.panel.addEventListener("keydown", (event) => { if (event.key === "Escape") closePanel(); });

  root.querySelectorAll("[data-lang]").forEach((btn) => btn.addEventListener("click", () => setLanguage(btn.dataset.lang)));

  el.mute.addEventListener("click", () => {
    state.muted = !state.muted;
    store.set("muted", state.muted ? "1" : "0");
    if (state.muted) stopSpeaking();
    applyLanguage();
  });

  // THIS IS NEW CODE — tapping Priya directly starts the welcome and voice call in one action.
  el.members.forEach((member) => member.addEventListener("click", () => {
    window.GeminiLiveNative?.unlockAudio?.();
    if (state.view === "call") return;
    choosePersona(member.dataset.persona);
    letsTalk();
  }));
  // OLD CODE — NOT USED NOW: double-clicking a character to start was not discoverable.
  // el.members.forEach((member) => member.addEventListener("dblclick", () => { choosePersona(member.dataset.persona); letsTalk(); }));
  // OLD CODE — NOT USED NOW: the separate “Let’s Talk” button duplicated Priya’s new click action.
  // el.startVoice.addEventListener("click", letsTalk);
  el.endCall.addEventListener("click", endCall);
  el.callMic.addEventListener("click", () => {
    if (state.micMuted && liveClient()?.status() !== "connected" && !state.nativeCall) startCall();
    else setMicMuted(!state.micMuted);
  });
  el.team.addEventListener("click", showTeam);

  el.mic.addEventListener("click", () => {
    showChat();
    if (state.handsFree) endConversation(); else startConversation();
  });

  // In a voice chat, "Stop speaking" interrupts the answer and goes straight to listening.
  el.stop.addEventListener("click", () => { stopSpeaking(); continueConversation(); });
  el.confirmSend.addEventListener("click", () => { if (state.pending) submit(state.pending, { confirmed: true }); });
  el.confirmEdit.addEventListener("click", () => {
    cancelConfirm();
    if (state.view === "call") { if (!state.micMuted) liveClient()?.resumeMicrophone(); setStatus("listening"); }
    else listen();
  });

  // Speech must not continue on a page the visitor has left.
  window.addEventListener("pagehide", () => { endCall(); state.handsFree = false; stopListening(true); stopSpeaking(); });

  if (synth) {
    loadVoices();
    synth.addEventListener?.("voiceschanged", loadVoices);
  }

  if (!voiceSupported) {
    el.panel.dataset.voice = "unsupported";
    el.intro.querySelector(".rva-notice p").dataset.i18n = window.isSecureContext ? "noVoiceSupport" : "insecure";
  }
  if (!config.usesAi) el.privacyAi.hidden = true;
  setView("intro");
  root.hidden = false;
})();
