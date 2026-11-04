import assert from "node:assert/strict";
import { readFileSync } from "node:fs";
import { test } from "node:test";
import vm from "node:vm";

const clientSource = readFileSync(new URL("../../public/js/gemini-live-native.js", import.meta.url), "utf8");
const voiceSource = readFileSync(new URL("../../public/js/voice-assistant.js", import.meta.url), "utf8");
const viewSource = readFileSync(new URL("../../resources/views/components/voice-assistant.blade.php", import.meta.url), "utf8");

function createHarness(fetchImpl = async () => ({
  ok: true,
  status: 200,
  json: async () => ({
    token: "one-use-token",
    model: "gemini-3.8-live-extended-thinking",
    knowledge_context: "Topic: Hostel Wi-Fi\nVerified answer: Wi-Fi connectivity is available throughout the hostel premises.",
    knowledge_load_ms: 1,
    diagnostic_mode: false,
  }),
})) {
  const events = [];
  const sockets = [];
  const audioSources = [];
  const logs = [];
  let fetchCount = 0;
  let mockNow = 1000;
  let processorSize = 0;

  class FakeWebSocket {
    static OPEN = 1;
    static CLOSED = 3;

    constructor(url) {
      this.url = url;
      this.readyState = 0;
      this.sent = [];
      sockets.push(this);
    }

    send(text) { this.sent.push(JSON.parse(text)); }
    open() { this.readyState = FakeWebSocket.OPEN; this.onopen?.(); }
    receive(data) { this.onmessage?.({ data: JSON.stringify(data) }); }
    close(code = 1000, reason = "") {
      this.readyState = FakeWebSocket.CLOSED;
      this.onclose?.({ code, reason });
    }
  }

  class FakeAudioContext {
    constructor() {
      this.state = "running";
      this.sampleRate = 48000;
      this.currentTime = 2;
      this.destination = {};
    }

    resume() { return Promise.resolve(); }
    createMediaStreamSource() { return { connect: (node) => { this.processor = node; }, disconnect() {} }; }
    createScriptProcessor(size) { processorSize = size; return { connect() {}, disconnect() {}, onaudioprocess: null }; }
    createGain() { return { gain: { value: 1 }, connect() {}, disconnect() {} }; }
    createBuffer(_channels, length, rate) { return { duration: length / rate, copyToChannel() {} }; }
    createBufferSource() {
      const source = {
        buffer: { duration: 0.5 },
        connect() {},
        disconnect() {},
        start(time) { source.startAt = time; },
        stop() { source.onended?.(); }
      };
      audioSources.push(source);
      return source;
    }
  }

  const window = {
    AudioContext: FakeAudioContext,
    setTimeout,
    clearTimeout,
    dispatchEvent: (event) => events.push(event),
  };
  const context = {
    window,
    WebSocket: FakeWebSocket,
    AbortController,
    CustomEvent: class { constructor(type, options) { this.type = type; this.detail = options?.detail; } },
    TextDecoder,
    crypto: { randomUUID: () => "mock-request-id" },
    performance: { now: () => mockNow },
    navigator: { mediaDevices: { getUserMedia: async () => ({ getTracks: () => [{ stop() {} }] }) } },
    btoa,
    atob,
    fetch: async (...args) => { fetchCount += 1; return fetchImpl(...args); },
    console: {
      log: (...args) => logs.push(args),
      info: (...args) => logs.push(args),
      warn: (...args) => logs.push(args),
      error: (...args) => logs.push(args),
    },
  };
  vm.runInNewContext(clientSource, context, { filename: "gemini-live-native.js" });

  return {
    client: window.GeminiLiveNative,
    events,
    sockets,
    audioSources,
    logs,
    context,
    get fetchCount() { return fetchCount; },
    get processorSize() { return processorSize; },
    setNow(value) { mockNow = value; },
  };
}

