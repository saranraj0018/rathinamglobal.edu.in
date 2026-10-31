<?php

namespace Tests\Feature\Assistant;

use App\Models\AssistantMessage;
use App\Models\Faq;
use App\Models\KnowledgeDocument;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;

class AdminAreaTest extends AssistantTestCase
{
    public function test_guests_are_redirected_and_non_admins_are_forbidden(): void
    {
        foreach (['admin.dashboard', 'admin.faqs.index', 'admin.documents.index', 'admin.unanswered', 'admin.settings.edit'] as $route) {
            $this->get(route($route))->assertRedirect(route('admin.login'));
        }

        $this->actingAs(User::factory()->create())->get(route('admin.faqs.index'))->assertForbidden();
        $this->actingAs(User::factory()->create())->post(route('admin.faqs.store'), [])->assertForbidden();
    }

    public function test_only_admins_can_sign_in(): void
    {
        $user = User::factory()->create(['email' => 'user@example.test']);
        $this->post(route('admin.login.store'), ['email' => 'user@example.test', 'password' => 'password'])->assertSessionHasErrors('email');

        User::factory()->admin()->create(['email' => 'boss@example.test']);
        $this->post(route('admin.login.store'), ['email' => 'boss@example.test', 'password' => 'password'])->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticated();
        $this->assertNotNull($user);
    }

    public function test_admin_creates_a_published_faq_that_the_assistant_can_use(): void
    {
        $admin = User::factory()->admin()->create();
        Http::fake();

        $this->actingAs($admin)->post(route('admin.faqs.store'), [
            'question_en' => 'Is there a hostel?', 'answer_en' => 'Yes, separate hostels for boys and girls.',
            'keywords' => 'hostel, accommodation', 'is_active' => 1, 'published' => 1,
        ])->assertRedirect(route('admin.faqs.index'));

        $faq = Faq::first();
        $this->assertSame($admin->id, $faq->created_by);
        $this->assertDatabaseHas('knowledge_chunks', ['source_type' => 'faq', 'source_id' => $faq->id]);

        $this->actingAs($admin)->put(route('admin.faqs.update', $faq), ['question_en' => 'Is there a hostel?', 'answer_en' => 'Yes.', 'is_active' => 1])->assertRedirect();
        $this->assertDatabaseMissing('knowledge_chunks', ['source_id' => $faq->id]);

        $this->actingAs($admin)->delete(route('admin.faqs.destroy', $faq))->assertRedirect();
        $this->assertDatabaseCount('faqs', 0);
    }

    public function test_faq_needs_a_complete_question_and_answer_pair(): void
    {
        $this->actingAs(User::factory()->admin()->create())
            ->post(route('admin.faqs.store'), ['question_en' => 'Only a question'])
            ->assertSessionHasErrors();
    }

    public function test_faqs_can_be_searched_and_bulk_imported(): void
    {
        $admin = User::factory()->admin()->create();
        $csv = "category,question_en,answer_en,question_ta,answer_ta,keywords,variations\nHostel,Is there a hostel?,Yes.,,,hostel,\n,,,,,,\n";

        $this->actingAs($admin)->post(route('admin.faqs.import'), ['file' => UploadedFile::fake()->createWithContent('faqs.csv', $csv)])->assertRedirect();

        $this->assertDatabaseCount('faqs', 1);
        $this->actingAs($admin)->get(route('admin.faqs.index', ['q' => 'hostel']))->assertOk()->assertSee('Is there a hostel?');
        $this->actingAs($admin)->get(route('admin.faqs.index', ['q' => 'nothing-here']))->assertDontSee('Is there a hostel?');
    }

    public function test_admin_publishes_a_document_from_pasted_text_and_text_upload(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->post(route('admin.documents.store'), [
            'title' => 'Placement report', 'category' => 'Placement information', 'language' => 'en',
            'content' => 'Pasted intro.', 'status' => 'published',
            'file' => UploadedFile::fake()->createWithContent('report.txt', 'Highest package last year was 12 LPA.'),
        ])->assertRedirect(route('admin.documents.index'));

        $document = KnowledgeDocument::first();
        $this->assertStringContainsString('12 LPA', $document->content);
        $this->assertSame($admin->id, $document->updated_by);
        $this->assertDatabaseHas('knowledge_chunks', ['source_type' => 'document', 'source_id' => $document->id]);
    }

    public function test_unanswered_questions_can_be_converted_to_faqs(): void
    {
        $admin = User::factory()->admin()->create();
        $this->postJson(route('assistant.ask'), ['message' => 'Is there a swimming pool?'])->assertOk();
        $message = AssistantMessage::first();

        $this->actingAs($admin)->get(route('admin.unanswered'))->assertOk()->assertSee('Is there a swimming pool?');
        $this->actingAs($admin)->get(route('admin.faqs.create', ['question' => $message->user_message, 'from_message' => $message->id]))
            ->assertOk()->assertSee('Is there a swimming pool?');

        $this->actingAs($admin)->post(route('admin.faqs.store'), [
            'question_en' => 'Is there a swimming pool?', 'answer_en' => 'Yes, an Olympic-size pool.', 'is_active' => 1, 'published' => 1, 'from_message' => $message->id,
        ])->assertRedirect();

        $this->assertNotNull($message->fresh()->resolved_at);
        $this->actingAs($admin)->get(route('admin.unanswered'))->assertDontSee('swimming pool?');
        $this->fakeGemini();
        $this->assertSame('answered', $this->postJson(route('assistant.ask'), ['message' => 'swimming pool?'])->json('message.status'));
    }

    public function test_dashboard_shows_analytics(): void
    {
        $this->bcaFeeFaq();
        $this->fakeGemini();
        $this->ask('BCA fee?');
        $this->ask('BCA fee?');
        $id = $this->ask('BCA kattanam evlo')['message']['id'];
        $this->postJson(route('assistant.feedback'), ['message_id' => $id, 'rating' => 1]);

        $this->actingAs(User::factory()->admin()->create())->get(route('admin.dashboard'))
            ->assertOk()->assertSee('Total questions')->assertSee('BCA fee?')->assertSee('Tanglish');
    }

    public function test_categories_and_settings_are_managed_by_admins(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->post(route('admin.categories.store'), ['name_en' => 'Hostel', 'name_ta' => 'விடுதி'])->assertRedirect();
        $this->assertDatabaseHas('faq_categories', ['name_en' => 'Hostel', 'slug' => 'hostel']);

        $this->actingAs($admin)->put(route('admin.settings.update'), ['admissions_contact' => 'Call 04222 000000'])->assertRedirect();
        $this->assertDatabaseHas('assistant_settings', ['key' => 'admissions_contact', 'value' => 'Call 04222 000000']);
    }

    public function test_the_public_site_still_renders_with_the_new_widget(): void
    {
        $this->get('/')->assertOk()->assertSee('id="rva"', false);
    }
}
