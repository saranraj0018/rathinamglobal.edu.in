<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['assistant_message_id', 'rating', 'comment'])]
class AssistantFeedback extends Model
{
    protected $table = 'assistant_feedback';
}
