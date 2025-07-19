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
        Schema::create('groups', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->uuid('creator_id');
            $table->boolean('is_public')->default(true);
            $table->string('cover_image', 255)->nullable();
            $table->text('rules')->nullable();
            $table->enum('join_policy', ['open', 'request', 'invite_only'])->default('open');
            $table->enum('post_policy', ['all', 'moderators', 'admins'])->default('all');
            $table->integer('member_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
