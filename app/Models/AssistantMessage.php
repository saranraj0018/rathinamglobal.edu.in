<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable([
    'assistant_conversation_id', 'user_message', 'ai_response', 'detected_language', 'response_language',
    'sources', 'model', 'prompt_tokens', 'completion_tokens', 'status', 'error_reason', 'resolved_at',
])]
class AssistantMessage extends Model
{
    public const STATUS_ANSWERED = 'answered';

    public const STATUS_UNANSWERED = 'unanswered';

    public const STATUS_FAILED = 'failed';

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return ['sources' => 'array', 'resolved_at' => 'datetime'];
    }

    /**
     * @return BelongsTo<AssistantConversation, $this>
     */
    public function conversation(): BelongsTo
    {
        return $this->belongsTo(AssistantConversation::class, 'assistant_conversation_id');
    }

    /**
     * @return HasOne<AssistantFeedback, $this>
     */
    public function feedback(): HasOne
    {
        return $this->hasOne(AssistantFeedback::class);
    }
}
