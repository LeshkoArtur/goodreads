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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('username', 50)->unique();
            $table->string('email', 255)->unique();
            $table->string('password_hash', 255);
            $table->string('profile_picture', 255)->nullable();
            $table->text('bio')->nullable();
            $table->boolean('is_public')->default(true);
            $table->date('birthday')->nullable();
            $table->string('gender', 20)->nullable();
            $table->string('location', 100)->nullable();
            $table->timestamp('last_login')->nullable();
            $table->enum('role', ['user', 'author', 'librarian', 'admin'])->default('user');
            $table->jsonb('social_media_links')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
