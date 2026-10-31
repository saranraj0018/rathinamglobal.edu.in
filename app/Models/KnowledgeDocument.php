<?php

namespace App\Models;

use App\Observers\KnowledgeObserver;
use Database\Factories\KnowledgeDocumentFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy(KnowledgeObserver::class)]
#[Fillable(['title', 'category', 'language', 'content', 'keywords', 'status', 'source_file'])]
class KnowledgeDocument extends Model
{
    /** @use HasFactory<KnowledgeDocumentFactory> */
    use HasFactory;

    public const STATUS_DRAFT = 'draft';

    public const STATUS_PUBLISHED = 'published';

    public const CATEGORIES = [
        'College information', 'Course information', 'Admission procedures', 'Fee details',
        'Eligibility requirements', 'Facilities', 'Placement information',
        'Important announcements', 'General institutional information',
    ];

    public function isPublished(): bool
    {
        return $this->status === self::STATUS_PUBLISHED;
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
