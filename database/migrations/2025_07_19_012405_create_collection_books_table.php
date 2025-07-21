<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('collection_books', function (Blueprint $table) {
            $table->foreignUuid('collection_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('book_id')->constrained()->cascadeOnDelete();
            $table->integer('order_index')->default(0);
            $table->timestamps();
            $table->primary(['collection_id', 'book_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('collection_books');
    }
};
