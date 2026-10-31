<?php

namespace App\Models;

use App\Observers\KnowledgeObserver;
use Database\Factories\FaqCategoryFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy(KnowledgeObserver::class)]
#[Fillable(['name_en', 'name_ta', 'slug', 'sort_order', 'is_active'])]
class FaqCategory extends Model
{
    /** @use HasFactory<FaqCategoryFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    /**
     * @return HasMany<Faq, $this>
     */
    public function faqs(): HasMany
    {
        return $this->hasMany(Faq::class);
    }
}
