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
        Schema::create('group_members', function (Blueprint $table) {
            $table->uuid('group_id');
            $table->uuid('user_id');
            $table->enum('role', ['admin', 'moderator', 'member'])->default('member');
            $table->enum('status', ['active', 'pending', 'banned'])->default('active');
            $table->timestamp('joined_at')->useCurrent();
            $table->primary(['group_id', 'user_id']);
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_members');
    }
};
