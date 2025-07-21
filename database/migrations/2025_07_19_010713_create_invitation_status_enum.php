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
        IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'invitation_status_enum') THEN
            CREATE TYPE invitation_status_enum AS ENUM ('pending', 'accepted', 'declined');
        END IF;
    END
    $$;
    ");
    }
    public function down(): void
    {
        DB::statement("DROP TYPE IF EXISTS invitation_status_enum");
    }
};
