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
        DB::statement("
    DO $$
    BEGIN
        IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'author_work_type') THEN
            CREATE TYPE author_work_type AS ENUM (
                'novelist',
                'short_story_writer',
                'poet',
                'playwright',
                'screenwriter',
                'essayist',
                'biographer',
                'memoirist',
                'historian',
                'journalist',
                'science_writer',
                'self_help_writer',
                'children_writer',
                'young_adult_writer',
                'graphic_novelist',
                'fantasy_writer',
                'sci_fi_writer',
                'mystery_writer',
                'romance_writer',
                'horror_writer',
                'other'
            );
        END IF;
    END$$;
");

    }

    public function down(): void
    {
        DB::statement("DROP TYPE IF EXISTS author_work_type;");
    }

};
