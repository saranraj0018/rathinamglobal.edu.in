<?php

use App\Http\Controllers\Assistant\AssistantController;
use App\Http\Controllers\BrochureController;
use App\Http\Controllers\BrochureLeadController;
use App\Http\Controllers\BusRegistrationController;
use App\Http\Controllers\ConferenceController;
use App\Http\Controllers\DbtStarSchemeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ExtensionOfApprovalController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\GlobalAffairsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LegacyUrlController;
use App\Http\Controllers\ProgrammeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ResearchController;
use App\Http\Controllers\RguWayController;
use App\Http\Controllers\SchoolController;
use App\Support\ContentRepository;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Every URL of the legacy rathinamglobal.edu.in site is kept exactly as it
| was (extension-less, no trailing slash). Old ".php"/".html" addresses and
| the old /assets/... file paths are 301-redirected by LegacyUrlController.
|
*/

Route::get('/', HomeController::class)->name('home');

/* About ------------------------------------------------------------------ */
Route::view('/committees/statutory-committees', 'committees.statutory')->name('committees.statutory');
Route::view('/committees/non-statutory-committees', 'committees.non-statutory')->name('committees.non-statutory');
Route::get('/eoa/eoa', ExtensionOfApprovalController::class)->name('eoa');
Route::view('/iqac/iqac', 'iqac.index')->name('iqac');
Route::get('/faq', FaqController::class)->name('faq');
Route::get('/global-affairs', GlobalAffairsController::class)->name('global-affairs');
Route::get('/dbt-star-scheme', DbtStarSchemeController::class)->name('dbt-star-scheme');
Route::view('/careers', 'careers.index')->name('careers');

Route::get('/events', [EventController::class, 'index'])->name('events.index');
// Only listed events match, so /events/<anything>.php falls through to the legacy redirector or a 404.
Route::get('/events/{event}', [EventController::class, 'show'])
    ->whereIn('event', array_column(app(ContentRepository::class)->get('events'), 'slug'))
    ->name('events.show');

/* Academics -------------------------------------------------------------- */
Route::get('/courses/{school}', [SchoolController::class, 'show'])
    ->whereIn('school', SchoolController::SCHOOLS)
    ->name('schools.show');
Route::get('/courses/programmes/{school}/{programme}', [ProgrammeController::class, 'show'])
    ->where('programme', '[A-Za-z0-9.\-]+(?<!\.php)(?<!\.html)')
    ->name('programmes.show');

Route::get('/rgu-way', RguWayController::class)->name('rgu-way');

/* Research --------------------------------------------------------------- */
Route::prefix('research')->name('research.')->controller(ResearchController::class)->group(function (): void {
    Route::get('/', 'index')->name('index');
    Route::get('/directorate', 'directorate')->name('directorate');
    Route::get('/registrar', 'registrar')->name('registrar');
    Route::get('/grants-received', 'grants')->name('grants');
    Route::get('/publications', 'publications')->name('publications');
    Route::get('/book-chapters', 'bookChapters')->name('book-chapters');
    Route::get('/patents', 'patents')->name('patents');
    Route::get('/extension-consultancy', 'extensionConsultancy')->name('extension-consultancy');
    Route::get('/hackathons', 'hackathons')->name('hackathons');
    Route::get('/startups', 'startups')->name('startups');
});

// Aliases that used to serve the same page under a second address.
Route::permanentRedirect('/research/startup', '/research/startups');
Route::permanentRedirect('/research/books-book-chapters', '/research/book-chapters');

/* Landing pages ---------------------------------------------------------- */
Route::view('/law', 'landing.law')->name('law');
Route::get('/dsacb', ConferenceController::class)->name('dsacb');

Route::view('/esg', 'landing.esg')->name('esg.show');
Route::view('/esia', 'landing.esia')->name('esia.show');

Route::prefix('{site}')->whereIn('site', ['esg', 'esia'])->group(function (): void {
    Route::get('/lead', [BrochureLeadController::class, 'show'])->name('brochure-leads.show');
    Route::post('/lead', [BrochureLeadController::class, 'store'])
        ->middleware('throttle:brochure-leads')
        ->name('brochure-leads.store');
    Route::get('/brochure', [BrochureController::class, 'show'])->name('brochures.show');
});

/* AC bus registration ---------------------------------------------------- */
Route::get('/acbus', [BusRegistrationController::class, 'create'])->name('bus-registration.create');
Route::post('/acbus/submit', [BusRegistrationController::class, 'store'])
    ->middleware('throttle:bus-registration')
    ->name('bus-registration.store');

/* AI FAQ & voice assistant ------------------------------------------- */
// Web routes (session + CSRF) so only pages of this site can call them; see AssistantController.
Route::prefix('api/assistant')->name('assistant.')->controller(AssistantController::class)->group(function (): void {
    Route::post('/ask', 'ask')->middleware('throttle:assistant')->name('ask');
    Route::post('/feedback', 'feedback')->middleware('throttle:assistant')->name('feedback');
    Route::get('/history/{conversation}', 'history')->middleware('throttle:assistant')->name('history');
    Route::post('/transcribe', 'transcribe')->middleware('throttle:assistant-media')->name('transcribe');
    Route::post('/speak', 'speak')->middleware('throttle:assistant-media')->name('speak');
});

require __DIR__.'/admin.php';

/* Internal dashboards ---------------------------------------------------- */
Route::prefix('report')->name('reports.')->controller(ReportController::class)->group(function (): void {
    Route::get('/', 'index')->name('index');
    Route::get('/rgu/job-description', 'jobDescription')->name('job-description');
    Route::get('/{group}/{dashboard}', 'show')
        ->where('dashboard', '[A-Za-z0-9&\-]+')
        ->name('show');
});

/* Legacy addresses (*.php, *.html, /assets/...) -------------------------- */
Route::fallback(LegacyUrlController::class);
