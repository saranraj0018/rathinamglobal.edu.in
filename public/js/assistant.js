/* Rathinam floating assistant: text chat, voice input (browser speech
   recognition with a server fallback) and spoken replies. Plain JS; all
   visitor and server text is inserted with textContent, never as HTML. */
(function () {
    'use strict';
    var root = document.getElementById('rga');
    if (!root) { return; }
    root.hidden = false;

    var cfg = root.dataset;
    var $ = function (name) { return root.querySelector('[data-rga="' + name + '"]'); };
    var panel = $('panel'), log = $('log'), input = $('input'), sendBtn = $('send'), micBtn = $('mic'),
        errorBox = $('error'), statusEl = $('status'), langSel = $('language'), voiceBtn = $('voice-toggle');
    var store = window.sessionStorage;
    var conversation = store.getItem('rga-conversation');
    var voiceOn = window.localStorage.getItem('rga-voice') !== 'off' && cfg.voiceOutput === '1';
    var audio = null, busy = false, recognition = null, recorder = null, listening = false;
    var Recognition = window.SpeechRecognition || window.webkitSpeechRecognition;

    var STATUS = 'Ask in Tamil, English or Tanglish';
    if (cfg.voiceOutput !== '1') { voiceBtn.hidden = true; }
    voiceBtn.setAttribute('aria-pressed', String(voiceOn));
    langSel.value = store.getItem('rga-lang') || 'auto';

    function showError(text) { errorBox.textContent = text || ''; errorBox.hidden = !text; }
    function setStatus(text) { statusEl.textContent = text || STATUS; }

    function request(url, options) {
        options = options || {};
        options.headers = Object.assign({ 'Accept': 'application/json', 'X-CSRF-TOKEN': cfg.csrf, 'X-Requested-With': 'XMLHttpRequest' }, options.headers || {});
        options.credentials = 'same-origin';
        return fetch(url, options);
    }

    function addMessage(kind, text, extra) {
        var li = document.createElement('li');
        li.className = 'rga-msg rga-msg--' + kind;
        var p = document.createElement('span');
        p.textContent = text;
        li.appendChild(p);
        if (extra && extra.id) { li.appendChild(tools(extra)); }
        log.appendChild(li);
        log.scrollTop = log.scrollHeight;
        return li;
    }

    function toolButton(label, title, handler) {
        var b = document.createElement('button');
        b.type = 'button'; b.textContent = label; b.title = title; b.setAttribute('aria-label', title);
        b.addEventListener('click', function () { handler(b); });
        return b;
    }

    function tools(message) {
        var box = document.createElement('div');
        box.className = 'rga-msg__tools';
        if (cfg.voiceOutput === '1') { box.appendChild(toolButton('🔊', 'Play answer', function () { speak(message.id); })); }
        ['👍:1:Helpful', '👎:-1:Not helpful'].forEach(function (item) {
            var parts = item.split(':');
            box.appendChild(toolButton(parts[0], parts[2], function (b) {
                request(cfg.feedback, { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ message_id: message.id, rating: Number(parts[1]) }) })
                    .then(function (r) { if (r.ok) { box.querySelectorAll('[aria-pressed]').forEach(function (x) { x.removeAttribute('aria-pressed'); }); b.setAttribute('aria-pressed', 'true'); } });
            }));
        });
        return box;
    }

    function setBusy(state) { busy = state; sendBtn.disabled = state; }

    function ask(text) {
        text = text.trim();
        if (!text || busy) { return; }
        showError('');
        addMessage('user', text);
        input.value = '';
        var typing = document.createElement('li');
        typing.className = 'rga-msg rga-msg--bot';
        typing.innerHTML = '<span class="rga-dots" aria-label="Thinking"><i></i><i></i><i></i></span>';
        log.appendChild(typing); log.scrollTop = log.scrollHeight;
        setBusy(true); setStatus('Thinking…');

        request(cfg.ask, {
            method: 'POST', headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ message: text, conversation: conversation, language: langSel.value })
        }).then(function (r) {
            if (r.status === 404) { conversation = null; store.removeItem('rga-conversation'); throw new Error('Your previous conversation expired. Please ask again.'); }
            return r.json().then(function (data) { return { ok: r.ok, data: data }; });
        }).then(function (res) {
            if (!res) { return; }
            typing.remove();
            if (!res.ok || !res.data.success) { throw new Error(res.data && res.data.message ? res.data.message : 'failed'); }
            conversation = res.data.conversation;
            store.setItem('rga-conversation', conversation);
            addMessage('bot', res.data.message.answer, res.data.message);
            if (voiceOn) { speak(res.data.message.id); }
        }).catch(function (e) {
            typing.remove();
            showError(e && e.message && e.message !== 'failed' && e.message !== 'Failed to fetch' ? e.message : 'The assistant could not be reached. Please check your connection and try again.');
        }).then(function () { setBusy(false); setStatus(); });
    }

    function stopAudio() { if (audio) { audio.pause(); audio = null; } }

    function speak(id) {
        stopAudio();
        request(cfg.speak, { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ message_id: id }) })
            .then(function (r) {
                if (!r.ok) { return r.json().then(function (d) { throw new Error(d.message || 'Voice output is unavailable.'); }); }
                return r.blob();
            })
            .then(function (blob) { audio = new Audio(URL.createObjectURL(blob)); return audio.play(); })
            .catch(function (e) { showError(e.message || 'Voice output is unavailable.'); });
    }

    /* ----- voice input ----- */
    function micLanguage() {
        var l = langSel.value === 'auto' ? cfg.defaultLanguage : langSel.value;
        return l === 'en' ? 'en-IN' : 'ta-IN';
    }

    function endListening() {
        listening = false; micBtn.classList.remove('is-listening'); micBtn.setAttribute('aria-label', 'Start speaking'); setStatus();
    }

    function startListening() {
        showError(''); stopAudio();
        if (Recognition) { return startBrowserRecognition(); }
        if (cfg.voiceInputFallback === '1' && window.MediaRecorder && navigator.mediaDevices) { return startRecording(); }
        showError('Voice input is not supported in this browser. Please type your question.');
    }

    function micError(code) {
        var messages = {
            'not-allowed': 'Microphone permission was denied. Allow microphone access in your browser, or type your question.',
            'service-not-allowed': 'Microphone permission was denied. Allow microphone access in your browser, or type your question.',
            'no-speech': 'I did not hear anything. Please try again or type your question.',
            'audio-capture': 'No microphone was found. Please type your question.',
            'network': 'Speech recognition needs an internet connection. Please type your question.'
        };
        showError(messages[code] || 'Speech recognition failed. Please try again or type your question.');
    }

    function startBrowserRecognition() {
        recognition = new Recognition();
        recognition.lang = micLanguage();
        recognition.interimResults = true;
        recognition.maxAlternatives = 1;
        var finalText = '';
        recognition.onstart = function () { listening = true; micBtn.classList.add('is-listening'); micBtn.setAttribute('aria-label', 'Stop listening'); setStatus('Listening…'); };
        recognition.onresult = function (event) {
            var interim = '';
            for (var i = event.resultIndex; i < event.results.length; i++) {
                if (event.results[i].isFinal) { finalText += event.results[i][0].transcript; } else { interim += event.results[i][0].transcript; }
            }
            input.value = (finalText + interim).trim();
        };
        recognition.onerror = function (event) { if (event.error !== 'aborted') { micError(event.error); } };
        recognition.onend = function () {
            endListening();
            input.focus(); /* the transcript stays editable until the visitor presses Send */
        };
        try { recognition.start(); } catch (e) { micError('other'); }
    }

    function startRecording() {
        navigator.mediaDevices.getUserMedia({ audio: true }).then(function (stream) {
            var chunks = [];
            recorder = new MediaRecorder(stream);
            recorder.ondataavailable = function (e) { if (e.data.size) { chunks.push(e.data); } };
            recorder.onstop = function () {
                stream.getTracks().forEach(function (t) { t.stop(); });
                endListening();
                var form = new FormData();
                form.append('audio', new Blob(chunks, { type: recorder.mimeType || 'audio/webm' }), 'speech.webm');
                form.append('language', langSel.value);
                setStatus('Transcribing…');
                request(cfg.transcribe, { method: 'POST', body: form })
                    .then(function (r) { return r.json().then(function (d) { if (!r.ok || !d.success) { throw new Error(d.message || 'Speech recognition failed.'); } return d.text; }); })
                    .then(function (text) { input.value = text; input.focus(); })
                    .catch(function (e) { showError(e.message); })
                    .then(function () { setStatus(); });
            };
            recorder.start();
            listening = true; micBtn.classList.add('is-listening'); micBtn.setAttribute('aria-label', 'Stop listening'); setStatus('Listening…');
            setTimeout(function () { if (recorder && recorder.state === 'recording') { recorder.stop(); } }, 15000);
        }).catch(function (e) { micError(e && e.name === 'NotFoundError' ? 'audio-capture' : 'not-allowed'); });
    }

    function stopListening() {
        if (recognition) { recognition.stop(); }
        if (recorder && recorder.state === 'recording') { recorder.stop(); }
    }

    micBtn.addEventListener('click', function () { if (listening) { stopListening(); } else { startListening(); } });

    /* ----- window controls ----- */
    function open() {
        panel.hidden = false; root.classList.remove('is-min'); $('open').setAttribute('aria-expanded', 'true');
        if (!log.children.length) { loadHistory(); }
        input.focus();
    }
    function close() { stopListening(); stopAudio(); panel.hidden = true; $('open').setAttribute('aria-expanded', 'false'); }

    function loadHistory() {
        if (!conversation) { return; }
        request(cfg.history + '/' + encodeURIComponent(conversation)).then(function (r) {
            if (!r.ok) { conversation = null; store.removeItem('rga-conversation'); return null; }
            return r.json();
        }).then(function (data) {
            if (!data) { return; }
            data.messages.forEach(function (m) { addMessage('user', m.question); addMessage('bot', m.answer, m); });
        }).catch(function () {});
    }

    $('open').addEventListener('click', function () { if (panel.hidden) { open(); } else { close(); } });
    $('close').addEventListener('click', close);
    $('minimize').addEventListener('click', function () { root.classList.toggle('is-min'); });
    $('clear').addEventListener('click', function () { stopAudio(); log.textContent = ''; conversation = null; store.removeItem('rga-conversation'); showError(''); });
    voiceBtn.addEventListener('click', function () {
        voiceOn = !voiceOn; voiceBtn.setAttribute('aria-pressed', String(voiceOn));
        window.localStorage.setItem('rga-voice', voiceOn ? 'on' : 'off'); if (!voiceOn) { stopAudio(); }
    });
    langSel.addEventListener('change', function () { store.setItem('rga-lang', langSel.value); });
    $('form').addEventListener('submit', function (e) { e.preventDefault(); ask(input.value); });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape' && !panel.hidden) { close(); } });
})();
