<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['uuid', 'visitor_id', 'preferred_language'])]
class AssistantConversation extends Model
{
    /**
     * @return HasMany<AssistantMessage, $this>
     */
    public function messages(): HasMany
    {
        return $this->hasMany(AssistantMessage::class);
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }
}
