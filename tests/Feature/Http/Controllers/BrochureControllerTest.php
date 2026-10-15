<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BrochureControllerTest extends TestCase
{
    private function grant(string $site, string $kind, int $expiresIn = 600): array
    {
        $grant = ['token' => 'valid-token', 'expires' => now()->addSeconds($expiresIn)->getTimestamp(), 'email' => 'a@example.org', 'kind' => $kind];

        return ["brochure_grant_{$site}" => $grant];
    }

    public function test_brochure_streams_inline_for_a_valid_grant(): void
    {
        Storage::fake('local');
        Storage::disk('local')->putFileAs('brochures', UploadedFile::fake()->create('esia-brochure.pdf', 10, 'application/pdf'), 'esia-brochure.pdf');

        $response = $this->withSession($this->grant('esg', 'esia'))
            ->get('/esg/brochure?t=valid-token')
            ->assertOk()
            ->assertHeader('Content-Type', 'application/pdf')
            ->assertHeader('X-Robots-Tag', 'noindex, nofollow');

        $this->assertStringContainsString('inline; filename=ESIA-Brochure.pdf', $response->headers->get('Content-Disposition'));
    }

    public function test_download_mode_sends_an_attachment(): void
    {
        Storage::fake('local');
        Storage::disk('local')->putFileAs('brochures', UploadedFile::fake()->create('esg-brochure.pdf', 10, 'application/pdf'), 'esg-brochure.pdf');

        $response = $this->withSession($this->grant('esg', 'esg'))
            ->get('/esg/brochure?t=valid-token&mode=download')
            ->assertOk();

        $this->assertStringContainsString('attachment; filename=ESG-Brochure.pdf', $response->headers->get('Content-Disposition'));
    }

    public function test_brochure_without_a_grant_returns_403(): void
    {
        $this->get('/esg/brochure?t=anything')
            ->assertForbidden()
            ->assertSeeText('Please complete the enquiry form to download the brochure.');
    }

    public function test_brochure_with_the_wrong_token_returns_403(): void
    {
        $this->withSession($this->grant('esg', 'esg'))
            ->get('/esg/brochure?t=guessed')
            ->assertForbidden()
            ->assertSeeText('Invalid download link.');
    }

    public function test_expired_grant_returns_403(): void
    {
        $this->withSession($this->grant('esg', 'esg', -5))
            ->get('/esg/brochure?t=valid-token')
            ->assertForbidden()
            ->assertSeeText('This download link has expired. Please submit the form again.');
    }

    public function test_grant_for_one_site_does_not_unlock_the_other(): void
    {
        $this->withSession($this->grant('esg', 'esg'))
            ->get('/esia/brochure?t=valid-token')
            ->assertForbidden();
    }
}
