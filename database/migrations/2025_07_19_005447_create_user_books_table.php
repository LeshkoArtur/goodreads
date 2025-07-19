<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('user_books', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->index();
            $table->uuid('book_id')->index();
            $table->uuid('shelf_id')->index();
            $table->date('start_date')->nullable();
            $table->date('read_date')->nullable();
            $table->integer('progress_pages')->nullable();
            $table->boolean('is_private')->default(false);
            $table->integer('rating')->nullable()->check('rating >= 1 AND rating <= 5');
            $table->text('notes')->nullable();
            $table->enum('reading_format', ['physical', 'ebook', 'audiobook', 'other'])->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->unique(['user_id', 'book_id']);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
            $table->foreign('shelf_id')->references('id')->on('shelves')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_books');
    }
};
