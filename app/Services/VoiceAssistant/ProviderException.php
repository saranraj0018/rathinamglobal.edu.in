<?php

namespace App\Services\VoiceAssistant;

use RuntimeException;

/**
 * The AI provider could not produce an answer. The message is for the logs
 * only and never contains credentials or the visitor's question.
 */
class ProviderException extends RuntimeException {}
