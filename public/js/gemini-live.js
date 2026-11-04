
/**
 * THIS IS NEW CODE — Gemini Live continuous voice client. Reason: low-latency browser voice with server-side verified answers.
 * Microphone streaming + Gemini audio playback + diagnostics.
 */

(() => {
    'use strict';

    console.log('[Gemini Live] Client loaded.');

    const INPUT_SAMPLE_RATE = 16000;
    const OUTPUT_SAMPLE_RATE = 24000;
    const PROCESSOR_BUFFER_SIZE = 4096;
    // THIS IS NEW CODE — bound the complete token and WebSocket setup to the browser's 27-second voice-answer budget.
    const CONNECTION_TIMEOUT_MS = 27000;

    let socket = null;
    let transcriptionSocket = null;
    let connectionStatus = 'disconnected';
    let connectionPromise = null;
    let connectionTimeout = null;
    let connectionGeneration = 0;

    let microphoneStream = null;
    let audioContext = null;
    let microphoneSource = null;
    let processor = null;
    let silentGain = null;

    let microphoneActive = false;
    // THIS IS NEW CODE — associate connection/audio milestones without exposing transcript or audio payloads.
    let diagnosticSessionId = null;
    let audioChunkCount = 0;

    // Audio playback state.
    let nextPlaybackTime = 0;
    let activeAudioSources = new Set();
    let onSpeechAnswerDone = null;
    let speechTurnComplete = false;
    // THIS IS NEW CODE — track Extended Thinking lifecycle separately from utterance turnComplete. Reason: an IN_PROGRESS turn may be followed by more reasoning and audio.
    let speechInteractionIdle = false;
    let requiresInteractionIdle = false;
    let pendingAnswerAudioChunks = [];
    // THIS IS NEW CODE — track answer playback timing without retaining or logging spoken text.
    let speechStartedAt = 0;
    let playbackChunkCount = 0;

    function maybeFinishSpeech() {
        if (!speechTurnComplete || (requiresInteractionIdle && !speechInteractionIdle) || activeAudioSources.size > 0 || !onSpeechAnswerDone) return;
        speechTurnComplete = false;
        const done = onSpeechAnswerDone;
        onSpeechAnswerDone = null;
        console.info('[Gemini Live diagnostics] answer_audio_playback_complete', { sessionId: diagnosticSessionId, elapsedMs: Math.round(performance.now() - speechStartedAt), playbackChunkCount });
        done();
    }

    /**
     * Get temporary Gemini Live token.
     */
    // THIS IS NEW CODE — correlate token provisioning while never logging token values.
    async function getToken(requestId, purpose) {
        const startedAt = performance.now();
        const response = await fetch('/api/gemini-live/token', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-Assistant-Request-Id': requestId,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ purpose })
        });
        console.info('[Gemini Live diagnostics] token_response', { sessionId: requestId, elapsedMs: Math.round(performance.now() - startedAt), httpStatus: response.status });

        const data = await response.json().catch(() => ({}));
        if (!response.ok) {
            throw new Error(data.error || `Gemini Live token endpoint returned HTTP ${response.status}.`);
        }

        if (!data.token || !data.model) {
            throw new Error('Invalid Gemini Live token response.');
        }

        console.log('[Gemini Live] Temporary token received.');
        console.log('[Gemini Live] Model:', data.model);

        return data;
    }

    /**
     * Connect to Gemini Live.
     */
    async function connect() {
        if (
            socket &&
            socket.readyState === WebSocket.OPEN &&
            connectionStatus === 'connected'
        ) {
            return 'Already connected.';
        }

        if (connectionPromise) {
            return connectionPromise;
        }

        const generation = ++connectionGeneration;
        // THIS IS NEW CODE — provide a safe session correlation value for browser lifecycle logs.
        diagnosticSessionId = crypto.randomUUID();
        const connectionStartedAt = performance.now();
        console.info('[Gemini Live diagnostics] connection_started', { sessionId: diagnosticSessionId, elapsedMs: 0 });
        connectionPromise = new Promise(async (resolve, reject) => {
            let settled = false;

            const finish = (error, result) => {
                if (settled) return;

                settled = true;

                clearTimeout(connectionTimeout);
                connectionTimeout = null;
                connectionPromise = null;

                if (error) {
                    connectionStatus = 'disconnected';
                    reject(error);
                } else {
                    connectionStatus = 'connected';
                    resolve(result);
                }
            };

            try {
                connectionStatus = 'connecting';

                // THIS IS NEW CODE — use a unique ID for the voice session's two one-use credentials.
                connectionTimeout = setTimeout(() => {
                    if (connectionStatus === 'connecting') {
                        socket?.close();
                        transcriptionSocket?.close();
                        finish(new Error('Gemini Live connection timed out.'));
                    }
                }, CONNECTION_TIMEOUT_MS);
                const [data, transcriptionData] = await Promise.all([
                    getToken(diagnosticSessionId, 'speaker'),
                    getToken(diagnosticSessionId, 'transcription')
                ]);
                if (settled || generation !== connectionGeneration) {
                    finish(new Error('Gemini Live connection was cancelled.'));
                    return;
                }

                const model = data.model.startsWith('models/')
                    ? data.model
                    : `models/${data.model}`;
                // THIS IS NEW CODE — require the final idle status only for Extended Thinking, preserving compatibility with the standard Live model.
                requiresInteractionIdle = model.endsWith('/gemini-3.8-live-extended-thinking');
                // OLD CODE — NOT USED NOW: the previous inline setup configuration did not add a model-specific thinking option or share a single generation config between token and socket.
                // const oldSpeakerGenerationConfig = {
                //     responseModalities: ['AUDIO'],
                //     speechConfig: { voiceConfig: { prebuiltVoiceConfig: { voiceName: 'Aoede' } } }
                // };
                // THIS IS NEW CODE — add the thinking option only for its supported model. Reason: keep switching back to standard Live protocol-compatible.
                const speakerGenerationConfig = {
                    responseModalities: ['AUDIO'],
                    speechConfig: {
                        voiceConfig: {
                            prebuiltVoiceConfig: {
                                voiceName: 'Aoede'
                            }
                        }
                    }
                };
                if (requiresInteractionIdle) {
                    speakerGenerationConfig.thinkingConfig = { thinkingLevel: 'LOW' };
                }

                const url =
                    'wss://generativelanguage.googleapis.com/ws/' +
                    'google.ai.generativelanguage.v1beta.GenerativeService.' +
                    'BidiGenerateContentConstrained?access_token=' +
                    encodeURIComponent(data.token);

                socket = new WebSocket(url);
                const transcriptionUrl =
                    'wss://generativelanguage.googleapis.com/ws/' +
                    'google.ai.generativelanguage.v1beta.GenerativeService.' +
                    'BidiGenerateContentConstrained?access_token=' +
                    encodeURIComponent(transcriptionData.token);
                transcriptionSocket = new WebSocket(transcriptionUrl);
                let speakerReady = false;
                let transcriptionReady = false;
                const maybeReady = () => {
                    if (speakerReady && transcriptionReady) finish(null, 'Gemini Live connected successfully.');
                };

                socket.onopen = () => {
                    console.log('[Gemini Live] WebSocket connected.');
                    console.info('[Gemini Live diagnostics] speaker_socket_open', { sessionId: diagnosticSessionId, elapsedMs: Math.round(performance.now() - connectionStartedAt) });

                    const setupMessage = {
                        setup: {
                            model,

                            generationConfig: speakerGenerationConfig,

                            systemInstruction: {
                                parts: [{ text: 'You are a speech renderer. Speak the exact text supplied by the client, verbatim. Do not add, remove, or infer any information.' }]
                            },
                            outputAudioTranscription: {}
                        }
                    };

                    socket.send(JSON.stringify(setupMessage));

                    console.log('[Gemini Live] Answer speech session setup sent.');
                };

                transcriptionSocket.onopen = () => {
                    console.info('[Gemini Live diagnostics] transcription_socket_open', { sessionId: diagnosticSessionId, elapsedMs: Math.round(performance.now() - connectionStartedAt) });
                    transcriptionSocket.send(JSON.stringify({
                        setup: {
                            model: transcriptionData.model.startsWith('models/') ? transcriptionData.model : `models/${transcriptionData.model}`,
                            generationConfig: { responseModalities: ['TEXT'] },
                            inputAudioTranscription: { languageCodes: [] }
                        }
                    }));
                };

                socket.onmessage = async (event) => {
                    try {
                        let raw = event.data;

                        if (raw instanceof Blob) {
                            raw = await raw.text();
                        }

                        if (raw instanceof ArrayBuffer) {
                            raw = new TextDecoder().decode(raw);
                        }

                        const message = JSON.parse(raw);

                        if (message.setupComplete) {
                            speakerReady = true;
                            maybeReady();

                            console.log('[Gemini Live] Session ready.');
                            console.info('[Gemini Live diagnostics] speaker_setup_complete', { sessionId: diagnosticSessionId, elapsedMs: Math.round(performance.now() - connectionStartedAt) });
                            return;
                        }

                        if (message.error) {
                            console.error('[Gemini Live diagnostics] speaker_setup_error', { sessionId: diagnosticSessionId, status: String(message.error.status || 'unknown') });
                            finish(new Error('Gemini Live speaker setup failed.'));

                            return;
                        }

                        const content = message.serverContent;

                        if (content) {
                            // Gemini speech transcription.
                            if (content.outputTranscription?.text) {
                                const text = content.outputTranscription.text;

                                console.log('[Gemini]', text);

                                window.dispatchEvent(
                                    new CustomEvent(
                                        'gemini-live-model-transcript',
                                        { detail: { text } }
                                    )
                                );
                            }

                            // OLD CODE — NOT USED NOW: immediate chunk playback could speak an intermediate filler and treated turnComplete as final while reasoning continued.
                            // for (const part of content.modelTurn?.parts || []) {
                            //     if (part.inlineData?.data && part.inlineData.mimeType?.startsWith('audio/pcm')) {
                            //         playAudioChunk(part.inlineData.data, part.inlineData.mimeType);
                            //     }
                            // }
                            // if (content.turnComplete) {
                            //     speechTurnComplete = true;
                            //     maybeFinishSpeech();
                            // }
                            // THIS IS NEW CODE — buffer chunks until Extended Thinking confirms the final interaction status. Reason: discard intermediate filler audio before playback.
                            const parts = content.modelTurn?.parts || [];

                            for (const part of parts) {
                                if (
                                    part.inlineData?.data &&
                                    part.inlineData.mimeType?.startsWith('audio/pcm')
                                ) {
                                    pendingAnswerAudioChunks.push({
                                        data: part.inlineData.data,
                                        mimeType: part.inlineData.mimeType
                                    });
                                }
                            }

                            // Stop queued audio if Gemini is interrupted.
                            if (content.interrupted) {
                                const interruptedDone = onSpeechAnswerDone;
                                pendingAnswerAudioChunks = [];
                                console.log(
                                    '[Gemini Live] Response interrupted.'
                                );

                                stopPlayback();
                                interruptedDone?.();
                            }
                        }

                        // THIS IS NEW CODE — handle interaction status in either supported message envelope. Reason: turnComplete is not final while Extended Thinking remains IN_PROGRESS.
                        const interactionStatus = content?.interactionStatus || content?.interaction_status || message.interactionStatus || message.interaction_status || null;
                        const turnComplete = content?.turnComplete || message.turnComplete || false;
                        if (turnComplete || interactionStatus === 'IDLE') {
                            if (interactionStatus === 'IN_PROGRESS') {
                                pendingAnswerAudioChunks = [];
                                speechTurnComplete = false;
                                speechInteractionIdle = false;
                            } else if (interactionStatus === 'IDLE' || !requiresInteractionIdle) {
                                for (const chunk of pendingAnswerAudioChunks) {
                                    playAudioChunk(chunk.data, chunk.mimeType);
                                }
                                pendingAnswerAudioChunks = [];
                                speechTurnComplete = Boolean(turnComplete || interactionStatus === 'IDLE');
                                speechInteractionIdle = interactionStatus === 'IDLE' || !requiresInteractionIdle;
                                console.log('[Gemini Live] Final response turn completed.');
                                maybeFinishSpeech();
                            }
                        }

                        if (message.sessionResumptionUpdate) {
                            console.log(
                                '[Gemini Live] Session resumption updated.'
                            );
                        }

                    } catch (error) {
                        console.error(
                            '[Gemini Live] Message processing error:',
                            error
                        );
                    }
                };

                transcriptionSocket.onmessage = async (event) => {
                    try {
                        let raw = event.data;
                        if (raw instanceof Blob) raw = await raw.text();
                        if (raw instanceof ArrayBuffer) raw = new TextDecoder().decode(raw);
                        const message = JSON.parse(raw);
                        if (message.error) {
                            console.error('[Gemini Live diagnostics] transcription_setup_error', { sessionId: diagnosticSessionId, status: String(message.error.status || 'unknown') });
                            finish(new Error('Gemini Live transcription setup failed.'));
                            return;
                        }
                        if (message.setupComplete) {
                            transcriptionReady = true;
                            maybeReady();
                            console.info('[Gemini Live diagnostics] transcription_setup_complete', { sessionId: diagnosticSessionId, elapsedMs: Math.round(performance.now() - connectionStartedAt) });
                            return;
                        }
                        const content = message.serverContent;
                        const text = content?.inputTranscription?.text?.trim();
                        if (text) {
                            console.info('[Gemini Live diagnostics] transcript_received', { sessionId: diagnosticSessionId, characterCount: text.length });
                            window.dispatchEvent(new CustomEvent('gemini-live-user-transcript', { detail: { text } }));
                        }
                        const interim = content?.interimInputTranscription?.text;
                        if (interim) {
                            window.dispatchEvent(new CustomEvent('gemini-live-interim-transcript', { detail: { text: interim } }));
                        }
                    } catch (error) {
                        console.error('[Gemini Live] Transcription message error:', error);
                    }
                };
                transcriptionSocket.onerror = () => {
                    console.error('[Gemini Live diagnostics] transcription_socket_error', { sessionId: diagnosticSessionId });
                    finish(new Error('Gemini Live transcription connection failed.'));
                };
                transcriptionSocket.onclose = (event) => {
                    const detail = `code ${event.code}${event.reason ? `: ${event.reason}` : ''}`;
                    if (connectionStatus === 'connecting') {
                        finish(new Error(`Gemini Live transcription socket closed during setup (${detail}).`));
                    } else if (connectionStatus === 'connected') {
                        console.error('[Gemini Live] Transcription socket closed:', detail);
                        disconnect();
                        window.dispatchEvent(new CustomEvent('gemini-live-connection-error', {
                            detail: { message: `Transcription connection closed (${detail}).` }
                        }));
                    }
                };

                socket.onerror = () => {
                    console.error('[Gemini Live] WebSocket error.');
                    console.error('[Gemini Live diagnostics] speaker_socket_error', { sessionId: diagnosticSessionId });

                    finish(
                        new Error('Gemini Live WebSocket error.')
                    );
                };

                socket.onclose = (event) => {
                    const wasConnected = connectionStatus === 'connected';
                    const detail = `code ${event.code}${event.reason ? `: ${event.reason}` : ''}`;
                    console.log('[Gemini Live] Connection closed:', detail);

                    stopMicrophone();
                    stopPlayback();

                    if (transcriptionSocket) {
                        const currentTranscriptionSocket = transcriptionSocket;
                        transcriptionSocket = null;
                        currentTranscriptionSocket.close();
                    }

                    connectionStatus = 'disconnected';
                    socket = null;

                    if (!settled) {
                        finish(new Error(`Gemini Live speaker socket closed during setup (${detail}).`));
                    } else if (wasConnected) {
                        disconnect();
                        window.dispatchEvent(new CustomEvent('gemini-live-connection-error', {
                            detail: { message: `Speaker connection closed (${detail}).` }
                        }));
                    }
                };

            } catch (error) {
                finish(error);
            }
        });

        return connectionPromise;
    }

    /**
     * Convert microphone audio to 16-bit PCM, 16 kHz.
     */
    function convertToPCM(input, inputRate) {
        const ratio = inputRate / INPUT_SAMPLE_RATE;
        const outputLength = Math.floor(input.length / ratio);

        const output = new Int16Array(outputLength);

        for (let i = 0; i < outputLength; i++) {
            const start = Math.floor(i * ratio);
            const end = Math.min(
                Math.floor((i + 1) * ratio),
                input.length
            );

            let sum = 0;
            let count = 0;

            for (let j = start; j < end; j++) {
                sum += input[j];
                count++;
            }

            let sample = count ? sum / count : 0;

            sample = Math.max(-1, Math.min(1, sample));

            output[i] = sample < 0
                ? sample * 32768
                : sample * 32767;
        }

        return output;
    }

    /**
     * Convert PCM bytes to Base64.
     */
    function pcmToBase64(pcm) {
        const bytes = new Uint8Array(
            pcm.buffer,
            pcm.byteOffset,
            pcm.byteLength
        );

        const chunkSize = 0x8000;
        let binary = '';

        for (let i = 0; i < bytes.length; i += chunkSize) {
            const chunk = bytes.subarray(
                i,
                Math.min(i + chunkSize, bytes.length)
            );

            binary += String.fromCharCode(...chunk);
        }

        return btoa(binary);
    }

    /**
     * Send microphone audio to Gemini.
     */
    function sendAudio(pcm) {
        if (
            !transcriptionSocket ||
            transcriptionSocket.readyState !== WebSocket.OPEN ||
            connectionStatus !== 'connected'
        ) {
            return;
        }

        transcriptionSocket.send(JSON.stringify({
            realtimeInput: {
                audio: {
                    data: pcmToBase64(pcm),
                    mimeType: 'audio/pcm;rate=16000'
                }
            }
        }));
        // THIS IS NEW CODE — record only audio chunk counts, never encoded microphone data.
        audioChunkCount += 1;
        if (audioChunkCount === 1 || audioChunkCount % 50 === 0) {
            console.info('[Gemini Live diagnostics] microphone_audio_sent', { sessionId: diagnosticSessionId, chunkCount: audioChunkCount, chunkSamples: pcm.length });
        }
    }

    /**
     * Decode and play one Gemini PCM audio chunk.
     */
    function playAudioChunk(base64Data, mimeType) {
        try {
            if (!audioContext || audioContext.state === 'closed') {
                console.warn(
                    '[Gemini Live] Audio context unavailable.'
                );
                return;
            }

            if (audioContext.state !== 'running') {
                console.warn(
                    '[Audio Debug] AudioContext is not running:',
                    audioContext.state
                );
                return;
            }

            if (!mimeType.startsWith('audio/pcm')) {
                console.warn(
                    '[Gemini Live] Unsupported audio format:',
                    mimeType
                );
                return;
            }

            // Decode Base64.
            const binary = atob(base64Data);
            const byteLength = binary.length;

            if (byteLength < 2) {
                console.warn('[Gemini Live] Empty audio chunk.');
                return;
            }

            // Read little-endian signed 16-bit PCM samples.
            const samples = new Float32Array(
                Math.floor(byteLength / 2)
            );

            const view = new DataView(
                new ArrayBuffer(byteLength)
            );

            for (let i = 0; i < byteLength; i++) {
                view.setUint8(i, binary.charCodeAt(i));
            }

            for (let i = 0; i < samples.length; i++) {
                const value = view.getInt16(i * 2, true);
                const sample = value / 32768;

                samples[i] = sample;
            }

            // Create a 24 kHz audio buffer.
            const audioBuffer = audioContext.createBuffer(
                1,
                samples.length,
                OUTPUT_SAMPLE_RATE
            );

            audioBuffer.copyToChannel(samples, 0);

            // Schedule chunks sequentially.
            const source = audioContext.createBufferSource();

            source.buffer = audioBuffer;
            source.connect(audioContext.destination);

            const startAt = Math.max(
                audioContext.currentTime + 0.03,
                nextPlaybackTime
            );

            source.onended = () => {
                activeAudioSources.delete(source);
                source.disconnect();

                if (activeAudioSources.size === 0) {
                    window.dispatchEvent(
                        new CustomEvent(
                            'gemini-live-playback-status',
                            {
                                detail: { active: false }
                            }
                        )
                    );
                    maybeFinishSpeech();
                }
            };

            activeAudioSources.add(source);
            // THIS IS NEW CODE — report the start of playback with no decoded audio samples.
            playbackChunkCount += 1;
            if (playbackChunkCount === 1) {
                console.info('[Gemini Live diagnostics] answer_audio_playback_started', { sessionId: diagnosticSessionId, audioContextState: audioContext.state, sampleRate: OUTPUT_SAMPLE_RATE });
            }

            source.start(startAt);

            nextPlaybackTime =
                startAt + audioBuffer.duration;

            window.dispatchEvent(
                new CustomEvent('gemini-live-playback-status', {
                    detail: { active: true }
                })
            );

            console.log(
                '[Gemini Live] Audio chunk queued:',
                audioBuffer.duration.toFixed(2),
                'seconds'
            );

        } catch (error) {
            console.error(
                '[Gemini Live] Audio playback error:',
                error
            );
        }
    }

    /**
     * Stop all scheduled Gemini audio.
     */
    function stopPlayback() {
        onSpeechAnswerDone = null;
        speechTurnComplete = false;
        // THIS IS NEW CODE — clear buffered model chunks on cancellation and hang-up. Reason: prevent stale Extended Thinking audio from playing in the next answer.
        speechInteractionIdle = false;
        pendingAnswerAudioChunks = [];
        for (const source of activeAudioSources) {
            try {
                source.stop();
                source.disconnect();
            } catch (error) {
                // Source may already have finished.
            }
        }

        activeAudioSources.clear();
        nextPlaybackTime = 0;

        window.dispatchEvent(
            new CustomEvent('gemini-live-playback-status', {
                detail: { active: false }
            })
        );

        console.log('[Gemini Live] Playback queue cleared.');
    }

    /** Create/resume the playback context while the browser still has a user gesture. */
    function unlockAudio() {
        const AudioContextClass = window.AudioContext || window.webkitAudioContext;
        if (!AudioContextClass) {
            return null;
        }

        if (!audioContext || audioContext.state === 'closed') {
            audioContext = new AudioContextClass();
        }

        audioContext.resume().catch((error) => {
            console.warn('[Gemini Live] Could not resume audio context:', error);
        });

        return audioContext;
    }

    /**
     * Start continuous microphone streaming.
     */
    async function startMicrophone(deviceId = null) {
        if (microphoneActive) {
            return 'Microphone already active.';
        }

        if (
            !socket ||
            socket.readyState !== WebSocket.OPEN ||
            connectionStatus !== 'connected'
        ) {
            throw new Error(
                'Connect Gemini Live before starting microphone.'
            );
        }

        try {
            microphoneStream = await navigator.mediaDevices.getUserMedia({
                audio: {
                    ...(deviceId ? { deviceId: { exact: deviceId } } : {}),
                    channelCount: 1,
                    echoCancellation: true,
                    noiseSuppression: true,
                    autoGainControl: true
                }
            });

            unlockAudio();
            await audioContext.resume();

            console.log(
                '[Audio Debug] Microphone AudioContext:',
                audioContext.state,
                audioContext.sampleRate
            );

            microphoneSource =
                audioContext.createMediaStreamSource(microphoneStream);

            processor = audioContext.createScriptProcessor(
                PROCESSOR_BUFFER_SIZE,
                1,
                1
            );

            silentGain = audioContext.createGain();
            silentGain.gain.value = 0;

            processor.onaudioprocess = (event) => {
                if (!microphoneActive) return;

                if (
                    !socket ||
                    socket.readyState !== WebSocket.OPEN
                ) {
                    return;
                }

                const input =
                    event.inputBuffer.getChannelData(0);

                const pcm = convertToPCM(
                    input,
                    audioContext.sampleRate
                );

                if (pcm.length > 0) {
                    sendAudio(pcm);
                }
            };

            microphoneSource.connect(processor);
            processor.connect(silentGain);
            silentGain.connect(audioContext.destination);

            microphoneActive = true;
            audioChunkCount = 0;

            console.log(
                '[Gemini Live] Microphone started:',
                microphoneStream.getAudioTracks()[0].label
            );
            console.info('[Gemini Live diagnostics] microphone_capture_started', { sessionId: diagnosticSessionId, audioContextState: audioContext.state, sampleRate: audioContext.sampleRate });

            window.dispatchEvent(
                new CustomEvent('gemini-live-microphone-status', {
                    detail: { active: true }
                })
            );

            return 'Microphone streaming started.';

        } catch (error) {
            stopMicrophone();

            console.error('[Gemini Live] Microphone startup failed:', error?.name, error?.message, error);

            throw error;
        }
    }

    /**
     * Stop microphone streaming.
     */
    function stopMicrophone() {
        microphoneActive = false;

        if (
            transcriptionSocket &&
            transcriptionSocket.readyState === WebSocket.OPEN &&
            connectionStatus === 'connected'
        ) {
            transcriptionSocket.send(JSON.stringify({
                realtimeInput: {
                    audioStreamEnd: true
                }
            }));
        }

        if (processor) {
            processor.onaudioprocess = null;
            processor.disconnect();
            processor = null;
        }

        if (microphoneSource) {
            microphoneSource.disconnect();
            microphoneSource = null;
        }

        if (silentGain) {
            silentGain.disconnect();
            silentGain = null;
        }

        if (microphoneStream) {
            microphoneStream.getTracks().forEach(
                track => track.stop()
            );

            microphoneStream = null;
        }

        stopPlayback();

        console.log('[Gemini Live] Microphone stopped.');

        window.dispatchEvent(
            new CustomEvent('gemini-live-microphone-status', {
                detail: { active: false }
            })
        );

        return 'Microphone stopped.';
    }

    /**
     * Disconnect Gemini Live.
     */
    function disconnect() {
        connectionGeneration += 1;
        stopMicrophone();
        stopPlayback();

        clearTimeout(connectionTimeout);
        connectionTimeout = null;

        if (socket) {
            const currentSocket = socket;
            socket = null;
            currentSocket.close();
        }

        if (transcriptionSocket) {
            const currentSocket = transcriptionSocket;
            transcriptionSocket = null;
            currentSocket.close();
        }

        connectionStatus = 'disconnected';
        connectionPromise = null;

        console.log('[Gemini Live] Disconnected.');
    }

    /**
     * Public Gemini Live API.
     */
    window.GeminiLive = {
        initialized: true,

        getToken,
        connect,
        disconnect,

        startMicrophone,
        stopMicrophone,
        stopPlayback,
        unlockAudio,
        pauseMicrophone() {
            microphoneActive = false;
        },

        resumeMicrophone() {
            if (microphoneStream && processor) microphoneActive = true;
        },

        speak(text, onDone = () => {}) {
            if (!socket || socket.readyState !== WebSocket.OPEN || connectionStatus !== 'connected') {
                throw new Error('Gemini Live speech session is not connected.');
            }
            onSpeechAnswerDone = onDone;
            speechTurnComplete = false;
            // THIS IS NEW CODE — reset answer-turn state before sending a new exact-text request. Reason: keep follow-up audio isolated from earlier interactions.
            speechInteractionIdle = !requiresInteractionIdle;
            pendingAnswerAudioChunks = [];
            speechStartedAt = performance.now();
            playbackChunkCount = 0;
            console.info('[Gemini Live diagnostics] answer_audio_requested', { sessionId: diagnosticSessionId, characterCount: text.length });
            socket.send(JSON.stringify({
                clientContent: {
                    turns: [{ role: 'user', parts: [{ text: `Speak this text exactly as written, with no additions: ${text}` }] }],
                    turnComplete: true
                }
            }));
        },

        status() {
            return connectionStatus;
        },

        isMicrophoneActive() {
            return microphoneActive;
        },

        isPlaybackActive() {
            return activeAudioSources.size > 0;
        }
    };

})();
