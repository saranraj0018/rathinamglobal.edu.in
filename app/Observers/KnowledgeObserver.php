<?php

namespace App\Observers;

use App\Models\Faq;
use App\Models\FaqCategory;
use App\Models\KnowledgeChunk;
use App\Models\KnowledgeDocument;
use App\Services\Assistant\KnowledgeIndexer;
use Illuminate\Database\Eloquent\Model;

/**
 * Re-indexes content for AI retrieval whenever an administrator saves,
 * publishes, unpublishes or deletes it.
 */
class KnowledgeObserver
{
    public function __construct(private KnowledgeIndexer $indexer) {}

    public function saved(Model $model): void
    {
        match (true) {
            $model instanceof Faq => $this->indexer->indexFaq($model),
            $model instanceof KnowledgeDocument => $this->indexer->indexDocument($model),
            $model instanceof FaqCategory => $model->faqs()->each(fn (Faq $faq) => $this->indexer->indexFaq($faq)),
            default => null,
        };
    }

    public function deleted(Model $model): void
    {
        match (true) {
            $model instanceof Faq => $this->indexer->remove(KnowledgeChunk::SOURCE_FAQ, $model->id),
            $model instanceof KnowledgeDocument => $this->indexer->remove(KnowledgeChunk::SOURCE_DOCUMENT, $model->id),
            default => null,
        };
    }
}
