<?php

namespace Tests\Feature;

use App\Support\ContentRepository;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * Every public URL of the migrated site renders.
 */
class PublicPagesTest extends TestCase
{
    /**
     * @return array<string, array{0: string, 1: string}>
     */
    public static function pages(): array
    {
        $pages = [
            'home' => ['/', 'Best University in Tamil Nadu | Rathinam Global University'],
            'statutory committees' => ['/committees/statutory-committees', 'Statutory Committees | RGU'],
            'non-statutory committees' => ['/committees/non-statutory-committees', 'Non Statutory Committees | RGU'],
            'eoa' => ['/eoa/eoa', 'EOA | RGU'],
            'iqac' => ['/iqac/iqac', 'IQAC | RGU'],
            'faq' => ['/faq', 'Frequently Asked Questions | Rathinam Global University'],
            'global affairs' => ['/global-affairs', 'Office of Global Affairs | Rathinam Global Deemed to be University'],
            'dbt star scheme' => ['/dbt-star-scheme', 'DBT Star College Scheme | Rathinam Global University'],
            'careers' => ['/careers', 'zimyo.work/recruit/jobwidget.js'],
            'events' => ['/events', 'Events | RGU'],
            'event' => ['/events/aicte-vaani-cybersecurity-2026', 'AICTE'],
            'research' => ['/research', 'Research Overview | Research · Rathinam Global University'],
            'directorate' => ['/research/directorate', 'About Directorate | Research'],
            'registrar' => ['/research/registrar', 'Registrar | Research'],
            'grants' => ['/research/grants-received', 'Grants Received | Research'],
            'publications' => ['/research/publications', 'Publications | Research'],
            'book chapters' => ['/research/book-chapters', 'Books &amp; Book Chapters | Research'],
            'patents' => ['/research/patents', 'Patents &amp; IP | Research'],
            'extension' => ['/research/extension-consultancy', 'Extension &amp; Consultancy | Research'],
            'hackathons' => ['/research/hackathons', 'Hackathons &amp; Innovation Wins | Research'],
            'startups' => ['/research/startups', 'Startups &amp; Incubation | Research'],
            'rgu way' => ['/rgu-way', 'The RGU Way'],
            'law' => ['/law', 'RGU School of Law'],
            'esg' => ['/esg', '<title>'],
            'esia' => ['/esia', '<title>'],
            'dsacb' => ['/dsacb', 'DSACB 2027 | Rathinam Global University, Coimbatore'],
            'ac bus' => ['/acbus', 'New Air Conditioned Bus Service'],
            'reports' => ['/report', '<title>'],
            'report dashboard' => ['/report/rgu/placement', 'datastudio.google.com/embed/reporting/d88ba8b7'],
            'report with ampersand slug' => ['/report/rtc/s&h', 'datastudio.google.com/embed'],
        ];

        foreach ([
            'school-of-applied-biosciences', 'school-of-business-and-commerce', 'school-of-engineering-emerging-technologies',
            'school-of-fashion-design', 'school-of-liberal-arts-science', 'school-of-media-and-performing-arts',
            'school-of-quantum-science', 'school-of-sports-and-health-sciences', 'school-of-sustainability-and-climate-studies',
        ] as $school) {
            $pages[$school] = ["/courses/{$school}", '| RGU'];
        }

        foreach ([
            'school-of-business-and-commerce/b.com-ca',
            'school-of-business-and-commerce/b.com-pa-and-b.com-pa-with-ca',
            'school-of-business-and-commerce/m.com-ca',
            'school-of-quantum-science/b.sc-computer-science',
        ] as $programme) {
            $pages[$programme] = ["/courses/programmes/{$programme}", 'Curriculum, Eligibility, Fees'];
        }

        return $pages;
    }

    #[DataProvider('pages')]
    public function test_page_renders(string $uri, string $expectedText): void
    {
        $this->get($uri)
            ->assertOk()
            ->assertSee($expectedText, false);
    }

    public function test_job_description_export_is_served_as_html(): void
    {
        Storage::fake('local')->put('reports/job-description.html', '<h1>University Leadership</h1>');

        $response = $this->get('/report/rgu/job-description')
            ->assertOk()
            ->assertHeader('Content-Type', 'text/html; charset=UTF-8');

        $this->assertStringContainsString('University Leadership', file_get_contents($response->baseResponse->getFile()->getPathname()));
    }

    public function test_pages_emit_canonical_link_on_the_production_host(): void
    {
        config(['rgu.canonical_url' => 'https://rathinamglobal.edu.in']);

        $this->get('/research/patents')
            ->assertSee('<link rel="canonical" href="https://rathinamglobal.edu.in/research/patents">', false);

        $this->get('/')
            ->assertSee('<link rel="canonical" href="https://rathinamglobal.edu.in/">', false);
    }

    public function test_programme_links_on_school_page_point_to_programme_pages(): void
    {
        $this->get('/courses/school-of-business-and-commerce')
            ->assertSee(route('programmes.show', ['school' => 'school-of-business-and-commerce', 'programme' => 'b.com-ca']), false);
    }

    public function test_eoa_lists_only_years_with_a_document(): void
    {
        $this->get('/eoa/eoa')
            ->assertSee('<span class="year-pill disabled" title="Not available">2010</span>', false)
            ->assertSee(storage_asset('assets/EOA/EOA-2011.pdf'), false);
    }

    public function test_global_affairs_serves_partner_logos_from_storage_instead_of_inline_data(): void
    {
        $this->get('/global-affairs')
            ->assertSee(storage_asset('global-affairs/partners/cheng-shiu-university.png'), false)
            ->assertSee('vasanthaseelan.oga@rathinam.in')
            ->assertDontSee('data:image', false);
    }

    public function test_dbt_star_scheme_lists_every_objective(): void
    {
        $response = $this->get('/dbt-star-scheme');

        $objectives = app(ContentRepository::class)->get('dbt-star-scheme')['objectives'];

        $this->assertCount(10, $objectives);

        foreach ($objectives as $objective) {
            $response->assertSee($objective);
        }
    }

    public function test_faq_page_includes_structured_data(): void
    {
        $this->get('/faq')->assertSee('"@type":"FAQPage"', false);
    }

    #[DataProvider('missingPages')]
    public function test_unknown_page_returns_404(string $uri): void
    {
        $this->get($uri)->assertNotFound();
    }

    /**
     * @return array<string, array{0: string}>
     */
    public static function missingPages(): array
    {
        return [
            'unknown school' => ['/courses/school-of-nothing'],
            'unknown programme' => ['/courses/programmes/school-of-quantum-science/b.sc-nothing'],
            'programme under unknown school' => ['/courses/programmes/school-of-nothing/b.com-ca'],
            'unknown event' => ['/events/not-an-event'],
            'unknown dashboard' => ['/report/rgu/not-a-dashboard'],
        ];
    }
}
