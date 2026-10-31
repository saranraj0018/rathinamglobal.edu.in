<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('knowledge_documents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category');
            $table->string('language', 5)->default('en');
            $table->longText('content');
            $table->text('keywords')->nullable();
            $table->string('status', 20)->default('draft');
            $table->string('source_file')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index('status');
        });

        // One searchable row per FAQ (or per piece of a long document); only published sources have rows.
        Schema::create('knowledge_chunks', function (Blueprint $table) {
            $table->id();
            $table->string('source_type', 20);
            $table->unsignedBigInteger('source_id');
            $table->unsignedSmallInteger('position')->default(0);
            $table->string('title');
            $table->string('language', 5)->default('en');
            $table->text('content');
            $table->text('search_text');
            $table->timestamps();

            $table->index(['source_type', 'source_id']);
        });

        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE knowledge_chunks ADD FULLTEXT knowledge_chunks_search_text_fulltext (search_text)');
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('knowledge_chunks');
        Schema::dropIfExists('knowledge_documents');
    }
};
