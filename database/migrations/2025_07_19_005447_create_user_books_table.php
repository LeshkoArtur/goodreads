<?php

use App\Enums\ReadingFormat;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_books', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->index()->constrained()->nullOnDelete();
            $table->foreignUuid('book_id')->index()->constrained()->nullOnDelete();
            $table->foreignUuid('shelf_id')->index()->constrained()->nullOnDelete();
            $table->date('start_date')->nullable();
            $table->date('read_date')->nullable();
            $table->integer('progress_pages')->nullable();
            $table->boolean('is_private')->default(false);
            $table->integer('rating')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'book_id']);

        });
        DB::statement('ALTER TABLE user_books ADD CONSTRAINT check_rating_range CHECK (rating >= 1 AND rating <= 5)');
        Schema::table('user_books', function (Blueprint $table) {
            $table->enumAlterColumn('reading_format', 'reading_format', ReadingFormat::class);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_books');
        DB::unprepared('DROP TYPE user_books');
    }
};
