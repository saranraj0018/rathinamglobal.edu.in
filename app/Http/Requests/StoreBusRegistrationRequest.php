<?php

namespace App\Http\Requests;

use App\Support\ContentRepository;
use Closure;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

/**
 * AC bus registration. The browser validates the same rules, but the browser
 * can be bypassed, so every rule that protects the sheet is enforced here.
 */
class StoreBusRegistrationRequest extends FormRequest
{
    /** Fields that get the generic "fill in every required field" message. */
    private const REQUIRED_FIELDS = ['name', 'studentId', 'department', 'phone', 'email'];

    public function authorize(): bool
    {
        return true;
    }

    /**
     * Bots fill the hidden "website_hp" field; they get a success reply and nothing is recorded.
     */
    public function isHoneypotTriggered(): bool
    {
        return trim((string) $this->input('website_hp', '')) !== '';
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'email' => strtolower(trim((string) $this->input('email', ''))),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        if ($this->isHoneypotTriggered()) {
            return [];
        }

        $routes = app(ContentRepository::class)->get('bus-routes');

        return [
            'name' => ['required', 'string', 'not_regex:/[0-9]/', "regex:/^[a-zA-Z\\s.'-]+$/u"],
            'studentId' => ['required', 'string'],
            'department' => ['required', 'string', 'not_regex:/[0-9]/', "regex:/^[a-zA-Z\\s.&'-]+$/u"],
            'email' => ['required', 'email:filter', 'regex:/^[a-z0-9._%+-]+@rathinam\.in$/'],
            'phone' => ['required', 'string', function (string $attribute, mixed $value, Closure $fail): void {
                if (preg_match('/^[0-9]{10}$/', preg_replace('/[\s-]/', '', (string) $value)) !== 1) {
                    $fail('Please enter a valid 10-digit phone number.');
                }
            }],
            'interestedInAC' => ['required', Rule::in(['Yes'])],
            'preferredRoute' => ['required', Rule::in(array_keys($routes))],
            'pickupLocation' => ['required', function (string $attribute, mixed $value, Closure $fail) use ($routes): void {
                $route = trim((string) $this->input('preferredRoute', ''));

                if (isset($routes[$route]) && ! in_array(trim((string) $value), $routes[$route], true)) {
                    $fail('That pickup stop is not on the selected route. Please choose again.');
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
            'name.not_regex' => 'Full Name cannot contain numbers.',
            'name.regex' => 'Full Name must contain letters and spaces only.',
            'department.not_regex' => 'Department name cannot contain numbers.',
            'department.regex' => 'Department name must contain letters and spaces only.',
            'email.email' => 'Only official @rathinam.in university email addresses are allowed.',
            'email.regex' => 'Only official @rathinam.in university email addresses are allowed.',
            'interestedInAC.required' => 'Select "Yes" to the AC Bus upgrade question to register.',
            'interestedInAC.in' => 'Select "Yes" to the AC Bus upgrade question to register.',
            'preferredRoute.required' => 'Please select a valid route.',
            'preferredRoute.in' => 'Please select a valid route.',
            'pickupLocation.required' => 'That pickup stop is not on the selected route. Please choose again.',
        ];
    }

    /**
     * The page shows one message at a time: a missing basic field wins,
     * otherwise the first failing field in form order.
     */
    protected function failedValidation(Validator $validator): void
    {
        $failed = $validator->failed();
        $message = $validator->errors()->first();

        foreach (self::REQUIRED_FIELDS as $field) {
            if (isset($failed[$field]['Required'])) {
                $message = 'Please fill in every required field and try again.';

                break;
            }
        }

        throw new HttpResponseException(response()->json(['ok' => false, 'message' => $message], 422));
    }
}
