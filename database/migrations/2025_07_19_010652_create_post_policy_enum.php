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
        IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'post_policy_enum') THEN
            CREATE TYPE post_policy_enum AS ENUM ('all', 'moderators', 'admins');
        END IF;
    END
    $$;
    ");
    }

    public function down(): void
    {
        DB::statement("DROP TYPE IF EXISTS post_policy_enum");
    }
};
