<?php

namespace App\Http\Requests;

use Closure;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * ESG / ESIA enquiry form (JSON body). The page checks the same rules, but
 * the browser can be bypassed, so every rule that protects the sheet is
 * enforced again here. Replies carry the first failing field so the page can
 * highlight it.
 */
class StoreBrochureLeadRequest extends FormRequest
{
    private const MAX_BODY_BYTES = 20000;

    private const HONEYPOT_FIELDS = ['website', 'company_url', 'fax'];

    private const DISPOSABLE_DOMAINS = [
        'mailinator.com', 'yopmail.com', 'guerrillamail.com', 'tempmail.com',
        'temp-mail.org', '10minutemail.com', 'trashmail.com', 'sharklasers.com',
        'getnada.com', 'dispostable.com', 'fakeinbox.com', 'maildrop.cc',
        'throwawaymail.com', 'mailnesia.com', 'spam4.me', 'moakt.com',
    ];

    public function authorize(): bool
    {
        return true;
    }

    /**
     * Bots fill the hidden honeypot inputs; they get a success reply and nothing is written.
     */
    public function isHoneypotTriggered(): bool
    {
        foreach (self::HONEYPOT_FIELDS as $field) {
            if (trim((string) $this->input($field, '')) !== '') {
                return true;
            }
        }

        return false;
    }

    protected function prepareForValidation(): void
    {
        $raw = $this->getContent();

        if ($raw === '' || strlen($raw) > self::MAX_BODY_BYTES || ! is_array(json_decode($raw, true))) {
            throw new HttpResponseException(response()->json(['success' => false, 'message' => 'Invalid request.'], 400));
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        if ($this->isHoneypotTriggered()) {
            return [];
        }

        return [
            'full_name' => ['bail', 'required', 'string', 'min:2', 'max:60', 'not_regex:/\d/', "regex:/^[\\p{L}][\\p{L}\\s.'\\-]{1,59}$/u"],
            'email' => ['bail', 'required', 'string', 'email:filter', 'max:100', 'not_regex:/\.\./', function (string $attribute, mixed $value, Closure $fail): void {
                $domain = strtolower(substr(strrchr((string) $value, '@') ?: '', 1));

                if (in_array($domain, self::DISPOSABLE_DOMAINS, true)) {
                    $fail('Please use a permanent email address.');
                }
            }],
            'mobile' => ['bail', 'required', 'string', function (string $attribute, mixed $value, Closure $fail): void {
                if (($error = $this->mobileError((string) $value)) !== null) {
                    $fail($error);
                }
            }],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'full_name.required' => 'Enter your full name.',
            'full_name.min' => 'Enter your full name.',
            'full_name.max' => 'Enter your full name.',
            'full_name.not_regex' => 'Name cannot contain numbers.',
            'full_name.regex' => 'Enter a valid name.',
            'email.required' => 'Enter a valid email address.',
            'email.email' => 'Enter a valid email address.',
            'email.max' => 'Enter a valid email address.',
            'email.not_regex' => 'Enter a valid email address.',
            'mobile.required' => 'This field is required.',
        ];
    }

    /**
     * Indian numbers (optionally +91 / 0 prefixed) must be 10 digits starting
     * 6-9; other international numbers 8-15 digits.
     */
    private function mobileError(string $raw): ?string
    {
        $allDigits = preg_replace('/\D/', '', $raw) ?? '';
        $digits = $allDigits;

        if (strlen($digits) === 12 && str_starts_with($digits, '91')) {
            $digits = substr($digits, 2);
        } elseif (strlen($digits) === 11 && $digits[0] === '0') {
            $digits = substr($digits, 1);
        }

        $isInternational = str_starts_with($raw, '+') && ! str_starts_with($allDigits, '91');

        return match (true) {
            preg_match('/[A-Za-z]/', $raw) === 1 => 'Enter a valid mobile number.',
            $isInternational => strlen($allDigits) < 8 || strlen($allDigits) > 15 ? 'Enter a valid mobile number.' : null,
            preg_match('/^(\d)\1+$/', $digits) === 1 || $digits === '1234567890' => 'Enter a valid mobile number.',
            strlen($digits) !== 10 => 'Enter a 10-digit mobile number.',
            preg_match('/^[6-9]/', $digits) !== 1 => 'Mobile number must start with 6, 7, 8 or 9.',
            default => null,
        };
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
