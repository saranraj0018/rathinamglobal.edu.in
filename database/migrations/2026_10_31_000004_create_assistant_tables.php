<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assistant_conversations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('visitor_id', 64)->index();
            $table->string('preferred_language', 5)->nullable();
            $table->timestamps();
        });

        // One row per turn: the visitor's question and the assistant's answer.
        Schema::create('assistant_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assistant_conversation_id')->constrained('assistant_conversations')->cascadeOnDelete();
            $table->text('user_message');
            $table->text('ai_response')->nullable();
            $table->string('detected_language', 10)->nullable();
            $table->string('response_language', 5)->nullable();
            $table->json('sources')->nullable();
            $table->string('model')->nullable();
            $table->unsignedInteger('prompt_tokens')->nullable();
            $table->unsignedInteger('completion_tokens')->nullable();
            $table->string('status', 20)->index();
            $table->string('error_reason', 40)->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'created_at']);
        });

        Schema::create('assistant_feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assistant_message_id')->unique()->constrained('assistant_messages')->cascadeOnDelete();
            $table->smallInteger('rating');
            $table->string('comment', 500)->nullable();
            $table->timestamps();
        });

        Schema::create('assistant_settings', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->text('value')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assistant_settings');
        Schema::dropIfExists('assistant_feedback');
        Schema::dropIfExists('assistant_messages');
        Schema::dropIfExists('assistant_conversations');
    }
};
