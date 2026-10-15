<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Js;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class BrochureLeadControllerTest extends TestCase
{
    private const APPS_SCRIPT = 'https://script.google.com/macros/s/leads-test/exec';

    protected function setUp(): void
    {
        parent::setUp();

        config(['rgu.brochure_leads.apps_script_url' => self::APPS_SCRIPT]);
    }

    /**
     * @return array<string, string|int>
     */
    private function validLead(array $overrides = []): array
    {
        return array_merge([
            'full_name' => 'Priya Natarajan',
            'email' => 'priya@example.org',
            'mobile' => '+91 98765 43210',
            'current_role' => 'Analyst',
            'organization' => 'Example Ltd',
            'programme' => 'Environmental & Social Impact Assessment (ESIA)',
            'form_name' => 'hero',
            'page_url' => 'https://rathinamglobal.edu.in/esg',
            'elapsed' => 12,
        ], $overrides);
    }

    public function test_landing_page_receives_lead_endpoints_and_csrf_token(): void
    {
        $this->get('/esg')
            ->assertOk()
            ->assertSee('window.RGU_LEAD_CONFIG', false)
            ->assertSee((string) Js::from(route('brochure-leads.store', 'esg')), false);
    }

    public function test_saved_lead_grants_the_brochure_matching_the_chosen_programme(): void
    {
        Http::preventStrayRequests();
        Http::fake([self::APPS_SCRIPT => Http::response(['success' => true, 'message' => 'Thank you.'])]);

        $response = $this->postJson('/esg/lead', $this->validLead())
            ->assertOk()
            ->assertJson(['success' => true, 'duplicate' => false, 'download' => ['kind' => 'esia']]);

        $this->assertNotEmpty($response->json('download.token'));

        // The sheet tab comes from config, never from the request.
        Http::assertSent(function (Request $request): bool {
            $payload = json_decode($request->body(), true);

            return $request->url() === self::APPS_SCRIPT
                && $payload['target_sheet'] === 'esg_leads'
                && $payload['full_name'] === 'Priya Natarajan';
        });
    }

    public function test_grant_survives_a_page_reload(): void
    {
        Http::preventStrayRequests();
        Http::fake([self::APPS_SCRIPT => Http::response(['success' => true])]);

        $token = $this->postJson('/esg/lead', $this->validLead())->json('download.token');

        $this->getJson('/esg/lead?grant=1')
            ->assertOk()
            ->assertJson(['granted' => true, 'download' => ['token' => $token]]);

        // Grants are per site.
        $this->getJson('/esia/lead?grant=1')->assertExactJson(['granted' => false]);
    }

    public function test_duplicate_lead_still_receives_the_brochure(): void
    {
        Http::preventStrayRequests();
        Http::fake([self::APPS_SCRIPT => Http::response(['success' => false, 'code' => 'duplicate'])]);

        $this->postJson('/esia/lead', $this->validLead())
            ->assertOk()
            ->assertJson(['success' => true, 'duplicate' => true, 'message' => 'You have already registered. Your brochure is ready.']);
    }

    public function test_rejected_lead_returns_the_sheet_message_without_a_grant(): void
    {
        Http::preventStrayRequests();
        Http::fake([self::APPS_SCRIPT => Http::response(['success' => false, 'field' => 'email', 'message' => 'Email rejected.'])]);

        $this->postJson('/esg/lead', $this->validLead())
            ->assertOk()
            ->assertExactJson(['success' => false, 'field' => 'email', 'message' => 'Email rejected.']);

        $this->getJson('/esg/lead?grant=1')->assertExactJson(['granted' => false]);
    }

    public function test_honeypot_lead_looks_successful_but_is_not_forwarded(): void
    {
        Http::preventStrayRequests();
        Http::fake();

        $this->postJson('/esg/lead', $this->validLead(['company_url' => 'http://spam.example']))
            ->assertOk()
            ->assertExactJson(['success' => true, 'message' => 'Thank you.']);

        Http::assertNothingSent();
    }

    /**
     * @return array<string, array{0: array<string, string>, 1: string, 2: string}>
     */
    public static function invalidLeads(): array
    {
        return [
            'missing name' => [['full_name' => ''], 'full_name', 'Enter your full name.'],
            'digits in name' => [['full_name' => 'Priya 2'], 'full_name', 'Name cannot contain numbers.'],
            'invalid email' => [['email' => 'priya@'], 'email', 'Enter a valid email address.'],
            'disposable email' => [['email' => 'priya@mailinator.com'], 'email', 'Please use a permanent email address.'],
            'missing mobile' => [['mobile' => ''], 'mobile', 'This field is required.'],
            'repeated digits' => [['mobile' => '9999999999'], 'mobile', 'Enter a valid mobile number.'],
            'nine digits' => [['mobile' => '987654321'], 'mobile', 'Enter a 10-digit mobile number.'],
            'bad prefix' => [['mobile' => '5876543210'], 'mobile', 'Mobile number must start with 6, 7, 8 or 9.'],
        ];
    }

    /**
     * @param  array<string, string>  $overrides
     */
    #[DataProvider('invalidLeads')]
    public function test_invalid_lead_returns_422_naming_the_field(array $overrides, string $field, string $message): void
    {
        Http::preventStrayRequests();
        Http::fake();

        $this->postJson('/esg/lead', $this->validLead($overrides))
            ->assertStatus(422)
            ->assertExactJson(['success' => false, 'field' => $field, 'message' => $message]);

        Http::assertNothingSent();
    }

    public function test_sixth_submission_from_one_ip_returns_429_even_without_session_cookies(): void
    {
        Http::preventStrayRequests();
        Http::fake([self::APPS_SCRIPT => Http::response(['success' => true])]);

        // No cookies are sent back, so every request starts a fresh session.
        for ($i = 0; $i < 5; $i++) {
            $this->postJson('/esg/lead', $this->validLead())->assertOk();
        }

        $this->postJson('/esg/lead', $this->validLead())
            ->assertStatus(429)
            ->assertJson(['success' => false, 'message' => 'Too many submissions. Please try again in a few minutes.']);
    }

    public function test_get_without_grant_parameter_returns_405(): void
    {
        $this->getJson('/esg/lead')->assertStatus(405);
    }

    public function test_unknown_site_returns_404(): void
    {
        $this->getJson('/law/lead?grant=1')->assertNotFound();
    }
}
