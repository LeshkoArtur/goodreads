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
        IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'event_status_enum') THEN
            CREATE TYPE event_status_enum AS ENUM ('upcoming', 'ongoing', 'past', 'canceled');
        END IF;
    END
    $$;
    ");
    }

    public function down(): void
    {
        DB::statement("DROP TYPE IF EXISTS event_status_enum");
    }
};
