<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('book_id')->constrained()->cascadeOnDelete();
            $table->integer('rating');
            $table->text('review')->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'book_id']);

        });
        DB::statement('ALTER TABLE ratings ADD CONSTRAINT check_rating_range CHECK (rating >= 1 AND rating <= 5)');
    }

    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
