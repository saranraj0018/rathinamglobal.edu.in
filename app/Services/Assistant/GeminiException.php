<?php

namespace App\Services\Assistant;

use RuntimeException;

class GeminiException extends RuntimeException
{
    public const NOT_CONFIGURED = 'not_configured';

    public const INVALID_KEY = 'invalid_key';

    public const QUOTA = 'quota_exceeded';

    public const MODEL_NOT_FOUND = 'model_not_found';

    public const UNAVAILABLE = 'unavailable';

    public const TIMEOUT = 'timeout';

    public const BLOCKED = 'blocked';

    public const BAD_RESPONSE = 'bad_response';

    public function __construct(public readonly string $reason, string $message = '')
    {
        parent::__construct($message !== '' ? $message : $reason);
    }
}
