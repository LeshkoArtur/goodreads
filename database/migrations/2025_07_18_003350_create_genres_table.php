<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('genres', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 50);
            $table->uuid('parent_id')->nullable();
            $table->text('description')->nullable();
            $table->integer('book_count')->default(0);
            $table->timestamps();
        });

        Schema::table('genres', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('genres')->nullOnDelete();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('genres');
    }
};
