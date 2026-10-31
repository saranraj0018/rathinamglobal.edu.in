<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['source_type', 'source_id', 'position', 'title', 'language', 'content', 'search_text'])]
class KnowledgeChunk extends Model
{
    public const SOURCE_FAQ = 'faq';

    public const SOURCE_DOCUMENT = 'document';
}