async function connectHarness(harness) {
  const connecting = harness.client.connect({ csrf: "csrf-test", requestUrl: "/api/gemini-live/native-token" });
  await new Promise((resolve) => setTimeout(resolve, 10));
  const socket = harness.sockets[0];
  socket.open();
  const setup = socket.sent[0].setup;
  socket.receive({ setupComplete: {} });
  await connecting;
  return { socket, setup };
}

test("preloads the verified context once in a tool-free Live setup", async () => {
  const harness = createHarness();
  const { socket, setup } = await connectHarness(harness);

  assert.equal(harness.fetchCount, 1);
  assert.equal(harness.sockets.length, 1);
  assert.equal(setup.model, "models/gemini-3.8-live-extended-thinking");
  assert.equal(setup.generationConfig.responseModalities[0], "AUDIO");
  assert.equal(setup.generationConfig.speechConfig.voiceConfig.prebuiltVoiceConfig.voiceName, "Aoede");
  assert.equal(setup.generationConfig.thinkingConfig.thinkingLevel, "LOW");
  assert.equal(setup.realtimeInputConfig.automaticActivityDetection.disabled, false);
  assert.ok(setup.inputAudioTranscription);
  assert.ok(setup.outputAudioTranscription);
  assert.equal("tools" in setup, false);
  assert.match(setup.systemInstruction.parts[0].text, /Priya/);
  assert.match(setup.systemInstruction.parts[0].text, /English, Tamil, and Tanglish/);
  assert.match(setup.systemInstruction.parts[0].text, /broken English/);
  assert.match(setup.systemInstruction.parts[1].text, /Topic: Hostel Wi-Fi/);
  assert.match(setup.systemInstruction.parts[0].text, /Never invent or infer university-specific fees, timings, routes/);
  assert.doesNotMatch(setup.systemInstruction.parts[1].text, /hostel fee is \d|route via Coimbatore/i);
  assert.equal(harness.fetchCount, 1, "only the session token and knowledge payload are fetched");
});

test("never sends a model function call to the Laravel knowledge endpoint", async () => {
  const harness = createHarness();
  const { socket } = await connectHarness(harness);
  const setup = socket.sent[0].setup;
  socket.receive({
    toolCall: {
      functionCalls: [{ id: "call_abc123", name: "search_rathinam_knowledge", args: { query: "What bus routes are available?" } }],
    },
  });

  assert.equal(harness.fetchCount, 1, "no additional HTTP call is made for a user question or model tool request");
  assert.equal("tools" in setup, false);
  assert.equal(socket.sent.some((message) => message.toolResponse), false);
  assert.equal(socket.sent.some((message) => JSON.stringify(message).includes("live-knowledge")), false);
});

test("always keeps verified context in setup even when a diagnostic flag is returned", async () => {
  const harness = createHarness(async () => ({
    ok: true,
    status: 200,
    json: async () => ({
      token: "one-use-token",
      model: "gemini-3.8-live-extended-thinking",
      knowledge_context: "Verified answer: Hostel fees are not specified.",
      diagnostic_mode: true,
    }),
  }));
  const { setup } = await connectHarness(harness);

  assert.match(setup.systemInstruction.parts[0].text, /You are Priya/);
  assert.match(setup.systemInstruction.parts[1].text, /Hostel fees are not specified/);
});

test("a reconnect obtains and sends fresh session knowledge", async () => {
  let requestNumber = 0;
  const harness = createHarness(async () => {
    requestNumber += 1;
    return { ok: true, status: 200, json: async () => ({
      token: `one-use-token-${requestNumber}`,
      model: "gemini-3.8-live-extended-thinking",
      knowledge_context: `session knowledge ${requestNumber}`,
      diagnostic_mode: false,
    }) };
  });

  await connectHarness(harness);
  const reconnecting = harness.client.connect({ csrf: "csrf-test", requestUrl: "/api/gemini-live/native-token" });
  await new Promise((resolve) => setTimeout(resolve, 10));
  const socket = harness.sockets[1];
  socket.open();
  const setup = socket.sent[0].setup;
  socket.receive({ setupComplete: {} });
  await reconnecting;

  assert.equal(harness.fetchCount, 2);
  assert.equal(setup.systemInstruction.parts[1].text, "session knowledge 2");
});

