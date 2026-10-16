<?php

namespace App\Services\VoiceAssistant;

use RuntimeException;

/**
 * A second question arrived for a conversation whose previous one is still
 * being answered (a double submit or two tabs).
 */
class ConversationBusyException extends RuntimeException {}
