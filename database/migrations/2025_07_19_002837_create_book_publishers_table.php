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
        Schema::create('book_publishers', function (Blueprint $table) {
            $table->uuid('book_id');
            $table->uuid('publisher_id');
            $table->date('published_date')->nullable();
            $table->string('isbn', 13)->unique()->nullable();
            $table->integer('circulation')->nullable();
            $table->string('format', 50)->nullable();
            $table->enum('cover_type', ['hardcover', 'paperback', 'other'])->nullable();
            $table->string('translator', 100)->nullable();
            $table->integer('edition')->nullable();
            $table->bigInteger('price')->nullable();
            $table->string('binding', 50)->nullable();
            $table->timestamps();
            $table->primary(['book_id', 'publisher_id']);
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
            $table->foreign('publisher_id')->references('id')->on('publishers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_publishers');
    }
};
