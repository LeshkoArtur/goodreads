<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('author_user', function (Blueprint $table) {
            $table->foreignUuid('author_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->primary(['author_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('author_user');
    }
};
