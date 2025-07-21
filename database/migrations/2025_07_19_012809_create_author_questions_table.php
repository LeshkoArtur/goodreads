<?php

use App\Enums\QuestionStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('author_questions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('author_id')->constrained()->nullOnDelete();
            $table->foreignUuid('book_id')->nullable()->constrained()->nullOnDelete();
            $table->text('content');
            $table->timestamps();
        });

        Schema::table('author_questions', function (Blueprint $table) {
            $table->enumAlterColumn('question_status', 'question_status', QuestionStatus::class);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('author_questions');
        DB::unprepared('DROP TYPE question_status');
    }
};
