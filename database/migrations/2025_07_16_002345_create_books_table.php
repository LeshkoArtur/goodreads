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
        Schema::create('books', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->text('plot')->nullable();
            $table->text('history')->nullable();
            $table->uuid('series_id')->nullable();
            $table->integer('number_in_series')->nullable();
            $table->integer('page_count')->nullable();
            $table->jsonb('languages')->nullable();
            $table->enum('age_restriction', ['0+', '6+', '12+', '16+', '18+'])->nullable();
            $table->string('cover_image', 255)->nullable();
            $table->jsonb('fun_facts')->nullable();
            $table->jsonb('adaptations')->nullable();
            $table->boolean('is_bestseller')->nullable();
            $table->decimal('average_rating', 3, 2)->default(0.00);
            $table->timestamps();
            $table->foreign('series_id')
                ->references('id')->on('book_series')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
