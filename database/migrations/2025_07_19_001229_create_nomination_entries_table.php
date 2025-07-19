<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('nomination_entries', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('nomination_id');
            $table->uuid('book_id')->nullable();
            $table->uuid('author_id')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->foreign('nomination_id')
                ->references('id')
                ->on('nominations')
                ->onDelete('cascade');
            $table->foreign('book_id')
                ->references('id')
                ->on('books')
                ->onDelete('set null');
            $table->foreign('author_id')
                ->references('id')
                ->on('authors')
                ->onDelete('set null');
        });
        DB::statement("ALTER TABLE nomination_entries ADD COLUMN status nomination_status NOT NULL");
        DB::statement("ALTER TABLE nomination_entries ADD CONSTRAINT check_book_or_author CHECK (book_id IS NOT NULL OR author_id IS NOT NULL)");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nomination_entries');
    }
};