test("streams microphone audio as 16 kHz PCM and sends user turns", async () => {
  const harness = createHarness();
  const { socket } = await connectHarness(harness);
  await harness.client.startMicrophone();

  harness.client.processor.onaudioprocess({
    inputBuffer: {
      getChannelData: () => new Float32Array(4096).fill(0.1),
    },
  });

  const firstAudio = socket.sent.at(-1).realtimeInput.audio;
  assert.equal(firstAudio.mimeType, "audio/pcm;rate=16000");
  assert.ok(firstAudio.data.length > 0);
  assert.equal(harness.processorSize, 4096);

  harness.client.sendText("Can you give another example?");
  assert.equal(harness.sockets.length, 1);
  assert.equal(socket.sent.at(-1).clientContent.turns[0].parts[0].text, "Can you give another example?");
  assert.equal(socket.sent.at(-1).clientContent.turnComplete, true);
});

test("surfaces input/output transcripts and plays model audio chunks in order", async () => {
  const harness = createHarness();
  const { socket } = await connectHarness(harness);
  const audio = btoa(String.fromCharCode(0, 0, 0, 0));

  socket.receive({ serverContent: {
    inputTranscription: { text: "What is machine learning?" },
    outputAudioTranscription: { text: "Machine learning is..." },
    modelTurn: { parts: [
      { inlineData: { mimeType: "audio/pcm;rate=24000", data: audio } },
      { inlineData: { mimeType: "audio/pcm;rate=24000", data: audio } },
    ] },
  } });

  assert.ok(harness.events.some((event) => event.type === "gemini-live-native-transcript" && event.detail.text === "What is machine learning?"));
  assert.ok(harness.events.some((event) => event.type === "gemini-live-native-caption" && event.detail.text === "Machine learning is..."));
  assert.equal(harness.client.sources.size, 2);
  assert.equal(harness.audioSources.length, 2);
  assert.ok(harness.audioSources[1].startAt >= harness.audioSources[0].startAt);

  socket.receive({ serverContent: { interrupted: true } });
  assert.equal(harness.client.sources.size, 0, "interruption clears queued model audio");
});

test("completes a turn after final IDLE and returns the UI to listening", async () => {
  const harness = createHarness();
  const { socket } = await connectHarness(harness);
  await harness.client.startMicrophone();
  let speechCompleted = false;
  harness.client.activeSpeechDone = () => { speechCompleted = true; };

  socket.receive({ serverContent: { turnComplete: true, interactionStatus: "IN_PROGRESS" } });
  assert.equal(speechCompleted, false);
  socket.receive({ serverContent: { interactionStatus: "IDLE" } });
  assert.equal(speechCompleted, true);
  assert.equal(harness.client.status(), "listening");
  assert.equal(harness.client.turnComplete, false, "a completed turn must not be reused for later server messages");
  socket.receive({ serverContent: { interactionStatus: "IDLE" } });
  assert.equal(harness.logs.filter((entry) => entry[0] === "[Gemini Live diagnostics] live_turn_completed").length, 1);

  harness.client.pauseMicrophone();
  socket.receive({ serverContent: { turnComplete: true } });
  assert.equal(harness.client.status(), "muted");
});

