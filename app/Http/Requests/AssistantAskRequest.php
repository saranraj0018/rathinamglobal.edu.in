<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssistantAskRequest extends FormRequest
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
            'message' => ['required', 'string', 'max:'.config('assistant.max_message_length')],
            'conversation' => ['nullable', 'uuid'],
            'language' => ['nullable', 'in:auto,ta,en'],
        ];
    }
}
