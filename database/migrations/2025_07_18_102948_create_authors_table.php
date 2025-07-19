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
        Schema::create('authors', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 100);
            $table->text('bio')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('birth_place', 100)->nullable();
            $table->string('nationality', 50)->nullable();
            $table->string('website', 255)->nullable();
            $table->enum('type_of_work', ['poet', 'novelist', 'philosopher', 'essayist', 'playwright'])->nullable();
            $table->string('profile_picture', 255)->nullable();
            $table->date('death_date')->nullable();
            $table->jsonb('social_media_links')->nullable();
            $table->jsonb('media_images')->nullable();
            $table->jsonb('media_videos')->nullable();
            $table->jsonb('fun_facts')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('authors');
    }
};
