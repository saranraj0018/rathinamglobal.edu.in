<?php

namespace App\Http\Requests;

use App\Services\VoiceAssistant\KnowledgeBase;
use App\Services\VoiceAssistant\VoiceAssistant;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

/**
 * A visitor's question to the website voice assistant (JSON body). The text
 * comes from browser speech recognition or the typed fallback; either way it
 * is untrusted input.
 */
class VoiceAssistantChatRequest extends FormRequest
{
    private const MAX_BODY_BYTES = 8000;

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if (strlen($this->getContent()) > self::MAX_BODY_BYTES) {
            throw new HttpResponseException(response()->json(['success' => false, 'message' => 'Invalid request.'], 413));
        }

        if (is_string($this->input('message'))) {
            // Control characters are never part of a real question.
            $this->merge(['message' => trim((string) preg_replace('/[\p{Cc}\p{Cf}]+/u', ' ', $this->input('message')))]);
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'message' => ['required', 'string', 'min:2', 'max:'.config('rgu.voice_assistant.max_message_length')],
            'language' => ['sometimes', 'string', Rule::in(array_keys(VoiceAssistant::LANGUAGES))],
            'conversation_id' => ['nullable', 'string', 'uuid'],
            'persona' => ['nullable', 'string', Rule::in(array_keys($this->container->make(KnowledgeBase::class)->personas()))],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'message.required' => 'Please ask a question.',
            'message.min' => 'Please ask a longer question.',
            'message.max' => 'Please keep your question under :max characters.',
            'language.in' => 'Please choose English or Tamil.',
            'conversation_id.uuid' => 'Invalid conversation.',
            'persona.in' => 'Please choose someone from the team.',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        $field = array_key_first($validator->errors()->messages());

        throw new HttpResponseException(response()->json([
            'success' => false,
            'field' => $field,
            'message' => $validator->errors()->first($field),
        ], 422));
    }
}
