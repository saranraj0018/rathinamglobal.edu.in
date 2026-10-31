<?php

namespace App\Services\Assistant;

use App\Models\Faq;
use App\Models\KnowledgeChunk;
use App\Models\KnowledgeDocument;

/**
 * Keeps the retrieval index (knowledge_chunks) in step with the admin content:
 * only live FAQs and published documents have chunks, so anything unpublished,
 * disabled or deleted can never be retrieved.
 */
class KnowledgeIndexer
{
    public function __construct(private ChunkSplitter $splitter) {}

    public function indexFaq(Faq $faq): void
    {
        $faq->loadMissing('category');
        $this->remove(KnowledgeChunk::SOURCE_FAQ, $faq->id);

        if (! $faq->isLive()) {
            return;
        }

        $content = collect([
            $faq->question_en ? "Q: {$faq->question_en}" : null,
            $faq->answer_en ? "A: {$faq->answer_en}" : null,
            $faq->question_ta ? "கேள்வி: {$faq->question_ta}" : null,
            $faq->answer_ta ? "பதில்: {$faq->answer_ta}" : null,
        ])->filter()->implode("\n");

        if ($content === '') {
            return;
        }

        $this->store(KnowledgeChunk::SOURCE_FAQ, $faq->id, 0, $faq->question_en ?: (string) $faq->question_ta, $faq->answer_ta && ! $faq->answer_en ? 'ta' : 'en', $content, [
            $faq->category?->name_en, $faq->category?->name_ta, $faq->keywords, $faq->variations,
        ]);
    }

    public function indexDocument(KnowledgeDocument $document): void
    {
        $this->remove(KnowledgeChunk::SOURCE_DOCUMENT, $document->id);

        if (! $document->isPublished()) {
            return;
        }

        foreach ($this->splitter->split($document->content, (int) config('assistant.chunk_size')) as $position => $text) {
            $this->store(KnowledgeChunk::SOURCE_DOCUMENT, $document->id, $position, $document->title, $document->language, $text, [
                $document->title, $document->category, $document->keywords,
            ]);
        }
    }

    public function remove(string $sourceType, int $sourceId): void
    {
        KnowledgeChunk::query()->where('source_type', $sourceType)->where('source_id', $sourceId)->delete();
    }

    /**
     * @param  list<?string>  $extraSearchText
     */
    private function store(string $type, int $id, int $position, string $title, string $language, string $content, array $extraSearchText): void
    {
        KnowledgeChunk::create([
            'source_type' => $type,
            'source_id' => $id,
            'position' => $position,
            'title' => mb_substr($title, 0, 250),
            'language' => $language,
            'content' => $content,
            'search_text' => mb_strtolower($content."\n".implode("\n", array_filter($extraSearchText))),
        ]);
    }
}
