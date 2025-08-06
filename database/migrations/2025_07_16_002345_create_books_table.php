<?php

use App\Enums\AgeRestriction;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->text('plot')->nullable();
            $table->text('history')->nullable();
            $table->foreignUuid('series_id')->nullable()->constrained('book_series')->nullOnDelete();
            $table->integer('number_in_series')->nullable();
            $table->integer('page_count')->nullable();
            $table->jsonb('languages')->nullable();
            $table->string('cover_image', 255)->nullable();
            $table->jsonb('fun_facts')->nullable();
            $table->jsonb('adaptations')->nullable();
            $table->boolean('is_bestseller')->nullable();
            $table->decimal('average_rating', 3, 2)->default(0.00);
            $table->timestamps();

        });

        Schema::table('books', function (Blueprint $table) {
            $table->enumAlterColumn('age_restriction', 'age_restriction', AgeRestriction::class);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
        DB::unprepared('DROP TYPE age_restriction');
    }
};
