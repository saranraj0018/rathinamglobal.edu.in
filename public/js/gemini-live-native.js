/* Browser-native Gemini Live audio session with session-preloaded approved facts. */
(() => {
  "use strict";

  const INPUT_RATE = 16000;
  const OUTPUT_RATE = 24000;
  const POLICY = `You are Priya, a friendly, intelligent voice assistant for Rathinam Global University students.
You are approachable and helpful, like a knowledgeable college senior, never a formal customer-care robot.
Understand and speak English, Tamil, and Tanglish. Understand broken English, slang, shorthand, and incomplete but understandable questions. Do not correct grammar or make the student repeat an understandable question. Follow the language the student uses and retain context for follow-up questions.
Answer the actual question directly and naturally. Be concise by default, and provide more detail when requested. Do not repeat information unnecessarily.
For general topics, answer using your built-in knowledge. For Rathinam-specific hostel and transport questions, use only the verified facts supplied in the session context. Never invent or infer university-specific fees, timings, routes, policies, facilities, names, or contact details. If a requested detail is missing, say in the student's language that you do not have confirmed information and suggest checking with the hostel or transport office.
Treat topic labels and question cues as silent understanding aids. Convert the verified answer into natural spoken language. Never read headings, metadata, keywords, markdown, or URLs aloud. Do not use retrieval, tools, or external sources.
Speak warmly and naturally. Keep ordinary spoken answers to one to three sentences, while giving more detail when the student asks.`;

  class NativeLiveClient {
    constructor() {
      this.socket = null;
      this.context = null;
      this.stream = null;
      this.processor = null;
      this.source = null;
      this.silentGain = null;
      this.sources = new Set();
      this.nextPlaybackAt = 0;
      this.generation = 0;
      this.csrf = "";
      this.requestUrl = "";
      this.state = "closed";
      this.microphoneEnabled = false;
      this.interaction = "IDLE";
      this.turnComplete = false;
      this.setupResolve = null;
      this.setupReject = null;
      this.setupTimer = null;
      this.activeSpeechDone = null;
      this.audioCount = 0;
      this.diagnosticSessionId = "";
      this.connectionStartedAt = 0;
      this.tokenRequestStartedAt = 0;
      this.socketConnectStartedAt = 0;
      this.setupSentAt = 0;
      this.connectionOpened = false;
      this.setupCompleted = false;
      this.microphoneStarted = false;
      this.audioChunksSent = 0;
      this.serverMessagesReceived = 0;
      this.responseAudioChunksReceived = 0;
      this.responseTextCharacters = 0;
      this.firstServerResponseLogged = false;
      this.firstResponseAudioLogged = false;
      this.clientTextTurnsSent = 0;
      this.awaitingUserAudioResponse = false;
      this.userTurnResponseLogged = false;
    }

    unlockAudio() {
      const AudioContextClass = window.AudioContext || window.webkitAudioContext;
      if (!AudioContextClass) return null;
      if (!this.context || this.context.state === "closed") {
        this.context = new AudioContextClass({ sampleRate: OUTPUT_RATE });
      }
      if (this.context.state === "suspended") {
        this.context.resume().catch(() => {});
      }
      return this.context;
    }

    async connect({ csrf, requestUrl }) {
      this.disconnect(false);
      this.unlockAudio();
      const generation = ++this.generation;
      this.csrf = csrf || "";
      this.requestUrl = requestUrl;
      this.state = "connecting";
      this.interaction = "IDLE";
      this.turnComplete = false;
      this.audioCount = 0;
      this.connectionOpened = false;
      this.setupCompleted = false;
      this.microphoneStarted = false;
      this.audioChunksSent = 0;
      this.serverMessagesReceived = 0;
      this.responseAudioChunksReceived = 0;
      this.responseTextCharacters = 0;
      this.firstServerResponseLogged = false;
      this.firstResponseAudioLogged = false;
      this.clientTextTurnsSent = 0;
      this.awaitingUserAudioResponse = false;
      this.userTurnResponseLogged = false;
      this.diagnosticSessionId = crypto.randomUUID();
      this.connectionStartedAt = performance.now();

      try {
        this.tokenRequestStartedAt = performance.now();
        const response = await fetch(requestUrl, {
          method: "POST",
          credentials: "same-origin",
          headers: {
            "Accept": "application/json",
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": this.csrf,
            "X-Assistant-Request-Id": this.diagnosticSessionId,
          },
          body: "{}",
        });

        const tokenData = await response.json().catch(() => ({}));
        if (!response.ok) {
          const detail = typeof tokenData.error === "string" ? `: ${tokenData.error}` : "";
          throw new Error(`Native Live token request failed (HTTP ${response.status})${detail}`);
        }
        if (typeof tokenData.token !== "string" || tokenData.token === "" || typeof tokenData.model !== "string" || tokenData.model === "" || typeof tokenData.knowledge_context !== "string" || tokenData.knowledge_context.trim() === "") {
          throw new Error(`Native Live startup response is missing a token, model, or verified knowledge context (HTTP ${response.status}).`);
        }

        this.logDiagnostic("native_token_ready", {
          requestId: this.diagnosticSessionId,
          httpStatus: response.status,
          elapsedMs: Math.round(performance.now() - this.tokenRequestStartedAt),
          knowledgeLoadMs: Number(tokenData.knowledge_load_ms) || 0,
          knowledgeCharacters: tokenData.knowledge_context.length,
        });
        if (generation !== this.generation) throw new Error("Native Live session was superseded.");

        this.socketConnectStartedAt = performance.now();
        const socket = new WebSocket("wss://generativelanguage.googleapis.com/ws/google.ai.generativelanguage.v1beta.GenerativeService.BidiGenerateContentConstrained?access_token=" + encodeURIComponent(tokenData.token));
        this.socket = socket;
        socket.binaryType = "arraybuffer";

        await new Promise((resolve, reject) => {
          this.setupResolve = resolve;
          this.setupReject = reject;
          this.setupTimer = window.setTimeout(() => reject(new Error("Native Live session setup timed out after 20 seconds.")), 20000);

          socket.onopen = () => {
            if (generation !== this.generation) return;
            const model = tokenData.model.startsWith("models/") ? tokenData.model : `models/${tokenData.model}`;
            const instructionParts = [{ text: POLICY }, { text: tokenData.knowledge_context }];
            const setupPayload = {
              model,
              generationConfig: {
                responseModalities: ["AUDIO"],
                speechConfig: { voiceConfig: { prebuiltVoiceConfig: { voiceName: "Aoede" } } },
                thinkingConfig: { thinkingLevel: "LOW" },
              },
              systemInstruction: { parts: instructionParts },
              inputAudioTranscription: {},
              outputAudioTranscription: {},
              realtimeInputConfig: { automaticActivityDetection: { disabled: false } },
            };

            this.setupSentAt = performance.now();
            this.connectionOpened = true;
            this.logDiagnostic("websocket_connected", {
              elapsedMs: Math.round(this.setupSentAt - this.socketConnectStartedAt),
              connectionOpened: true,
            });
            socket.send(JSON.stringify({ setup: setupPayload }));
            this.logDiagnostic("session_setup_sent", {
              model: tokenData.model,
              knowledgeIncluded: true,
              instructionPartCount: instructionParts.length,
              knowledgeCharacters: tokenData.knowledge_context.length,
            });
          };

          socket.onmessage = (event) => this.handleMessage(event.data, generation);
          socket.onerror = () => {
            const error = new Error("Native Live WebSocket transport failed.");
            this.logDiagnostic("websocket_error", {
              connectionOpened: this.connectionOpened,
              setupComplete: this.setupCompleted,
              microphoneStarted: this.microphoneStarted,
              audioChunksSent: this.audioChunksSent,
              serverMessagesReceived: this.serverMessagesReceived,
              errorName: error.name,
              errorMessage: error.message,
              errorStack: error.stack || "",
            }, "error");
            if (this.setupReject) {
              this.setupReject(error);
            } else {
              this.failSession(error);
            }
          };
          socket.onclose = (event) => {
            if (generation !== this.generation || this.state === "closed") return;
            const wasSettingUp = Boolean(this.setupReject);
            const closeReason = this.safeDiagnosticMessage(event?.reason || "");
            this.logDiagnostic("websocket_closed", {
              connectionOpened: this.connectionOpened,
              setupComplete: this.setupCompleted,
              microphoneStarted: this.microphoneStarted,
              audioChunksSent: this.audioChunksSent,
              serverMessagesReceived: this.serverMessagesReceived,
              responseAudioChunksReceived: this.responseAudioChunksReceived,
              closeCode: event?.code ?? null,
              closeReason,
              beforeSetupComplete: !this.setupCompleted,
            }, "warn");
            if (wasSettingUp) {
              this.setupReject(new Error(`Native Live WebSocket closed before setup completed (code ${event?.code ?? "unknown"})${closeReason ? `: ${closeReason}` : ""}.`));
            }
            this.socket = null;
            this.disconnect(false);
            this.dispatch("gemini-live-native-error", { message: `Native Live connection closed (code ${event?.code ?? "unknown"})${closeReason ? `: ${closeReason}` : ""}.` });
          };
        });

        if (generation !== this.generation) throw new Error("Native Live session was superseded.");
        this.state = "ready";
        this.logDiagnostic("live_session_started", {
          elapsedMs: Math.round(performance.now() - this.connectionStartedAt),
          setupElapsedMs: Math.round(performance.now() - this.setupSentAt),
          model: tokenData.model,
          connectionOpened: this.connectionOpened,
          setupComplete: this.setupCompleted,
        });
        this.dispatch("gemini-live-native-status", { state: this.state });
        return true;
      } catch (error) {
        if (generation === this.generation) {
          this.state = "closed";
          this.microphoneEnabled = false;
          window.clearTimeout(this.setupTimer);
          this.setupTimer = null;
          this.setupResolve = this.setupReject = null;
          const failedSocket = this.socket;
          this.socket = null;
          this.stopPlayback();
          if (failedSocket && failedSocket.readyState !== WebSocket.CLOSED) failedSocket.close();
          const safeMessage = this.safeDiagnosticMessage(error?.message || "Native Live setup failed.");
          this.logDiagnostic("startup_failed", {
            connectionOpened: this.connectionOpened,
            setupComplete: this.setupCompleted,
            microphoneStarted: this.microphoneStarted,
            audioChunksSent: this.audioChunksSent,
            serverMessagesReceived: this.serverMessagesReceived,
            errorName: error?.name || "Error",
            errorMessage: safeMessage,
            errorStack: this.safeDiagnosticMessage(error?.stack || ""),
          }, "error");
          this.dispatch("gemini-live-native-error", { message: safeMessage });
        }
        throw error;
      }
    }

    handleMessage(raw, generation = this.generation) {
      if (generation !== this.generation || this.state === "closed") return;
      let message;
      try {
        message = JSON.parse(typeof raw === "string" ? raw : new TextDecoder().decode(raw));
      } catch (error) {
        this.logDiagnostic("server_message_parse_failed", {
          errorName: error?.name || "SyntaxError",
          errorMessage: this.safeDiagnosticMessage(error?.message || "Invalid JSON message."),
        }, "error");
        return;
      }
      this.serverMessagesReceived += 1;

      if (message.error) {
        const safeMessage = this.safeDiagnosticMessage(message.error.message || "Native Live setup or session error.");
        this.logDiagnostic("server_error", {
          connectionOpened: this.connectionOpened,
          setupComplete: this.setupCompleted,
          microphoneStarted: this.microphoneStarted,
          audioChunksSent: this.audioChunksSent,
          serverMessagesReceived: this.serverMessagesReceived,
          errorCode: message.error.code ?? null,
          errorStatus: this.safeDiagnosticMessage(message.error.status || ""),
          errorMessage: safeMessage,
          beforeSetupComplete: !this.setupCompleted,
        }, "error");
        const error = new Error(safeMessage);
        error.name = "GeminiLiveServerError";
        if (this.setupReject) {
          this.setupReject(error);
        } else {
          this.failSession(error);
        }
        return;
      }

      if (message.setupComplete) {
        this.setupCompleted = true;
        window.clearTimeout(this.setupTimer);
        this.setupTimer = null;
        this.state = "ready";
        this.setupResolve?.();
        this.setupResolve = this.setupReject = null;
        this.logDiagnostic("setup_complete", {
          connectionOpened: this.connectionOpened,
          setupComplete: true,
          setupElapsedMs: Math.round(performance.now() - this.setupSentAt),
        });
        return;
      }

      const content = message.serverContent || {};
      const interactionStatus = content.interactionStatus || content.interaction_status || message.interactionStatus || message.interaction_status;
      const responseParts = content.modelTurn?.parts || [];
      const responseAudioParts = responseParts.filter((part) => {
        const audio = part.inlineData || part.inline_data;
        return audio?.data && String(audio.mimeType || audio.mime_type || "").startsWith("audio/pcm");
      });
      const textParts = responseParts.filter((part) => typeof part.text === "string");
      const outputTranscriptText = content.outputAudioTranscription?.text || content.interimOutputAudioTranscription?.text || "";
      if (Object.keys(content).length > 0 && !this.firstServerResponseLogged) {
        this.firstServerResponseLogged = true;
        this.logDiagnostic("first_server_message", {
          serverMessagesReceived: this.serverMessagesReceived,
          clientTextTurnsSent: this.clientTextTurnsSent,
          interactionStatus: interactionStatus || null,
          inputTranscriptCharacters: (content.inputTranscription?.text || content.interimInputTranscription?.text || "").length,
          responseAudioParts: responseAudioParts.length,
          responseTextCharacters: textParts.reduce((count, part) => count + part.text.length, 0),
          outputTranscriptCharacters: outputTranscriptText.length,
          turnComplete: Boolean(content.turnComplete),
        });
      }
      if (interactionStatus) {
        this.interaction = interactionStatus;
        this.dispatch("gemini-live-native-status", { state: this.interaction === "IDLE" ? "listening" : "thinking" });
      }

      if (content.interrupted) {
        this.stopPlayback();
        this.turnComplete = false;
        this.dispatch("gemini-live-native-interrupted", {});
      }

      const input = content.inputTranscription?.text || content.interimInputTranscription?.text;
      if (input) {
        if (content.inputTranscription?.text) {
          this.logDiagnostic("user_audio_turn_transcribed", {
            textCharacters: input.length,
            audioChunksSent: this.audioChunksSent,
            microphoneStarted: this.microphoneStarted,
          });
        }
        this.logDiagnostic("input_transcription_received", {
          textCharacters: input.length,
          final: Boolean(content.inputTranscription?.text),
          setupComplete: this.setupCompleted,
          microphoneStarted: this.microphoneStarted,
        });
        if (content.inputTranscription?.text) {
          this.awaitingUserAudioResponse = true;
          this.userTurnResponseLogged = false;
        }
        this.dispatch("gemini-live-native-transcript", { text: input, final: Boolean(content.inputTranscription?.text) });
      }

      const outputTranscript = outputTranscriptText;
      if (this.awaitingUserAudioResponse && !this.userTurnResponseLogged && (responseAudioParts.length > 0 || textParts.length > 0 || outputTranscriptText.length > 0)) {
        this.userTurnResponseLogged = true;
        this.logDiagnostic("user_turn_response_started", {
          responseAudioParts: responseAudioParts.length,
          responseTextCharacters: textParts.reduce((count, part) => count + part.text.length, 0),
          outputTranscriptCharacters: outputTranscriptText.length,
          serverMessagesReceived: this.serverMessagesReceived,
        });
      }
      if (outputTranscript) this.dispatch("gemini-live-native-caption", { text: outputTranscript });

      for (const part of content.modelTurn?.parts || []) {
        const audio = part.inlineData || part.inline_data;
        if (audio?.data && String(audio.mimeType || audio.mime_type || "").startsWith("audio/pcm")) {
          this.responseAudioChunksReceived += 1;
          if (!this.firstResponseAudioLogged) {
            this.firstResponseAudioLogged = true;
            this.logDiagnostic("first_audio_output_received", {
              responseAudioChunksReceived: this.responseAudioChunksReceived,
              clientTextTurnsSent: this.clientTextTurnsSent,
              audioMimeType: audio.mimeType || audio.mime_type,
              setupComplete: this.setupCompleted,
              microphoneStarted: this.microphoneStarted,
              elapsedMs: Math.round(performance.now() - this.connectionStartedAt),
            });
          }
          this.playAudio(audio.data, audio.mimeType || audio.mime_type);
        }
        const spokenText = part.text;
        if (spokenText) {
          this.responseTextCharacters += spokenText.length;
          this.dispatch("gemini-live-native-caption", { text: spokenText });
        }
      }

      if (content.turnComplete) {
        this.turnComplete = true;
      }
      this.finishIfIdle();
    }

    sendText(text) {
      if (!this.socket || this.socket.readyState !== WebSocket.OPEN || this.state === "closed") throw new Error("Native Live is not connected.");
      this.turnComplete = false;
      this.interaction = "IN_PROGRESS";
      this.socket.send(JSON.stringify({ clientContent: { turns: [{ role: "user", parts: [{ text }] }], turnComplete: true } }));
      this.clientTextTurnsSent += 1;
      this.logDiagnostic("client_text_turn_sent", { textCharacters: String(text).length });
    }

    async startMicrophone() {
      if (!this.socket || this.state === "closed") throw new Error("Native Live is not connected.");
      const AudioContextClass = window.AudioContext || window.webkitAudioContext;
      if (!AudioContextClass) throw new Error("Audio input is unavailable.");
      this.context = this.context || new AudioContextClass({ sampleRate: OUTPUT_RATE });
      if (this.context.state === "suspended") {
        await this.context.resume().catch(() => {});
      }
      this.stream = await navigator.mediaDevices.getUserMedia({ audio: { channelCount: 1, echoCancellation: true, noiseSuppression: true, autoGainControl: true } });
      this.microphoneStarted = true;
      this.source = this.context.createMediaStreamSource(this.stream);
      this.processor = this.context.createScriptProcessor(4096, 1, 1);
      this.silentGain = this.context.createGain();
      this.silentGain.gain.value = 0;
      this.processor.onaudioprocess = (event) => {
        if (!this.microphoneEnabled || !this.socket || this.socket.readyState !== WebSocket.OPEN) return;
        const pcm = this.convertToPcm(event.inputBuffer.getChannelData(0), this.context.sampleRate);
        if (pcm.length) {
          this.socket.send(JSON.stringify({
            realtimeInput: {
              audio: {
                data: this.toBase64(pcm),
                mimeType: `audio/pcm;rate=${INPUT_RATE}`,
              },
            },
          }));
          this.audioChunksSent += 1;
          if (this.audioChunksSent === 1) {
            this.logDiagnostic("first_microphone_audio_sent", {
              setupComplete: this.setupCompleted,
              microphoneStarted: this.microphoneStarted,
              inputRate: INPUT_RATE,
              audioChunksSent: this.audioChunksSent,
            });
          }
        }
      };
      this.source.connect(this.processor);
      this.processor.connect(this.silentGain);
      this.silentGain.connect(this.context.destination);
      this.state = "listening";
      this.microphoneEnabled = true;
      this.dispatch("gemini-live-native-status", { state: this.state });
      this.dispatch("gemini-live-native-audio-input-started", {});
      this.logDiagnostic("microphone_started", {
        connectionOpened: this.connectionOpened,
        setupComplete: this.setupCompleted,
        microphoneStarted: true,
        inputRate: INPUT_RATE,
        audioContextRate: this.context.sampleRate,
      });
    }

    convertToPcm(input, inputRate) {
      const ratio = inputRate / INPUT_RATE;
      const result = new Int16Array(Math.floor(input.length / ratio));
      for (let index = 0; index < result.length; index += 1) {
        const start = Math.floor(index * ratio);
        const end = Math.min(Math.floor((index + 1) * ratio), input.length);
        let total = 0;
        for (let cursor = start; cursor < end; cursor += 1) total += input[cursor];
        const sample = Math.max(-1, Math.min(1, total / Math.max(1, end - start)));
        result[index] = sample < 0 ? sample * 32768 : sample * 32767;
      }
      return result;
    }

    toBase64(pcm) {
      const bytes = new Uint8Array(pcm.buffer, pcm.byteOffset, pcm.byteLength);
      let binary = "";
      for (let offset = 0; offset < bytes.length; offset += 0x8000) {
        binary += String.fromCharCode(...bytes.subarray(offset, Math.min(offset + 0x8000, bytes.length)));
      }
      return btoa(binary);
    }

    playAudio(base64, mimeType) {
      const rate = Number(/rate=(\d+)/.exec(mimeType)?.[1] || OUTPUT_RATE);
      const AudioContextClass = window.AudioContext || window.webkitAudioContext;
      if (!AudioContextClass) return;
      if (!this.context || this.context.state === "closed") {
        this.context = new AudioContextClass({ sampleRate: OUTPUT_RATE });
      }
      if (this.context.state === "suspended") {
        this.context.resume().catch(() => {});
      }
      const bytes = Uint8Array.from(atob(base64), (character) => character.charCodeAt(0));
      if (bytes.length < 2) return;
      const view = new DataView(bytes.buffer);
      const samples = new Float32Array(Math.floor(bytes.length / 2));
      for (let index = 0; index < samples.length; index += 1) {
        samples[index] = view.getInt16(index * 2, true) / 32768;
      }
      const buffer = this.context.createBuffer(1, samples.length, rate);
      buffer.copyToChannel(samples, 0);
      const source = this.context.createBufferSource();
      source.buffer = buffer;
      source.connect(this.context.destination);

      // Reset playback scheduler if nextPlaybackAt has fallen behind currentTime
      const now = this.context.currentTime;
      const startAt = Math.max(now + 0.025, this.nextPlaybackAt);
      this.nextPlaybackAt = startAt + buffer.duration;

      source.onended = () => {
        this.sources.delete(source);
        source.disconnect();
        this.finishIfIdle();
      };
      this.sources.add(source);
      source.start(startAt);
      this.audioCount += 1;
      if (this.audioCount === 1) {
        console.info("[Gemini Live stage 9: continuation_audio_started]", {
          requestId: this.diagnosticSessionId,
          firstAudioElapsedMs: Math.round(performance.now() - this.connectionStartedAt),
        });
      }
      this.dispatch("gemini-live-native-status", { state: "speaking" });
      this.dispatch("gemini-live-native-playback", { active: true, chunk: this.audioCount });
    }

    finishIfIdle() {
      if (this.sources.size !== 0) return;
      this.dispatch("gemini-live-native-playback", { active: false });
      if (this.interaction === "IDLE" && this.turnComplete) {
        const completedTurn = {
          audioChunksSent: this.audioChunksSent,
          responseAudioChunksReceived: this.responseAudioChunksReceived,
          responseTextCharacters: this.responseTextCharacters,
          serverMessagesReceived: this.serverMessagesReceived,
        };
        if (this.awaitingUserAudioResponse) {
          completedTurn.userTurnResponseStarted = this.userTurnResponseLogged;
          this.awaitingUserAudioResponse = false;
        }
        this.turnComplete = false;
        this.state = this.microphoneEnabled ? "listening" : (this.stream ? "muted" : "ready");
        this.activeSpeechDone?.();
        this.activeSpeechDone = null;
        this.dispatch("gemini-live-native-status", { state: this.state });
        this.logDiagnostic("live_turn_completed", completedTurn);
      }
    }

    logDiagnostic(eventName, details = {}, level = "info") {
      const payload = {
        event: eventName,
        timestamp: new Date().toISOString(),
        requestId: this.diagnosticSessionId,
        elapsedMs: this.connectionStartedAt ? Math.round(performance.now() - this.connectionStartedAt) : null,
        ...details,
      };
      const safePayload = Object.fromEntries(Object.entries(payload).map(([key, value]) => [
        key,
        typeof value === "string" ? this.safeDiagnosticMessage(value) : value,
      ]));
      const logger = level === "error" ? console.error : level === "warn" ? console.warn : console.info;
      logger.call(console, `[Gemini Live diagnostics] ${eventName}`, safePayload);
    }

    safeDiagnosticMessage(value) {
      return String(value)
        .replace(/(access_token=)[^&\s)]+/gi, "$1[redacted]")
        .replace(/(Bearer\s+)[^\s,;]+/gi, "$1[redacted]")
        .replace(/AIza[0-9A-Za-z_-]{20,}/g, "[redacted-api-key]")
        .replace(/((?:api[_-]?key|token)\s*[:=]\s*)[^\s,;]+/gi, "$1[redacted]")
        .slice(0, 1200);
    }

    failSession(error) {
      const safeMessage = this.safeDiagnosticMessage(error?.message || "Native Live session failed.");
      this.logDiagnostic("live_session_failed", {
        connectionOpened: this.connectionOpened,
        setupComplete: this.setupCompleted,
        microphoneStarted: this.microphoneStarted,
        audioChunksSent: this.audioChunksSent,
        serverMessagesReceived: this.serverMessagesReceived,
        responseAudioChunksReceived: this.responseAudioChunksReceived,
        errorName: error?.name || "Error",
        errorMessage: safeMessage,
        errorStack: this.safeDiagnosticMessage(error?.stack || ""),
        beforeSetupComplete: !this.setupCompleted,
      }, "error");
      const socket = this.socket;
      this.socket = null;
      this.disconnect(false);
      if (socket && socket.readyState !== WebSocket.CLOSED) socket.close();
      this.dispatch("gemini-live-native-error", { message: safeMessage });
    }

    sayWelcome(text, done) {
      this.activeSpeechDone = done;
      this.sendText(`Begin this call by speaking this exact short welcome: ${text}`);
    }

    stopPlayback() {
      for (const source of this.sources) {
        try { source.stop(); source.disconnect(); } catch { /* Audio source already ended. */ }
      }
      this.sources.clear();
      this.nextPlaybackAt = 0;
      this.dispatch("gemini-live-native-playback", { active: false });
    }

    pauseMicrophone() {
      this.microphoneEnabled = false;
      if (this.stream) this.state = "muted";
      if (this.socket?.readyState === WebSocket.OPEN) this.socket.send(JSON.stringify({ realtimeInput: { audioStreamEnd: true } }));
    }

    resumeMicrophone() {
      if (this.stream) {
        this.microphoneEnabled = true;
        this.state = "listening";
      }
    }

    status() { return this.state; }

    disconnect() {
      const oldGeneration = this.generation;
      this.generation += 1;
      this.state = "closed";
      this.microphoneEnabled = false;
      window.clearTimeout(this.setupTimer);
      this.setupTimer = null;
      this.setupResolve = this.setupReject = null;
      this.interaction = "IDLE";
      this.turnComplete = false;
      this.activeSpeechDone = null;
      this.stopPlayback();
      if (this.processor) { this.processor.onaudioprocess = null; this.processor.disconnect(); }
      this.source?.disconnect();
      this.silentGain?.disconnect();
      this.stream?.getTracks().forEach((track) => track.stop());
      this.processor = this.source = this.silentGain = this.stream = null;

      if (this.socket) {
        const socket = this.socket;
        this.socket = null;
        socket.close();
      }
      this.dispatch("gemini-live-native-status", { state: this.state, generation: oldGeneration });
    }

    dispatch(name, detail) { window.dispatchEvent(new CustomEvent(name, { detail })); }
  }

  window.GeminiLiveNative = new NativeLiveClient();
})();