test("records setup, microphone transmission, and response stages without user content", async () => {
  const harness = createHarness();
  const { socket } = await connectHarness(harness);
  await harness.client.startMicrophone();
  harness.client.processor.onaudioprocess({
    inputBuffer: { getChannelData: () => new Float32Array(4096).fill(0.1) },
  });
  const audio = btoa(String.fromCharCode(0, 0, 0, 0));
  socket.receive({ serverContent: {
    inputTranscription: { text: "Bro hostel la Wi-Fi irukka?" },
    modelTurn: { parts: [{ inlineData: { mimeType: "audio/pcm;rate=24000", data: audio } }] },
    turnComplete: true,
    interactionStatus: "IDLE",
  } });

  const diagnostics = harness.logs
    .filter((entry) => typeof entry[0] === "string" && entry[0].startsWith("[Gemini Live diagnostics]"))
    .map((entry) => entry[1]);
  const eventNames = diagnostics.map((entry) => entry.event);
  assert.ok(eventNames.includes("setup_complete"));
  assert.ok(eventNames.includes("microphone_started"));
  assert.ok(eventNames.includes("first_microphone_audio_sent"));
  assert.ok(eventNames.includes("user_audio_turn_transcribed"));
  assert.ok(eventNames.includes("user_turn_response_started"));
  assert.ok(eventNames.includes("first_audio_output_received"));
  assert.ok(diagnostics.every((entry) => typeof entry.timestamp === "string"));
  assert.equal(JSON.stringify(diagnostics).includes("Bro hostel la Wi-Fi irukka?"), false, "diagnostics must not log user speech");
});

test("surfaces post-setup provider errors and redacts token-shaped text", async () => {
  const harness = createHarness();
  const { socket } = await connectHarness(harness);
  socket.receive({ error: {
    code: 13,
    status: "INTERNAL",
    message: "provider failure access_token=never-log-this",
  } });

  assert.equal(harness.client.status(), "closed");
  assert.equal(socket.readyState, 3);
  const errors = harness.events.filter((event) => event.type === "gemini-live-native-error");
  assert.equal(errors.length, 1);
  assert.match(errors[0].detail.message, /provider failure/);
  assert.doesNotMatch(errors[0].detail.message, /never-log-this/);
  const logs = JSON.stringify(harness.logs);
  assert.match(logs, /server_error/);
  assert.doesNotMatch(logs, /never-log-this/);
});

test("records close code, reason, and setup state after session setup", async () => {
  const harness = createHarness();
  const { socket } = await connectHarness(harness);
  socket.close(1008, "provider closed session");

  const closedLog = harness.logs.find((entry) => entry[0] === "[Gemini Live diagnostics] websocket_closed");
  assert.equal(closedLog[1].closeCode, 1008);
  assert.equal(closedLog[1].closeReason, "provider closed session");
  assert.equal(closedLog[1].setupComplete, true);
  assert.ok(harness.events.some((event) => event.type === "gemini-live-native-error" && /1008/.test(event.detail.message)));
});

test("reports token HTTP errors and leaves no client stuck in connecting", async () => {
  const harness = createHarness(async () => ({
    ok: false,
    status: 502,
    json: async () => ({ error: "Unable to start the native voice assistant." }),
  }));

  await assert.rejects(
    harness.client.connect({ csrf: "csrf-test", requestUrl: "/api/gemini-live/native-token" }),
    /HTTP 502.*Unable to start/,
  );
  assert.equal(harness.sockets.length, 0);
  assert.equal(harness.client.status(), "closed");
  assert.ok(harness.events.some((event) => event.type === "gemini-live-native-error" && /HTTP 502/.test(event.detail.message)));
});

test("a server setup error rejects startup and closes the socket visibly", async () => {
  const harness = createHarness();
  const connecting = harness.client.connect({ csrf: "csrf-test", requestUrl: "/api/gemini-live/native-token" });
  await new Promise((resolve) => setTimeout(resolve, 10));
  const socket = harness.sockets[0];
  socket.open();
  socket.receive({ error: { message: "Invalid model setup" } });

  await assert.rejects(connecting, /Invalid model setup/);
  assert.equal(harness.client.status(), "closed");
  assert.equal(socket.readyState, 3);
});

test("uses one Live initializer and cache-busting script tag when native mode is enabled", () => {
  const nativeBranch = voiceSource.slice(
    voiceSource.indexOf('if (root.dataset.nativeLive === "1"'),
    voiceSource.indexOf("      } else {\n        await window.GeminiLive.connect();"),
  );

  assert.match(viewSource, /gemini-live-native\.js.*?\?v=/);
  assert.match(nativeBranch, /throw nativeError/);
  assert.doesNotMatch(nativeBranch, /GeminiLive\.connect\(/);
});
