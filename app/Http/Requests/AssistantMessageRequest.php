<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validates requests that refer to one earlier answer (speak, feedback).
 */
class AssistantMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'message_id' => ['required', 'integer'],
            'rating' => [$this->routeIs('assistant.feedback') ? 'required' : 'prohibited', 'in:1,-1'],
            'comment' => ['nullable', 'string', 'max:500'],
        ];
    }
}
