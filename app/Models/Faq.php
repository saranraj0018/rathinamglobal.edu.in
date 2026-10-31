<?php

namespace App\Models;

use App\Observers\KnowledgeObserver;
use Database\Factories\FaqFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy(KnowledgeObserver::class)]
#[Fillable([
    'faq_category_id', 'question_en', 'answer_en', 'question_ta', 'answer_ta',
    'keywords', 'variations', 'is_active', 'published_at',
])]
class Faq extends Model
{
    /** @use HasFactory<FaqFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return ['is_active' => 'boolean', 'published_at' => 'datetime'];
    }

    /**
     * @return BelongsTo<FaqCategory, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(FaqCategory::class, 'faq_category_id');
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * @param  Builder<Faq>  $query
     */
    public function scopeLive(Builder $query): void
    {
        $query->where('is_active', true)->whereNotNull('published_at')->where('published_at', '<=', now());
    }

    public function isLive(): bool
    {
        return $this->is_active
            && $this->published_at !== null
            && $this->published_at->lte(now())
            && ($this->category === null || $this->category->is_active);
    }
}
