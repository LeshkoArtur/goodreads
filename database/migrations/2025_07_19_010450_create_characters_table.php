<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('characters', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('book_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->jsonb('other_names')->nullable();
            $table->string('race', 64)->nullable();
            $table->string('nationality', 64)->nullable();
            $table->string('residence', 128)->nullable();
            $table->text('biography')->nullable();
            $table->jsonb('fun_facts')->nullable();
            $table->jsonb('links')->nullable();
            $table->jsonb('media_images')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('characters');
    }
};
