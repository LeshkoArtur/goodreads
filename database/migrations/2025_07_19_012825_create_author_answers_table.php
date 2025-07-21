<?php

use App\Enums\AnswerStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('author_answers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('question_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('author_id')->constrained()->cascadeOnDelete();
            $table->text('content');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        Schema::table('author_answers', function (Blueprint $table) {
            $table->enumAlterColumn('answer_status', 'answer_status', AnswerStatus::class, AnswerStatus::DRAFT);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('author_answers');
    }
};
