<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Js;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class BusRegistrationControllerTest extends TestCase
{
    private const APPS_SCRIPT = 'https://script.google.com/macros/s/bus-test/exec';

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'rgu.bus_registration.apps_script_url' => self::APPS_SCRIPT,
            'rgu.bus_registration.turnstile_secret' => null,
        ]);
    }

    /**
     * @return array<string, string>
     */
    private function validRegistration(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Rahul Sharma',
            'studentId' => '23BCS042',
            'department' => 'Computer Science',
            'phone' => '9876543210',
            'email' => 'Rahul@Rathinam.in',
            'interestedInAC' => 'Yes',
            'preferredRoute' => 'Alandurai',
            'pickupLocation' => 'Kalampalayam',
            'busNo' => '',
            'earlyBirdOffer' => 'Yes',
        ], $overrides);
    }

    public function test_form_page_embeds_routes_and_submit_endpoint(): void
    {
        $this->get('/acbus')
            ->assertOk()
            ->assertSee('window.AC_BUS_ROUTES', false)
            ->assertSee((string) Js::from(route('bus-registration.store')), false);
    }

    public function test_valid_registration_is_forwarded_to_the_sheet(): void
    {
        Http::preventStrayRequests();
        Http::fake([self::APPS_SCRIPT => Http::response(['status' => 'success'])]);

        $this->post('/acbus/submit', $this->validRegistration())
            ->assertOk()
            ->assertExactJson(['ok' => true, 'message' => 'Registration received.']);

        Http::assertSent(fn (Request $request): bool => $request->url() === self::APPS_SCRIPT
            && $request['email'] === 'rahul@rathinam.in'
            && $request['pickupLocation'] === 'Kalampalayam'
            && $request['timestamp'] !== '');
    }

    public function test_eleventh_submission_from_one_ip_within_ten_minutes_returns_429(): void
    {
        Http::preventStrayRequests();
        Http::fake([self::APPS_SCRIPT => Http::response(['status' => 'success'])]);

        for ($i = 0; $i < 10; $i++) {
            $this->post('/acbus/submit', $this->validRegistration())->assertOk();
        }

        $this->post('/acbus/submit', $this->validRegistration())
            ->assertStatus(429)
            ->assertJson(['ok' => false]);

        Http::assertSentCount(10);
    }

    public function test_honeypot_submission_reports_success_without_forwarding(): void
    {
        Http::preventStrayRequests();
        Http::fake();

        $this->post('/acbus/submit', ['website_hp' => 'http://spam.example'])
            ->assertOk()
            ->assertJson(['ok' => true]);

        Http::assertNothingSent();
    }

    /**
     * @return array<string, array{0: array<string, string>, 1: string}>
     */
    public static function invalidRegistrations(): array
    {
        return [
            'missing student id' => [['studentId' => ''], 'Please fill in every required field and try again.'],
            'digits in name' => [['name' => 'Rahul 2'], 'Full Name cannot contain numbers.'],
            'symbols in name' => [['name' => 'Rahul_S'], 'Full Name must contain letters and spaces only.'],
            'digits in department' => [['department' => 'CSE 1'], 'Department name cannot contain numbers.'],
            'non-university email' => [['email' => 'rahul@gmail.com'], 'Only official @rathinam.in university email addresses are allowed.'],
            'short phone' => [['phone' => '98765'], 'Please enter a valid 10-digit phone number.'],
            'not interested in AC' => [['interestedInAC' => 'No'], 'Select "Yes" to the AC Bus upgrade question to register.'],
            'unknown route' => [['preferredRoute' => 'Nowhere'], 'Please select a valid route.'],
            'stop not on route' => [['pickupLocation' => 'Ukkadam'], 'That pickup stop is not on the selected route. Please choose again.'],
        ];
    }

    /**
     * @param  array<string, string>  $overrides
     */
    #[DataProvider('invalidRegistrations')]
    public function test_invalid_registration_returns_422_with_message(array $overrides, string $message): void
    {
        Http::preventStrayRequests();
        Http::fake();

        $this->post('/acbus/submit', $this->validRegistration($overrides))
            ->assertStatus(422)
            ->assertExactJson(['ok' => false, 'message' => $message]);

        Http::assertNothingSent();
    }

    public function test_duplicate_registration_returns_409(): void
    {
        Http::preventStrayRequests();
        Http::fake([self::APPS_SCRIPT => Http::response(['status' => 'duplicate'])]);

        $this->post('/acbus/submit', $this->validRegistration())
            ->assertStatus(409)
            ->assertJson(['ok' => false, 'code' => 'duplicate']);
    }

    public function test_google_sign_in_page_from_apps_script_returns_502(): void
    {
        Http::preventStrayRequests();
        Http::fake([self::APPS_SCRIPT => Http::response('<html><a href="https://accounts.google.com/">Sign in</a></html>')]);

        $this->post('/acbus/submit', $this->validRegistration())
            ->assertStatus(502)
            ->assertJson(['ok' => false, 'message' => 'Registration service is not accepting public submissions yet. Please contact the transport office.']);
    }

    public function test_upstream_error_returns_502(): void
    {
        Http::preventStrayRequests();
        Http::fake([self::APPS_SCRIPT => Http::response(['status' => 'error'])]);

        $this->post('/acbus/submit', $this->validRegistration())
            ->assertStatus(502)
            ->assertJson(['ok' => false, 'code' => 'upstream']);
    }

    public function test_unreachable_apps_script_returns_502(): void
    {
        Http::preventStrayRequests();
        Http::fake([self::APPS_SCRIPT => Http::failedConnection()]);

        $this->post('/acbus/submit', $this->validRegistration())
            ->assertStatus(502)
            ->assertJson(['ok' => false, 'message' => 'We could not reach the registration service. Please try again in a moment.']);
    }

    public function test_missing_turnstile_token_returns_400_when_captcha_is_enabled(): void
    {
        config(['rgu.bus_registration.turnstile_secret' => 'secret']);
        Http::preventStrayRequests();
        Http::fake();

        $this->post('/acbus/submit', $this->validRegistration())
            ->assertStatus(400)
            ->assertJson(['ok' => false, 'message' => 'Please complete the security verification.']);

        Http::assertNothingSent();
    }

    public function test_rejected_turnstile_token_returns_403(): void
    {
        config(['rgu.bus_registration.turnstile_secret' => 'secret']);
        Http::preventStrayRequests();
        Http::fake(['https://challenges.cloudflare.com/turnstile/v0/siteverify' => Http::response(['success' => false])]);

        $this->post('/acbus/submit', $this->validRegistration(['cf-turnstile-response' => 'bad-token']))
            ->assertStatus(403)
            ->assertJson(['ok' => false, 'message' => 'Security verification failed. Please retry the checkbox.']);
    }
}
