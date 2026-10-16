<?php

namespace App\Http\Requests;

use App\Services\VoiceAssistant\KnowledgeBase;
use App\Services\VoiceAssistant\VoiceAssistant;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

/**
 * A request to read one of the assistant's own replies aloud (JSON body).
 * The controller only accepts text the assistant actually said.
 */
class VoiceAssistantSpeechRequest extends FormRequest
{
    private const MAX_BODY_BYTES = 12000;

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if (strlen($this->getContent()) > self::MAX_BODY_BYTES) {
            throw new HttpResponseException(response()->json(['success' => false, 'message' => 'Invalid request.'], 413));
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'text' => ['required', 'string', 'max:'.((int) config('rgu.voice_assistant.max_answer_length') + 200)],
            'language' => ['required', 'string', Rule::in(array_keys(VoiceAssistant::LANGUAGES))],
            'conversation_id' => ['nullable', 'string', 'uuid'],
            'persona' => ['nullable', 'string', Rule::in(array_keys($this->container->make(KnowledgeBase::class)->personas()))],
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Invalid request.',
        ], 422));
    }
}
