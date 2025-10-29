<?php

use App\Enums\CoverType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('book_publisher', function (Blueprint $table) {
            $table->foreignUuid('book_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('publisher_id')->constrained()->cascadeOnDelete();
            $table->date('published_date')->nullable();
            $table->string('isbn', 13)->unique()->nullable();
            $table->integer('circulation')->nullable();
            $table->string('format', 50)->nullable();
            $table->string('translator', 100)->nullable();
            $table->integer('edition')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('binding', 50)->nullable();
            $table->timestamps();
            $table->primary(['book_id', 'publisher_id']);
        });

        Schema::table('book_publisher', function (Blueprint $table) {
            $table->enumAlterColumn('cover_type', 'cover_type', CoverType::class);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_publisher');
        DB::unprepared('DROP TYPE cover_type');
    }
};
