<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssistantTranscribeRequest extends FormRequest
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
            'audio' => ['required', 'file', 'mimetypes:audio/webm,video/webm,audio/ogg,application/ogg', 'max:'.config('assistant.transcription.max_kilobytes')],
            'language' => ['nullable', 'in:auto,ta,en'],
        ];
    }
}
