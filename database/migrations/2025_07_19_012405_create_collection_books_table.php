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
        Schema::create('collection_books', function (Blueprint $table) {
            $table->uuid('collection_id');
            $table->uuid('book_id');
            $table->integer('order_index')->default(0);
            $table->timestamps();
            $table->primary(['collection_id', 'book_id']);
            $table->foreign('collection_id')->references('id')->on('collections')->onDelete('cascade');
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collection_books');
    }
};
