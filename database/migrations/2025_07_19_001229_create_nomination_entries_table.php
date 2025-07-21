<?php

use App\Enums\NominationStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nomination_entries', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid("nomination_id")->constrained()->cascadeOnDelete();
            $table->foreignUuid("book_id")->nullable()->constrained()->nullOnDelete();
            $table->foreignUuid("author_id")->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });

        Schema::table('nomination_entries', function (Blueprint $table) {
            $table->enumAlterColumn('nomination_status', 'nomination_status', NominationStatus::class);
        });

        DB::statement("ALTER TABLE nomination_entries ADD CONSTRAINT check_book_or_author CHECK (book_id IS NOT NULL OR author_id IS NOT NULL)");
    }

    public function down(): void
    {
        Schema::dropIfExists('nomination_entries');
        DB::unprepared('DROP TYPE nomination_status');
    }
};
