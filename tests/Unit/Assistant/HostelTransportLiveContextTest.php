<?php

namespace Tests\Unit\Assistant;

use App\Services\Assistant\HostelTransportKnowledgeService;
use Tests\TestCase;

class HostelTransportLiveContextTest extends TestCase
{
    public function test_live_context_contains_all_approved_questions_and_answers(): void
    {
        HostelTransportKnowledgeService::clearCache();
        $service = app(HostelTransportKnowledgeService::class);
        $context = $service->liveSessionContext();

        $this->assertCount(30, $service->allFaqs());
        $this->assertStringContainsString('Question cues:', $context);
        $this->assertStringContainsString('available ah?', $context);
        $this->assertStringContainsString('Is Wi-Fi available in the hostel?', $context);
        $this->assertStringContainsString('Wi-Fi connectivity is available throughout the hostel premises.', $context);
        $this->assertStringContainsString('6:45 AM and 8:05 AM', $context);
        $this->assertStringContainsString('விடுதி', $context);
        $this->assertStringNotContainsString('five hostels', $context);
        $this->assertStringNotContainsString('gym', $context);
    }
}
