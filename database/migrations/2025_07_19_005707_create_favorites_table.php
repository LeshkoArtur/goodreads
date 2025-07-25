<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->uuid('favoriteable_id');
            $table->string('favoriteable_type', 50);
            $table->timestamps();
            $table->unique(['user_id', 'favoriteable_id', 'favoriteable_type']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};
