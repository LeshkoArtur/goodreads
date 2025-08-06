<?php

use App\Enums\AnswerStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('author_answers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('question_id')->constrained('author_questions')->cascadeOnDelete();
            $table->foreignUuid('author_id')->constrained()->cascadeOnDelete();
            $table->text('content');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        Schema::table('author_answers', function (Blueprint $table) {
            $table->enumAlterColumn('answer_status', 'answer_status', AnswerStatus::class, AnswerStatus::DRAFT->value);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('author_answers');
        DB::unprepared('DROP TYPE answer_status');
    }
};
